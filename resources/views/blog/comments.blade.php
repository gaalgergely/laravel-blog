<a name="comments"></a>
<article class="post-comments">
    <h3><i class="fa fa-comments"></i>{{ $post->comment_count }}</h3>

    <div class="comment-body padding-10">
        <ul class="comments-list">
            @forelse($postComments as $comment)
            <li class="comment-item">
                <div class="comment-heading clearfix">
                    <div class="comment-author-meta">
                        <h4>{{ $comment->author_name }} <small>{{ $comment->date }}</small></h4>
                    </div>
                </div>
                <div class="comment-content">
                    {!! $comment->body_html !!}
                </div>
            </li>
            @empty
            <li class="comment-item">
                <div class="comment-content">
                    <p>There are no comments yet.</p>
                </div>
            </li>
            @endforelse
        </ul>
        <nav>
            {!! $postComments->links() !!}
        </nav>
    </div>

    <div class="comment-footer padding-10">
        <h3>Leave a comment</h3>
        {!! form($form) !!}
    </div>

</article>