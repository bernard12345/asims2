@extends('layouts.masters')
@section('content')
<div class="col-md-6">
@foreach($poll as $polls)
{{ PollWriter::draw($polls->id, auth()->user()) }}
@endforeach
</div>
@stop
