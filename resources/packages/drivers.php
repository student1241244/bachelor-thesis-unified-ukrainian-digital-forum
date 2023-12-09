<?php

return [
	"author_name" => "author",
	"author_username" => "cms",
	"author_email" => "contact@cms.com",
	"author_website" => "http://cms.com",
	"package_name" => "Drivers",
	"package_description" => "Drivers package.",
	"models" => [
		"Driver" => [
			"table" => "drivers", // default: $modelName
			"name_singular" => "Driver", // default: $modelName
			"name_plural" => "Drivers", // // default: Str::plural($modelName)
			"navigation" => [
				"color" => "#EB5757",
				"icon" => "fa-folder",
				"rank" => 5,
			],
			"route" => "drivers", // default: Str::snake(Str::plural($modelName))
			"foreign_field" => "driver_id", // default: Str::snake('Driver') . '_id'
			"fields" => [
                [
                    "label" => "Активний",
                    "name" => "is_active",
                    "type" => "boolean",
                ],
				[
				  "label" => "Назва",
				  "name" => "title",
				  "type" => "text",
				],
				[
				  "label" => "Ім’я",
				  "name" => "name",
				  "type" => "text",
				],
				[
				  "label" => "Моб.тел",
				  "name" => "phone",
				  "type" => "text",
				],
				[
				  "label" => "Автомобіль",
				  "name" => "car",
				  "type" => "text",
				],
				[
				  "label" => "Держ. Номер",
				  "name" => "govt_number",
				  "type" => "text",
				],
			],
		],
	],
];
