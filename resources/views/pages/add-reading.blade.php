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
<h1><a href="/meters">Meters</a> > <a href="/meters/{{ $mpxn }}/view">{{ $mpxn }}</a> > New Reading</h1>
@if($errors->any())
    <table>
        {!! implode('', $errors->all('<tr><td>:message</td></tr>')) !!}
    </table>
@endif
<form action="/meters/{{ $mpxn }}/readings/new" method="POST">
    @csrf
    @method('PUT')
    <label for="value">Value</label>
    <input type="number" id="value" name="value" {!! $errors->has('value') ? 'placeholder="Invalid" aria-invalid="true"' : '' !!} value="{{ old('value') }}"/>

    <label for="date">Date</label>
    <input type="datetime-local" id="date" name="date" {!! $errors->has('date') ? 'placeholder="Invalid" aria-invalid="true"' : '' !!} value="{{ old('date') }}"/>

    <input type="submit"/>
</form>
@stop
