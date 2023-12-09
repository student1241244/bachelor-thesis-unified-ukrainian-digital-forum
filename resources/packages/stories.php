<?php

return [
	"author_name" => "author",
	"author_username" => "cms",
	"author_email" => "contact@cms.com",
	"author_website" => "http://cms.com",
	"package_name" => "Stories",
	"package_description" => "Stories package.",
	"models" => [
        "Category" => [
            "table" => "stories_categories", // default: $modelName
            "name_singular" => "Category", // default: $modelName
            "name_plural" => "Categories", // // default: Str::plural($modelName)
            "navigation" => [
                "color" => "#999000",
                "icon" => "fa-folder",
                "rank" => 10,
            ],
            "route" => "stories-categories",
            "foreign_field" => "category_id",
            "fields" => [
                [
                    "label" => "Title",
                    "name" => "title",
                    "type" => "text",
                    "translatable" => true,
                ],
                [
                    "label" => "Parent",
                    "name" => "parent_id",
                    "type" => \Packages\Generator\App\Generators\Base::FIELD_TYPE_FOREIGN,
                    "relation" => [
                        "class" => "\Packages\Stories\App\Models\Category",
                        "table" => "stories_categories",
                        "label" => "title",
                        "rel_translatable" => true,
                    ],
                    "rules" => [
                        "required" => false,
                    ],
                ],
            ],
            'functions' => [
                'model' => [
                    'getList' => ['label' => 'title'],
                ],
            ],
        ],
		"Story" => [
			"table" => "stories", // default: $modelName
			"name_singular" => "Story", // default: $modelName
			"name_plural" => "Stories", // // default: Str::plural($modelName)
			"navigation" => [
				"color" => "#999000",
				"icon" => "fa-folder",
				"rank" => 10,
			],
			"route" => "stories",
			"foreign_field" => "story_id",
			"fields" => [
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
				    "translatable" => true,
				],
                [
                    "label" => "Category",
                    "name" => "category_id",
                    "type" => \Packages\Generator\App\Generators\Base::FIELD_TYPE_FOREIGN,
                    "relation" => [
                        "class" => "\Packages\Stories\App\Models\Category",
                        "table" => "stories_categories",
                        "label" => "title",
                        "rel_translatable" => true,
                    ],
                    "rules" => [
                        "required" => false,
                    ],
                ],
                [
                    "label" => "User",
                    "name" => "user_id",
                    "type" => \Packages\Generator\App\Generators\Base::FIELD_TYPE_FOREIGN,
                    "relation" => [
                        "class" => "\Packages\Dashboard\App\Models\User",
                        "table" => "users",
                        "label" => "nickname",
                        "rel_translatable" => false,
                    ],
                    "rules" => [
                        "required" => true,
                    ],
                ],
                [
                    "label" => "Vehicle",
                    "name" => "car_id",
                    "type" => \Packages\Generator\App\Generators\Base::FIELD_TYPE_FOREIGN,
                    "relation" => [
                        "class" => "\App\Models\Car",
                        "table" => "users",
                        "label" => "nickname",
                        "rel_translatable" => false,
                    ],
                    "rules" => [
                        "required" => false,
                    ],
                ],
                [
                    "label" => "Steps",
                    "name" => "steps_count",
                    "type" => "integer",
                    "default" => "0",
                    "rules" => [
                        "required" => false,
                    ],
                    "readonly" => true,
                ],
                [
                    "label" => "Products",
                    "name" => "products_count",
                    "type" => "integer",
                    "default" => "0",
                    "rules" => [
                        "required" => false,
                    ],
                    "readonly" => true,
                ],
                [
                    "label" => "Likes",
                    "name" => "likes_count",
                    "type" => "integer",
                    "default" => "0",
                    "rules" => [
                        "required" => false,
                    ],
                    "readonly" => true,
                ],
                [
                    "label" => "Comments",
                    "name" => "comments_count",
                    "type" => "integer",
                    "default" => "0",
                    "rules" => [
                        "required" => false,
                    ],
                    "readonly" => true,
                ],
                [
                    "label" => "Cost",
                    "name" => "cost",
                    "type" => "integer",
                    "default" => "0",
                    "rules" => [
                        "required" => false,
                    ],
                    "readonly" => true,
                ],
                [
                    "label" => "Status",
                    "name" => "status",
                    "type" => "integer",
                    "default" => "0",
                    "rules" => [
                        "required" => false,
                    ],
                ],
                [
                    "label" => "Date",
                    "type" => \Packages\Generator\App\Generators\Base::FIELD_TYPE_DATE,
                    "name" => "date",
                    "rules" => [
                        "required" => false,
                    ],
                ],
                [
                    "label" => "Mileage",
                    "name" => "mileage_value",
                    "type" => "integer",
                    "rules" => [
                        "required" => false,
                    ],
                ],
                [
                    "label" => "Mileage Unit",
                    "name" => "mileage_unit",
                    "type" => "integer",
                    "rules" => [
                        "required" => false,
                    ],
                ],
                [
                    "label" => "Description",
                    "name" => "description",
                    "type" => \Packages\Generator\App\Generators\Base::FIELD_TYPE_TEXTAREA,
                    "translatable" => true,
                ],
            ],
		],
    ],
];
