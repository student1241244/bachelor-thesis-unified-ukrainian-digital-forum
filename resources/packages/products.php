<?php

return [
	"author_name" => "author",
	"author_username" => "cms",
	"author_email" => "contact@cms.com",
	"author_website" => "http://cms.com",
	"package_name" => "Products",
	"package_description" => "Products package.",
	"models" => [
		"Product" => [
			"table" => "products", // default: $modelName
			"name_singular" => "Product", // default: $modelName
			"name_plural" => "Products", // // default: Str::plural($modelName)
			"navigation" => [
				"color" => "#EB5757",
				"icon" => "fa-folder",
				"rank" => 5,
			],
			"route" => "products", // default: Str::snake(Str::plural($modelName))
			"foreign_field" => "product_id", // default: Str::snake('Product') . '_id'
			"fields" => [
				[
				  "label" => "Зображення",
				  "name" => "image",
				  "type" => "image",
				],
				[
				  "label" => "Назва",
				  "name" => "title",
				  "type" => "text",
				  "translatable" => true,
				],
				[
				  "label" => "Опис",
				  "name" => "description",
				  "type" => "text",
				  "translatable" => true,
				],
				[
				  "label" => "Дата від",
				  "name" => "data_from",
				  "type" => "text",
				],
				[
				  "label" => "Дата до",
				  "name" => "data_to",
				  "type" => "text",
				],
				[
				  "label" => "Артикул",
				  "name" => "article",
				  "type" => "text",
				],
			],
		],
	],
];
