@if( NAdminPanel\AdminPanel\Models\PermissionLabel::exists('post') && (\Auth::user()->hasPermissionTo('show post') || \Auth::user()->hasPermissionTo('create post') || \Auth::user()->hasRole('developer')))
<li class="{{ active_check(config('nadminpanel.admin_backend_prefix').'/post', true) }} treeview">
    <a href="#">
        <i class="fa fa-shield"></i>
        <span>Posts</span>
        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        @if(\Auth::user()->hasPermissionTo('show post') || \Auth::user()->hasRole('developer'))
            <li class="{{ active_check(config('nadminpanel.admin_backend_prefix').'/post') }}"><a href="{{ route('post.index') }}"><i class="fa fa-circle-o"></i> Post List</a></li>
        @endif
        @if(\Auth::user()->hasPermissionTo('create post') || \Auth::user()->hasRole('developer'))
            <li class="{{ active_check(config('nadminpanel.admin_backend_prefix').'/post/create') }}"><a href="{{ route('post.create') }}"><i class="fa fa-circle-o"></i> Create Post</a></li>
        @endif
        @if(\Auth::user()->hasPermissionTo('show post') || \Auth::user()->hasRole('developer'))
            <li class="{{ active_check(config('nadminpanel.admin_backend_prefix').'/post/archive') }}"><a href="{{ route('post.archive') }}"><i class="fa fa-circle-o"></i> Archive Post List</a></li>
        @endif
    </ul>
</li>
@endif