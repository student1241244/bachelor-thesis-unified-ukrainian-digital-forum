<?php

return [
	"author_name" => "author",
	"author_username" => "cms",
	"author_email" => "contact@cms.com",
	"author_website" => "http://cms.com",
	"package_name" => "Packages",
	"package_description" => "Packages package.",
	"models" => [
		"Package" => [
			"table" => "packages", // default: $modelName
			"name_singular" => "Package", // default: $modelName
			"name_plural" => "Packages", // // default: Str::plural($modelName)
			"navigation" => [
				"color" => "#EB5757",
				"icon" => "fa-folder",
				"rank" => 5,
			],
			"route" => "packages", // default: Str::snake(Str::plural($modelName))
			"foreign_field" => "package_id", // default: Str::snake('Package') . '_id'
			"fields" => [
				[
				  "label" => "Назва",
				  "name" => "title",
				  "type" => "text",
				  "translatable" => true,
				],
				[
				  "label" => "Вартість, $",
				  "name" => "price",
				  "type" => "integer",
				],
				[
				  "label" => "К-ть UNITS",
				  "name" => "units_amount",
				  "type" => "integer",
				],
				[
				  "label" => "Опис",
				  "name" => "description",
				  "type" => "text",
				  "translatable" => true,
				],
			],
		],
	],
];
