<?php

return [
	"author_name" => "author",
	"author_username" => "cms",
	"author_email" => "contact@cms.com",
	"author_website" => "http://cms.com",
	"package_name" => "Vehicles",
	"package_description" => "Vehicles package.",
	"models" => [
		"Vehicle" => [
			"table" => "vehicles", // default: $modelName
			"name_singular" => "Vehicle", // default: $modelName
			"name_plural" => "Vehicles", // // default: Str::plural($modelName)
			"navigation" => [
				"color" => "#999000",
				"icon" => "fa-folder",
				"rank" => 10,
			],
			"route" => "dictionaries/vehicles", // default: Str::snake(Str::plural($modelName))
			"foreign_field" => "vehicle_id", // default: Str::snake('Lead') . '_id'
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
				],
				[
				    "label" => "Seo Title",
				    "name" => "seo_title",
				    "type" => "text",
				    "translatable" => true,
				],
				[
				    "label" => "Seo Description",
				    "name" => "seo_description",
				    "type" => "text",
				    "translatable" => true,
				],
				[
				    "label" => "Seo H1",
				    "name" => "seo_h1",
				    "type" => "text",
				    "translatable" => true,
				],
                [
                    "label" => "Description",
                    "name" => "description",
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
    ],
];
