{{-- Meta tags partial. Include from a @section('meta_tags') block.
     Available variables: $pageTitle, $metaTitle, $metaDescription, $ogImage, $ogUrl, $ogType, $robots
--}}
@php
    $appName = config('app.name', 'StAutoparts');
    $metaTitle = $metaTitle ?? ($page->meta_title ?? null);
    $metaDesc  = $metaDescription ?? ($page->meta_description ?? null);
    $ogImage   = $ogImage ?? ($page->og_image ?? null);
    $ogUrl     = $ogUrl ?? url()->current();
    $ogType    = $ogType ?? 'website';
    $robots    = $robots ?? 'noindex, nofollow';
@endphp

<title>{{ $pageTitle ?? ($metaTitle ? $metaTitle . ' - ' . $appName : $appName) }}</title>

@if($metaTitle)
<meta name="title" content="{{ $metaTitle }}">
@endif
@if($metaDesc)
<meta name="description" content="{{ $metaDesc }}">
@endif
<meta name="robots" content="{{ $robots }}">

<meta property="og:type" content="{{ $ogType }}">
<meta property="og:title" content="{{ $pageTitle ?? $metaTitle ?? $appName }}">
@if($metaDesc)
<meta property="og:description" content="{{ $metaDesc }}">
@endif
<meta property="og:url" content="{{ $ogUrl }}">
@if($ogImage)
<meta property="og:image" content="{{ $ogImage }}">
@endif
