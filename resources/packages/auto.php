<?php

return [
	"author_name" => "author",
	"author_username" => "cms",
	"author_email" => "contact@cms.com",
	"author_website" => "http://cms.com",
	"package_name" => "Auto",
	"package_description" => "Auto package.",
	"models" => [
		"Make" => [
			"table" => "auto_makes", // default: $modelName
			"name_singular" => "Make", // default: $modelName
			"name_plural" => "Makes", // // default: Str::plural($modelName)
			"navigation" => [
				"color" => "#999000",
				"icon" => "fa-folder",
				"rank" => 10,
			],
			"route" => "auto/makes", // default: Str::snake(Str::plural($modelName))
			"foreign_field" => "make_id", // default: Str::snake('Lead') . '_id'
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
                    "label" => "Active",
                    "name" => "is_active",
                    "type" => "checkbox",
                    "default" => 0,
                ],
                [
                    "label" => "Description",
                    "name" => "description",
                    "type" => "textarea",
                    "translatable" => true,
                    "index" => false,
                ],
            ],
            'functions' => [
                'model' => [
                    'getList' => ['label' => 'title'],
                ],
            ],
		],
		"Model" => [
			"table" => "auto_models", // default: $modelName
			"name_singular" => "Model", // default: $modelName
			"name_plural" => "Models", // // default: Str::plural($modelName)
			"navigation" => [
				"color" => "#999000",
				"icon" => "fa-folder",
				"rank" => 11,
			],
			"route" => "auto/models", // default: Str::snake(Str::plural($modelName))
			"foreign_field" => "model_id", // default: Str::snake('Lead') . '_id'
			"fields" => [
                [
                    "label" => "Make",
                    "name" => "make_id",
                    "type" => \Packages\Generator\App\Generators\Base::FIELD_TYPE_FOREIGN,
                    "relation" => [
                        "class" => "\Packages\Auto\App\Models\Make",
                        "table" => "auto_makes",
                        "label" => "title",
                        "rel_translatable" => false,
                    ],
                    "rules" => [
                        "required" => true,
                    ],
                ],
				[
				    "label" => "Title",
				    "name" => "title",
				    "type" => "text",
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
                    "label" => "Active",
                    "name" => "is_active",
                    "type" => "checkbox",
                    "default" => 0,
                ],
                [
                    "label" => "Description",
                    "name" => "description",
                    "type" => "textarea",
                    "translatable" => true,
                    "index" => false,
                ],
                [
                    "label" => "Amazon img code",
                    "name" => "amazon_img_code",
                    "type" => "text",
                ],
            ],
            'functions' => [
                'model' => [
                    'getList' => ['label' => 'title'],
                ],
            ],
		],
		"ModelYear" => [
			"table" => "auto_model_years", // default: $modelName
			"name_singular" => "ModelYear", // default: $modelName
			"name_plural" => "ModelYear", // // default: Str::plural($modelName)
			"navigation" => [
				"color" => "#999000",
				"icon" => "fa-folder",
				"rank" => 11,
			],
			"route" => "auto/model-years", // default: Str::snake(Str::plural($modelName))
			"foreign_field" => "model_year_id", // default: Str::snake('Lead') . '_id'
			"fields" => [
				[
				    "label" => "Image",
				    "name" => "image",
				    "type" => "image",
				],
                [
                    "label" => "Model",
                    "name" => "model_id",
                    "type" => \Packages\Generator\App\Generators\Base::FIELD_TYPE_FOREIGN,
                    "relation" => [
                        "class" => "\Packages\Auto\App\Models\Model",
                        "table" => "auto_models",
                        "label" => "title",
                        "rel_translatable" => false,
                    ],
                    "rules" => [
                        "required" => true,
                    ],
                ],
				[
				    "label" => "Year",
				    "name" => "year",
				    "type" => "integer",
				],
                [
                    "label" => "Active",
                    "name" => "is_active",
                    "type" => "checkbox",
                    "default" => 0,
                ],
                [
                    "label" => "Description",
                    "name" => "description",
                    "type" => "textarea",
                    "translatable" => true,
                    "index" => false,
                ],
            ],
		],
    ],
];
