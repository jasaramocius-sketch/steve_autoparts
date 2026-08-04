@extends('layouts.app')
{{-- Add your custom page ID and classes right here --}}
@section('page-id', 'user-show-page')
@section('page-class', 'user-show-page')
@section('title', $page->title)
@section('content')

<div class="container py-5"> 
    <div class="row justify-content-center">
        <div class="col-lg-12 mb-4">
            <h1 class="">{{ $page->title }}</h1>
            @if ($page->short_description)
                <p class="lead page-short-description">{{ $page->short_description }}</p>
            @endif
        </div>
        <div class="col-lg-12">
            <div class="page-content">
                {!! $page->content !!}
            </div>
        </div>
    </div>
</div>

<x-page-blocks :model="$page" />

<style>
    .page-content p { margin-bottom: 1rem; line-height: 1.8; }
    .page-content img { max-width: 100%; height: auto; border-radius: 8px; margin: 1rem 0; }
</style>

@endsection
