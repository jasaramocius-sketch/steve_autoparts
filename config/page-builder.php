<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Enable / Disable
    |--------------------------------------------------------------------------
    |
    | Master toggle for the page builder plugin. Set to false in .env to
    | completely disable all rendering, routes, and editor UI.
    |
    */
    'enabled' => env('PAGE_BUILDER_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Admin Route Configuration
    |--------------------------------------------------------------------------
    */
    'prefix' => 'admin/page-builder',

    'middleware' => ['web', 'auth'],

    /*
    |--------------------------------------------------------------------------
    | Registered Models
    |--------------------------------------------------------------------------
    |
    | List of Eloquent models that can use the HasBlocks trait and the
    | page builder editor. Each model must use the HasBlocks trait.
    |
    */
    'models' => [
        'page' => \App\Models\Page::class,
        'blog' => \App\Models\Blog::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Block Types
    |--------------------------------------------------------------------------
    |
    | List of block classes to register. You can add your own custom block
    | classes here. Each must extend SteveStore\PageBuilder\Blocks\Block.
    |
    */
    'blocks' => [
        \SteveStore\PageBuilder\Blocks\BuiltIn\HeroBanner::class,
        \SteveStore\PageBuilder\Blocks\BuiltIn\TextBlock::class,
        \SteveStore\PageBuilder\Blocks\BuiltIn\ImageGallery::class,
        \SteveStore\PageBuilder\Blocks\BuiltIn\FeaturesGrid::class,
        \SteveStore\PageBuilder\Blocks\BuiltIn\TestimonialCarousel::class,
        \SteveStore\PageBuilder\Blocks\BuiltIn\CTABanner::class,
        \SteveStore\PageBuilder\Blocks\BuiltIn\SnippetBlock::class,
        \SteveStore\PageBuilder\Blocks\BuiltIn\HtmlBlock::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Storage Column
    |--------------------------------------------------------------------------
    |
    | The database column name where blocks JSON is stored. This must be
    | a JSON/longText column on your model's table.
    |
    */
    'column' => 'content_blocks',

    /*
    |--------------------------------------------------------------------------
    | Asset URL Configuration
    |--------------------------------------------------------------------------
    */
    'asset_url' => 'vendor/page-builder',

    /*
    |--------------------------------------------------------------------------
    | Live URL Map
    |--------------------------------------------------------------------------
    |
    | Maps a model type + slug to the canonical frontend route name. This keeps
    | the "View Live Page" link pointing to the real page URL instead of the
    | generic /page/{slug} fallback (which would create duplicate content for
    | SEO). Keys are route names. Omit entries to keep the default fallback.
    |
    */
    'live_url_map' => [
        'page' => [
            'home'               => 'home',
            'shop'               => 'shop',
            'faq'                => 'faq',
            'contact'            => 'contact',
            'about'              => 'about',
            'privacy-policy'     => 'privacy.policy',
            'terms-conditions'   => 'terms.conditions',
            'return-policy'      => 'return.policy',
            'support-policy'     => 'support.policy',
        ],
    ],

];
