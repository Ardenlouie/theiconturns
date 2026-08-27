@extends('adminlte::master')

@php
    $dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home');

    if (config('adminlte.use_route_url', false)) {
        $dashboard_url = $dashboard_url ? route($dashboard_url) : '';
    } else {
        $dashboard_url = $dashboard_url ? url($dashboard_url) : '';
    }

    $bodyClasses = ($auth_type ?? 'login') . '-page';

    if (! empty(config('adminlte.layout_dark_mode', null))) {
        $bodyClasses .= ' dark-mode';
    }
@endphp

@section('adminlte_css')
    @stack('css')
    @yield('css')
    <style>
        .login-logo,
        .register-logo {
            text-align: center;
            margin-bottom: 1.5rem !important;
        }
        .login-logo a,
        .register-logo a {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            gap: 0.65rem;
            text-decoration: none !important;
        }
        .auth-logo-img-wrap {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--glass-bg-hover);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border: 2px solid var(--glass-border);
            box-shadow:
                0 8px 32px rgba(99, 102, 241, 0.22),
                inset 0 0 0 1px rgba(255,255,255,0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: box-shadow 0.3s, transform 0.3s;
        }
        .login-logo a:hover .auth-logo-img-wrap,
        .register-logo a:hover .auth-logo-img-wrap {
            box-shadow:
                0 12px 40px rgba(99, 102, 241, 0.35),
                inset 0 0 0 1px rgba(255,255,255,0.6);
            transform: translateY(-2px);
        }
        .auth-logo-img-wrap img {
            width: 52px;
            height: 52px;
            object-fit: contain;
            border-radius: 50%;
            display: block;
        }
        .auth-logo-text {
            font-size: 1.45rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, var(--accent-1), var(--accent-2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: none;
            line-height: 1;
        }
        body.dark-mode .auth-logo-img-wrap {
            box-shadow:
                0 8px 32px rgba(99, 102, 241, 0.3),
                inset 0 0 0 1px rgba(255,255,255,0.08);
        }
        body {
            /* 1. Full height setup */
            min-height: 100vh;
            margin: 0;

            /* 2. Gradient overlay + background image */
            background-image: 
                linear-gradient(rgb(255, 255, 255), rgba(253, 253, 253, 1)), 
                url("{{ asset('images/kojiesan.png') }}");
            
            /* 3. Center and cover properties */
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
    
@stop

@section('iCheckBoostrap', true)

@section('classes_body'){{ $bodyClasses }}@stop

@section('body')
<div class="container-fluid p-0">

    <!-- 1. Top Responsive Banner Header -->
    <div class="w-100" style=" overflow: hidden;">

        <div class="position-absolute top-0 start-0 w-100 h-100 d-none d-md-block" style="
            background: radial-gradient(circle at center, transparent 60%, rgba(253, 253, 253, 0.95) 80%);
            pointer-events: none;
            z-index: 2;">
        </div>
       
        <!-- Desktop Image (screens 768px and up) -->
        <img src="{{ asset('images/desktop3.png') }}" class="img-fluid d-none d-md-block w-100" style="object-fit: cover; height: 100%;" alt="Desktop Banner">
        
        <!-- Mobile Image (screens under 768px) -->
        <img src="{{ asset('images/mobile2.png') }}" class="img-fluid d-block d-md-none w-100" style="object-fit: cover; height: 100%;" alt="Mobile Banner">

    
    </div>

    

    @yield('auth_body')
        <img src="{{ asset('images/bg2.png') }}" class="img-fluid w-100 d-block d-md-none" style=" object-fit: cover;">

    {{-- Card Footer --}}
    @hasSection('auth_footer')
        <div class="card-footer {{ config('adminlte.classes_auth_footer', '') }} bg-white">
            
            @yield('auth_footer')
        </div>
    @endif
</div>

@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
    <script>
        $(function() {
            $('body').on('click', '.btn-confirm', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: "Final Confirmation",
                    text: "Are you sure you want to cofirm your Attendance?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#0ba236",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, confirm it!",
                    cancelButtonText: "No",
                    }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                        allowOutsideClick: false,
                        title: "Confirmed!",
                        text: "Your attendance has been sent.",
                        icon: "success"
                        });

                        Swal.showLoading();

                        $('#confirm').submit();

                    }
                    });
            });
        });
    </script>
@stop
