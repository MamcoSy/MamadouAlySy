<?php

namespace Tests\Controllers;

use MamcoSy\Http\Response;

class TestController
{
    public function index()
    {
        return new Response(200, 'hello');
    }
}
