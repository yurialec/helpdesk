<?php

namespace App\Traits;

use App\Models\Site\SiteAbout;
use App\Models\Site\SiteContact;

trait SiteTrait
{
    public function contactSite()
    {
        return SiteContact::first();
    }

    public function aboutSite()
    {
        return SiteAbout::first();
    }
}
