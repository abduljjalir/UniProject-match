<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings.index', [
            'results_date' => setting('results_date'),
            'review_date' => setting('review_date'),
        ]);
    }

    public function store(Request $request)
    {
        Setting::updateOrCreate(
            ['key' => 'results_date'],
            ['value' => $request->results_date]
        );

        Setting::updateOrCreate(
            ['key' => 'review_date'],
            ['value' => $request->review_date]
        );

        return back()->with('success', 'Settings updated!');
    }
}