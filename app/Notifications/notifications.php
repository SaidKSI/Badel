<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class notifications extends Notification
{
    use Queueable;

    protected $data;
    protected $type;

    /**
     * Create a new notification instance.
     *
     * @param mixed $data
     * @param string $type
     */
    public function __construct($data, $type)
    {
        $this->data = $data;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['database']; // Notify via database notification
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase($notifiable)
    {
        switch ($this->type) {
            case 'transaction':
                return [
                    'id' => $this->data->id,
                    'type' => 'transaction',
                    'transaction_id' => $this->data->transaction_id,
                    'amount' => $this->data->amount,
                    'message' => 'New transaction created: ' . $this->data->id,
                ];

            case 'phone':
                return [
                    'id' => $this->data->id,
                    'type' => 'phone',
                    'phone_number' => $this->data->phone_number,
                    'message' => 'New phone created: ' . $this->data->id,
                ];
            default:
                break;
        }
    }
}
