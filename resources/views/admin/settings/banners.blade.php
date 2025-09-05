@extends('admin.master')

@section('title', __('messages.banners_management'))

@section('content')
<div class="container-fluid py-4">
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

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">
                        <form id="banners-form" enctype="multipart/form-data">
                            @csrf

                            <div id="banners-container">
                                @foreach ($banners as $i => $banner)
                                    <div class="banner-item mb-4 border p-3 rounded">
                                        <input type="hidden" name="banners[{{ $i }}][id]" value="{{ $banner->id }}">
                                        <div class="row g-3 align-items-center">
                                            <div class="col-md-3">
                                                <label>Title</label>
                                                <input type="text" name="banners[{{ $i }}][title]" value="{{ $banner->title }}" class="form-control" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label>Status</label>
                                                <select name="banners[{{ $i }}][status]" class="form-control" required>
                                                    <option value="1" {{ $banner->status ? 'selected' : '' }}>Active</option>
                                                    <option value="0" {{ !$banner->status ? 'selected' : '' }}>Inactive</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Link</label>
                                                <input type="url" name="banners[{{ $i }}][link]" value="{{ $banner->link }}" class="form-control" placeholder="https://example.com" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Image</label>
                                                <input type="file" name="banners[{{ $i }}][image]" class="form-control" accept="image/*">
                                                @if($banner->image)
                                                    <a href="{{ asset('storage/' . $banner->image) }}" target="_blank">View</a>
                                                @endif
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-danger btn-sm remove-banner">X</button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" id="add-banner" class="btn btn-secondary mt-2">+ Add Banner</button>
                            <button type="button" id="submit-all" class="btn btn-primary mt-2">Update All</button>

                            <div id="status-message" class="mt-3 text-success"></div>
                        </form>
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
    let bannerIndex = {{ count($banners) }};

    // Add new banner row
    $('#add-banner').on('click', function() {
        let newBanner = `
            <div class="banner-item mb-4 border p-3 rounded">
                <div class="row g-3 align-items-center">
                    <div class="col-md-3">
                        <label>Title</label>
                        <input type="text" name="banners[${bannerIndex}][title]" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label>Status</label>
                        <select name="banners[${bannerIndex}][status]" class="form-control" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Link</label>
                        <input type="url" name="banners[${bannerIndex}][link]" class="form-control" placeholder="https://example.com" required>
                    </div>
                    <div class="col-md-3">
                        <label>Image</label>
                        <input type="file" name="banners[${bannerIndex}][image]" class="form-control" accept="image/*">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-sm remove-banner">X</button>
                    </div>
                </div>
            </div>`;
        $('#banners-container').append(newBanner);
        bannerIndex++;
    });

    // Remove banner row
    $(document).on('click', '.remove-banner', function() {
        $(this).closest('.banner-item').remove();
    });

    // Submit all banners
    $('#submit-all').on('click', function() {
        var form = $('#banners-form')[0];
        var formData = new FormData(form);

        $('#status-message').text('');
        $('#submit-all').prop('disabled', true).text('Updating...');

        $.ajax({
            url: "{{ route('banners.ajaxUpdateAll') }}",
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
            success: function(response) {
                const alertHtml = `
                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="update-alert">
                        ${response.message || 'Banners updated successfully.'}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
                $('.dashboard-content').prepend(alertHtml);

                $('#status-message').text('');
                $('#submit-all').prop('disabled', false).text('Update All');

                setTimeout(() => {
                    const alertElem = document.getElementById('update-alert');
                    if(alertElem) {
                        const bsAlert = bootstrap.Alert.getOrCreateInstance(alertElem);
                        bsAlert.close();
                    }
                }, 4000);
            },
            error: function(xhr) {
                let err = 'Update failed. Please try again.';
                if(xhr.responseJSON && xhr.responseJSON.message) err = xhr.responseJSON.message;
                $('#status-message').text(err).css('color', 'red');
                $('#submit-all').prop('disabled', false).text('Update All');
            }
        });
    });
});
</script>
@endpush
