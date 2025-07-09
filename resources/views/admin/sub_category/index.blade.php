{{-- ```blade --}}
@extends('admin.master')

@section('title', __('messages.categories_list'))



@section('content')
    <div class="container-fluid py-4">
        <div class="pagetitle mb-4">
            <h1 class="display-6 fw-bold">{{ __('messages.stock_management_system') }}</h1>
            <p class="text-muted">{{ __('messages.dashboard_welcome') }}</p>
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
                                <h5 class="card-title mb-0 fw-semibold">Categories Table</h5>
                                <div class="dropdown">
                                    <button class="btn btn-primary btn-sm dropdown-toggle rounded-3" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-gear-fill me-1"></i> Actions
                                    </button>
                                    <ul class="dropdown-menu shadow-sm rounded-3">
                                        <li><a class="dropdown-item" id="addCategoryBtn">{{ __('messages.add') }}</a></li>
                                        <li><a class="dropdown-item" id="bulkDeleteBtn"
                                                disabled>{{ __('messages.delete') }}</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div id="alertsContainer" class="mb-4"></div>

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered rounded-3 align-middle"
                                    id="subCategoriesTable">
                                    <thead class="table-primary">
                                        <tr>
                                            <th scope="col" class="py-3"><input type="checkbox" id="selectAll"></th>
                                            <th scope="col" class="py-3">{{ __('messages.sub_category_name') }}</th>
                                            <th scope="col" class="py-3">{{ __('messages.category') }}</th>
                                            <th scope="col" class="py-3 text-center">{{ __('messages.Actions') }}</th>

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
            // Set up CSRF token for AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Initialize DataTables
            $('#subCategoriesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('subcategories.index') }}',
                columns: [{
                        data: 'id',
                        id: 'sub_categories.id'
                    },
                    {
                        data: 'sub_category_name',
                        name: 'sub_categories.name'
                    },
                    {
                        data: 'category_name',
                        name: 'categories.name',
                        defaultContent: 'N/A'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                language: {
                    emptyTable: '{{ __('messages.no_subcategories_available') }}',
                    processing: '<i class="fa fa-spinner fa-spin"></i> Loading...'
                }
            });


        });
    </script>
@endpush
