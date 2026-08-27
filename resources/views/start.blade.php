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
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-8">
                
                <div class="card border-0 shadow-sm bg-white rounded-4 p-4 p-md-5">
                    <!-- <div class="text-center mb-4">
                        <img src="{{ asset('images/kojiesan.png') }}" class="img-fluid d-block mx-auto mb-3" style="height: 150px; width: 150px; object-fit: contain;" alt="logo">

                        <h2 class="text-bold text-dark text-uppercase">Event Registration Form</h2>

                        <p class="text-muted small">Please fill in your details below.</p>
                    </div> -->

                    <form method="POST" action="{{ route('register-invite') }}" id="confirm">
                        @csrf

                        <!-- Name -->
                        <div class="form-floating mb-3">
                            <label class="mb-0">Name: <small class="text-danger font-italic text-bold">(required)</small></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Company / Organization -->
                        <div class="form-floating mb-3">
                            <label class="mb-0">Company / Organization: <small class="text-danger font-italic text-bold">(required)</small></label>
                            <input type="text" class="form-control @error('company') is-invalid @enderror" id="company" name="company" placeholder="Company" value="{{ old('company') }}">

                            @error('company')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Position / Title -->
                        <div class="form-floating mb-3">
                            <label class="mb-0">Position / Title: <small class="text-danger font-italic text-bold">(required)</small></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Position" value="{{ old('title') }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email Address -->
                        <div class="form-floating mb-3">
                            <label class="mb-0">Email Address: <small class="text-danger font-italic text-bold">(required)</small></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Are you attending -->
                        <div class="form-floating mb-3">
                            <label class="mb-0">Are you attending? <small class="text-danger font-italic text-bold">(required)</small></label>

                                <select class="form-control" id="attending" name="attending" required>
                                    <option value="" disabled {{ old('attending') === null ? 'selected' : '' }}>-- Select option --</option>
                                    <option value="YES" {{ old('attending') === 'YES' ? 'selected' : '' }}>Yes, I will attend</option>
                                    <option value="NO" {{ old('attending') === 'NO' ? 'selected' : '' }}>No, I cannot make it</option>
                                </select>
                            @error('attending')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div class="form-floating mb-4">
                            <label class="mb-0">Note: <small class=" font-italic text-bold">(optional)</small></label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" placeholder="Notes" style="height: 90px">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <input type="hidden" name="control_number" value="{{$control_number}}"> 

                        <a href="#" title="confirm" class="btn-confirm btn bg-danger btn-lg w-100 fw-semibold rounded-3 py-3">CONFIRM</a>

                    </form>
                </div>

            </div>
        </div>
    </div>

@stop

@section('auth_footer')

    <strong>Copyright &copy; {{ date('Y') }}
            <a href="https://www.bevi.com.ph/" target="_blank">BEVI Beauty Elements Ventures Inc.</a>
        </strong>
@stop