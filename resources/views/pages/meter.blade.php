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
<h1><a href="/">Meters</a> > {{ $meter->mpxn }}</h1>
<table>
    <thead>
    <tr>
        <th>Installation Date</th>
        <th>Fuel Type</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>{{ $meter->installation }}</td>
        <td>{{ $meter->fuel }}</td>
    </tr>
    </tbody>
</table>
<article>
<header style="font-weight: bold">Readings <a href="/readings/{{ $mpxn }}" data-tooltip="Add reading">+</a></header>
@if(count($readings) === 0)
    <p>There are no readings for this meter yet.</p>
@else
<table>
    <thead>
        <tr>
            <th>Value</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
    @foreach($readings as $reading)
        <tr>
            <td>{{ $reading->value }}</td>
            <td>{{ $reading->date }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@endif
</article>
@stop
