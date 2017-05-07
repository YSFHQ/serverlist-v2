@extends('app')

@section('content')

<div class="row-fluid">
    <div class="col-md-6 col-md-offset-3">

    @if (isset($server))
    {!! Form::model($server, ['route' => ['server.update', $server->id], 'method' => 'put']) !!}
    @else
    {!! Form::open(['route' => 'server.store']) !!}
        <div class="alert alert-warning" role="alert">
            NOTE: Your server must be online and unlocked in order to add it.
        </div>
    @endif
        <div class="form-group">
            {!! Form::label('name', 'Server name') !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'The Best Server Ever', 'required' => 'required']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('owner', 'Owner') !!}
            {!! Form::text('owner', null, ['class' => 'form-control', 'placeholder' => 'YSFHQ Username']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('website', 'Website') !!}
            {!! Form::text('website', null, ['class' => 'form-control', 'placeholder' => 'http://www.ysfhq.com/']) !!}
        </div>
        <div class="form-group row">
            <div class="col-md-6">
            {!! Form::label('ip', 'IP Address (currently '.Request::ip().')') !!}
            {!! Form::text('ip', (isset($server) ? $server->ip : Request::ip()), ['class' => 'form-control', 'placeholder' => 'NOT 192.168.1.xxx', 'required' => 'required']) !!}
            </div>
            <div class="col-md-6">
            {!! Form::label('port', 'Port') !!}
            {!! Form::text('port', '7915', ['class' => 'form-control', 'placeholder' => '7915', 'required' => 'required']) !!}
            </div>
        </div>
        {{-- <div class="form-group row">
            <div class="col-md-4">
            {!! Form::label('country', 'Country') !!}
            {!! Form::text('country', null, ['class' => 'form-control', 'placeholder' => 'US', 'required' => 'required']) !!}
            </div>
            <div class="col-md-4">
            {!! Form::label('latitude', 'Latitude') !!}
            {!! Form::text('latitude', null, ['class' => 'form-control', 'placeholder' => '41.01234']) !!}
            </div>
            <div class="col-md-4">
            {!! Form::label('longitude', 'Longitude') !!}
            {!! Form::text('longitude', null, ['class' => 'form-control', 'placeholder' => '-83.01234']) !!}
            </div>
        </div> --}}
        {!! Form::submit((isset($server) ? 'Edit' : 'Add').' Server', ['class' => 'btn btn-default']) !!}
    {!! Form::close() !!}

    </div>
</div>

@endsection