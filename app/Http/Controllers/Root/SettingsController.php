<?php

namespace App\Http\Controllers\Root;

use App\Services\{Notify};
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    /**
     * Show settings page
     * @return \Illuminate\View\View
     */
    public function showSettingsPage()
    {
        return view('root.system.settings');
    }

    /**
     * Update settings
     * @param Illuminate\Http\Request
     * @return Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        foreach ($request->all() as $name => $value) {
            DB::table('settings')->where('name', $name)->update([
                'value' => $value
            ]);
        }

        Notify::success('Settings updated.', 'Success!');

        return back();
    }
}
