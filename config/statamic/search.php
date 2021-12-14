<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default search index
    |--------------------------------------------------------------------------
    |
    | This option controls the search index that gets queried when performing
    | search functions without explicitly selecting another index.
    |
    */

    'default' => env('STATAMIC_DEFAULT_SEARCH_INDEX', 'default'),

    /*
    |--------------------------------------------------------------------------
    | Search Indexes
    |--------------------------------------------------------------------------
    |
    | Here you can define all of the available search indexes.
    |
    */

    'indexes' => [

        'default' => [
            'driver' => 'local',
            'searchables' => ['collection:home_page', 'collection:pages', 'collection:news'],
            'fields' => [
                'title',
                'subtitle',
                'content_section_title',
                'content_section_content',
                'content_section_link_text',
                // Note - content_sections should be below these as it sets them on index
                'content_sections',
                'content',
                'executive_leadership',
                'board_of_directors'
            ],
            'transformers' => [
                // Flatten the sections into searchable combined fields
                'content_sections' => function ($content_sections) {
                    $content_section_title = '';
                    $content_section_content = '';
                    $content_section_link_text = '';

                    // if no content_sections are available on the entry
                    // leave blank
                    if (!is_array($content_sections)) {
                        return [
                            'content_section_title' => $content_section_title,
                            'content_section_content' => $content_section_content,
                            'content_section_link_text' => $content_section_link_text,
                        ];
                    }

                    $get_content_text = function($content) {
                        $text = '';
                        if (is_array($content)) {
                            foreach ($content as $c) {
                                if (isset($c['content'])) {
                                    foreach ($c['content'] as $part) {
                                        if ($text) {
                                            if (isset($part['text'])) {
                                                $text = trim($text) . ' ' . trim($part['text']);
                                            }
                                        } else {
                                            if (isset($part['text'])) {
                                                $text = $part['text'];
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        return trim($text);
                    };

                    foreach ($content_sections as $section) {

                        // index the section titles
                        if (isset($section['title']) && $section['title']) {
                            if ($content_section_title) {
                                $content_section_title = trim($content_section_title) . ' ' . trim($section['title']);
                            } else {
                                $content_section_title = trim($section['title']);
                            }
                        }

                        // index the section contents
                        if (isset($section['content']) && $section['content']) {
                            if ($content_section_content) {
                                $content_section_content = $content_section_content . ' ' . $get_content_text($section['content']);
                            } else {
                                $content_section_content = $get_content_text($section['content']);
                            }
                        }

                        // index the link texts
                        if (isset($section['link_text']) && $section['link_text']) {
                            if ($content_section_link_text) {
                                $content_section_link_text = trim($content_section_link_text) . ' ' . trim($section['link_text']);
                            } else {
                                $content_section_link_text = trim($section['link_text']);
                            }
                        }
                    }

                    return [
                        'content_section_title' => $content_section_title,
                        'content_section_content' => $content_section_content,
                        'content_section_link_text' => $content_section_link_text,
                    ];
                }
            ]
        ],

        // 'blog' => [
        //     'driver' => 'local',
        //     'searchables' => 'collection:blog',
        // ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Driver Defaults
    |--------------------------------------------------------------------------
    |
    | Here you can specify default configuration to be applied to all indexes
    | that use the corresponding driver. For instance, if you have two
    | indexes that use the "local" driver, both of them can have the
    | same base configuration. You may override for each index.
    |
    */

    'drivers' => [

        'local' => [
            'path' => storage_path('statamic/search'),
        ],

        'algolia' => [
            'credentials' => [
                'id' => env('ALGOLIA_APP_ID', ''),
                'secret' => env('ALGOLIA_SECRET', ''),
            ],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Search Defaults
    |--------------------------------------------------------------------------
    |
    | Here you can specify default configuration to be applied to all indexes
    | regardless of the driver. You can override these per driver or per index.
    |
    */

    'defaults' => [
        'fields' => ['title'],
    ],

];
