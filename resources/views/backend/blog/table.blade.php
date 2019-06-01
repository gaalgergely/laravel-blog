<tbody>
<?php
        $currentUser = request()->user();
?>
@forelse($posts as $post)
    <tr>
        <td>
            {!! Form::open(['method' => 'DELETE', 'route' => ['backend.blog.destroy', $post->id]]) !!}
            @if($currentUser->owns(\App\Post::withTrashed()->findOrFail($post->id), 'author_id') || $currentUser->can('update-others-post'))
                <a href="{{ route('backend.blog.edit', $post->id) }}" class="btn btn-xs btn-default">
                    <i class="fa fa-edit"></i>
                </a>
            @else
                <a href="#" class="btn btn-xs btn-default disabled">
                    <i class="fa fa-edit"></i>
                </a>
            @endif
            @if($currentUser->owns(\App\Post::withTrashed()->findOrFail($post->id), 'author_id') || $currentUser->can('delete-others-post'))
                <button type="submit" class="btn btn-xs btn-danger">
                    <i class="fa fa-times"></i>
                </button>
            @else
                <button type="submit" onclick="return false;" class="btn btn-xs btn-danger disabled">
                    <i class="fa fa-times"></i>
                </button>
            @endif
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
