<?php

namespace App\Http\Controllers;

use App\Models\Meter;
use DateTime;
use Exception;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class MeterController extends Controller
{
    /**
     * @throws Exception
     */
    function new(Request $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $mpxn = $request->input('mpxn');

        $meter = new Meter([
            'mpxn' => $mpxn,
            'installation' => new DateTime($request->input('installation')),
            'fuel' => $request->input('fuel'),
        ]);
        $meter->save();

        return redirect('/meters/' . $mpxn);
    }
}
