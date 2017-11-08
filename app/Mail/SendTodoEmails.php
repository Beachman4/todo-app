<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTodoEmails extends Mailable
{
    use Queueable, SerializesModels;

    public $todoItems;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($todoItems)
    {
        $this->todoItems = $todoItems;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $numOfItems = count($this->todoItems);
        return $this->markdown('emails.todo.item')
            ->subject("$numOfItems Todo Item" . $numOfItems == 1 ? '' : 's' . ' due today');
    }
}
