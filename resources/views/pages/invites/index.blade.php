@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', __('Invite Lists'))
@section('content_header_title', __('Invites'))
@section('content_header_subtitle', __('Invite List'))

{{-- Content body: main page content --}}
@section('content_body')
    <div class="card">
        <div class="card-header py-2">
            <div class="row">
                <!-- Total Forms Created -->
                    <div class="col-lg-4 col-6">
                        <div class="small-box bg-white border-left-primary shadow-sm rounded">
                            <div class="inner p-3">
                                <span class="text-uppercase text-muted font-weight-bold text-xs">Total RSVP</span>
                                <h2 class="font-weight-bold my-1 text-primary">{{ $invite_count ?? 0 }}</h2>
                                <p class="mb-0 text-xs text-primary">
                                    <i class="fas fa-arrow-up mr-1"></i>All RSVP
                                </p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-plus text-primary opacity-25"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Approval -->
                    <div class="col-lg-4 col-6">
                        <div class="small-box bg-white border-left-primary shadow-sm rounded">
                            <div class="inner p-3">
                                <span class="text-uppercase text-muted font-weight-bold text-xs">Attending Guest</span>
                                <h2 class="font-weight-bold my-1 text-dark">{{ $attending_count ?? 0 }}</h2>
                                <p class="mb-0 text-xs text-dark">RSVP responsed YES</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-clock text-dark opacity-25"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-6">
                        <div class="small-box bg-white border-left-success shadow-sm rounded">
                            <div class="inner p-3">
                                <span class="text-uppercase text-muted font-weight-bold text-xs">Confirmed Guest</span>
                                <h2 class="font-weight-bold my-1 text-success">{{ $confirmed_count ?? 0 }}</h2>
                                <p class="mb-0 text-xs text-success">
                                    <i class="fas fa-check-circle mr-1"></i>Confirmed attending guests
                                </p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-thumbs-up text-success opacity-25"></i>
                            </div>
                        </div>
                    </div>
                
            </div>
        </div>
        <div class="card-body">

            <div class="row mb-3">
                <div class="col-lg-4">
                    <div class="form-group">
                        <input type="text" id="search_forms" class="form-control form-control-xl" placeholder="Search">
                    </div>
                </div>
                <div class="col-lg-4 mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-filter"></i>STATUS</span>
                        </div>
                        <select id="status_filter" name="status" class="form-control text-uppercase">
                            <option value="">All</option>
                            <option value="1">Confirmed</option>
                            <option value="not_guest">Not Guest</option>
                            <option value="null">Not yet confirmed</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 ">
                    <a href="{{ route('invite.export') }}" class="btn btn-success fw-semibold float-right">
                        <i class="bi bi-file-earmark-excel me-1"></i> Export to Excel
                    </a>
                </div>
            </div>
            
            <div id="forms_table_container" class="table-responsive p-0">
                @include('pages.invites.partials' )
            </div>

        </div>
        <div class="card-footer">
            <div class="modal fade" id="modal-confirm">
                <div class="modal-dialog modal-dialog-centered">
                    <livewire:confirm />
                </div>
            </div>
        </div>
    </div>
@stop

{{-- Push extra CSS --}}
@push('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endpush

{{-- Push extra scripts --}}
@push('js')
<script>
    let debounceTimer;

    // Listen to both the search input and the status select
    const searchInput = document.getElementById('search_forms');
    const statusSelect = document.getElementById('status_filter'); // Ensure your <select> has this ID

    const handleFilterChange = () => {
        let searchTerm = searchInput.value;
        let status = statusSelect ? statusSelect.value : '';

        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            fetchSearch(searchTerm, status);
        }, 300);
    };

    searchInput.addEventListener('input', handleFilterChange);
    
    if (statusSelect) {
        statusSelect.addEventListener('change', handleFilterChange);
    }

    function fetchSearch(query, status) {
        document.getElementById('forms_table_container').style.opacity = '0.5';

        fetch(`/invites?search=${query}&status=${status}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            document.getElementById('forms_table_container').innerHTML = html;
            document.getElementById('forms_table_container').style.opacity = '1';
        })
        .catch(error => {
            console.warn('Error fetching search:', error);
            document.getElementById('forms_table_container').style.opacity = '1';
        });
    }
</script>
<script>
    $(function() {
        $('body').on('click', '.btn-confirm', function(e) {
            e.preventDefault();
            let data = {
                id: $(this).data('id'),
            };
            Livewire.dispatch('confirmInvite', {data});
            $('#modal-confirm').modal('show');
        });
    });
</script>
<script>
    $(function() {
        $('body').on('click', '.btn-delete', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            Livewire.dispatch('setDeleteModel', {type: 'OrgStructure', model_id: id});
            $('#modal-delete').modal('show');
        });
    });
</script>

@endpush