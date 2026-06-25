<?php

namespace App\View\Composers;

use App\Models\CompanyProfile;
use Illuminate\View\View;

class CompanyProfileComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $view->with('companyProfile', CompanyProfile::query()->first());
    }
}
