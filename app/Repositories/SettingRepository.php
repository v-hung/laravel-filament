<?php

namespace App\Repositories;

use App\Models\Setting;

class SettingRepository
{

    public function getAll()
    {
        return Setting::get();
    }
}
