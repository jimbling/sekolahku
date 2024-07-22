<li class="list-group-item" data-id="{{ $menu->id }}" style="margin-left: {{ $level * 20 }}px;">
    <div class="d-flex justify-content-between">
        <span class="handle">{{ $menu->title }}</span>
        <div>
            <!-- Edit Button -->
            <button class="btn btn-sm btn-warning" data-toggle="modal"
                data-target="#editMenuModal{{ $menu->id }}">Edit</button>
            <!-- Delete Button -->
            <form action="{{ route('menus.destroy', $menu->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger">Delete</button>
            </form>
        </div>
    </div>
    <!-- Edit Menu Modal -->
    <div class="modal fade" id="editMenuModal{{ $menu->id }}" tabindex="-1" role="dialog"
        aria-labelledby="editMenuModalLabel{{ $menu->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMenuModalLabel{{ $menu->id }}">Edit Menu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('menus.update', $menu->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="menus_nama{{ $menu->id }}">Title</label>
                            <input type="text" name="menus_nama" class="form-control"
                                id="menus_nama{{ $menu->id }}" value="{{ $menu->title }}" required>
                        </div>
                        <div class="form-group">
                            <label for="menus_tautan{{ $menu->id }}">URL</label>
                            <input type="text" name="menus_tautan" class="form-control"
                                id="menus_tautan{{ $menu->id }}" value="{{ $menu->url }}" required>
                        </div>
                        <div class="form-group">
                            <label for="menus_target{{ $menu->id }}">Target</label>
                            <select name="menus_target" class="form-control" id="menus_target{{ $menu->id }}">
                                <option value="_self" {{ $menu->menu_target == '_self' ? 'selected' : '' }}>Same Tab
                                </option>
                                <option value="_blank" {{ $menu->menu_target == '_blank' ? 'selected' : '' }}>New Tab
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if ($menu->children->count())
        <ul class="list-group">
            @foreach ($menu->children as $child)
                @include('admin.tampilan.partials.menu-item', ['menu' => $child, 'level' => $level + 1])
            @endforeach
        </ul>
    @endif
</li>
