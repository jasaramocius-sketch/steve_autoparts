{{-- Renders the <body> tag merging the current CMS page attributes with the view's page-id/page-class sections. --}}
@php
    $pageModel = $page ?? null;
    $pageId = optional($pageModel)->id;
    $pageIdPrefix = $pageId !== null ? 'page-' . $pageId : '';
    $pageClassPrefix = optional($pageModel)->title ? ' page-' . Str::slug($pageModel->title) : '';
    $viewPageId = trim($__env->yieldContent('page-id', 'default-page-id'));
    $viewPageClass = trim($__env->yieldContent('page-class', 'default-body-class'));
@endphp
<body id="{{ trim($pageIdPrefix . ' ' . $viewPageId) }}" class="{{ trim($pageClassPrefix . ' ' . $viewPageClass) }}">
