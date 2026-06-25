<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use Illuminate\View\View;

class CompanyProfileController extends Controller
{
    public function index(): View
    {
        return view('pages.home');
    }

    public function about(): View
    {
        $companyProfile = CompanyProfile::query()->first();

        return view('pages.about', compact('companyProfile'));
    }

    public function vision(): View
    {
        return view('pages.vision-mission');
    }

    public function contact(): View
    {
        $companyProfile = CompanyProfile::query()->first();

        return view('pages.contact', compact('companyProfile'));
    }
}
