@extends('app')

@section('title') Edit Server - @parent @stop
@section('content')

{!! Form::model($server, ['action' => 'ServerController@update']) !!}
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
    <div class="form-group">
        {!! Form::label('ip', 'IP Address') !!}
        {!! Form::text('ip', null, ['class' => 'form-control', 'placeholder' => 'NOT 192.168.1.xxx', 'required' => 'required']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('port', 'Port') !!}
        {!! Form::text('port', null, ['class' => 'form-control', 'placeholder' => '7915', 'required' => 'required']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('country', 'Country') !!}
        {!! Form::text('country', null, ['class' => 'form-control', 'placeholder' => 'US', 'required' => 'required']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('latitude', 'Latitude') !!}
        {!! Form::text('latitude', null, ['class' => 'form-control', 'placeholder' => '41.01234']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('longitude', 'Longitude') !!}
        {!! Form::text('longitude', null, ['class' => 'form-control', 'placeholder' => '-83.01234']) !!}
    </div>
    {!! Form::submit('Edit Server', ['class' => 'btn btn-default']) !!}
{!! Form::close() !!}

@endsection

@stop
