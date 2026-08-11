{{-- Registers the page-id/page-class sections, merging the current CMS page attributes ($page) with the static values passed from each view. Include in every view: @include('partials.page-attributes', ['pageId' => 'my-page', 'pageClass' => 'my-page']) --}}
@php
    $pageModel = $page ?? null;
    $pageIdValue = trim(($pageModel ? 'page-' . $pageModel->id : '') . ' ' . trim($pageId ?? ''));
    $pageClassValue = trim(($pageModel ? ' page-' . Str::slug($pageModel->title) : '') . ' ' . trim($pageClass ?? ''));
@endphp
@section('page-id', $pageIdValue !== '' ? $pageIdValue : 'default-page-id')
@section('page-class', $pageClassValue !== '' ? $pageClassValue : 'default-body-class')
