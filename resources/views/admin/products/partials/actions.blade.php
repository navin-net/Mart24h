<div class="dropdown">
  <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton{{ $row->id }}" data-bs-toggle="dropdown" aria-expanded="false" title="{{ __('messages.actions') }}">
    Actions
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $row->id }}">
    <li>
      <button class="dropdown-item edit-product" data-id="{{ $row->id }}" type="button">
        <i class="bi bi-pencil me-2"></i> {{ __('messages.edit') }}
      </button>
    </li>
  <li>
  <a class="dropdown-item" href="{{ url('products/show/' . $row->id) }}">
    <i class="bi bi-eye me-2"></i> {{ __('messages.show') }}
  </a>
  </li>
    <li><hr class="dropdown-divider"></li>
  <li>
  <button class="dropdown-item delete-product text-danger" data-id="{{ $row->id }}" type="button">
    <i class="bi bi-trash me-2"></i> {{ __('messages.delete') }}
  </button>
  </li>
  </ul>
</div>
