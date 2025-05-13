<div class="btn-group">
    <button class="btn btn-sm btn-warning edit-product" data-id="{{ $row->id }}" title="{{ __('messages.edit') }}">
        <i class="bi bi-pencil"></i>
    </button>
    <button class="btn btn-sm btn-danger delete-product" data-id="{{ $row->id }}" title="{{ __('messages.delete') }}">
        <i class="bi bi-trash"></i>
    </button>
</div>
