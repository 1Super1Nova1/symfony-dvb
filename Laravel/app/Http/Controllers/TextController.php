<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TextController extends Controller
{
    public function test(): string
    {
        return "TEST";
    }
}
