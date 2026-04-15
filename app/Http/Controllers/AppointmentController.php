<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Shop;
use App\Notifications\NewAppointment;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'shop_id' => 'required|exists:shops,id',
            'user_id' => 'required|exists:users,id',
            'service' => 'required|string|max:255',
            'scheduled_at' => 'required|date|after:now',
            'notes' => 'nullable|string',
        ]);

        // 1️⃣ Create the appointment
        $appointment = Appointment::create($data);

        // 2️⃣ Notify the shop admin
        $shopAdmin = $appointment->shop->admins()->first(); // get the first admin
        if ($shopAdmin) {
            $shopAdmin->notify(new NewAppointment($appointment));
        }

        return redirect()->back()->with('success', 'Appointment booked successfully!');
    }
}