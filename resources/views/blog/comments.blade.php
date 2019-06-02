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
        <form>
            <div class="form-group required">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control">
            </div>
            <div class="form-group required">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" class="form-control">
            </div>
            <div class="form-group">
                <label for="website">Website</label>
                <input type="text" name="website" id="website" class="form-control">
            </div>
            <div class="form-group required">
                <label for="comment">Comment</label>
                <textarea name="comment" id="comment" rows="6" class="form-control"></textarea>
            </div>
            <div class="clearfix">
                <div class="pull-left">
                    <button type="submit" class="btn btn-lg btn-success">Submit</button>
                </div>
                <div class="pull-right">
                    <p class="text-muted">
                        <span class="required">*</span>
                        <em>Indicates required fields</em>
                    </p>
                </div>
            </div>
        </form>
    </div>

</article>