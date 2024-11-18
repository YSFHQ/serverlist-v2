@extends('layouts.app')

@section('content')

<div class="row mt-3 mb-3">
    <div class="col-md-6 col-md-offset-3">

    @if (isset($server))
    {{ html()->modelForm($server, 'PUT', '/server/'.$server->id) }}
    @else
    {{ html()->form('POST', '/server')->open() }}
        <div class="alert alert-warning" role="alert">
            NOTE: Your server must be online and unlocked in order to add it.
        </div>
    @endif
        <div class="form-group mb-3">
            {{ html()->label('Server name', 'name') }}
            {{ html()->text('name')->class('form-control')->placeholder('The Best Server Ever')->required() }}
        </div>
        <div class="form-group mb-3">
            {{ html()->label('Owner', 'owner') }}
            {{ html()->text('owner')->class('form-control')->placeholder('YSFHQ Username')->required() }}
        </div>
        <div class="form-group mb-3">
            {{ html()->label('Website', 'website') }}
            {{ html()->text('website')->class('form-control')->placeholder('http://www.ysfhq.com/') }}
        </div>
        <div class="form-group row mb-3">
            <div class="col-md-6">
            {{ html()->label('IP Address (currently '.Request::ip().')', 'ip') }}
            {{ html()->text('ip', isset($server) ? $server->ip : Request::ip())->class('form-control')->placeholder('NOT 192.168.1.xxx')->required() }}
            </div>
            <div class="col-md-6">
            {{ html()->label('Port', 'port') }}
            {{ html()->text('port', isset($server) ? $server->port : '7915')->class('form-control')->placeholder('7915')->required() }}
            </div>
        </div>
        {{-- <div class="form-group row mb-3">
            <div class="col-md-4">
            {{ html()->label('Country', 'country') }}
            {{ html()->text('country')->class('form-control')->placeholder('US')->required() }}
            </div>
            <div class="col-md-4">
            {{ html()->label('Latitude', 'latitude') }}
            {{ html()->text('latitude')->class('form-control')->placeholder('41.01234') }}
            </div>
            <div class="col-md-4">
            {{ html()->label('Longitude', 'longitude') }}
            {{ html()->text('longitude')->class('form-control')->placeholder('-83.01234') }}
            </div>
        </div> --}}
        @csrf
        {{ html()->submit((isset($server) ? 'Edit' : 'Add').' Server')->class('btn btn-primary') }}
    @if (isset($server))
    {{ html()->closeModelForm() }}
    @else
    {{ html()->form()->close() }}
    @endif

    </div>
</div>

@endsection
