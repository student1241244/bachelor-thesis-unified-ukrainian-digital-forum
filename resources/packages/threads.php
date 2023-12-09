<?php

return [
	"author_name" => "author",
	"author_username" => "cms",
	"author_email" => "contact@cms.com",
	"author_website" => "http://cms.com",
	"package_name" => "Threads",
	"package_description" => "Threads package.",
	"models" => [
        "Category" => [
            "table" => "threads_categories", // default: $modelName
            "name_singular" => "Category", // default: $modelName
            "name_plural" => "Categories", // // default: Str::plural($modelName)
            "navigation" => [
                "color" => "#999000",
                "icon" => "fa-folder",
                "rank" => 10,
            ],
            "route" => "threads/categories",
            "foreign_field" => "category_id",
            "fields" => [
                [
                    "label" => "Title",
                    "name" => "title",
                    "type" => "text",
                ],
            ],
            'functions' => [
                'model' => [
                    'getList' => ['label' => 'title'],
                ],
            ],
        ],
		"Thread" => [
			"table" => "threads", // default: $modelName
			"name_singular" => "Thread", // default: $modelName
			"name_plural" => "Threads", // // default: Str::plural($modelName)
			"navigation" => [
				"color" => "#999000",
				"icon" => "fa-folder",
				"rank" => 10,
			],
			"route" => "threads",
			"foreign_field" => "thread_id",
			"fields" => [
                [
                    "label" => "Category",
                    "name" => "category_id",
                    "type" => \Packages\Generator\App\Generators\Base::FIELD_TYPE_FOREIGN,
                    "relation" => [
                        "class" => "\Packages\Threads\App\Models\Category",
                        "table" => "threads_categories",
                        "label" => "title",
                        "rel_translatable" => true,
                    ],
                    "rules" => [
                        "required" => false,
                    ],
                ],
                [
                    "label" => "Image",
                    "name" => "image",
                    "type" => "image",
                    "required" => false,
                ],
                [
				    "label" => "Title",
				    "name" => "title",
				    "type" => "text",
				],
                [
				    "label" => "Body",
				    "name" => "body",
				    "type" => \Packages\Generator\App\Generators\Base::FIELD_TYPE_TEXTAREA,
				],
            ],
		],
		"Comment" => [
			"table" => "threads_comments", // default: $modelName
			"name_singular" => "Comment", // default: $modelName
			"name_plural" => "Comments", // // default: Str::plural($modelName)
			"navigation" => [
				"color" => "#999000",
				"icon" => "fa-folder",
				"rank" => 10,
			],
			"route" => "threads/comments",
			"foreign_field" => "comment_id",
			"fields" => [
                [
                    "label" => "Thread",
                    "name" => "thread_id",
                    "type" => \Packages\Generator\App\Generators\Base::FIELD_TYPE_FOREIGN,
                    "relation" => [
                        "class" => "\Packages\Threads\App\Models\Thread",
                        "table" => "threads",
                        "label" => "title",
                    ],
                    "rules" => [
                        "required" => false,
                    ],
                ],
                [
				    "label" => "Body",
				    "name" => "body",
				    "type" => "text",
				],
            ],
		],
    ],
];
