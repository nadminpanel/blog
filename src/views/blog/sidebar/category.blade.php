@if( NAdminPanel\AdminPanel\Models\PermissionLabel::exists('category') && (\Auth::user()->hasPermissionTo('show category') || \Auth::user()->hasPermissionTo('create category') || \Auth::user()->hasRole('developer')))
<li class="{{ active_route('category.*') }} treeview">
    <a href="#">
        <i class="fa fa-th-list"></i>
        <span>Categories</span>
        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        @if(\Auth::user()->hasPermissionTo('show category') || \Auth::user()->hasRole('developer'))
            <li class="{{ active_route('category.index') }}"><a href="{{ route('category.index') }}"><i class="fa fa-circle-o"></i> Category List</a></li>
        @endif
        @if(\Auth::user()->hasPermissionTo('create category') || \Auth::user()->hasRole('developer'))
            <li class="{{ active_route('category.create') }}"><a href="{{ route('category.create') }}"><i class="fa fa-circle-o"></i> Create Category</a></li>
        @endif
        @if(\Auth::user()->hasPermissionTo('show category') || \Auth::user()->hasRole('developer'))
            <li class="{{ active_route('category.archive') }}"><a href="{{ route('category.archive') }}"><i class="fa fa-circle-o"></i> Archive Category List</a></li>
        @endif
    </ul>
</li>
@endif