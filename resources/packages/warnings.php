<?php

return [
	"author_name" => "author",
	"author_username" => "cms",
	"author_email" => "contact@cms.com",
	"author_website" => "http://cms.com",
	"package_name" => "Warnings",
	"package_description" => "Warnings package.",
	"models" => [
		"Warning" => [
			"table" => "warnings", // default: $modelName
			"name_singular" => "Warning", // default: $modelName
			"name_plural" => "Warnings", // // default: Str::plural($modelName)
			"navigation" => [
				"color" => "#999000",
				"icon" => "fa-folder",
				"rank" => 10,
			],
			"route" => "warnings",
			"foreign_field" => "warning_id",
			"fields" => [
                [
                    "label" => "User",
                    "name" => "user_id",
                    "type" => \Packages\Generator\App\Generators\Base::FIELD_TYPE_FOREIGN,
                    "relation" => [
                        "class" => "\Packages\Dashboard\App\Models\User",
                        "table" => "users",
                        "label" => "email",
                    ],
                    "rules" => [
                        "required" => false,
                    ],
                ],
                [
				    "label" => "Body",
				    "name" => "body",
				    "type" => \Packages\Generator\App\Generators\Base::FIELD_TYPE_TEXTAREA,
				],
            ],
		],
    ],
];
