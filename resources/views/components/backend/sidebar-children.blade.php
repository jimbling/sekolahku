@foreach ($children as $child)
    @if (!isset($child['permission']) || auth()->user()->can($child['permission']))
        @php
            $hasChildren = !empty($child['children']);
            $isActive = is_menu_active($child);
            $childUrl = $hasChildren ? '#' : url('admin/' . ltrim($child['url'], '/'));
        @endphp

        <li class="nav-item {{ $hasChildren && $isActive ? 'menu-open' : '' }}">
            <a href="{{ $childUrl }}" class="nav-link {{ $isActive ? 'active' : '' }}">
                <i class="fas fa-angle-right nav-icon"></i>
                <p>
                    {{ $child['title'] }}
                    @if ($hasChildren)
                        <i class="fas fa-angle-left right"></i>
                    @endif
                </p>
            </a>

            @if ($hasChildren)
                <ul class="nav nav-treeview ml-2">
                    {{-- Panggil dirinya sendiri untuk render cucu, cicit, dst. --}}
                    @include('components.backend.sidebar-children', ['children' => $child['children']])
                </ul>
            @endif
        </li>
    @endif
@endforeach
