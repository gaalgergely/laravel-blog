@extends('layouts.backend.main')

@section('title', 'MyBlog | Users')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                User
                <small>Display all users</small>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i> <a href="{{ route('home') }}">Dashboard</a></li>
                <li><a href="{{ route('backend.user.index') }}">Users</a></li>
                <li class="active">All Users</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header clearfix">
                            <div class="pull-left">
                                <a href="{{ route('backend.user.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Add New</a>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body ">
                            @include('backend.partials.message')
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td width="70">Action</td>
                                        <td>Name</td>
                                        <td>Email</td>
                                        <td>Role</td>
                                        <td>Posts Count</td>
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>
                                            <a href="{{ route('backend.user.edit', $user->id) }}" class="btn btn-xs btn-default">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            @if($user->id == config('cms.default_user_id') || $user->id == auth()->user()->id)
                                                <button onclick="return false;" type="submit" class="btn btn-xs btn-danger disabled">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            @else
                                                <a href="{{ route('backend.user.confirm', [$user->id]) }}" type="submit" class="btn btn-xs btn-danger">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            @endif
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->roles->first()->display_name }}</td>
                                        <td>{{ $user->posts()->withTrashed()->count() }}</td>
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
                                {{ $users->render() }}
                            </div>
                            <div class="pull-right">
                                <small>
                                    <?php $usersCount = $users->total() ?>
                                    {{ $usersCount }} {{ \Illuminate\Support\Str::plural('user', $usersCount) }}
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