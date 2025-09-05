@extends('admin.master')
@section('title', __('messages.units_list'))

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
                                    <li><a class="dropdown-item" id="addUnitsBtn">{{ __('messages.add') }}</a></li>
                                    <li><a class="dropdown-item" id="bulkDeleteBtn"
                                            disabled>{{ __('messages.delete') }}</a></li>
                                </ul>
                            </div>
                        </div>
                        <div id="alertsContainer" class="mb-4"></div>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered rounded-3 align-middle" id="unitsTable">
                                <thead class="table-primary">
                                    <tr>
                                        <th scope="col" class="py-3"><input type="checkbox" id="selectAll"></th>
                                        <th scope="col" class="py-3">{{ __('messages.name')}}</th>
                                        <th scope="col" class="py-3">{{ __('messages.slug')}}</th>
                                        <th scope="col" class="py-3 text-center">{{ __('messages.actions')}}</th>
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
    <!-- Add Units Modal -->
    <div class="modal fade" id="addUnitsModal" tabindex="-1" aria-labelledby="addUnitsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 border-0 shadow">
                <div class="modal-header border-0  rounded-top-3">
                    <h5 class="modal-title fw-semibold" id="addUnitsModalLabel">Create New Units</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="createUnitsForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-medium">Units Name</label>
                            <input type="text" class="form-control rounded-3" name="name" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="slug" class="form-label fw-medium">Slug</label>
                            <input type="text" class="form-control rounded-3" name="slug" id="slug">
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary btn-sm rounded-3"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm rounded-3">Save Units</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="editUnitsModal" tabindex="-1" aria-labelledby="editUnitsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 border-0 shadow">
                <div class="modal-header border-0  rounded-top-3">
                    <h5 class="modal-title fw-semibold" id="editUnitsModalLabel">Edit units</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editUnitsForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editName" class="form-label fw-medium">units Name</label>
                            <input type="text" class="form-control rounded-3" name="name" id="editName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editSlug" class="form-label fw-medium">Slug</label>
                            <input type="text" class="form-control rounded-3" name="slug" id="editSlug">
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary btn-sm rounded-3"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm rounded-3">Update units</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteUnitsModal" tabindex="-1" aria-labelledby="deleteUnitsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 border-0 shadow">
                <div class="modal-header border-0  rounded-top-3">
                    <h5 class="modal-title fw-semibold" id="deleteUnitsModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this units?
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary btn-sm rounded-3"
                        data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteUnitsForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm rounded-3">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Delete Confirmation Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 border-0 shadow">
                <div class="modal-header border-0  rounded-top-3">
                    <h5 class="modal-title fw-semibold" id="deleteUnitsModalLabel">Confirm Delete</h5>
                    <!-- <h5 class="modal-title fw-semibold" id="confirmModalLabel">Confirm Deletion</h5> -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the selected units?
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary btn-sm rounded-3"
                        data-bs-dismiss="modal">Cancel</button>
                    <button id="confirmDeleteBtn" type="button" class="btn btn-danger btn-sm rounded-3">Delete</button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@push('scripts')
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function() {
    var table = $('#unitsTable').DataTable({
        dom: 'lBfrtip', // Ensure 'l' is included for the length menu
        pageLength: 10, // Default rows per page
        lengthMenu: [
            [10, 20, 30, 50, -1],
            [10, 20, 30, 50, "All"]
        ], // Custom options including "All"
        buttons: [],
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('units.index') }}",
        columns: [{
                data: 'id',
                name: 'id',
                render: function(data) {
                    return `<input type="checkbox" class="Checkbox" value="${data}">`;
                },
                orderable: false,
                searchable: false
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'slug',
                name: 'slug'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ],
        language: {
            paginate: {
                previous: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/></svg>',
                next: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/></svg>'
            },
            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
            lengthMenu: 'Show _MENU_ entries',
            search: 'Search:',
            emptyTable: 'No data available in table'
        }
    });


    // Show Add Units Modal
    $('#addUnitsBtn').click(function() {
        $('#addUnitsModal').modal('show');
    });

    // Create Units
    $('#createUnitsForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('units.store') }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#addUnitsModal').modal('hide');
                table.ajax.reload();
                const successAlert = `
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Units add successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
                $('#alertsContainer').html(successAlert);
            },
            error: function(response) {
                alert('Error: ' + response.responseJSON.message);
            }
        });
    });


    // Edit units
    $(document).on('click', '.editUnits', function() {
        var id = $(this).data('id');
        $.get("{{ url('units') }}/" + id + "/edit", function(data) {
            $('#editUnitsModal').modal('show');
            $('#editName').val(data.units.name);
            $('#editSlug').val(data.units.slug);
            $('#editUnitsForm').attr('action', "{{ url('units') }}/" + id);
        });
    });

    // Update units
    $('#editUnitsForm').submit(function(e) {
        e.preventDefault();
        var id = $(this).attr('action').split('/').pop();
        $.ajax({
            url: "{{ url('units') }}/" + id,
            method: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                $('#editUnitsModal').modal('hide');
                table.ajax.reload();
                const successAlert = `
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        units Update successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
                $('#alertsContainer').html(successAlert);
            },
            error: function(response) {
                alert('Error: ' + response.responseJSON.message);
            }
        });
    });



    $(document).on('click', '.deleteUnits', function() {
        var id = $(this).data('id');
        $('#deleteUnitsForm').attr('action', "{{ url('units') }}/" + id);
        $('#deleteUnitsModal').modal('show');
    });

    $('#deleteUnitsForm').submit(function(e) {
        e.preventDefault();
        var id = $(this).attr('action').split('/').pop();
        $.ajax({
            url: "{{ url('units') }}/" + id,
            method: 'DELETE',
            success: function(response) {
                $('#deleteUnitsModal').modal('hide');
                table.ajax.reload();
                const successAlert = `
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        units Delete successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
                $('#alertsContainer').html(successAlert);
            },
            error: function(response) {
                alert('Error: ' + response.responseJSON.message);
            }
        });
    });



    $('#selectAll').on('click', function() {
        var isChecked = $(this).prop('checked');
        $('.Checkbox').prop('checked', isChecked);
    });

    $('#bulkDeleteBtn').on('click', function() {
        var selectedIds = [];
        $('.Checkbox:checked').each(function() {
            selectedIds.push($(this).val());
        });

        if (selectedIds.length > 0) {
            var confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
            confirmModal.show();

            $('#confirmDeleteBtn').off('click').on('click', function() {
                $.ajax({
                    url: "{{ route('units.bulkDelete') }}",
                    method: 'POST',
                    data: {
                        ids: selectedIds
                    },
                    success: function(response) {
                        table.ajax.reload();
                        const successAlert = `
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Category Delete successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
                        $('#alertsContainer').html(successAlert);
                    },
                    error: function(response) {
                        showToast('error', 'Error: ' + response.responseJSON
                            .message);
                    }
                });
                confirmModal.hide();
            });
        } else {
            showToast('warning', 'Please select at least one units.');
        }
    });




});
</script>
@endpush