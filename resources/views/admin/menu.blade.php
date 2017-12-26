@if(isset($menu['url']))
    <li>
        <a class="J_menuItem" href="{{ url($menu['url']) }}">
            <i class="{{$menu['icon'] or 'fa fa-leaf'}}"></i>
            <span class="nav-label">{{ $menu['title'] }}</span>
        </a>
    </li>
@else
    <li>
        <a href="#">
            <i class="{{$menu['icon'] or 'fa fa-plus-square-o'}}"></i>
            <span class="nav-label">{{ $menu['title'] }}</span><span class="fa arrow"></span>
        </a>
        <ul class="nav nav-second-level">
            {!! $child !!}
        </ul>
    </li>
@endif
