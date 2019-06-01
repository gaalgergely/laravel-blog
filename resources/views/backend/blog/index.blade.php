@extends('layouts.backend.main')

@section('title', 'MyBlog | Blog index')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Blog
                <small>Display all blog posts</small>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i> <a href="{{ route('home') }}">Dashboard</a></li>
                <li><a href="{{ route('backend.blog.index') }}">Posts</a></li>
                <li class="active">All Posts</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header clearfix">
                            <div class="pull-left">
                                <a href="{{ route('backend.blog.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Add New</a>
                            </div>
                            <div class="pull-right" style="padding: 7px 0px;">
                                <a href="?status=own" class="@if(Request::get('status')=='own') selected-status @endif">All({{ request()->user()->posts()->withTrashed()->count() }}) </a> |
                                <a href="?status=all" class="@if(Request::get('status')=='all') selected-status @endif">All({{ \App\Post::all()->count() }}) </a> |
                                <a href="?status=published" class="@if(Request::get('status')=='published') selected-status @endif">Published({{ \App\Post::published()->count() }})</a> |
                                <a href="?status=scheduled" class="@if(Request::get('status')=='scheduled') selected-status @endif">Scheduled({{ \App\Post::scheduled()->count() }})</a> |
                                <a href="?status=draft" class="@if(Request::get('status')=='draft') selected-status @endif">Draft({{ \App\Post::draft()->count() }})</a> |
                                <a href="?status=trash" class="@if(Request::get('status')=='trash') selected-status @endif">Trash({{ \App\Post::onlyTrashed()->count() }})</a>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body ">
                            @include('backend.partials.message')
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td width="70">Action</td>
                                        <td>Title</td>
                                        <td width="120">Author</td>
                                        <td width="150">Category</td>
                                        <td width="150">Date</td>
                                    </tr>
                                </thead>
                                @if($onlyTrashed)
                                    @include('backend.blog.table-trash')
                                @else
                                    @include('backend.blog.table')
                                @endif
                            </table>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer clearfix">
                            <div class="pull-left">
                                {{ $posts->appends(Request::query())->render() }}
                            </div>
                            <div class="pull-right">
                                <small>
                                    <?php $postCount = $posts->total() ?>
                                    {{ $postCount }} {{ \Illuminate\Support\Str::plural('post', $postCount) }}
                                </small>
                            </div>
                        </div>
                    </div>
                    <!-- /.box -->
                </div>
            </div>
            <!-- ./row -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('script')
<script>
    $('ul.pagination').addClass('no-margin pagination-sm');
</script>
@endsection