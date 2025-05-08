@extends('admin.master')
@section('title', 'Qualitys List')

@section('content')
<div class="container-fluid py-4">
    <div class="pagetitle mb-4">
        <h1 class="display-6 fw-bold">{{ $pageTitle }}</h1>
        <nav>
            <ol class="breadcrumb rounded-3 p-2">
                @foreach ($breadcrumbs as $breadcrumb)
                    <li class="breadcrumb-item {{ $breadcrumb['active'] ? 'active text-muted' : '' }}">
                        @if (!$breadcrumb['active'])
                            <a href="{{ $breadcrumb['url'] }}" class="text-primary text-decoration-none">{{ $breadcrumb['label'] }}</a>
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
                            <h5 class="card-title mb-0 fw-semibold">Qualitys Table</h5>
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm dropdown-toggle rounded-3" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-gear-fill me-1"></i> Actions
                                </button>
                                <ul class="dropdown-menu shadow-sm rounded-3">
                                    <li><a class="dropdown-item" id="addQualityBtn">{{ __('messages.add') }}</a></li>
                                    <li><a class="dropdown-item" id="bulkDeleteBtn" disabled>{{ __('messages.delete') }}</a></li>
                                </ul>
                            </div>
                        </div>
                        <div id="alertsContainer" class="mb-4"></div>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered rounded-3 align-middle" id="qualitysTable">
                                <thead class="table-primary">
                                    <tr>
                                        <th scope="col" class="py-3"><input type="checkbox" id="selectAll"></th>
                                        <th scope="col" class="py-3">Name</th>
                                        <th scope="col" class="py-3">Description</th>
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

    <!-- Add Qualitys Modal -->
    <div class="modal fade" id="addQualityModal" tabindex="-1" aria-labelledby="addQualityModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 border-0 shadow">
                <div class="modal-header border-0 rounded-top-3">
                    <h5 class="modal-title fw-semibold" id="addQualityModalLabel">Create New Qualitys</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="createQualityForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-medium">Qualitys Name</label>
                            <input type="text" class="form-control rounded-3" name="name" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label fw-medium">Description</label>
                            <input type="text" class="form-control rounded-3" name="description" id="description">
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm rounded-3">Save Qualitys</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Qualitys Modal -->
    <div class="modal fade" id="editQualityModal" tabindex="-1" aria-labelledby="editQualityModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 border-0 shadow">
                <div class="modal-header border-0 rounded-top-3">
                    <h5 class="modal-title fw-semibold" id="editQualityModalLabel">Edit Qualitys</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editQualityForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editName" class="form-label fw-medium">Qualitys Name</label>
                            <input type="text" class="form-control rounded-3" name="name" id="editName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDescription" class="form-label fw-medium">Description</label>
                            <input type="text" class="form-control rounded-3" name="description" id="editDescription">
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm rounded-3">Update Qualitys</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Qualitys Modal -->
    <div class="modal fade" id="deleteQualityModal" tabindex="-1" aria-labelledby="deleteQualityModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 border-0 shadow">
                <div class="modal-header border-0 rounded-top-3">
                    <h5 class="modal-title fw-semibold" id="deleteQualityModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this qualitys?
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteQualityForm" method="POST">
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
                <div class="modal-header border-0 bg-light rounded-top-3">
                    <h5 class="modal-title fw-semibold" id="confirmModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the selected qualitys?
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-dismiss="modal">Cancel</button>
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
        var table = $('#qualitysTable').DataTable({
            dom: 'lBfrtip',
            pageLength: 10,
            lengthMenu: [
                [10, 20, 30, 50, -1],
                [10, 20, 30, 50, "All"]
            ],
            buttons: [],
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('qualitys.index') }}",
            columns: [
                {
                    data: 'id',
                    name: 'id',
                    render: function(data) {
                        return `<input type="checkbox" class="qualitysCheckbox" value="${data}">`;
                    },
                    orderable: false,
                    searchable: false
                },
                { data: 'name', name: 'name' },
                { data: 'description', name: 'description' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
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

        // Show Add Qualitys Modal
        $('#addQualityBtn').click(function() {
            $('#addQualityModal').modal('show');
        });

        // Create Qualitys
        $('#createQualityForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('qualitys.store') }}",
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#addQualityModal').modal('hide');
                    table.ajax.reload();
                    const successAlert = `
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Qualitys added successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
                    $('#alertsContainer').html(successAlert);
                },
                error: function(response) {
                    alert('Error: ' + response.responseJSON.message);
                }
            });
        });

        // Edit Qualitys
        $(document).on('click', '.editQuality', function() {
            var id = $(this).data('id');
            $.get("{{ url('qualitys') }}/" + id + "/edit", function(data) {
                $('#editQualityModal').modal('show');
                $('#editName').val(data.qualitys.name);
                $('#editDescription').val(data.qualitys.description);
                $('#editQualityForm').attr('action', "{{ url('qualitys') }}/" + id);
            });
        });

        // Update Qualitys
        $('#editQualityForm').submit(function(e) {
            e.preventDefault();
            var id = $(this).attr('action').split('/').pop();
            $.ajax({
                url: "{{ url('qualitys') }}/" + id,
                method: 'PUT',
                data: $(this).serialize(),
                success: function(response) {
                    $('#editQualityModal').modal('hide');
                    table.ajax.reload();
                    const successAlert = `
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Qualitys updated successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
                    $('#alertsContainer').html(successAlert);
                },
                error: function(response) {
                    alert('Error: ' + response.responseJSON.message);
                }
            });
        });

        // Delete Qualitys
        $(document).on('click', '.deleteQuality', function() {
            var id = $(this).data('id');
            $('#deleteQualityForm').attr('action', "{{ url('qualitys') }}/" + id);
            $('#deleteQualityModal').modal('show');
        });

        $('#deleteQualityForm').submit(function(e) {
            e.preventDefault();
            var id = $(this).attr('action').split('/').pop();
            $.ajax({
                url: "{{ url('qualitys') }}/" + id,
                method: 'DELETE',
                success: function(response) {
                    $('#deleteQualityModal').modal('hide');
                    table.ajax.reload();
                    const successAlert = `
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Qualitys deleted successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
                    $('#alertsContainer').html(successAlert);
                },
                error: function(response) {
                    alert('Error: ' + response.responseJSON.message);
                }
            });
        });

        // Select All Checkboxes
        $('#selectAll').on('click', function() {
            var isChecked = $(this).prop('checked');
            $('.qualitysCheckbox').prop('checked', isChecked);
            $('#bulkDeleteBtn').prop('disabled', !$('.qualitysCheckbox:checked').length);
        });

        // Update Bulk Delete Button State
        $(document).on('change', '.qualitysCheckbox', function() {
            $('#bulkDeleteBtn').prop('disabled', !$('.qualitysCheckbox:checked').length);
        });

        // Bulk Delete
        $('#bulkDeleteBtn').on('click', function() {
            var selectedIds = [];
            $('.qualitysCheckbox:checked').each(function() {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length > 0) {
                var confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
                confirmModal.show();

                $('#confirmDeleteBtn').off('click').on('click', function() {
                    $.ajax({
                        url: "{{ route('qualitys.bulkDelete') }}",
                        method: 'DELETE',
                        data: { ids: selectedIds },
                        success: function(response) {
                            table.ajax.reload();
                            const successAlert = `
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                Qualitys deleted successfully!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`;
                            $('#alertsContainer').html(successAlert);
                            confirmModal.hide();
                        },
                        error: function(response) {
                            alert('Error: ' + response.responseJSON.message);
                        }
                    });
                });
            } else {
                alert('Please select at least one qualitys.');
            }
        });
    });
</script>
@endpush
