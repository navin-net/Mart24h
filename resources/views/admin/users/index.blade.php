@extends('admin.master')

@section('title', __('messages.list_users'))

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
                            <table class="table table-striped table-bordered rounded-3 align-middle" id="usersTable">
                                <thead class="table-primary">
                                    <tr>
                                        <th scope="col" class="py-3"><input type="checkbox" id="selectAll"></th>
                                        <th scope="col" class="py-3">Name</th>
                                        <th scope="col" class="py-3">Email</th>
                                        <th scope="col" class="py-3">Group</th>
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

    <div class="modal fade" id="editUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow">
                <form id="editUserForm">
                    @csrf
                    <input type="hidden" id="edit_id" name="id">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" id="edit_name" required>
                            <div class="invalid-feedback" id="edit_name_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_group_id" class="form-label">Group</label>
                            <select class="form-select" name="group_id" id="edit_group_id" required>
                                <option value="">-- Select Group --</option>
                                @foreach ($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="edit_group_id_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('messages.email') }}</label>
                            <input type="email" name="email" id="edit_email"
                                class="form-control @error('email') is-invalid @enderror" required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="password" class="form-label">{{ __('messages.password') }}</label>
                            <div class="input-group">
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror" required>
                                <button type="button" class="btn btn-outline-secondary toggle-password">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="password_confirmation"
                                class="form-label">{{ __('messages.confirm_password') }}</label>
                            <div class="input-group">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control @error('password_confirmation') is-invalid @enderror" required>
                                <button type="button" class="btn btn-outline-secondary toggle-password">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            @error('password_confirmation')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                    </div>
                </form>
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


</div>
@endsection
@push('scripts')
<script>
$(function() {
    const table = $('#usersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('users.index') }}",
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
                data: 'email',
                name: 'email'
            },
            {
                data: 'group_name',
                name: 'group_name'
            },
            {
                data: 'action',
                orderable: false,
                searchable: false,
                className: 'text-center'
            }
        ]
    });

    // Edit User
    $(document).on('click', '.editUser', function() {
        var id = $(this).data('id');
        $.get("{{ url('users') }}/" + id + "/edit", function(data) {
            $('#editUserModal').modal('show');
            $('#edit_name').val(data.user.name);
            $('#edit_email').val(data.user.email);
            $('#edit_group_id').val(data.user.group_id);
            $('#editUserForm').attr('action', "{{ url('users') }}/" + id);
        });
    });

    // Update User
    $('#editUserForm').submit(function(e) {
        e.preventDefault();
        var id = $(this).attr('action').split('/').pop();
        $.ajax({
            url: "{{ url('users') }}/" + id,
            method: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                $('#editUserModal').modal('hide');
                table.ajax.reload();
                const successAlert = `
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        User updated successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
                $('#alertsContainer').html(successAlert);
            },
            error: function(response) {
                alert('Error: ' + response.responseJSON.message);
            }
        });
    });

    // Delete User
    $(document).on('click', '.deleteUser', function() {
        const userId = $(this).data('id');
        const deleteUrl = "{{ url('users') }}/" + userId;
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
                if (response.status === 'success') {
                    $('#deleteModal').modal('hide');
                    table.ajax.reload();
                    $('#alertsContainer').html(`
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        ${response.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `);
                }
            },
            error: function(xhr) {
                let errorMessage = 'Failed to delete the user. Please try again.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                $('#deleteModal').modal('hide'); // close modal if needed
                $('#alertsContainer').html(`
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    ${errorMessage}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `);
            }
        });
    });




    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.closest('.input-group').querySelector('input');
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    });


});
</script>
@endpush