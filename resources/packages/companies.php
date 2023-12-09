<?php

return [
	"author_name" => "author",
	"author_username" => "cms",
	"author_email" => "contact@cms.com",
	"author_website" => "http://cms.com",
	"package_name" => "Companies",
	"package_description" => "Companies package.",
	"models" => [
		"Company" => [
			"table" => "companies", // default: $modelName
			"name_singular" => "Company", // default: $modelName
			"name_plural" => "Companies", // // default: Str::plural($modelName)
			"navigation" => [
				"color" => "#EB5757",
				"icon" => "fa-folder",
				"rank" => 5,
			],
			"route" => "companies", // default: Str::snake(Str::plural($modelName))
			"foreign_field" => "company_id", // default: Str::snake('Company') . '_id'
			"fields" => [
				[
				  "label" => "Name",
				  "name" => "name",
				  "type" => "text",
				],
			    [
                    "label" => "Alias",
                    "name" => "alias",
                    "type" => "text",
                ],
			],
		],
	],
];
