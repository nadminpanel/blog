@if(active_check(config('nadminpanel.admin_backend_prefix').'/post') == 'active')
	@if(\Auth::user()->hasPermissionTo('edit post') || \Auth::user()->hasRole('developer'))
		<a href="{{ route('post.edit', $post->id) }}" class="btn btn-xs btn-primary">
			<i class="glyphicon glyphicon-edit"></i> Edit
		</a>
	@endif
	@if(\Auth::user()->hasPermissionTo('delete post') || \Auth::user()->hasRole('developer'))
		<a class="btn btn-xs bg-red-active delete" data-id="{{ $post->id }}">
			<i class="fa fa-trash"></i> Archive
		</a>
	@endif
@elseif(active_check(config('nadminpanel.admin_backend_prefix').'/post/archive') == 'active')
	@if(\Auth::user()->hasPermissionTo('edit post') || \Auth::user()->hasRole('developer'))
		<a class="btn btn-xs bg-blue-active unarchive" data-id="{{ $post->id }}">
			<i class="fa fa-trash"></i> UnArchived
		</a>
	@endif
	@if(\Auth::user()->hasPermissionTo('delete post') || \Auth::user()->hasRole('developer'))
		<a class="btn btn-xs bg-red-active delete" data-id="{{ $post->id }}">
			<i class="fa fa-trash"></i> Deleted
		</a>
	@endif
@endif

