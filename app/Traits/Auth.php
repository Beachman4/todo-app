<?php
/**
 * Created by PhpStorm.
 * User: Aylon
 * Date: 11/4/2017
 * Time: 9:23 PM
 */

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