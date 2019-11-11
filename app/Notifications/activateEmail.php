<?php

namespace App\Notifications;

use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class activateEmail extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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

        try {

            $found = false;
            $token = Str::random(32);

            while(!$found) {
                $existingToken = User::where('activation_token', '=', $token);

                if($existingToken->count()) {
                    $token = Str::random(32);
                } else {
                    $found = true;
                }
            }

            $notifiable->activation_token = $token;
            $notifiable->save();

            $url = url('/api/email/activate/'.$token);
            return (new MailMessage)
                ->subject('Confirm your account')
                ->greeting('Hello!')
                ->line('Please activate your account')
                ->action('Confirm Account', $url)
                ->line('Thank you for using our application!');

        } catch (\Exception $e) {

            logger()->debug($e->getTraceAsString());
            return response()->json([
                'message' => 'Error while sending activation email',
                'body' => $e->getMessage()
            ], 500);
        }
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
