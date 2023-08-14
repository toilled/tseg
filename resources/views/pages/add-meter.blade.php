@extends('layouts.default')
@section('content')
<h1><a href="/">Meters</a> > New Meter</h1>
@if($errors->any())
    <table>
        {!! implode('', $errors->all('<tr><td>:message</td></tr>')) !!}
    </table>
@endif
<form action="/meters/new" method="POST">
    @csrf
    @method('PUT')
    <label for="mpxn">MPXN</label>
    <input type="text" id="mpxn" name="mpxn" {!! $errors->has('mpxn') ? 'placeholder="Invalid" aria-invalid="true"' : '' !!} value="{{ old('mpxn') }}"/>

    <label for="installation">Installation Date</label>
    <input type="datetime-local" id="installation" name="installation" {!! $errors->has('installation') ? 'placeholder="Invalid" aria-invalid="true"' : '' !!} value="{{ old('installation') }}"/>

    <label for="fuel">Fuel</label>
    <select id="fuel" name="fuel" {!! $errors->has('fuel') ? 'placeholder="Invalid" aria-invalid="true"' : '' !!}>
        <option disabled selected>Select</option>
        <option value="Electric" {!! old('fuel') === 'Electric' ? 'selected' : '' !!}>Electric</option>
        <option value="Gas" {!! old('fuel') === 'Gas' ? 'selected' : '' !!}>Gas</option>
    </select>

    <input type="submit"/>
</form>
@stop
