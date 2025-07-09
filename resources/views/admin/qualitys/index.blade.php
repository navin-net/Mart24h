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
                    <h5 class="modal-title fw-semibold" id="addQualityModalLabel">Create New Quality</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="createQualityForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-medium">Quality Name</label>
                            <input type="text" class="form-control rounded-3" name="name" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label fw-medium">Description</label>
                            <input type="text" class="form-control rounded-3" name="description" id="description">
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm rounded-3">Save Quality</button>
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
                    <h5 class="modal-title fw-semibold" id="editQualityModalLabel">Edit Quality</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editQualityForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editName" class="form-label fw-medium">Quality Name</label>
                            <input type="text" class="form-control rounded-3" name="name" id="editName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDescription" class="form-label fw-medium">Description</label>
                            <input type="text" class="form-control rounded-3" name="description" id="editDescription" value="sas">
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm rounded-3">Update Quality</button>
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
                    Are you sure you want to delete this quality?
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteQualityForm" method="POST" class="d-inline">
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
                    Are you sure you want to delete the selected qualities?
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
<!-- Include DataTable Core Helper -->
<script src="{{ asset('assets/js/datatable-core.js') }}"></script>

<script>
$(document).ready(function() {
    const dataTableCore = new DataTableCore();
    
    // Define columns (checkbox column is added automatically by the helper)
    const columns = [
        { 
            data: 'name', 
            name: 'name',
            render: function(data, type, row) {
                return `<span class="fw-medium">${data}</span>`;
            }
        },
        { 
            data: 'description', 
            name: 'description',
            render: function(data, type, row) {
                return data || '<span class="text-muted">No description</span>';
            }
        },
        { 
            data: null,
            name: 'action', 
            orderable: false, 
            searchable: false,
            className: 'text-center',
            render: function(data, type, row) {
                return `
                    <div class="btn-group" role="group">
                        <button class="btn btn-outline-warning btn-sm edit-btn" data-id="${row.id}" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-outline-danger btn-sm delete-btn" data-id="${row.id}" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
            }
        }
    ];

    // Configuration object
    const config = {
        tableId: '#qualitysTable',
        ajaxUrl: "{{ route('qualitys.index') }}",
        columns: columns,
        tableOptions: {
            // Additional DataTable options can be added here
            order: [[1, 'asc']], // Sort by name column by default
            columnDefs: [
                { targets: [0, 3], orderable: false } // Disable sorting for checkbox and action columns
            ]
        },
        bulkConfig: {
            selectAllId: '#selectAll',
            bulkDeleteBtnId: '#bulkDeleteBtn',
            bulkDeleteUrl: "{{ route('qualitys.bulkDelete') }}",
            confirmModalId: '#confirmModal',
            confirmBtnId: '#confirmDeleteBtn',
            alertContainerId: '#alertsContainer'
        },
        crudConfig: {
            addBtnId: '#addQualityBtn',
            addModalId: '#addQualityModal',
            addFormId: '#createQualityForm',
            editModalId: '#editQualityModal',
            editFormId: '#editQualityForm',
            deleteModalId: '#deleteQualityModal',
            deleteFormId: '#deleteQualityForm',
            storeUrl: "{{ route('qualitys.store') }}",
            updateUrl: "{{ url('qualitys') }}/:id",
            editUrl: "{{ url('qualitys') }}/:id/edit",
            deleteUrl: "{{ url('qualitys') }}/:id",
            alertContainerId: '#alertsContainer'
        }
    };

    // Initialize the complete CRUD table
    const table = dataTableCore.initCompleteCrud(config);
    
    // Custom functionality specific to qualities (if needed)
    // Example: Custom validation
    $('#createQualityForm, #editQualityForm').on('submit', function(e) {
        const nameInput = $(this).find('input[name="name"]');
        const name = nameInput.val().trim();
        
        if (name.length < 2) {
            e.preventDefault();
            DataTableCore.showAlert('#alertsContainer', 'Quality name must be at least 2 characters long.', 'warning');
            nameInput.addClass('is-invalid');
            return false;
        } else {
            nameInput.removeClass('is-invalid');
        }
    });

    // Clear form validation on modal close
    $('#addQualityModal, #editQualityModal').on('hidden.bs.modal', function() {
        $(this).find('form')[0].reset();
        $(this).find('.is-invalid').removeClass('is-invalid');
    });

    // Auto-refresh table every 5 minutes (optional)
    // setInterval(function() {
    //     table.ajax.reload();
    // }, 300000);
});
</script>
@endpush