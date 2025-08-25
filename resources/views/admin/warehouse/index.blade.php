@extends('admin.master')

@section('title', __('messages.warehouse_list'))

@section('content')
<div class="container-fluid py-4">
    <!-- Page title & breadcrumbs -->
    <div class="pagetitle mb-4">
        <h1 class="display-6 fw-bold">{{ $pageTitle }}</h1>
        <nav>
            <ol class="breadcrumb rounded-3 p-2">
                @foreach ($breadcrumbs as $breadcrumb)
                    <li class="breadcrumb-item {{ $breadcrumb['active'] ? 'active text-muted' : '' }}">
                        @if (!$breadcrumb['active'])
                            <a href="{{ $breadcrumb['url'] }}" class="text-primary text-decoration-none">
                                {{ $breadcrumb['label'] }}
                            </a>
                        @else
                            {{ $breadcrumb['label'] }}
                        @endif
                    </li>
                @endforeach
            </ol>
        </nav>
    </div>

    <!-- Main content section -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">
                        <!-- Actions -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="card-title mb-0 fw-semibold">Warehouse Table</h5>
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm dropdown-toggle rounded-3" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-gear-fill me-1"></i> Actions
                                </button>
                                <ul class="dropdown-menu shadow-sm rounded-3">
                                    <li><a class="dropdown-item" id="addWarehouseBtn">{{ __('messages.add') }}</a></li>
                                    <li><a class="dropdown-item" id="bulkDeleteBtn" disabled>{{ __('messages.delete') }}</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- Alerts -->
                        <div id="alertsContainer" class="mb-4"></div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered rounded-3 align-middle" id="warehousesTable">
                                <thead class="table-primary">
                                    <tr>
                                        <th class="py-3"><input type="checkbox" id="selectAll"></th>
                                        <th class="py-3">Name</th>
                                        <th class="py-3">Location</th>
                                        <th class="py-3">Note</th>
                                        <th class="py-3 text-center">Actions</th>
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

    <!-- Add Warehouse Modal -->
    <div class="modal fade" id="addWarehouseModal" tabindex="-1" aria-labelledby="addWarehouseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 border-0 shadow">
                <div class="modal-header border-0 rounded-top-3">
                    <h5 class="modal-title fw-semibold" id="addWarehouseModalLabel">Create Warehouse</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="createWarehouseForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-medium">Warehouse Name</label>
                            <input type="text" class="form-control rounded-3" name="name" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label fw-medium">Location</label>
                            <input type="text" class="form-control rounded-3" name="location" id="location">
                        </div>
                        <div class="mb-3">
                            <label for="note" class="form-label fw-medium">Note</label>
                            <input type="text" class="form-control rounded-3" name="note" id="note">
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm rounded-3">Save Warehouse</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Warehouse Modal -->
    <div class="modal fade" id="editWarehouseModal" tabindex="-1" aria-labelledby="editWarehouseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 border-0 shadow">
                <div class="modal-header border-0 rounded-top-3">
                    <h5 class="modal-title fw-semibold" id="editWarehouseModalLabel">Edit Warehouse</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editWarehouseForm">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editName" class="form-label fw-medium">Warehouse Name</label>
                            <input type="text" class="form-control rounded-3" name="name" id="editName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editlocation" class="form-label fw-medium">Location</label>
                            <input type="text" class="form-control rounded-3" name="location" id="editlocation">
                        </div>
                        <div class="mb-3">
                            <label for="editnote" class="form-label fw-medium">Note</label>
                            <input type="text" class="form-control rounded-3" name="note" id="editnote">
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm rounded-3">Update Warehouse</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
$(function() {
    // DataTable initialization
    const table = $('#warehousesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('warehouse.index') }}",
        columns: [
            {
                data: 'id',
                render: data => `<input type="checkbox" class="selectRow" value="${data}">`,
                orderable: false,
                searchable: false
            },
            { data: 'name', name: 'name' },
            { data: 'location', name: 'location' },
            { data: 'note', name: 'note' },
            { 
                data: 'action',
                orderable: false,
                searchable: false,
                className: 'text-center'
            }
        ]
    });

    // Show Add Warehouse Modal
    $('#addWarehouseBtn').click(function() {
        $('#createWarehouseForm')[0].reset();
        $('#addWarehouseModal').modal('show');
    });

    // Create Warehouse
    $('#createWarehouseForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('warehouse.store') }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#addWarehouseModal').modal('hide');
                table.ajax.reload();
                $('#alertsContainer').html(`
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Warehouse added successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `);
            },
            error: function(response) {
                alert('Error: ' + (response.responseJSON?.message || 'Unable to create'));
            }
        });
    });

    // Edit Warehouse (open modal)
    $(document).on('click', '.editWarehouse', function() {
        const id = $(this).data('id');
        $.get("{{ url('warehouse') }}/" + id + "/edit", function(data) {
            $('#editWarehouseModal').modal('show');
            $('#editName').val(data.warehouse.name);
            $('#editlocation').val(data.warehouse.location);
            $('#editnote').val(data.warehouse.note);
            $('#editWarehouseForm').attr('data-id', id);
        }).fail(function() {
            alert('Unable to fetch warehouse details.');
        });
    });

    // Update Warehouse
    $('#editWarehouseForm').submit(function(e) {
        e.preventDefault();
        const id = $(this).attr('data-id');
        $.ajax({
            url: "{{ url('warehouse') }}/" + id,
            method: 'POST', // send as POST with _method=PUT
            data: $(this).serialize(),
            success: function(response) {
                $('#editWarehouseModal').modal('hide');
                table.ajax.reload();
                $('#alertsContainer').html(`
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Warehouse updated successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `);
            },
            error: function(response) {
                alert('Error: ' + (response.responseJSON?.message || 'Unable to update'));
            }
        });
    });
});
</script>
@endpush
