@extends('nadminpanel::admin.common.main')

@section('title')
    @if(!isset($tag))
        Create new Tag
    @else
        Edit Tag
    @endif
@endsection

@section('extra-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/datatables.net-bs/css/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/datatables.net-bs/css/responsive.bootstrap.min.css') }}">
@endsection

@section('box')
    <div class="box" id="post">

        <div class="box-header with-border">
            <h3 class="box-title">
                @if(!isset($tag))
                    Create
                @else
                    Edit
                @endif
                    Tag
            </h3>
            <a class="btn btn-success pull-right" href="{{ url('tag') }}">See All</a>
        </div><!-- /.box-header -->

    @if(!isset($tag))
        <form id="tag-form" method="POST" action="{{ route('tag.store') }}" class="form-horizontal" role="form" autocomplete="off">
    @else
        <form id="tag-form" method="POST" action="{{ route('tag.update', $tag->id) }}" class="form-horizontal" role="form" autocomplete="off">
            {{ method_field('PUT') }}
    @endif

            {!! csrf_field() !!}

            <div class="box-body">

                <div class="form-group">
                    <label for="name" class="col-md-3 control-label">Name<span class="text-red">&nbsp;*</span></label>
                    <div class="col-md-6">
                        <input type="text" name="name" id="name" placeholder="Enter Name" value="{{ (old('name') != null) ? old('name') : (isset($tag->name) ? $tag->name : '') }}" class="form-control" />
                        @if($errors->has('name'))
                            <span class="text-red">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="description" class="col-md-3 control-label">Description</label>
                    <div class="col-md-6">
                        <textarea class="form-control" name="description" id="description">{{ (old('description') != null) ? old('description') : (isset($tag->description) ? $tag->description : '') }}</textarea>
                        @if($errors->has('description'))
                            <span class="text-red">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-6">
                        @if(!isset($tag))
                            <button type="submit" class="btn btn-success">Save</button>
                        @else
                            <button type="submit" class="btn btn-primary">Update</button>
                        @endif
                        <a href="{{ route('tag.index') }}"><button type="button" class="btn btn-default">Cancel</button></a>
                    </div>
                </div>

            </div><!-- /.box-body -->
        </form>
    </div>

@endsection

@section('extra-script')
    <script type="text/javascript" src="{{ asset('backend/plugins/datatables.net/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/plugins/datatables.net-bs/js/dataTables.responsive.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/plugins/datatables.net-bs/js/dataTables.bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/vuejs/vue.min.js') }}"></script>
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                name: '{{ (old('name') != null) ? old('name') : (isset($tag->name) ? $tag->name : '') }}'
            }
        })
    </script>
@endsection