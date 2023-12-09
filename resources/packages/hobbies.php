<?php

return [
	"author_name" => "author",
	"author_username" => "cms",
	"author_email" => "contact@cms.com",
	"author_website" => "http://cms.com",
	"package_name" => "Hobbies",
	"package_description" => "Hobbies package.",
	"models" => [
		"Hobby" => [
			"table" => "hobbies", // default: $modelName
			"name_singular" => "Hobby", // default: $modelName
			"name_plural" => "Hobbies", // // default: Str::plural($modelName)
			"navigation" => [
				"color" => "#999000",
				"icon" => "fa-folder",
				"rank" => 10,
			],
			"route" => "dictionaries/hobbies", // default: Str::snake(Str::plural($modelName))
			"foreign_field" => "hobby_id", // default: Str::snake('Lead') . '_id'
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
                        "class" => "\Packages\Hobbies\App\Models\Hobby",
                        "table" => "hobbies",
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
    ],
];
