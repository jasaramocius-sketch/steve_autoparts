<?php

if (!function_exists('sortUrl')) {
    function sortUrl($column, $currentSortBy, $currentSortDir): string
    {
        $newDir = $currentSortBy === $column && $currentSortDir === 'asc' ? 'desc' : 'asc';
        return request()->fullUrlWithQuery(['sort_by' => $column, 'sort_dir' => $newDir]);
    }
}

if (!function_exists('sortIndicator')) {
    function sortIndicator($column, $currentSortBy, $currentSortDir): string
    {
        if ($currentSortBy !== $column) return '';
        return $currentSortDir === 'asc'
            ? '<small class="text-muted">&nbsp;↑</small>'
            : '<small class="text-muted">&nbsp;↓</small>';
    }
}
