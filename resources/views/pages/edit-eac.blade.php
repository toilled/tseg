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
    <h1><a href="/meters">Meters</a> > <a href="/meters/{{ $mpxn }}/view">{{ $mpxn }}</a> > Edit EAC</h1>
    @if($errors->any())
        <table>
            {!! implode('', $errors->all('<tr><td>:message</td></tr>')) !!}
        </table>
    @endif
    <form action="/meters/{{ $mpxn }}/eac" method="POST">
        @csrf
        @method('PUT')
        <label for="value">Value</label>
        <input type="number" min="2000" max="8000" id="value" name="value" {!! $errors->has('value') ? 'placeholder="Invalid" aria-invalid="true"' : '' !!} value="{{ old('value') ?? $meter->getAttribute('eac') }}"/>

        <input type="submit"/>
    </form>
@stop
