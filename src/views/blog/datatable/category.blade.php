@if(active_check(config('nadminpanel.admin_backend_prefix').'/category') == 'active')
	@if(\Auth::user()->hasPermissionTo('edit category') || \Auth::user()->hasRole('developer'))
		<a href="{{ route('category.edit', $category->id) }}" class="btn btn-xs btn-primary">
			<i class="glyphicon glyphicon-edit"></i> Edit
		</a>
	@endif
	@if(\Auth::user()->hasPermissionTo('delete category') || \Auth::user()->hasRole('developer'))
		<a class="btn btn-xs bg-red-active delete" data-id="{{ $category->id }}">
			<i class="fa fa-trash"></i> Archive
		</a>
	@endif
@elseif(active_check(config('nadminpanel.admin_backend_prefix').'/category/archive') == 'active')
	@if(\Auth::user()->hasPermissionTo('edit category') || \Auth::user()->hasRole('developer'))
		<a class="btn btn-xs bg-blue-active unarchive" data-id="{{ $category->id }}">
			<i class="fa fa-trash"></i> UnArchived
		</a>
	@endif
	@if(\Auth::user()->hasPermissionTo('delete category') || \Auth::user()->hasRole('developer'))
		<a class="btn btn-xs bg-red-active delete" data-id="{{ $category->id }}">
			<i class="fa fa-trash"></i> Deleted
		</a>
	@endif
@endif

