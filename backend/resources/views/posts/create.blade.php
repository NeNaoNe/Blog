@extends('layouts.app')

@section('title', 'Create Post')

@section('content')
<form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <!-- cross-site request foegeries -->

    <div class="mb-3">
        <label for="title" class="form-label text-muted">Title</label>
        <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="Enter title here" autofocus>
        @error('title')
        <p class="text-danger small">{{ $message }}</p>
        @enderror
    </div>
      <div class="mb-3">
        <label for="body" class="form-label text-muted">Body</label>
        <textarea name="body" id="body" rows="5" class="form-control" placeholder="Start writing...">{{ old('body') }}</textarea>
        @error('body')
        <p class="text-danger small">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-3">
        <input type="file" name="image" class="form-control">
        @error('image')
        <p class="text-danger small">{{ $message }}</p>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary px-5">Post</button>
</form>
@endsection



