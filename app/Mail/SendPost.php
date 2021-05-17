<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendPost extends Mailable
{
    use Queueable, SerializesModels;

    protected $post;/**Criei essa propiedade protegida */

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($post) /**passei ela para o construtor */
    {
        $this->post = $post;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->with(['post' => $this->post])
            ->view('post-user');
    }
}
