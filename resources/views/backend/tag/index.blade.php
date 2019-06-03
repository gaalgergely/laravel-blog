@extends('layouts.backend.main')

@section('title', 'TagForm')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Tag
                <small>Display all tags</small>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i> <a href="{{ route('home') }}">Dashboard</a></li>
                <li><a href="{{ route('backend.tag.index') }}">Tags</a></li>
                <li class="active">All Tags</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header clearfix">
                            <div class="pull-left">
                                <a href="{{ route('backend.tag.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Add New</a>
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
                                        <td width="120">Post count</td>
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse($tags as $tag)
                                    <tr>
                                        <td>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['backend.tag.destroy', $tag->id]]) !!}
                                            <a href="{{ route('backend.tag.edit', $tag->id) }}" class="btn btn-xs btn-default">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <button onclick="return confirm('Are you sure?');" type="submit" class="btn btn-xs btn-danger">
                                                <i class="fa fa-times"></i>
                                            </button>
                                            {!! Form::close() !!}
                                        </td>
                                        <td>{{ $tag->name }}</td>
                                        <td>{{ $tag->posts->count() }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2">
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
                                {{ $tags->render() }}
                            </div>
                            <div class="pull-right">
                                <small>
                                    {{ $tags->total() }} {{ \Illuminate\Support\Str::plural('category', $tags->total()) }}
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