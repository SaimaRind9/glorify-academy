<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;

class HomeController extends Controller
{
    public function index()
    {
        $classes = ClassRoom::query()
            ->orderBy('class_name')
            ->get();

        return view('welcome', compact('classes'));
    }
}