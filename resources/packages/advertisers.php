<?php

return [
	"author_name" => "author",
	"author_username" => "cms",
	"author_email" => "contact@cms.com",
	"author_website" => "http://cms.com",
	"package_name" => "Advertisers",
	"package_description" => "Advertisers package.",
	"models" => [
		"Advertiser" => [
			"table" => "advertisers", // default: $modelName
			"name_singular" => "Advertiser", // default: $modelName
			"name_plural" => "Advertisers", // // default: Str::plural($modelName)
			"navigation" => [
				"color" => "#EB5757",
				"icon" => "fa-folder",
				"rank" => 5,
			],
			"route" => "advertisers", // default: Str::snake(Str::plural($modelName))
			"foreign_field" => "advertiser_id", // default: Str::snake('Advertiser') . '_id'
			"fields" => [
				[
				  "label" => "Name",
				  "name" => "name",
				  "type" => "text",
				],
			    [
                    "label" => "api_key",
                    "name" => "api_key",
                    "type" => "text",
                ],
			],
		],
	],
];
