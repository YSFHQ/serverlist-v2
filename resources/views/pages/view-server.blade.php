@extends('app')

@section('title') {{ isset($server) ? 'Edit' : 'Add' }} Server - @parent @stop
@section('content')

<div class="row">
    <div class="col-md-6 col-md-offset-3">

    <pre>
        {!! print_r($server->toArray()) !!}
    </pre>

    </div>
</div>

@endsection

@stop
