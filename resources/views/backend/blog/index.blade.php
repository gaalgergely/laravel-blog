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
                        <div class="box-header">
                            <div class="pull-left">
                                <a href="{{ route('backend.blog.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Add New</a>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body ">
                            @include('backend.blog.message')
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
                                <tbody>
                                    @forelse($posts as $post)
                                    <tr>
                                        <td>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['backend.blog.destroy', $post->id]]) !!}
                                            <a href="{{ route('backend.blog.edit', $post->id) }}" class="btn btn-xs btn-default">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <button type="submit" class="btn btn-xs btn-danger">
                                                <i class="fa fa-times"></i>
                                            </button>
                                            {!! Form::close() !!}
                                        </td>
                                        <td>{{ $post->title }}</td>
                                        <td>{{ $post->author->name }}</td>
                                        <td>{{ $post->category->title }}</td>
                                        <td>
                                            <abbr title="{{ $post->dateFormatted(true) }}">{{ $post->dateFormatted() }}</abbr>
                                            {!! $post->publicationLabel() !!}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5">
                                            <div class="alert alert-danger">
                                                <strong>No record found</strong>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer clearfix">
                            <div class="pull-left">
                                {{ $posts->render() }}
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