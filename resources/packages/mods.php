<?php

use TenPixls\Dashboard\App\Models\User;

return [
	"author_name" => "author",
	"author_username" => "cms",
	"author_email" => "contact@cms.com",
	"author_website" => "http://cms.com",
	"package_name" => "Mods",
	"package_description" => "Mods package.",
	"models" => [
		"Category" => [
			"table" => "mods_categories", // default: $modelName
			"name_singular" => "Category", // default: $modelName
			"name_plural" => "Categories", // // default: Str::plural($modelName)
			"navigation" => [
				"color" => "#999000",
				"icon" => "fa-folder",
				"rank" => 10,
			],
			"route" => "mods/categories", // default: Str::snake(Str::plural($modelName))
			"foreign_field" => "category_id", // default: Str::snake('Lead') . '_id'
			"fields" => [
				[
				    "label" => "Image",
				    "name" => "image",
				    "type" => "image",
				],
				[
				    "label" => "Title",
				    "name" => "title",
				    "type" => "text",
				    "translatable" => true,
				],
				[
				    "label" => "Alias",
				    "name" => "slug",
				    "type" => "text",
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
		"LevelOfHate" => [
			"table" => "mods_level_of_hate", // default: $modelName
			"name_singular" => "LevelOfHate", // default: $modelName
			"name_plural" => "LevelOfHate", // // default: Str::plural($modelName)
			"navigation" => [
				"color" => "#999000",
				"icon" => "fa-folder",
				"rank" => 11,
			],
			"route" => "mods/level-of-hate", // default: Str::snake(Str::plural($modelName))
			"foreign_field" => "level_of_hate_id", // default: Str::snake('Lead') . '_id'
			"fields" => [
				[
				    "label" => "Title",
				    "name" => "title",
				    "type" => "text",
				    "translatable" => true,
				],
				[
				    "label" => "Description",
				    "name" => "description",
				    "type" => "textarea",
				    "translatable" => true,
				],
			],
            'functions' => [
                'model' => [
                    'getList' => ['label' => 'title'],
                ],
            ],
		],
		"InstallationDifficulty" => [
			"table" => "mods_installation_difficulty", // default: $modelName
			"name_singular" => "InstallationDifficulty", // default: $modelName
			"name_plural" => "InstallationDifficulty", // // default: Str::plural($modelName)
			"navigation" => [
				"color" => "#999000",
				"icon" => "fa-folder",
				"rank" => 12,
			],
			"route" => "mods/installation-difficulty", // default: Str::snake(Str::plural($modelName))
			"foreign_field" => "installation_difficulty_id", // default: Str::snake('Lead') . '_id'
			"fields" => [
				[
				    "label" => "Title",
				    "name" => "title",
				    "type" => "text",
				    "translatable" => true,
				],
			],
            'functions' => [
                'model' => [
                    'getList' => ['label' => 'title'],
                ],
            ],
		],
		"Sub" => [
			"table" => "mods_subs", // default: $modelName
			"name_singular" => "Sub", // default: $modelName
			"name_plural" => "Subs", // // default: Str::plural($modelName)
			"navigation" => [
				"color" => "#999000",
				"icon" => "fa-folder",
				"rank" => 11,
			],
			"route" => "mods/subs", // default: Str::snake(Str::plural($modelName))
			"foreign_field" => "sub_id", // default: Str::snake('Lead') . '_id'
			"fields" => [
				[
				    "label" => "Image",
				    "name" => "image",
				    "type" => "image",
				],
                [
                    "label" => "Categories",
                    "name" => "categories",
                    "type" => \Packages\Generator\App\Generators\Base::FIELD_TYPE_VS_MULTIPLE,
                    "relation" => [
                        "class" => "\Packages\Mods\App\Models\Category",
                        "vs_table" => "mods_subs_vs_categories",
                        "label" => "title",
                        "self_id" => "sub_id",
                        "rel_id" => "category_id",
                        "rel_table" => "mods_categories",
                        "rel_translatable" => true,
                    ],
                    "rules" => [
                        "required" => false,
                    ],
                ],
				[
				    "label" => "Title",
				    "name" => "title",
				    "type" => "text",
				    "translatable" => true,
				],
				[
				    "label" => "Alias",
				    "name" => "slug",
				    "type" => "text",
				    "rules" => [
				        "required" => false,
                    ],
				],
				[
				    "label" => "Created At",
				    "name" => "created_at",
				    "type" => "timestamp",
				],
				[
				    "label" => "Description",
				    "name" => "description",
				    "type" => "textarea",
                    "translatable" => true,
				],
                [
				    "label" => "Node",
				    "name" => "node_id",
				    "type" => \Packages\Generator\App\Generators\Base::FIELD_TYPE_FOREIGN,
                    "relation" => [
                        "class" => "\App\Models\AF\MarketPlace\Node",
                        "table" => "nodes",
                        "label" => "title",
                    ],
                    "rules" => [
                        "required" => false,
                    ],
                ],
                [
				    "label" => "Installation difficulty",
				    "name" => "installation_difficulty_id",
				    "type" => \Packages\Generator\App\Generators\Base::FIELD_TYPE_FOREIGN,
                    "relation" => [
                        "class" => "\Packages\Mods\App\Models\InstallationDifficulty",
                        "table" => "mods_installation_difficulty",
                        "label" => "title",
                        "rel_translatable" => true,
                    ],
                    "rules" => [
                        "required" => false,
                    ],
                ],
                [
				    "label" => "Level of hate",
				    "name" => "level_of_hate_id",
				    "type" => \Packages\Generator\App\Generators\Base::FIELD_TYPE_FOREIGN,
                    "relation" => [
                        "class" => "\Packages\Mods\App\Models\LevelOfHate",
                        "table" => "mods_level_of_hate",
                        "label" => "title",
                        "rel_translatable" => true,
                    ],
                    "rules" => [
                        "required" => false,
                    ],
                ],
                [
                    "label" => "Popularity",
                    "name" => "popularity",
                    "type" => "integer",
                    "default" => "0",
                    "rules" => [
                        "required" => false,
                    ],
                ],
                [
                    "label" => "Average cost from",
                    "name" => "average_cost_from",
                    "type" => "integer",
                    "rules" => [
                        "required" => false,
                    ],
                ],
                [
                    "label" => "Average cost to",
                    "name" => "average_cost_to",
                    "type" => "integer",
                    "rules" => [
                        "required" => false,
                    ],
                ],
                [
                    "label" => "Installation cost from",
                    "name" => "installation_cost_from",
                    "type" => "integer",
                    "rules" => [
                        "required" => false,
                    ],
                ],
                [
                    "label" => "Installation cost to",
                    "name" => "installation_cost_to",
                    "type" => "integer",
                    "rules" => [
                        "required" => false,
                    ],
                ],
                [
                    "label" => "Dislikes",
                    "name" => "dislikes",
                    "type" => "integer",
                    "default" => "0",
                    "rules" => [
                        "required" => false,
                    ],
                ],
                [
                    "label" => "Likes",
                    "name" => "likes",
                    "type" => "integer",
                    "default" => "0",
                    "rules" => [
                        "required" => false,
                    ],
                ],
            ],
		],
    ],
];
