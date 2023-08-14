<?php

namespace App\Http\Controllers;

use App\Models\Reading;
use DateTime;
use Exception;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class ReadingController extends Controller
{
    /**
     * @throws Exception
     */
    function new(string $mpxn, Request $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $request->validate([
            'value' => 'required|integer',
            'date' => 'required|date',
        ]);

        $reading = new Reading([
            'meter_mpxn' => $mpxn,
            'value' => $request->input('value'),
            'date' => new DateTime($request->input('date')),
        ]);
        $reading->save();

        return redirect('/meters/' . $mpxn);
    }
}
