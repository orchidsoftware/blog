@extends('_layouts.master')

@php
    $page->type = 'article';
@endphp

@section('body')

    <div class="posts-container px-3 mx-auto my-5">
        <div class="post">
            <h1 class="post-title fw-500">
                {{ $page->title }}
            </h1>

            <span class="post-date mb-4">{{ $page->author }}  •  {{ $page->getDate()->format('F j, Y') }}</span>

            @if($page->cover_image)
                <img src="{{ $page->cover_image }}" class="cover-image">
            @endisset

            @yield('content')
        </div>


        <div class="pagination">
            @if ($next = $page->getNext())
                <a href="{{ $next->getUrl() }}" title="Older Post: {{ $next->title }}" class="pagination-item older">
                    &LeftArrow; {{ $next->title }}
                </a>
            @else
                <span class="pagination-item older">Older</span>
            @endif

            @if ($previous = $page->getPrevious())
                <a href="{{ $previous->getUrl() }}" title="Newer Post: {{ $previous->title }}"
                   class="pagination-item newer">
                    {{ $previous->title }} &RightArrow;
                </a>
            @else
                <span class="pagination-item newer">Newer</span>
            @endif
        </div>
    </div>
@endsection
