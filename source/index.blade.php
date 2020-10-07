---
title: Blog
pagination:
    collection: posts
    perPage: 4
---

@extends('_layouts.master')

@section('body')


    <div class="posts-container mx-auto px-3 my-5">
        <div class="posts">
            @foreach ($pagination->items as $post)
                <div class="post">
                    <h1 class="post-title fw-500">
                        <a href="{{ $post->getUrl() }}">
                            {{ $post->title }}
                        </a>
                    </h1>

                    <span class="post-date mb-2">{{ $post->getDate()->format('F j, Y') }}</span>

                    @if($post->cover_image)
                        <img src="{{ $post->cover_image }}" class="cover-image">
                    @endisset

                    {!! $post->getExcerpt(200) !!}
                </div>
            @endforeach
        </div>


        @if ($pagination->pages->count() > 1)
            <div class="pagination">
                @if ($previous = $pagination->previous)
                    <a
                            href="{{ $previous }}"
                            title="Previous Page"
                            class="pagination-item older mr-auto"
                    >&LeftArrow;</a>
                @endif

                {{--
                @foreach ($pagination->pages as $pageNumber => $path)
                    <a
                            href="{{ $path }}"
                            title="Go to Page {{ $pageNumber }}"
                            class="pagination-item newer {{ $pagination->currentPage == $pageNumber ? 'text-blue-600' : 'text-blue-700' }}"
                    >{{ $pageNumber }}</a>
                @endforeach
                --}}

                @if ($next = $pagination->next)
                    <a
                            href="{{ $next }}"
                            title="Next Page"
                            class="pagination-item newer ml-auto"
                    >&RightArrow;</a>
                @endif
            </div>
        @endif

    </div>



@stop

