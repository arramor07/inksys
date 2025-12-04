<?php

namespace App\Http\Controllers;

use App\Mail\BookingStatusMail;
use App\Models\Booking;
use App\Models\InventoryItem;
use App\Models\PortfolioItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Services\SmsService;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    protected SmsService $sms;

    public function __construct(SmsService $sms)
    {
        $this->sms = $sms;
    }

    // ==================== ADMIN: BOOKINGS LIST ====================

    public function index()
    {
        // list of bookings for the table
        $bookings = Booking::orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();

        // summary metrics
        $totalBookings    = Booking::count();
        $todayBookings    = Booking::whereDate('appointment_date', Carbon::today())->count();
        $upcomingBookings = Booking::whereDate('appointment_date', '>=', Carbon::today())->count();
        $portfolioCount   = PortfolioItem::count();
        $lowStockCount    = InventoryItem::whereColumn('quantity', '<=', 'low_stock_threshold')->count();

        return view('admin.bookings.index', compact(
            'bookings',
            'totalBookings',
            'todayBookings',
            'upcomingBookings',
            'portfolioCount',
            'lowStockCount'
        ));
    }

    // For older code that still calls adminIndex
    public function adminIndex()
    {
        return $this->index();
    }

    // ==================== CLIENT: BOOKING FORM ====================

    public function create(Request $request)
{
    $selectedDesign = $request->query('design'); // from ?design=...

    return view('layouts.create', [
        'selectedDesign' => $selectedDesign,
    ]);
}


    // CLIENT: handle booking submission
    public function store(Request $request)
{
    $validated = $request->validate([
        'name'              => ['required', 'string', 'max:255'],
        'email'             => ['required', 'email', 'max:255'],
        // allow 09xxxxxxxxx or +639xxxxxxxxx, digits only
        'phone'             => ['nullable', 'regex:/^(09\d{9}|\+639\d{9})$/'],
        'home_address'      => ['nullable', 'string', 'max:255'],
        'appointment_date'  => ['required', 'date'],
        'appointment_time'  => ['required'],
        'tattoo_prompt'     => ['nullable', 'string', 'max:1000'],
        'additional_message'=> ['nullable', 'string', 'max:2000'],
        'reference_image'   => ['nullable', 'image', 'max:4096'],
    ]);

    /*
     * NORMALIZE PHONE FOR SMS (E.164, e.g. +639xxxxxxxxx)
     */
    $phoneForDb  = null;
    $phoneForSms = null;

    if (!empty($validated['phone'])) {
        // remove spaces / dashes just in case
        $raw = preg_replace('/\D+/', '', $validated['phone']);

        if (str_starts_with($raw, '09') && strlen($raw) === 11) {
            // 09xxxxxxxxx -> +639xxxxxxxxx
            $phoneForSms = '+63' . substr($raw, 1);
        } elseif (str_starts_with($raw, '639') && strlen($raw) === 12) {
            // 639xxxxxxxxx -> +639xxxxxxxxx
            $phoneForSms = '+' . $raw;
        } else {
            // fallback – still try to send
            $phoneForSms = $validated['phone'];
        }

        // you can store the normalized version so admin sees +63...
        $phoneForDb = $phoneForSms;
    }

    /*
     * HANDLE FILE UPLOADS / AI IMAGE (keep whatever logic you already had)
     */
    $aiPath = null;
    $referencePath = null;

    if ($request->hasFile('reference_image')) {
        $referencePath = $request->file('reference_image')
            ->store('reference_images', 'public');
    }

    // if you later attach AI-generated image, set $aiPath there...

    /*
     * CREATE BOOKING
     */
    $booking = Booking::create([
        'name'               => $validated['name'],
        'email'              => $validated['email'],
        'phone'              => $phoneForDb,                   // normalized phone
        'home_address'       => $validated['home_address'] ?? null,
        'appointment_date'   => $validated['appointment_date'],
        'appointment_time'   => $validated['appointment_time'],
        'tattoo_prompt'      => $validated['tattoo_prompt'] ?? null,
        'additional_message' => $validated['additional_message'] ?? null,
        'ai_image_url'       => $aiPath ?? null,
        'reference_image_url'=> $referencePath ?? null,
        'status'             => 'pending',
    ]);

    /*
     * EMAIL
     */
    Mail::to($booking->email)->send(new BookingStatusMail($booking));

    /*
     * SMS – only if we have a usable number
     */
    if ($phoneForSms) {
        // use the injected SmsService on $this
        $this->sms->sendBookingStatus(
            $phoneForSms,
            "Hi {$booking->name}, your InkTech booking is now pending. We'll notify you once it's approved or rejected."
        );
    }

    return redirect()->route('book.create')
        ->with('success', 'Your booking has been submitted. Please check your email and SMS for updates.');
}


    // ==================== AI IMAGE (AJAX PREVIEW via HUGGINGFACE) ====================

public function generateImage(Request $request)
{
    $request->validate([
        'tattoo_prompt' => 'required|string|max:500',
    ]);

    $prompt = $request->input('tattoo_prompt');

    // Use the shared helper, but save previews in a separate folder
    $path = $this->generateAiImage($prompt, 'ai_previews');

    if (!$path) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to generate image. Please try again or contact the admin.',
        ], 500);
    }

    return response()->json([
        'success'   => true,
        'image_url' => asset('storage/' . $path),
    ]);
}

/**
 * PRIVATE: HuggingFace image generator
 *
 * - calls HF Router Inference API (text-to-image)
 * - saves raw bytes to storage/app/public/{folder}
 * - returns the relative path (e.g. "ai_designs/xxx.png") or null on failure
 */
private function generateAiImage(string $prompt, string $folder = 'ai_designs'): ?string
{
    try {
        $token = config('services.huggingface.token');
        $model = config('services.huggingface.model');

        if (!$token || !$model) {
            // .env or config/services.php not set
            return null;
        }

        $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type'  => 'application/json',
                'Accept'        => '*/*',
            ])
            ->timeout(90)
            ->post("https://router.huggingface.co/hf-inference/models/{$model}", [
                'inputs'  => $prompt,
                'options' => [
                    'wait_for_model' => true,
                ],
            ]);

        if (!$response->ok()) {
            return null;
        }

        $contentType = $response->header('content-type', '');
        if (strpos($contentType, 'image/') !== 0) {
            // HF sometimes returns JSON error instead of image
            return null;
        }

        $extension = str_contains($contentType, 'png') ? 'png' : 'jpg';
        $fileName  = 'ai_' . time() . '_' . Str::random(8) . '.' . $extension;
        $path      = trim($folder, '/') . '/' . $fileName;

        Storage::disk('public')->put($path, $response->body());

        return $path;
    } catch (\Throwable $e) {
        return null;
    }
}




    // ==================== ADMIN: USER REGISTRATIONS ====================

    public function adminUsers()
    {
        $pendingUsers  = \App\Models\User::where('status', 'pending')->get();
        $approvedUsers = \App\Models\User::where('status', 'approved')->get();

        return view('admin.users.index', compact('pendingUsers', 'approvedUsers'));
    }

    public function approveUser(\App\Models\User $user)
    {
        if ($user->status !== 'pending') {
            return redirect()->back()->with('error', 'User is not in pending status.');
        }

        $user->update([
            'status' => 'approved',
            'role'   => 'assistant_admin',
        ]);

        return redirect()->back()->with(
            'success',
            ucfirst($user->name) . ' has been approved as Assistant Admin.'
        );
    }

    public function deleteUser(\App\Models\User $user)
    {
        $userName = $user->name;
        $user->delete();

        return redirect()->back()->with('success', $userName . ' registration has been deleted.');
    }

    // ==================== ADMIN: BOOKING STATUS ACTIONS ====================

    public function approve(Booking $booking, SmsService $sms)
    {
        $booking->status = 'approved';
        $booking->save();

        // email
        Mail::to($booking->email)->send(new BookingStatusMail($booking));

        // sms
        if (!empty($booking->phone)) {
            $sms->sendBookingStatus(
                $booking->phone,
                "Hi {$booking->name}, your InkTech booking has been APPROVED."
            );
        }

        return back()->with('success', 'Booking approved. Email and SMS notification sent.');
    }

    public function reject(Booking $booking)
    {
        $booking->status = 'rejected';
        $booking->save();

        // email
        Mail::to($booking->email)->send(new BookingStatusMail($booking));

        // sms
        if ($booking->phone) {
            $this->sms->send(
                $booking->phone,
                "Hi {$booking->name}, unfortunately your InkTech booking on "
                . $booking->appointment_date->format('M d, Y')
                . " at "
                . \Carbon\Carbon::parse($booking->appointment_time)->format('h:i A')
                . " was not approved. You may rebook with a different schedule or design."
            );
        }

        return back()->with('success', 'Booking rejected and notification sent.');
    }

    public function complete(Booking $booking)
    {
        $booking->update([
            'status' => 'completed',
        ]);

        return back()->with('success', 'Marked as completed.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return back()->with('success', 'Booking deleted successfully.');
    }
}
