<?php

namespace App\Http\Controllers;

use App\Enums\Fuel;
use App\Models\Meter;
use DateTime;
use Exception;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\Rule;

class MeterController extends Controller
{
    /**
     * @throws Exception
     */
    public function new(Request $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $fuelsArray = Fuel::cases();
        $fuels = array_column($fuelsArray, 'name');

        $request->validate([
            'mpxn' => [
                'required',
                'unique:App\Models\Meter,mpxn'
            ],
            'installation' => [
                'required',
                'date'
            ],
            'fuel' => [
                'required',
                Rule::in($fuels)
            ],
            'eac' => [
                'gte:2000',
                'lte:8000',
            ],
        ]);

        $mpxn = $request->input('mpxn');

        $meter = new Meter([
            'mpxn' => $mpxn,
            'installation' => new DateTime($request->input('installation')),
            'fuel' => $request->input('fuel'),
            'eac' => $request->input('eac'),
        ]);
        $meter->save();

        return redirect('/meters/' . $mpxn . '/view');
    }

    public function eac(string $mpxn, Request $request)
    {
        $request->validate([
            'value' => [
                'required',
                'integer',
                'gte:2000',
                'lte:8000',
            ],
        ]);

        /** @var Meter $meter */
        $meter = Meter::find(['mpxn' => $mpxn])->first();

        $meter->setAttribute('eac', $request->input('value'));
        $meter->save();

        return redirect('/meters/' . $mpxn . '/view');
    }
}
