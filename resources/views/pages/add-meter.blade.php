@extends('layouts.default')
@section('content')
<h1><a href="/">Meters</a> > New Meter</h1>
<form action="/meters/new" method="POST">
    @csrf
    @method('PUT')
    <label for="mpxn">MPXN</label><input type="text" id="mpxn" name="mpxn" /><br/>
    <label for="installation">Installation Date</label><input type="datetime-local" id="installation" name="installation" /><br/>
    <label for="fuel">Fuel</label>
    <select id="fuel" name="fuel">
        <option disabled selected>Select</option>
        <option>Electric</option>
        <option>Gas</option>
    </select><br/>
    <input type="submit"/>
</form>
@stop
