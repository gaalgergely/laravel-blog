<tbody>
<?php
        $currentUser = request()->user();
?>
@forelse($posts as $post)
    <tr>
        <td>
            @if($currentUser->owns(\App\Post::withTrashed()->findOrFail($post->id), 'author_id') || $currentUser->can('delete-others-post'))
                {!! Form::open(['style' => 'display:inline-block', 'method' => 'PUT', 'route' => ['backend.blog.restore', $post->id]]) !!}
                <button type="submit" class="btn btn-xs btn-warning" title="Restore">
                    <i class="fa fa-refresh"></i>
                </button>
                {!! Form::close() !!}
                {!! Form::open(['style' => 'display:inline-block', 'method' => 'DELETE', 'route' => ['backend.blog.force-destroy', $post->id]]) !!}
                <button type="submit" class="btn btn-xs btn-danger" title="Delete permanent" onclick="return confirm('You are about to delete a post permanently. Are you sure?')">
                    <i class="fa fa-trash"></i>
                </button>
                {!! Form::close() !!}
            @else
                <button type="submit" onclick="return false;" class="btn btn-xs btn-warning disabled" title="Restore">
                    <i class="fa fa-refresh"></i>
                </button>
                <button type="submit" onclick="return false;" class="btn btn-xs btn-danger disabled" title="Delete permanent" onclick="return confirm('You are about to delete a post permanently. Are you sure?')">
                    <i class="fa fa-trash"></i>
                </button>
            @endif
        </td>
        <td>{{ $post->title }}</td>
        <td>{{ $post->author->name }}</td>
        <td>{{ $post->category->title }}</td>
        <td>{{ $post->deletionDateFormatted() }} <span class="label label-danger">Deleted</span></td>
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
