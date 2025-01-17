<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FormController extends Controller
{
    public function showForm()
    {
        $view = view('form-controller');
        return new Response($view);
    }
}