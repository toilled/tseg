<?php

namespace App\Http\Controllers;

use App\Models\Meter;
use App\Models\Reading;
use DateTime;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Redirect;

class ReadingController extends Controller
{
    public function createEstimate(string $mpxn): Application|View|Factory|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        /** @var Meter $meter */
        $meter = Meter::find(['mpxn' => $mpxn])->first();

        if ($meter === null) {
            return redirect('/');
        }

        if (count($meter->readings()->get()) === 0) {
            return Redirect::back()->withErrors(['msg' => 'There must be a previous reading to estimate a new one.']);
        }

        if (!$meter->validEAC()) {
            return Redirect::back()->withErrors(['msg' => 'The estimated usage has not been set on this meter.']);
        }

        return view('pages.estimate-reading', ['meter' => $meter]);
    }

    /**
     * @throws Exception
     */
    public function calculateEstimate(string $mpxn, Request $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $request->validate([
            'date' => [
                'required',
                'date'
            ],
        ]);

        $estimationDate = new DateTime($request->input('date'));

        /** @var Meter $meter */
        $meter = Meter::find(['mpxn' => $mpxn])->first();
        /** @var Reading $lastReading */
        $lastReading = $meter->getLastReading();
        $lastReadingDate = new DateTime($lastReading->date);

        if ($lastReadingDate > $estimationDate) {
            return Redirect::back()->withErrors(['date' => 'Estimation date must be after last real reading.']);
        }

        $daysBetweenReadings = $estimationDate->diff($lastReadingDate)->days;
        $estimatedUsage = ($meter->eac / 365) * $daysBetweenReadings;

        $reading = new Reading([
            'meter_mpxn' => $mpxn,
            'value' => (int)($lastReading->value + $estimatedUsage),
            'date' => $estimationDate,
            'estimated' => true,
        ]);
        $reading->save();

        return redirect('/meters/' . $mpxn . '/view');
    }

    /**
     * @throws Exception
     */
    public function new(string $mpxn, Request $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $request->validate([
            'value' => [
                'required',
                'integer'
            ],
            'date' => [
                'required',
                'date'
            ],
        ]);

        $readingDate = new DateTime($request->input('date'));
        $readingValue = $request->input('value');

        /** @var Meter $meter */
        $meter = Meter::find(['mpxn' => $mpxn])->first();
        /** @var Reading $lastReading */
        $lastReading = $meter->getLastReading();
        $lastReadingDate = new DateTime($lastReading->date);

        $daysBetweenReadings = $readingDate->diff($lastReadingDate)->days;
        $estimatedUsage = ($meter->eac / 365) * $daysBetweenReadings;

        $realDifference = $readingValue - $lastReading->value;
        $percentageBetweenEstimatedAndReal = (1 - $estimatedUsage / $realDifference) * 100;
        if (abs($percentageBetweenEstimatedAndReal) > 25) {
            return Redirect::back()->withErrors(['value' => 'Provided meter value differs more than 25% from estimation.']);
        }

        $reading = new Reading([
            'meter_mpxn' => $mpxn,
            'value' => $readingValue,
            'date' => $readingDate,
        ]);
        $reading->save();

        return redirect('/meters/' . $mpxn . '/view');
    }
}
