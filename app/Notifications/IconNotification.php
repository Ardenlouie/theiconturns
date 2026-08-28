<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Http\Traits\SettingTrait;

class IconNotification extends Notification
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
        $greeting = "Dear, {$notifiable->name} Group";

        if($this->rsvp->attending == 'YES'){
            $introLines = [$this->rsvp->name." RSVP has been submitted, and responded YES. RSVP requires your confirmation."];
        } else {
            $introLines = [$this->rsvp->name." RSVP has been submitted, and responded NO"];

        }
       
        $outroLines = [
            "Please review the submitted RSVP at your earliest convenience by clicking the button above."
        ];

        return (new MailMessage)
            ->subject($subject)
            ->view('emails.notification', [
                'url' => url('/invite/show/' . encrypt($this->rsvp->id)),
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
            'title' => 'RSVP SUBMITTED',
            'message' => 'A new RSVP ['.$this->rsvp->control_number.'] has been submitted and requires your confirmation.',
            'action_url' => url('/invite/show/' . encrypt($this->rsvp->id)),
        ];
    }
}
