@extends('admin.master')
@section('title', __('messages.create_brands'))

@section('content')
<h1>{{ __('messages.create_new_brand') }}</h1>
<form action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="name" class="form-label fw-medium">{{ __('messages.name') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control rounded-3" id="name" name="name" required>
            <div class="invalid-feedback" id="name-error"></div>
        </div>
        <div class="col-md-6">
            <label for="code" class="form-label fw-medium">{{ __('messages.code') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control rounded-3" id="code" name="code" required>
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
    <button type="submit" class="btn btn-primary btn-sm rounded-3" id="saveBtn">{{ __('messages.save') }}</button>
</form>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var nameInput = document.getElementById('name');
        var slugInput = document.getElementById('slug');
        var codeInput = document.getElementById('code');

        // Generate code automatically when the page loads
        codeInput.value = generateRandomCode();

        nameInput.addEventListener('input', function() {
            var name = nameInput.value;
            var slug = name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
            slugInput.value = slug;
        });

        function generateRandomCode() {
            var letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            var digits = '0123456789';
            var letter = letters.charAt(Math.floor(Math.random() * letters.length));
            var number = '';
            for (var i = 0; i < 4; i++) {
                number += digits.charAt(Math.floor(Math.random() * digits.length));
            }
            return 'B0' + letter + number;
        }
    });
</script>
@endsection
