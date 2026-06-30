<?php

if (!function_exists('current_year')) {
    /**
     * Get the current 4-digit year.
     *
     * @return string
     */
    function current_year(): string
    {
        return date('Y');
    }
}