<?php

namespace App\Http\Traits;

use App\Models\Setting;

trait ShareSettings
{
    public bool $loaded = false;

    public array $settings = [];

    public function shareSettingsData()
    {
        if (!$this->loaded) {
            $this->settings = Setting::get();
        }
        return $this->settings;
    }
}
