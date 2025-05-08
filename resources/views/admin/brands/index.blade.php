<!-- resources/views/brands/index.blade.php -->
@extends('admin.master')
@section('title', __('messages.brands_list'))

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
                        <div class="row align-items-center mb-4">
                            <div class="col-md-6">
                                <h5 class="card-title mb-0 fw-semibold">{{ __('messages.brands_list') }}</h5>
                            </div>
                            <div class="col-md-6 text-end">
                                <div class="dropdown">
                                    <button class="btn btn-primary btn-sm dropdown-toggle rounded-3" type="button" id="actionDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-gear-fill me-1"></i> {{ __('messages.actions') }}
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm rounded-3" aria-labelledby="actionDropdown">
                                        <li><a class="dropdown-item" href="#" id="addBrandBtn">
                                            <i class="bi bi-plus-circle me-2"></i>{{ __('messages.add') }}</a>
                                        </li>
                                        <li><a class="dropdown-item" href="#" id="exportBrands">
                                            <i class="bi bi-file-excel me-2"></i>{{ __('messages.export_to_excel') }}</a>
                                        </li>
                                        <li><a class="dropdown-item" href="#" id="bulkDeleteBtn" disabled>
                                            <i class="bi bi-trash me-2"></i>{{ __('messages.delete') }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div id="alertsContainer" class="mb-4">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered rounded-3 align-middle" id="brandsTable">
                                <thead class="table-primary">
                                    <tr>
                                        <th scope="col" class="py-3"><input type="checkbox" id="selectAll" class="form-check-input"></th>
                                        <th scope="col" class="py-3">{{ __('messages.code') }}</th>
                                        <th scope="col" class="py-3">{{ __('messages.image') }}</th>
                                        <th scope="col" class="py-3">{{ __('messages.name') }}</th>
                                        <th scope="col" class="py-3">{{ __('messages.slug') }}</th>
                                        <th scope="col" class="py-3 text-center" width="120">{{ __('messages.actions') }}</th>
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
                    <button type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm rounded-3">{{ __('messages.delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Delete Confirmation Modal -->
    <div class="modal fade" id="bulkDeleteModal" tabindex="-1" aria-labelledby="bulkDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 border-0 shadow">
                <div class="modal-header border-0 rounded-top-3">
                    <h5 class="modal-title fw-semibold" id="bulkDeleteModalLabel">{{ __('messages.confirm_bulk_delete') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ __('messages.delete_confirm') }}
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
                    <button type="button" class="btn btn-danger btn-sm rounded-3" id="confirmBulkDelete">{{ __('messages.delete') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 border-0 shadow">
                <div class="modal-header border-0 rounded-top-3">
                    <h5 class="modal-title display-6 fw-bold" id="imageModalLabel">{{ __('messages.current_image') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="/placeholder.svg" alt="Brand Image" class="img-fluid rounded-3">
                </div>
            </div>
        </div>
    </div>

    <!-- Brand Modal (Add/Edit) -->
    <div class="modal fade" id="brandModal" tabindex="-1" aria-labelledby="brandModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-3 border-0 shadow">
                <div class="modal-header border-0 rounded-top-3">
                    <h5 class="modal-title display-6 fw-bold" id="brandModalLabel">{{ __('messages.add_brand') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="brandForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="method" value="POST">
                    <input type="hidden" name="id" id="brand_id">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-medium">{{ __('messages.name') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control rounded-3" id="name" name="name" required>
                                <div class="invalid-feedback" id="name-error"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="code" class="form-label fw-medium">{{ __('messages.code') }}</label>
                                <input type="text" class="form-control rounded-3" id="code" name="code">
                                <div class="invalid-feedback" id="code-error"></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="slug" class="form-label fw-medium">{{ __('messages.slug') }}</label>
                                <input type="text" class="form-control rounded-3" id="slug" name="slug">
                                <div class="invalid-feedback" id="slug-error"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="image" class="form-label fw-medium">{{ __('messages.image') }}</label>
                                <input type="file" class="form-control rounded-3" id="image" name="image" accept="image/*">
                                <div class="invalid-feedback" id="image-error"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label fw-medium">{{ __('messages.description') }}</label>
                            <textarea class="form-control rounded-3" id="description" name="description" rows="3"></textarea>
                            <div class="invalid-feedback" id="description-error"></div>
                        </div>
                        <div id="currentImageContainer" class="mb-3 d-none">
                            <label class="form-label fw-medium">{{ __('messages.current_image') }}</label>
                            <div class="border p-2 rounded-3">
                                <img id="currentImage" src="/placeholder.svg" alt="Current Brand Image" class="img-thumbnail rounded-3" style="max-height: 150px;">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
                        <button type="submit" class="btn btn-primary btn-sm rounded-3" id="saveBtn">{{ __('messages.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <style>
        .brand-image-thumbnail {
            max-height: 50px;
            cursor: pointer;
        }
        .action-btn {
            margin: 0 3px;
        }
    </style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    var table = $('#brandsTable').DataTable({
        dom: 'lBfrtip',
        pageLength: 10,
        lengthMenu: [[10, 20, 30, 50, -1], [10, 20, 30, 50, "All"]],
        buttons: [],
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('brands.index') }}",
        columns: [
            {
                data: 'id',
                name: 'id',
                render: function(data) {
                    return `<input type="checkbox" class="brandCheckbox" value="${data}">`;
                },
                orderable: false,
                searchable: false
            },
            { data: 'code', name: 'code' },
            {
                data: 'image',
                name: 'image',
                render: function(data) {
                    if (data) {
                        return `<a href="#" class="image-popup" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="/upload/image/${data}">
                            <img src="/upload/image/${data}" width="50" class="img-thumbnail brand-image-thumbnail">
                        </a>`;
                    }
                    return `<a href="#" class="image-popup" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="/upload/image/noimage.png">
                        <img src="/upload/image/noimage.png" width="50" class="img-thumbnail brand-image-thumbnail">
                    </a>`;
                }
            },
            { data: 'name', name: 'name' },
            { data: 'slug', name: 'slug' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            paginate: {
                previous: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/></svg>',
                next: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/></svg>'
            },
            // info: 'Showing _START_ to _END_ of _TOTAL_ entries',
            lengthMenu: '{{ __('messages.show') }} _MENU_{{ __('messages.entries') }}',
            search: '{{ __('messages.search') }}',
            emptyTable: "{{ __('messages.no_data_available') }}",
            processing: "{{ __('messages.processing') }}",
            zeroRecords: "{{ __('messages.no_matching_records') }}",
            infoEmpty: "{{ __('messages.showing_0_to_0_of_0_entries') }}",
            infoFiltered: "{{ __('messages.filtered_from_total_entries', ['total' => '_MAX_']) }}"
        }
    });

    // CSRF Token Setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Open Modal for Add
    $('#addBrandBtn').on('click', function() {
        $('#brandForm').trigger('reset');
        $('#brand_id').val('');
        $('#method').val('POST');
        $('#brandModalLabel').text('{{ __('messages.add_brand') }}');
        $('#saveBtn').text('{{ __('messages.save') }}');
        $('#currentImageContainer').addClass('d-none');
        $('#name').removeClass('is-invalid');
        $('#code').removeClass('is-invalid');
        $('#slug').removeClass('is-invalid');
        $('#image').removeClass('is-invalid');
        $('#description').removeClass('is-invalid');
        $('#brandModal').modal('show');
    });

    // Open Modal for Edit
    $(document).on('click', '.editBrandBtn', function() {
        var id = $(this).data('id');
        $.get("{{ url('brands') }}/" + id + "/edit", function(data) {
            $('#brandModalLabel').text('{{ __('messages.edit_brand') }}');
            $('#saveBtn').text('{{ __('messages.update') }}');
            $('#brand_id').val(data.id);
            $('#name').val(data.name).removeClass('is-invalid');
            $('#code').val(data.code).removeClass('is-invalid');
            $('#slug').val(data.slug).removeClass('is-invalid');
            $('#description').val(data.description).removeClass('is-invalid');
            $('#image').removeClass('is-invalid');
            if (data.image) {
                $('#currentImage').attr('src', `/upload/image/${data.image}`);
                $('#currentImageContainer').removeClass('d-none');
            } else {
                $('#currentImageContainer').addClass('d-none');
            }
            $('#method').val('PUT');
            $('#brandModal').modal('show');
        });
    });

    // Handle Form Submission (Add or Update)
    $('#brandForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var isUpdate = $('#brand_id').val() ? true : false;
        var url = isUpdate ? "{{ url('brands') }}/" + $('#brand_id').val() : "{{ route('brands.store') }}";

        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#brandModal').modal('hide');
                table.ajax.reload();
                const successAlert = `
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        ${isUpdate ? '{{ __('messages.brand_updated_successfully') }}' : '{{ __('messages.brand_added_successfully') }}'}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
                $('#alertsContainer').html(successAlert);
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors || {};
                let errorMsg = 'Please fix the following errors:\n';
                $('.invalid-feedback').text('').hide();
                $('.form-control').removeClass('is-invalid');
                for (let key in errors) {
                    $(`#${key}-error`).text(errors[key][0]).show();
                    $(`#${key}`).addClass('is-invalid');
                    errorMsg += `- ${errors[key][0]}\n`;
                }
                if (!Object.keys(errors).length) {
                    errorMsg = 'An error occurred. Please try again.';
                }
                alert(errorMsg);
            }
        });
    });

    // Delete Brand
    $(document).on('click', '.deleteBrandBtn', function() {
        const brandId = $(this).data('id');
        const deleteUrl = "{{ url('brands') }}/" + brandId;
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
                        {{ __('messages.brand_deleted_successfully') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
                $('#alertsContainer').html(successAlert);
            },
            error: function(xhr) {
                alert('Failed to delete the brand. Please try again.');
            }
        });
    });

    // Bulk Delete
    $('#bulkDeleteBtn').on('click', function() {
        const selectedIds = $('.brandCheckbox:checked').map(function() {
            return $(this).val();
        }).get();

        if (selectedIds.length === 0) {
            alert('No brands selected for deletion.');
            return;
        }

        $('#bulkDeleteModal').modal('show');

        $('#confirmBulkDelete').off('click').on('click', function() {
            $.ajax({
                url: "{{ route('brands.bulkDelete') }}",
                method: "POST",
                data: { _token: "{{ csrf_token() }}", ids: selectedIds },
                success: function(response) {
                    $('#bulkDeleteModal').modal('hide');
                    table.ajax.reload();
                    $('#selectAll').prop('checked', false);
                    $('#bulkDeleteBtn').prop('disabled', true);
                    const successAlert = `
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ __('messages.selected_brands_deleted_successfully') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>`;
                    $('#alertsContainer').html(successAlert);
                },
                error: function(xhr) {
                    const errorAlert = `
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Failed to delete selected brands. Please try again.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>`;
                    $('#alertsContainer').html(errorAlert);
                }
            });
        });
    });

    // Select/Deselect All Checkboxes
    $('#selectAll').on('click', function() {
        $('.brandCheckbox').prop('checked', $(this).prop('checked'));
        toggleBulkDeleteButton();
    });

    // Check individual checkboxes
    $(document).on('change', '.brandCheckbox', function() {
        toggleBulkDeleteButton();
    });

    // Enable/Disable Bulk Delete Button
    function toggleBulkDeleteButton() {
        const anyChecked = $('.brandCheckbox:checked').length > 0;
        $('#bulkDeleteBtn').prop('disabled', !anyChecked);
    }

    // Image Popup
    $(document).on('click', '.image-popup', function(e) {
        e.preventDefault();
        const imageUrl = $(this).data('image');
        $('#modalImage').attr('src', imageUrl);
    });

    // Export Brands
    $('#exportBrands').on('click', function() {
        var selectedIds = $('.brandCheckbox:checked').map(function() {
            return $(this).val();
        }).get();

        var url = "{{ route('brands.export') }}";
        if (selectedIds.length > 0) {
            url += '?ids=' + selectedIds.join(',');
        }
        window.location.href = url;
    });
});
</script>
@endpush
