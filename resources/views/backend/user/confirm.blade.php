@extends('layouts.backend.main')

@section('title', 'MyBlog | Delete Confirmation')))

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                User
                <small>Delete Confirmation</small>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i> <a href="{{ route('home') }}">Dashboard</a></li>
                <li><a href="{{ route('backend.user.index') }}">Users</a></li>
                <li class="active">Delete Confirmation</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        {!! Form::open(['method' => 'DELETE', 'route' => ['backend.user.destroy', $user->id]]) !!}
                        <div class="box-body">
                            <p>You have specified this user for deletion:</p>
                            <p>ID #{{ $user->id }}: {{ $user->name }}</p>
                            <p>What should be done with content owned by this user?</p>
                            <p>{!! Form::input('radio', 'delete_option', 'delete', ['checked' => 'checked']) !!} Delete All Content</p>
                            <p>
                                {!! Form::input('radio', 'delete_option', 'attribute') !!} Attribute content to:
                                {!! Form::select('selected_user', \App\User::where('id', '!=', $user->id)->pluck('name', 'id'), null) !!}
                            </p>
                        </div>
                        <div class="box-footer">
                            {!! Form::button('Confirm Deletion', ['type' => 'submit', 'class' => 'btn btn-danger']) !!}
                            <a href="{{ route('backend.user.index') }}" class="btn btn-default">Cancel</a>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <!-- ./row -->
        </section>
        <!-- /.content -->
    </div>
@endsection