<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class BookingCreated extends Notification
{
    use Queueable;

    public function __construct(public Booking $booking)
    {
        //
    }

    /**
     * "mail" and "database" are the delivery channels.
     * "database" saves it to the notifications table so it shows up
     * even without email configured — good for quick testing.
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Booking Confirmation - Hostel Booking')
            ->greeting('Hi ' . $this->booking->guest_name . ',')
            ->line('Your booking has been received and is now pending confirmation.')
            ->line('Room: ' . $this->booking->room->room_number . ' (' . $this->booking->room->room_type . ')')
            ->line('Check-in: ' . $this->booking->check_in_date->format('F d, Y'))
            ->line('Check-out: ' . $this->booking->check_out_date->format('F d, Y'))
            ->line('Total: ₱' . number_format($this->booking->total_price, 2))
            ->line('Thank you for booking with us!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'room' => $this->booking->room->room_number,
            'check_in' => $this->booking->check_in_date->toDateString(),
            'check_out' => $this->booking->check_out_date->toDateString(),
            'message' => 'Your booking for room ' . $this->booking->room->room_number . ' was created.',
        ];
    }
}
