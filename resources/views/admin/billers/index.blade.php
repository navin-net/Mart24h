@extends('admin.master')
@section('title', __('messages.billers_list'))
@section('content')
    <div class="container-fluid py-4">
        <div class="pagetitle mb-4">
            <h1 class="display-6 fw-bold">{{ $pageTitle }}</h1>
            <nav>
                <ol class="breadcrumb rounded-3 p-2">
                    @foreach ($breadcrumbs as $breadcrumb)
                        <li class="breadcrumb-item {{ $breadcrumb['active'] ? 'active text-muted' : '' }}">
                            @if (!$breadcrumb['active'])
                                <a href="{{ $breadcrumb['url'] }}"
                                    class="text-primary text-decoration-none">{{ $breadcrumb['label'] }}</a>
                            @else
                                {{ $breadcrumb['label'] }}
                            @endif
                        </li>
                    @endforeach
                </ol>
            </nav>
        </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="card-title mb-0 fw-semibold"></h5>
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm dropdown-toggle rounded-3" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-gear-fill me-1"></i> Actions
                                </button>
                                <ul class="dropdown-menu shadow-sm rounded-3">
                                    <li><a class="dropdown-item" id="addUserBtn">{{ __('messages.add') }}</a></li>
                                    <li><a class="dropdown-item" id="bulkDeleteBtn"
                                            disabled>{{ __('messages.delete') }}</a></li>
                                </ul>
                            </div>
                        </div>
                        <div id="alertsContainer" class="mb-4"></div>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered rounded-3 align-middle" id="billersTable">
                                <thead class="table-primary">
                                    <tr>
                                        <th scope="col" class="py-3">
                                            <input type="checkbox" id="selectAll">
                                        </th>
                                        <th scope="col" class="py-3">Name</th>
                                        <th scope="col" class="py-3">Group</th>
                                        <th scope="col" class="py-3">Email</th>
                                        <th scope="col" class="py-3">Phone</th>
                                        <th scope="col" class="py-3">City</th>
                                        <th scope="col" class="py-3">Warehouse</th>
                                        <th scope="col" class="py-3 text-center">Actions</th>
                                    </tr>
                                </thead>

                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script>
$(document).ready(function() {
    const table = $('#billersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('billers.index') }}",
        columns: [{
                data: 'id',
                render: data => `<input type="checkbox" class="selectRow" value="${data}">`,
                orderable: false,
                searchable: false
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'group_name',
                name: 'group_name'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'phone',
                name: 'phone'
            },
            {
                data: 'city',
                name: 'city'
            },
            {
                data: 'warehouse_name',
                name: 'warehouse_name'
            },

            {
                data: 'action',
                orderable: false,
                searchable: false,
                className: 'text-center'
            }
        ]
    });
});
</script>


@endpush