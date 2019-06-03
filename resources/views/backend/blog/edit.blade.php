@extends('layouts.backend.main')

@section('title', 'MyBlog | ' . (($form->getModel() ? 'Edit post' : 'Add new post')))

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Blog
                <small>@if($form->getModel()) Edit post @else Add new post @endif</small>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i> <a href="{{ route('home') }}">Dashboard</a></li>
                <li><a href="{{ route('backend.blog.index') }}">Posts</a></li>
                @if($form->getModel())
                <li class="active">Edit</li>
                @else
                <li class="active">Add new</li>
                @endif
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                {!! form_start($form, ['files' => true]) !!}
                <div class="col-xs-9">
                    <div class="box">
                        <!-- /.box-header -->
                        <div class="box-body ">
                            {!! form_row($form->title) !!}
                            {!! form_row($form->slug) !!}
                            {!! form_row($form->excerpt) !!}
                            {!! form_row($form->body) !!}
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <div class="col-xs-3">
                    <div class="box">
                        <div class="box-header with-border"><h3 class="box-title">Publish</h3></div>
                        <div class="box-body">
                            {!! form_row($form->published_at) !!}
                        </div>
                        <div class="box-footer clearfix">
                            <div class="pull-left">
                                <a id="draft-btn" class="btn btn-default">Save Draft</a>
                            </div>
                            <div class="pull-right">
                                {!! form_row($form->submit) !!}
                            </div>
                        </div>
                    </div>
                    <div class="box">
                        <div class="box-header with-border"><h3 class="box-title">Category</h3></div>
                        <div class="box-body">
                            {!! form_row($form->category_id) !!}
                        </div>
                    </div>
                    <div class="box">
                        <div class="box-header with-border"><h3 class="box-title">Tags</h3></div>
                        <div class="box-body">
                            <div class="form-group">
                                {!! form_row($form->post_tags) !!}
                            </div>
                        </div>
                    </div>
                    <div class="box">
                        <div class="box-header with-border"><h3 class="box-title">Feature Image</h3></div>
                        <div class="box-body text-center">
                            {!! form_row($form->image) !!}
                        </div>
                    </div>
                </div>
                {!! form_end($form) !!}
            </div>
            <!-- ./row -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('script')
<script>
    $('#title').on('blur', function(){
        var theTitle = this.value.toLowerCase().trim(),
            slugInput = $('#slug'),
            theSlug = theTitle.replace(/&/g, '-and-')
                                .replace(/[^a-z0-9-]+/g, '-')
                                .replace(/\-\-+/g, '')
                                .replace(/^-+|-+$/g, '');

        slugInput.val(theSlug);
    });
    var excerptEditor = new SimpleMDE({ element: $("#excerpt")[0] });
    var bodyEditor = new SimpleMDE({ element: $("#body")[0] });
    $("#body").attr('required' ,false);
    /**
     * @todo validate post body textarea editor
     */
    //$(".CodeMirror textarea:eq(1)").attr('required' ,true);

    $('#published_at').datetimepicker({
        format: 'YY-MM-DD HH:mm:ss',
        showClear: true
    });

    $('#draft-btn').click(function(e) {
        e.preventDefault();
        $('#published_at').val("");
        $('button[type=submit]').click();
    });
</script>
<script src="/backend/plugins/tag-editor/jquery.caret.min.js"></script>
<script src="/backend/plugins/tag-editor/jquery.tag-editor.min.js"></script>
<script>
    var options = {};

    @if($form->getModel())
        options = {
        initialTags: {!! json_encode($form->getModel()->postTags(false)) !!},
    };
    @endif
    $('input[name=post_tags]').tagEditor(options);
</script>
@endsection

@section('style')
<link rel="stylesheet" href="/backend/plugins/tag-editor/jquery.tag-editor.css">
@endsection