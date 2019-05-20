@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@elseif(session('trash-message'))
    <?php list($message, $postId) = session('trash-message') ?>
    {!! Form::open(['method' => 'PUT', 'route' => ['backend.blog.restore', $postId]]) !!}
        <div class="alert alert-info">
            {{ $message }} <button type="submit" class="btn btn-sm btn-warning"><i class="fa fa-undo"></i>Undo</button>
        </div>
    {!! Form::close() !!}
@elseif(session('message'))
    <div class="alert alert-info">
        {{ session('message') }}
    </div>
@endif