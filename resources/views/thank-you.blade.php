@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('adminlte_css_pre')
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@stop

@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )
@php( $register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register') )
@php( $register_pet = View::getSection('register_pet') ?? config('adminlte.register_pet', 'register_pet') )
@php( $password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset') )

@if (config('adminlte.use_route_url', false))
    @php( $login_url = $login_url ? route($login_url) : '' )
    @php( $register_url = $register_url ? route($register_url) : '' )
    @php( $register_pet = $register_pet ? route($register_pet) : '' )
    @php( $password_reset_url = $password_reset_url ? route($password_reset_url) : '' )
@else
    @php( $login_url = $login_url ? url($login_url) : '' )
    @php( $register_url = $register_url ? url($register_url) : '' )
    @php( $register_pet = $register_pet ? url($register_pet) : '' )
    @php( $password_reset_url = $password_reset_url ? url($password_reset_url) : '' )
@endif

@section('auth_header', __(''))

@section('auth_body')
@if(session()->has('message_error'))
    <div class="alert alert-danger" role="alert">
        <i class="fa fa-exclamation mr-1"></i> Error!
        <br>
        {{session('message_error')}}
    </div>
@endif

<div class="card border-0 shadow-sm bg-white rounded-4 p-4 p-md-5">
    <div class="text-center mb-4">
        <img src="{{ asset('images/kojiesan.png') }}" class="img-fluid d-block mx-auto mb-3" style="height: 150px; width: 150px; object-fit: contain;" alt="logo">

        <h2 class="text-bold text-dark text-uppercase">THANK YOU FOR CONFIRMING YOUR ATTENDANCE!</h2>

        <!-- <p class="text-muted small">Please fill in your details below.</p> -->
    </div>
</div>

@stop

@section('auth_footer')
    <strong>Copyright &copy; {{ date('Y') }}
            <a href="https://www.bevi.com.ph/" target="_blank">BEVI Beauty Elements Ventures Inc.</a>
        </strong>
@stop