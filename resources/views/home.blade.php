@extends('layouts.app')

@section('content_header')
<div class="row">
    <div class="col-md-6">
        <h1></h1>
    </div>

</div>
@endsection

@section('content_body')
<div class="col-lg-12 text-center">
    <a href="{{ url('/invites') }}" class="btn btn-primary btn-xl">
        <h1><i class="fas fa-user-plus"></i>
            INVITES
        </h1>
    </a>
</div>
@stop

{{-- Push extra CSS --}}

@push('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endpush

{{-- Push extra scripts --}}

@push('js')
@endpush
