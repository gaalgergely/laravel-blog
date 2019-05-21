@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@elseif(session('message'))
    <div class="alert alert-info">
        {{ session('message') }}
    </div>
@endif