<?php

use App\Models\Meter;
use App\Models\Reading;

/** @var string $mpxn */

/** @var Meter $meter */
$meter = Meter::find(['mpxn' => $mpxn])->first();

if ($meter === null) {
    echo "<script>window.location = \"/\";</script>";
    exit();
}

/** @var Reading[] $readings */
$readings = $meter->readings()->get();
?>

@extends('layouts.default')
@section('content')
<h1><a href="/meters">Meters</a> > {{ $meter->getAttribute('mpxn') }}</h1>
<table>
    <thead>
    <tr>
        <th>Installation Date</th>
        <th>Fuel Type</th>
        <th>EAC</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>{{ $meter->getAttribute('installation') }}</td>
        <td>{{ $meter->getAttribute('fuel') }}</td>
        <td>
            @if($meter->getAttribute('eac') == 0)
                <a href="/meters/{{ $mpxn }}/eac">Set EAC</a>
            @else
                <a href="/meters/{{ $mpxn }}/eac/edit" data-tooltip="Edit EAC">{{ $meter->getAttribute('eac') }}</a>
            @endif
    </tr>
    </tbody>
</table>
<article>
    <header>
        <span style="font-weight: bold; float: left">Readings</span>
        <span style="float:right;">[<a href="/meters/{{ $mpxn }}/readings/add" data-tooltip="Add reading">Add</a>] [<a href="/meters/{{ $mpxn }}/readings/estimate" data-tooltip="Estimate reading">Estimate</a>]</span>
    </header>
    @if($errors->any())
        <p style="color: red">{{ $errors->first() }}</p>
    @endif
    @if(count($readings) === 0)
        <p>There are no readings for this meter yet.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Value</th>
                    <th>Date</th>
                    <th>Estimated</th>
                </tr>
            </thead>
            <tbody>
            @foreach($readings as $reading)
                <tr>
                    <td>{{ $reading->getAttribute('value') }}</td>
                    <td>{{ $reading->getAttribute('date') }}</td>
                    <td>{{ $reading->getAttribute('estimated') ? 'Yes' : 'No' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</article>
@stop
