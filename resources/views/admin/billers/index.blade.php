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
                            <h5 class="card-title mb-0 fw-semibold"></h5>
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm dropdown-toggle rounded-3" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-gear-fill me-1"></i> Actions
                                </button>
                                <ul class="dropdown-menu shadow-sm rounded-3">
                                    <li><a class="dropdown-item" id="addUserBtn">{{ __('messages.add') }}</a></li>
                                    <li><a class="dropdown-item" id="bulkDeleteBtn" disabled>{{ __('messages.delete') }}</a></li>
                                </ul>
                            </div>
                        </div>
                        <div id="alertsContainer" class="mb-4"></div>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered rounded-3 align-middle" id="billersTable">
                                <thead class="table-primary">
                                    <tr>
                                        <th scope="col" class="py-3"><input type="checkbox" id="selectAll"></th>
                                        <th scope="col" class="py-3">Name</th>
                                        <th scope="col" class="py-3">Group</th>
                                        <th scope="col" class="py-3">Warehouse</th>
                                        <th scope="col" class="py-3">Email</th>
                                        <th scope="col" class="py-3">Phone</th>
                                        <th scope="col" class="py-3">City</th>
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

<!-- Company Details Modal -->
<div class="modal fade" id="companyModal" tabindex="-1" aria-labelledby="companyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-3 shadow">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold" id="companyModalLabel">{{ __('messages.billers_details') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="companyDetailsContent">
                <table class="table table-bordered">
                    <tbody>
                        <tr><th>Name</th><td id="c_name"></td></tr>
                        <tr><th>Email</th><td id="c_email"></td></tr>
                        <tr><th>Phone</th><td id="c_phone"></td></tr>
                        <tr><th>City</th><td id="c_city"></td></tr>
                        <tr><th>Street</th><td id="c_street"></td></tr>
                        <tr><th>Address</th><td id="c_address"></td></tr>
                        <tr><th>Group</th><td id="c_group"></td></tr>
                        <tr><th>Warehouse</th><td id="c_warehouse"></td></tr>
                        <tr><th>Number of Houses</th><td id="c_houses"></td></tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="printCompanyBtn">Print</button>
            </div>
        </div>
    </div>
</div>



<!-- User List Modal -->
<div class="modal fade" id="userListModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{ __('messages.list_user') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="userListContent">
        <!-- loader placeholder -->
        <div class="text-center p-3">
          <div class="spinner-border text-primary" role="status"></div>
        </div>
      </div>
    </div>
  </div>
</div>




        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-3 border-0 shadow">
                    <div class="modal-header border-0 rounded-top-3">
                        <h5 class="modal-title fw-semibold" id="deleteModalLabel">{{ __('messages.confirm_delete') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{ __('messages.delete_confirm') }}
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary btn-sm rounded-3"
                            data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
                        <form id="deleteForm" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="btn btn-danger btn-sm rounded-3">{{ __('messages.delete') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


@endsection

@push('scripts')
<script>
$(document).ready(function() {
    const table = $('#billersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('billers.index') }}",
        columns: [
            { 
                data: 'id',
                render: data => `<input type="checkbox" class="selectRow" value="${data}">`,
                orderable: false,
                searchable: false
            },
            { data: 'name', name: 'name' },
            { data: 'group_name', name: 'group_name' },
            { data: 'warehouse_name', name: 'warehouse_name' },
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone' },
            { data: 'city', name: 'city' },
            { data: 'action', orderable: false, searchable: false, className: 'text-center' }
        ]
    });

    // Row click to show modal (skip first & last column)
    $('#billersTable tbody').on('click', 'td', function(e) {
        const colIndex = table.cell(this).index().column;
        if (colIndex === 0 || colIndex === 7) return; // Skip checkbox and actions

        // Remove previous highlights
        $('#billersTable tbody tr').removeClass('table-active');
        $(this).closest('tr').addClass('table-active');

        const rowData = table.row(this).data();
        if (!rowData) return;

        // Fill modal
        $('#c_name').text(rowData.name || '');
        $('#c_email').text(rowData.email || '');
        $('#c_phone').text(rowData.phone || '');
        $('#c_city').text(rowData.city || '');
        $('#c_street').text(rowData.street || '');
        $('#c_address').text(rowData.address || '');
        $('#c_group').text(rowData.group_name || '');
        $('#c_warehouse').text(rowData.warehouse_name || '');
        $('#c_houses').text(rowData.number_of_houses || '');

        $('#companyModal').modal('show');
    });

    // Print modal content
    $('#printCompanyBtn').on('click', function() {
        const content = document.getElementById('companyDetailsContent').innerHTML;
        const printWindow = window.open('', '', 'width=900,height=700');
        printWindow.document.write('<html><head><title>Biller Details</title>');
        printWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">');
        printWindow.document.write('</head><body>');
        printWindow.document.write('<h3 class="mb-4">Biller Details</h3>');
        printWindow.document.write(content);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    });

    $(document).on('click', '.editBiller', function() {
        var id = $(this).data('id');
        window.location.href = '/billers/' + id + '/edit';
    });


    $(document).on('click', '.listUser', function() {
        var id = $(this).data('id');

        // Show modal first with loader
        $('#userListModal').modal('show');
        $('#userListContent').html(
            '<div class="text-center p-3"><div class="spinner-border text-primary" role="status"></div></div>'
        );

        // Fetch content by Ajax
        $.ajax({
            url: '/billers/' + id + '/users', // You will create this route
            method: 'GET',
            success: function(response) {
                $('#userListContent').html(response);
            },
            error: function() {
                $('#userListContent').html(
                    '<div class="alert alert-danger">{{ __("messages.load_failed") }}</div>'
                );
            }
        });
    });

    $(document).on('click', '.addUser', function() {
        var id = $(this).data('id');
        window.location.href = '/billers/' + id + '/users/add';
    });

            $(document).on('click', '.deleteBillerBtn', function() {
                const billerId = $(this).data('id');
                const deleteUrl = "{{ url('billers') }}/" + billerId;
                $('#deleteForm').attr('action', deleteUrl);
                $('#deleteModal').modal('show');
            });

            $('#deleteForm').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                const action = form.attr('action');

                $.ajax({
                    url: action,
                    type: 'DELETE',
                    data: form.serialize(),
                    success: function(response) {
                        $('#deleteModal').modal('hide');
                        table.ajax.reload();
                        const successAlert = `
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ __('messages.biller_deleted_successfully') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
                        $('#alertsContainer').html(successAlert);
                    },
                    error: function(xhr) {
                        alert('Failed to delete the biller. Please try again.');
                    }
                });
            });






});
</script>
@endpush
