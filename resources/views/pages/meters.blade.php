<?php

use App\Models\Meter;

/** @var Meter[] $meters */
$meters = Meter::all();
?>

@extends('layouts.default')
@section('content')
<h1>Meters <a href="/meters/add" data-tooltip="Add Meter">+</a></h1>
<table>
    <tbody>
    @foreach($meters as $meter)
        <tr>
            <td><a href="/meters/{{ $meter->mpxn }}/view">{{ $meter->mpxn }}</a></td>
        </tr>
    @endforeach
    </tbody>
</table>
@stop
