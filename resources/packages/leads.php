<?php

return [
	"author_name" => "author",
	"author_username" => "cms",
	"author_email" => "contact@cms.com",
	"author_website" => "http://cms.com",
	"package_name" => "Leads",
	"package_description" => "Leads package.",
	"models" => [
		"Lead" => [
			"table" => "leads", // default: $modelName
			"name_singular" => "Lead", // default: $modelName
			"name_plural" => "Leads", // // default: Str::plural($modelName)
			"navigation" => [
				"color" => "#EB5757",
				"icon" => "fa-folder",
				"rank" => 5,
			],
			"route" => "leads", // default: Str::snake(Str::plural($modelName))
			"foreign_field" => "lead_id", // default: Str::snake('Lead') . '_id'
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
				    "label" => "Active",
				    "name" => "is_active",
				    "type" => "checkbox",
				    "default" => 0,
				],
                [
                    "label" => "Info",
                    "name" => "info",
                    "type" => "textarea",
                    "rules" => [
                        "required" => false
                    ],
                    "translatable" => true,
                ],
			],
		],
	],
];
