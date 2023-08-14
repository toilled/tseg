<?php

use App\Models\Meter;

/** @var Meter $meter */

$mpxn = $meter->mpxn;
?>
@extends('layouts.default')
@section('content')
    <h1><a href="/meters">Meters</a> > <a href="/meters/{{ $mpxn }}/view">{{ $mpxn }}</a> > Estimate Reading</h1>
    @if($errors->any())
        <table>
            {!! implode('', $errors->all('<tr><td>:message</td></tr>')) !!}
        </table>
    @endif
    <form action="/meters/{{ $mpxn }}/readings/estimate" method="POST">
        @csrf
        @method('PUT')
        <label for="date">Date</label>
        <input type="datetime-local" id="date" name="date" {!! $errors->has('date') ? 'placeholder="Invalid" aria-invalid="true"' : '' !!} value="{{ old('date') }}"/>

        <input type="submit"/>
    </form>
@stop
