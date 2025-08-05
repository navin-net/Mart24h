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

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">
                        <form id="banners-form" enctype="multipart/form-data">
                            @csrf

                            @foreach ($banners as $i => $banner)
                                <div class="banner-item mb-4">
                                    <input type="hidden" name="banners[{{ $i }}][id]" value="{{ $banner->id }}">
                                    <div class="row g-3 align-items-center">
                                        <div class="col-md-3">
                                            <label for="title-{{ $i }}">Title</label>
                                            <input type="text" id="title-{{ $i }}" name="banners[{{ $i }}][title]" value="{{ $banner->title }}" class="form-control" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="status-{{ $i }}">Status</label>
                                            <select id="status-{{ $i }}" name="banners[{{ $i }}][status]" class="form-control" required>
                                                <option value="1" {{ $banner->status ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ !$banner->status ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="link-{{ $i }}">Link</label>
                                            <input type="url" id="link-{{ $i }}" name="banners[{{ $i }}][link]" value="{{ $banner->link }}" class="form-control" placeholder="https://example.com" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Image</label><br>
                                            <!--
                                            @if($banner->image)
                                                <img src="{{ asset('storage/' . $banner->image) }}" alt="Banner Image" class="img-fluid" style="max-height: 100px; max-width: 50px;">
                                            @endif
                                            -->
                                            <input type="file" name="banners[{{ $i }}][image]" class="form-control mt-1" accept="image/*">
                                            <a href="{{ asset('storage/' . $banner->image) }}" target="_blank">sa.{{ $banner->id }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <button type="button" id="submit-all" class="btn btn-primary">Update All</button>
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
