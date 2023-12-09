<?php

return [
	"author_name" => "author",
	"author_username" => "cms",
	"author_email" => "contact@cms.com",
	"author_website" => "http://cms.com",
	"package_name" => "Urls",
	"package_description" => "Urls package.",
	"models" => [
		"Url" => [
			"table" => "urls", // default: $modelName
			"name_singular" => "Url", // default: $modelName
			"name_plural" => "Urls", // // default: Str::plural($modelName)
			"navigation" => [
				"color" => "#EB5757",
				"icon" => "fa-folder",
				"rank" => 5,
			],
			"route" => "urls", // default: Str::snake(Str::plural($modelName))
			"foreign_field" => "url_id", // default: Str::snake('Url') . '_id'
			"fields" => [
				[
				  "label" => "Link",
				  "name" => "link",
				  "type" => "text",
				],
			],
		],
	],
];
