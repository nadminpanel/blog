@extends('nadminpanel::admin.common.main')

@section('title')
    @if(!isset($post))
        Create new Post
    @else
        Edit Post
    @endif
@endsection

@section('extra-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/datatables.net-bs/css/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/datatables.net-bs/css/responsive.bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/summernote-0.8.3/dist/summernote.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/switchery-0.8.2/dist/switchery.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}">
    <style>
        .note-editor > .form-group {
            margin-right: 0px !important;
            margin-left: 0px !important;
        }
        .note-editor {
            margin-bottom: 5px !important;
        }
    </style>
@endsection

@section('box')
    <div class="box" id="post">

        <div class="box-header with-border">
            <h3 class="box-title">
                @if(!isset($post))
                    Create
                @else
                    Edit
                @endif
                    Post
            </h3>
            <a class="btn btn-success pull-right" href="{{ url('post') }}">See All</a>
        </div><!-- /.box-header -->

    @if(!isset($post))
        <form id="post-form" method="POST" action="{{ route('post.store') }}" class="form-horizontal" role="form" autocomplete="off">
    @else
        <form id="post-form" method="POST" action="{{ route('post.update', $post->id) }}" class="form-horizontal" role="form" autocomplete="off">
            {{ method_field('PUT') }}
    @endif

            {!! csrf_field() !!}

            <div class="box-body">

                <div class="form-group">
                    <label for="featured" class="col-md-2 control-label">Feature</label>
                    <div class="col-md-9">
                        <input name="featured" type="checkbox" class="js-switch" {{ (old('featured') != null) ? ((old('featured') == 'on') ? 'checked' : '') : ((isset($post->featured)) ? (($post->featured == 1) ? 'checked' : '') : '')}} />
                    </div>
                </div>

                <div class="form-group">
                    <label for="title" class="col-md-2 control-label">Title<span class="text-red">&nbsp;*</span></label>
                    <div class="col-md-9">
                        <input type="text" name="title" id="title" placeholder="Enter Title" value="{{ (old('title') != null) ? old('title') : (isset($post->title) ? $post->title : '') }}" class="form-control" />
                        @if($errors->has('title'))
                            <span class="text-red">{{ $errors->first('title') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="description" class="col-md-2 control-label">Description<span class="text-red">&nbsp;*</span></label>
                    <div class="col-md-9">
                        <div id="summernote">{{ (old('description') != null) ? old('description') : (isset($post->description) ? $post->description : '') }}</div>
                        <input type="hidden" name="description" value=""/>
                        @if($errors->has('description'))
                            <span class="text-red">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="published_at" class="col-md-2 control-label">Publish Date</label>
                    <div class='col-md-9 '>
                        <input type="text" name="published_at" id="published_at" class="form-control"  />
                        @if($errors->has('published_at'))
                            <span class="text-red">{{ $errors->first('published_at') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="source" class="col-md-2 control-label">Source</label>
                    <div class="col-md-9">
                        <input type="text" name="source" id="source" placeholder="Enter Source" value="{{ (old('source') != null) ? old('source') : (isset($post->source) ? $post->source : '') }}" class="form-control" />
                        @if($errors->has('source'))
                            <span class="text-red">{{ $errors->first('source') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label"></label>
                    <div class="col-md-9">
                        @if(!isset($post))
                            <button type="submit" class="btn btn-success">Save</button>
                        @else
                            <button type="submit" class="btn btn-primary">Update</button>
                        @endif
                        <a href="{{ route('post.index') }}"><button type="button" class="btn btn-default">Cancel</button></a>
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
    <script type="text/javascript" src="{{ asset('backend/plugins/summernote-0.8.3/dist/summernote.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/plugins/switchery-0.8.2/dist/switchery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/plugins/moment-develop/min/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script>
        $(document).ready(function(){

            // Define function to open filemanager window
            var lfm = function(options, cb) {
                var route_prefix = (options && options.prefix) ? options.prefix : '/laravel-filemanager';
                window.open(route_prefix + '?type=' + options.type || 'file', 'FileManager', 'width=900,height=600');
                window.SetUrl = cb;
            };

            // Define LFM summernote button
            var LFMButton = function(context) {
                var ui = $.summernote.ui;
                var button = ui.button({
                    contents: '<i class="note-icon-picture"></i> ',
                    tooltip: 'Image',
                    click: function() {

                        lfm({type: 'image', prefix: '/laravel-filemanager'}, function(url, path) {
                            context.invoke('insertImage', url);
                        });

                    }
                });
                return button.render();
            };

            // Initialize summernote with LFM button in the popover button group
            // Please note that you can add this button to any other button group you'd like
            $('#summernote').summernote({
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontstyle',['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['popovers', ['lfm']],
                    ['insert',['video','link']],
                    ['mesc',['codeview','fullscreen']]
                ],
                buttons: {
                    lfm: LFMButton
                }
            })

        });
    </script>
    <script>
        $(document).ready(function() {
            $('#published_at').datetimepicker({
                defaultDate: new Date()
            });
            $('#summernote').summernote();
        });
    </script>
    <script>
        var elem = document.querySelector('.js-switch');
        var switchery = new Switchery(elem);
    </script>
@endsection