<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Http\Traits\SettingTrait;

class RegisterNotification extends Notification
{
    use Queueable;
    use SettingTrait;

    protected $rsvp;

    /**
     * Create a new notification instance.
     */
    public function __construct($rsvp)
    {
        $this->rsvp = $rsvp;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        if($this->getEmailSending()) {
            return ['database', 'mail'];
        } else {
            return ['database'];
        }
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $subject = "THE ICON TURNS 20 - ".$this->rsvp->name;
        $greeting = "Dear, {$notifiable->name}";

        if($this->rsvp->attending == 'YES'){
            $introLines = ["Your RSVP has been received. Thank you for joining us, and we look forward to a great session."];
        } else {
            $introLines = ["Thank you for letting us know of your absence. We appreciate your response and hope to see you at a future event."];

        }
       
        $outroLines = [
            
        ];

        return (new MailMessage)
            ->subject($subject)
            ->view('emails.notification', [
                'greeting' => $greeting,
                'introLines' => $introLines,
                'outroLines' => $outroLines,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
