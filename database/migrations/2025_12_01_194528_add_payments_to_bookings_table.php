<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->enum('payment_method', ['cash', 'gcash'])
                  ->nullable()
                  ->after('status');

            // Amount paid when booking is approved (downpayment)
            $table->decimal('downpayment_amount', 10, 2)
                  ->nullable()
                  ->after('payment_method');

            // Amount paid on the day session is completed
            $table->decimal('final_payment_amount', 10, 2)
                  ->nullable()
                  ->after('downpayment_amount');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'payment_method',
                'downpayment_amount',
                'final_payment_amount',
            ]);
        });
    }
};
