<?php

namespace App\Traits;

use Auth as AuthFacade;


trait Auth
{
    public function user()
    {
        return AuthFacade::user();
    }

    public function id()
    {
        return AuthFacade::id();
    }
}