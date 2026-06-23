<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class CompanyProfileController extends Controller
{
    public function index(): View
    {
        return view('pages.home');
    }

    public function about(): View
    {
        return view('pages.about');
    }

    public function vision(): View
    {
        return view('pages.vision-mission');
    }

    public function contact(): View
    {
        return view('pages.contact');
    }
}
