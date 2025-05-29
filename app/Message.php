<?php

namespace App;

use Illuminate\Support\Facades\Session;

class Message
{
    public static function put(string $message)
    {
        if (Session::has('messages')) {
            $messages = Session::get('messages');
        }

        $messages[] = $message;


    }
}