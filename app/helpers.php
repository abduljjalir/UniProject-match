<?php

use App\Models\Setting;

function setting($key){
    return Setting::where('key', $key)->value('value');
}