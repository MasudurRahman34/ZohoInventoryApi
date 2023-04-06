<?php

namespace App\Notifications\V1;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class InviteUserRegistration extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $invitation;
    protected $url;
    public function __construct($invitaion)
    {
        $this->invitation = $invitaion;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $invitationUrl = $this->invitationUrl($this->invitation);
        return (new MailMessage)
            ->subject(Lang::get('Join ' . $this->invitation->company_name . 'BDERP Inventory Account'))
            ->line($this->invitation->first_name)
            ->line('We have been using BDEP Inventory for inventory order management. You can begin to use our BDERP Inventory account by accepting this invitation. Please click on the link below and sign up using', $this->invitation->email)
            ->action('Join Account', $invitationUrl)
            ->Line($this->invitation->company_name);
    }

    public function invitationUrl($invitation)
    {
        // $frontend = env('APP_FRONTEND_URL');
        $frontend = "http://127.0.0.1:8000/api/v1";
        return $frontend . '/invitation/register?token=' . $invitation->token . '&email=' . $invitation->email;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
