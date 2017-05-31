@extends('nadminpanel::admin.common.main')

@section('title')
    @if( active_check(config('nadminpanel.admin_backend_prefix').'/post') == 'active' )
        Post Index
    @elseif( active_check(config('nadminpanel.admin_backend_prefix').'/post/archive') == 'active' )
        Post Archive
    @endif
@endsection

@section('extra-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/datatables.net-bs/css/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/datatables.net-bs/css/responsive.bootstrap.min.css') }}">
@endsection

@section('box')
    <div class="box">

        <div class="box-header with-border">
            <h3 class="box-title">Post{{ (active_check(config('nadminpanel.admin_backend_prefix').'/post') == 'active') ? ' ' : ' Archive ' }}List</h3>
            <a style="margin-right:5px" class="btn btn-success pull-right " href="{{ route('post.create') }}">Create Post</a>
        </div><!-- /.box-header -->

        <div class="box-body">
            <table class="table table-bordered dt-responsive nowrap" id="data_table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Short Description</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div><!-- /.box-body -->

        <div class="box-footer clearfix"></div>

    </div>
@endsection

@section('extra-script')
    <script type="text/javascript" src="{{ asset('backend/plugins/datatables.net/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/plugins/datatables.net-bs/js/dataTables.responsive.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/plugins/datatables.net-bs/js/dataTables.bootstrap.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function  (argument) {

        @if(active_check(config('nadminpanel.admin_backend_prefix').'/post') == 'active')
            var mainUrl="{!! route('post.index') !!}";
        @elseif(active_check(config('nadminpanel.admin_backend_prefix').'/post/archive') == 'active')
            var mainUrl = "{!! route('post.archive') !!}";
        @endif

            var table=$('#data_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url : mainUrl
                },
                columns: [
                    { data: 'DT_Row_Index', name: 'DT_Row_Index', orderable: false, searchable: false },
                    { data: 'title', name: 'title'},
                    { data: 'short_description', name: 'short_description', orderable: false, searchable: false},
                    { data: 'action', name : 'action', orderable: false, searchable: false}
                ],
                order: [[ 1, "asc" ]]
            });

            $('#state').on('change', function(e) {
                table.draw();
                e.preventDefault();
            });

            var successHandler=function($msg){
                toastr.success($msg,'Status',{timeOut: 2000});
                table.ajax.reload(null, false);
            };

            var errorHandler=function($msg){
                toastr.error($msg,'Status', {timeOut: 2000});
            };

            @if(active_check(config('nadminpanel.admin_backend_prefix').'/post') == 'active')

                $('#data_table').on('click','.delete',function (e) {
                e.preventDefault();
                $.ajax({
                    url: mainUrl+"/"+$(this).data('id'),
                    type: 'DELETE',
                    success: function(result) {
                        successHandler('Successfully Archived Post');
                    },
                    error: function (err) {
                        errorHandler('Error Post. Please reload the page.');
                    }
                });
            });

            @elseif(active_check(config('nadminpanel.admin_backend_prefix').'/post/archive') == 'active')

                $('#data_table').on('click','.unarchive',function (e) {
                    e.preventDefault();
                    $.ajax({
                        url: mainUrl+"/"+$(this).data('id'),
                        type: 'PATCH',
                        success: function(result) {
                            successHandler('Successfully Unarchived Post');
                        },
                        error: function (err) {
                            errorHandler('Error Post. Try to reload the page or Wait Your connection');
                        }
                    });
                });

                $('#data_table').on('click','.delete',function (e) {
                e.preventDefault();
                $.ajax({
                    url: mainUrl+"/"+$(this).data('id'),
                    type: 'DELETE',
                    success: function(result) {
                        successHandler('Successfully deleted Post');
                    },
                    error: function (err) {
                        errorHandler('Error Post. Please reload the page.');
                    }
                });
            });

            @endif

        });
    </script>
@endsection