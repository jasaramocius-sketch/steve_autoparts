@php
    $currentUrl = url()->current();
    $menu = $menu ?? [];
@endphp
@foreach($menu as $item)
    @php
        $label = $item['label'] ?? '';
        $url = $item['url'] ?? '#';
        $children = $item['children'] ?? [];
        $isMegamenu = !empty($item['megamenu']) || count($children) > 4;
        $hasChildren = !empty($children);
        $isActive = $currentUrl === url($url) || $currentUrl === url($url . '/');
        $liClass = $hasChildren ? ($isMegamenu ? 'has-megamenu' : 'has-submenu') : '';
    @endphp
    
    <li class="{{ $liClass }}">
        <div class="menu-item-with-icon">
        <a href="{{ $url === '#' ? 'javascript:void(0)' : url($url) }}" class="nav-link{{ $isActive ? ' active' : '' }}">{{ $label }}</a>
        @if($hasChildren)
            <span class="has-submenu-icon">
                <i class="fas fa-chevron-down"></i>
            </span></div>
            @if($isMegamenu)
                <div class="megamenu cat-megamenu">
                    <div class="row w-100">
                        @foreach($children as $col)
                            <div class="col-lg-3">
                                <div class="single-menu mt-30">
                                    <h5><a href="{{ url($col['url'] ?? '#') }}">{{ $col['label'] ?? '' }}</a></h5>
                                    @if(!empty($col['children']))
                                        <ul>
                                            @foreach($col['children'] as $child)
                                                <li><a href="{{ url($child['url'] ?? '#') }}">{{ $child['label'] ?? '' }}</a></li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <ul class="dropdown-menu border-0 shadow">
                    @foreach($children as $child)
                        <li>
                            <a class="dropdown-item dropdown__item" href="{{ url($child['url'] ?? '#') }}">
                                {{ $child['label'] ?? '' }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        @endif
    </li>
@endforeach
