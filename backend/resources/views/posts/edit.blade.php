@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
<form action="{{ route('post.update', $post->id) }}"" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="mb-3">
        <label for="title" class="form-label text--muted">Title</label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $post->title) }}" placeholder="Enter title here" autofocus>
        @error('title')
        <p class="text-danger small">{{ $message }}</p>
        @enderror
    </div>
      <div class="mb-3">
        <label for="body" class="form-label text--muted">Body</label>
        <textarea name="body" id="body" rows="5" class="form-control" placeholder="Start writing...">{{ old('body', $post->body) }}</textarea>
        @error('body')
        <p class="text-danger small">{{ $message }}</p>
        @enderror
    </div>
    <div class="row mb-3">
        <div class="col-6">
            <img src="{{ asset('/storage/images/' . $post->image) }}" alt="{{ $post->image }}" class="card-img">
            <input type="file" name="image" class="form-control mt-1">
            @error('image')
            <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <button type="submit" class="btn btn-warning px-5">Save</button>
</form>
@endsection
