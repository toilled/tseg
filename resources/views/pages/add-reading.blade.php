<?php

use App\Models\Meter;

/** @var string $mpxn */

/** @var Meter $meter */
$meter = Meter::find(['mpxn' => $mpxn])->first();
?>
@if($meter === null)
    <script>window.location = "/";</script>
@endif

@extends('layouts.default')
@section('content')
<h1><a href="/">Meters</a> > <a href="/meters/{{ $mpxn }}">{{ $mpxn }}</a> > New Reading</h1>
<form action="/readings/{{ $mpxn }}/new" method="POST">
    @csrf
    @method('PUT')
    <label for="value">Value</label><input type="number" id="value" name="value" /><br/>
    <label for="date">Date</label><input type="datetime-local" id="date" name="date" /><br/>
    <input type="submit"/>
</form>
@stop
