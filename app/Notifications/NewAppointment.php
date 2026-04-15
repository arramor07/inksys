<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewAppointment extends Notification
{
    protected $appointment;

    public function __construct($appointment){
        $this->appointment = $appointment;
    }

    public function via($notifiable){
        return ['mail','database'];
    }

    public function toMail($notifiable){
        return (new MailMessage)
            ->line("New appointment booked by {$this->appointment->client_name}")
            ->action('View Appointment', url("/appointments/{$this->appointment->id}"))
            ->line('Check your dashboard for details.');
    }

    public function toArray($notifiable){
        return [
            'appointment_id' => $this->appointment->id,
            'client_name' => $this->appointment->client_name,
        ];
    }
}