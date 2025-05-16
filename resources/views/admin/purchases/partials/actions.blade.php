<div class="btn-group" role="group">
    {{-- <button class="btn btn-sm btn-info rounded-3 show-purchase action-btn" data-id="{{ $row->id }}" title="{{ __('messages.view') }}">
        <i class="bi bi-eye-fill"></i>
    </button> --}}
    <button class="btn btn-sm btn-warning rounded-3 edit-purchase action-btn" data-id="{{ $row->id }}" title="{{ __('messages.edit') }}">
        <i class="bi bi-pencil-fill"></i>
    </button>
    <button class="btn btn-sm btn-danger rounded-3 delete-purchase action-btn" data-id="{{ $row->id }}" title="{{ __('messages.delete') }}">
        <i class="bi bi-trash-fill"></i>
    </button>
</div>
