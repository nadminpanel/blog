@if( NAdminPanel\AdminPanel\Models\PermissionLabel::exists('tag') && (\Auth::user()->hasPermissionTo('show tag') || \Auth::user()->hasPermissionTo('create tag') || \Auth::user()->hasRole('developer')))
<li class="{{ active_route('tag.*') }} treeview">
    <a href="#">
        <i class="fa fa-tags"></i>
        <span>Tags</span>
        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        @if(\Auth::user()->hasPermissionTo('show tag') || \Auth::user()->hasRole('developer'))
            <li class="{{ active_route('tag.index') }}"><a href="{{ route('tag.index') }}"><i class="fa fa-circle-o"></i> Tag List</a></li>
        @endif
        @if(\Auth::user()->hasPermissionTo('create tag') || \Auth::user()->hasRole('developer'))
            <li class="{{ active_route('tag.create') }}"><a href="{{ route('tag.create') }}"><i class="fa fa-circle-o"></i> Create Tag</a></li>
        @endif
        @if(\Auth::user()->hasPermissionTo('show tag') || \Auth::user()->hasRole('developer'))
            <li class="{{ active_route('tag.archive') }}"><a href="{{ route('tag.archive') }}"><i class="fa fa-circle-o"></i> Archive Tag List</a></li>
        @endif
    </ul>
</li>
@endif