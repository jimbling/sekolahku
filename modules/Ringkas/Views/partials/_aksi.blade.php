@php
    $isActive = $row->is_active;
    $statusClass = $isActive ? 'btn-success' : 'btn-secondary';
    $statusIcon = $isActive ? 'fas fa-toggle-on' : 'fas fa-toggle-off';
@endphp

<button class="btn btn-sm {{ $statusClass }} btnToggleStatus" data-id="{{ $row->id }}"
    data-status="{{ $isActive }}">
    <i class="{{ $statusIcon }}"></i>
</button>

<button class="btn btn-sm btn-warning btnEdit" data-id="{{ $row->id }}" data-slug="{{ $row->slug }}"
    data-url="{{ $row->original_url }}" data-description="{{ $row->description }}">
    <i class="fas fa-edit"></i>
</button>

<form action="{{ route('ringkas.destroy', $row->id) }}" method="POST" class="d-inline deleteForm">
    @csrf @method('DELETE')
    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
</form>
