@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', __('RSVP'))
@section('content_header_title', __('Invites'))
@section('content_header_subtitle', __('RSVP'))

{{-- Content body: main page content --}}
@section('content_body')

@include('pages.invites.invite' )

@stop

{{-- Push extra CSS --}}
@push('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endpush