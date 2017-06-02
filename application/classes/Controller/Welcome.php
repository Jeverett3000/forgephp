<?php

namespace App\Controller;

use Forge\Controller;

class Welcome extends Controller
{
    public function action_index()
    {
        $this->response->body( 'hello, world!' );
    }
}
