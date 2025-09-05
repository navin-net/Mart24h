@extends('admin.master')

@section('title', 'Subcategory List')

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

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between mb-3">
                <h5 class="fw-semibold">Subcategories Table</h5>
                <div class="dropdown">
                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-gear-fill me-1"></i> Actions
                    </button>
                    <ul class="dropdown-menu shadow-sm">
                        <li><a class="dropdown-item" id="addSubCategoryBtn">{{ __('messages.add') }}</a></li>
                        <li><a class="dropdown-item" id="bulkDeleteBtn" disabled>{{ __('messages.delete') }} </a></li>
                    </ul>
                </div>
            </div>

            <div id="alertsContainer"></div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="subCategoriesTable">
                    <thead class="table-primary">
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
                            <th>Subcategory</th>
                            <th>Category</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addSubCategoryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow">
                <form id="createSubCategoryForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Create Subcategory</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Subcategory Name</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                            <div class="invalid-feedback" id="name_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select" name="category_id" id="category_id" required>
                                <option value="">-- Select Category --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="category_id_error"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editSubCategoryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow">
                <form id="editSubCategoryForm">
                    @csrf
                    <input type="hidden" id="edit_id" name="id">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Subcategory</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Subcategory Name</label>
                            <input type="text" class="form-control" name="name" id="edit_name" required>
                            <div class="invalid-feedback" id="edit_name_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_category_id" class="form-label">Category</label>
                            <select class="form-select" name="category_id" id="edit_category_id" required>
                                <option value="">-- Select Category --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="edit_category_id_error"></div>
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
</div>
@endsection

@push('scripts')
<script>
$(function () {
    const table = $('#subCategoriesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('categories.sub_category') }}",
        columns: [
            {
                data: 'id',
                render: data => `<input type="checkbox" class="selectRow" value="${data}">`,
                orderable: false,
                searchable: false
            },
            { data: 'sub_category_name', name: 'sub_category_name' },
            { data: 'category_name', name: 'category_name' },
            {
                data: 'action',
                orderable: false,
                searchable: false,
                className: 'text-center'
            }
        ]
    });

    $('#selectAll').on('click', function () {
        $('.selectRow').prop('checked', this.checked);
        toggleBulkButton();
    });

    $(document).on('change', '.selectRow', toggleBulkButton);

    function toggleBulkButton() {
        $('#bulkDeleteBtn').prop('disabled', $('.selectRow:checked').length === 0);
    }

    $('#addSubCategoryBtn').click(() => {
        $('#createSubCategoryForm')[0].reset();
        $('#name_error, #category_id_error').text('');
        $('#addSubCategoryModal').modal('show');
    });

    $('#createSubCategoryForm').submit(function (e) {
        e.preventDefault();
        $.post("{{ route('categories.sub_category.store') }}", $(this).serialize())
            .done(res => {
                $('#addSubCategoryModal').modal('hide');
                table.ajax.reload();
                alertMessage(res.success, 'success');
            })
            .fail(err => handleFormErrors(err.responseJSON.errors, ''));
    });

    $(document).on('click', '.editSubCategory', function () {
        const id = $(this).data('id');
        $.get(`/categories/sub_category/${id}/edit`, res => {
            $('#edit_id').val(res.subCategory.id);
            $('#edit_name').val(res.subCategory.name);
            $('#edit_category_id').val(res.subCategory.category_id);
            $('#editSubCategoryModal').modal('show');
        });
    });

    $('#editSubCategoryForm').submit(function (e) {
        e.preventDefault();
        const id = $('#edit_id').val();
        $.post(`/categories/sub_category/${id}/update`, $(this).serialize())
            .done(res => {
                $('#editSubCategoryModal').modal('hide');
                table.ajax.reload();
                alertMessage(res.success, 'success');
            })
            .fail(err => handleFormErrors(err.responseJSON.errors, 'edit_'));
    });

    $(document).on('click', '.deleteSubCategory', function () {
        const id = $(this).data('id');
        if (confirm('Delete this subcategory?')) {
            $.ajax({
                url: `/categories/sub_category/${id}/delete`,
                method: 'DELETE',
                data: { _token: '{{ csrf_token() }}' }
            }).done(res => {
                table.ajax.reload();
                alertMessage(res.success, 'success');
            });
        }
    });

    $('#bulkDeleteBtn').click(function () {
        const ids = $('.selectRow:checked').map(function () {
            return this.value;
        }).get();

        if (confirm('Delete selected subcategories?')) {
            $.post("{{ route('categories.sub_category.bulkDelete') }}", {
                ids: ids,
                _token: '{{ csrf_token() }}'
            }).done(res => {
                table.ajax.reload();
                $('#selectAll').prop('checked', false);
                $('#bulkDeleteBtn').prop('disabled', true);
                alertMessage(res.success, 'success');
            });
        }
    });

    function handleFormErrors(errors, prefix) {
        $(`#${prefix}name_error`).text(errors?.name?.[0] || '');
        $(`#${prefix}category_id_error`).text(errors?.category_id?.[0] || '');
    }

    function alertMessage(message, type = 'success') {
        const alert = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>`;
        $('#alertsContainer').html(alert);
    }
});
</script>
@endpush
