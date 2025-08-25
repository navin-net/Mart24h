@extends('admin.master')
@section('title', 'Categories List')

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
                            <h5 class="card-title mb-0 fw-semibold">Categories Table</h5>
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm dropdown-toggle rounded-3" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-gear-fill me-1"></i> Actions
                                </button>
                                <ul class="dropdown-menu shadow-sm rounded-3">
                                    <li><a class="dropdown-item" id="addCategoryBtn">{{ __('messages.add') }}</a></li>
                                    <li><a class="dropdown-item" id="bulkDeleteBtn" disabled>{{ __('messages.delete') }}</a></li>
                                </ul>
                            </div>
                        </div>
                        <div id="alertsContainer" class="mb-4"></div>

                        <div class="table-responsive" style="overflow-x: auto;">
                            <table class="table table-striped table-bordered rounded-3 align-middle" id="categoriesTable">
                                <thead class="table-primary">
                                    <tr>
                                        <th scope="col" class="py-3"><input type="checkbox" id="selectAll"></th>
                                        <th scope="col" class="py-3">Name</th>
                                        <th scope="col" class="py-3">Slug</th>
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

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 border-0 shadow">
                <div class="modal-header border-0  rounded-top-3">
                    <h5 class="modal-title fw-semibold" id="addCategoryModalLabel">Create New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="createCategoryForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-medium">Category Name</label>
                            <input type="text" class="form-control rounded-3" name="name" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="slug" class="form-label fw-medium">Slug</label>
                            <input type="text" class="form-control rounded-3" name="slug" id="slug">
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm rounded-3">Save Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 border-0 shadow">
                <div class="modal-header border-0  rounded-top-3">
                    <h5 class="modal-title fw-semibold" id="editCategoryModalLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editCategoryForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editName" class="form-label fw-medium">Category Name</label>
                            <input type="text" class="form-control rounded-3" name="name" id="editName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editSlug" class="form-label fw-medium">Slug</label>
                            <input type="text" class="form-control rounded-3" name="slug" id="editSlug">
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm rounded-3">Update Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Category Modal -->
    <div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 border-0 shadow">
                <div class="modal-header border-0  rounded-top-3">
                    <h5 class="modal-title fw-semibold" id="deleteCategoryModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this category?
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteCategoryForm" method="POST">
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
                    Are you sure you want to delete the selected categories?
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
@includeIf('admin.categories.partials.script')

@endpush
