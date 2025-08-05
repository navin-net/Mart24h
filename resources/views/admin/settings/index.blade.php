@extends('admin.master')

@section('title', __('messages.shop_info'))

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
                        <form id="shop-info-form" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label>Name Shop</label>
                                    <input type="text" name="name_shop" value="{{ $shop->name_shop }}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label>Email</label>
                                    <input type="email" name="email" value="{{ $shop->email }}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label>Phone</label>
                                    <input type="text" name="phone" value="{{ $shop->phone }}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label>Address</label>
                                    <input type="text" name="address" value="{{ $shop->address }}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label>Open Shop Time</label>
                                    <input type="time" name="open_shop_time" value="{{ $shop->open_shop_time }}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label>Close Shop Time</label>
                                    <input type="time" name="close_shop" value="{{ $shop->close_shop }}" class="form-control">
                                </div>
                                <div class="col-md-12">
                                    <label>Description</label>
                                    <textarea name="description" rows="3" class="form-control">{{ $shop->description }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label>Facebook</label>
                                    <input type="url" name="facebook" value="{{ $shop->facebook }}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label>X (Twitter)</label>
                                    <input type="url" name="x" value="{{ $shop->x }}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label>Instagram</label>
                                    <input type="url" name="instagram" value="{{ $shop->instagram }}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label>YouTube</label>
                                    <input type="url" name="youtube" value="{{ $shop->youtube }}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label>LinkedIn</label>
                                    <input type="url" name="linkedin" value="{{ $shop->linkedin }}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label>Logo Shop</label>
                                    @if ($shop->logo_shop)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $shop->logo_shop) }}" alt="Logo" class="img-fluid" style="max-height: 100px;">
                                        </div>
                                    @endif
                                    <input type="file" name="logo_shop" class="form-control" accept="image/*">
                                </div>
                            </div>

                            <button type="button" id="submit-shop-info" class="btn btn-primary">Update Info</button>
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
    $(document).ready(function () {
        $('#submit-shop-info').on('click', function () {
            const form = $('#shop-info-form')[0];
            const formData = new FormData(form);
            $('#status-message').text('');
            $('#submit-shop-info').prop('disabled', true).text('Updating...');

            $.ajax({
                url: "{{ route('settings.update') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('#status-message').text(response.message || 'Shop info updated.');
                    $('#submit-shop-info').prop('disabled', false).text('Update Info');
                },
                error: function (xhr) {
                    let msg = 'Update failed.';
                    if (xhr.responseJSON?.errors) {
                        msg = Object.values(xhr.responseJSON.errors).flat().join("\n");
                    }
                    $('#status-message').text(msg).css('color', 'red');
                    $('#submit-shop-info').prop('disabled', false).text('Update Info');
                }
            });
        });
    });
</script>
@endpush
