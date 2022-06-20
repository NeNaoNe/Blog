@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="row mt-2 mb-5">
    <div class="col-4">
        @if ($user->avatar)
        <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="{{ $user->avatar }}" class="img-thumbnail avatar d-block mx-auto">
        @else
        <i class="fa-solid fa-image fa-10x d-block text-center"></i>
        @endif
    </div>
    <div class="col-8">
        <h2 class="display-6">{{ $user->name }}</h2>
        @if ($user->id === Auth::user()->id)
        <a href="{{ route('profile.edit') }}" class="text-decoration-none">Edit Profile</a>
        @endif
    </div>
</div>

<!-- If the user has posts, show all posts of this user using the relationship method. -->
@if ($user->posts)
<ul class="list-group mb-5">
    @foreach ($user->posts as $post)
        <li class="list-group-item py-4">
            <div class="row">
                <div class="col-3">
                    <img src="{{ asset('/storage/images/' . $post->image) }}" alt="{{ $post->image }}" class="card-img shadow post-img-profile">
                </div>
                <div class="col-9">
                    <h2 class="h4">
                        <a href="{{ route('post.show', $post->id) }}">{{ $post->title }}</a>
                    </h2>
                    <p class="fw-light mb-0">{{ $post->body }}</p>
                </div>
            </div>
        </li>
    @endforeach
</ul>
@endif
@endsection
