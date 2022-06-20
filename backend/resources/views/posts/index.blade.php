@extends('layouts.app')

@section('title', 'Home')

@section('content')
@if ($all_posts->isNotEmpty())
    @foreach ($all_posts as $post)
    <div class="my-2 border border-2 rounded py-3 px-4">
       <div class="row">
            <div class="col-4">
                <img src="{{ asset('/storage/images/' . $post->image) }}" alt="{{ $post->image }}" class="card-img shadow post-img-home">
            </div>
            <div class="col-8">
                <h2 class="h4">
                    <a href="{{ route('post.show', $post->id) }}">{{ $post->title }}</a>
                </h2>
                <h3 class="h6 text-muted">
                    <a href="{{ route('profile.show', $post->user->id) }}" class="text-muted text-decoration-none">{{ $post->user->name }}</a>
                </h3>
                <p class="fw-light mb-0">{!! nl2br($post->body) !!}</p>

                <!-- If the owner of the post is the Auth user, show Edit and Delete button. -->
                @if ($post->user->id === Auth::user()->id)
                <div class="text-end mt-2">
                    <a href="{{ route('post.edit', $post->id) }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-pen"></i> Edit</a>

                    <form action="{{ route('post.destroy', $post->id) }}" method="post" class="d-inline">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can"></i> Delete</button>
                    </form>
                </div>
                @endif
            </div>
       </div>

    </div>
    @endforeach
    <div class="d-flex justify-content-center">
     {{ $all_posts->links() }}
    </div>

@endif
@endsection

