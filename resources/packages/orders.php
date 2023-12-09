<?php

return [
	"author_name" => "author",
	"author_username" => "cms",
	"author_email" => "contact@cms.com",
	"author_website" => "http://cms.com",
	"package_name" => "Orders",
	"package_description" => "Orders package.",
	"models" => [
		"Orders" => [
			"table" => "orders", // default: $modelName
			"name_singular" => "Order", // default: $modelName
			"name_plural" => "Orders", // // default: Str::plural($modelName)
			"navigation" => [
				"color" => "#EB5757",
				"icon" => "fa-folder",
				"rank" => 5,
			],
			"route" => "orders", // default: Str::snake(Str::plural($modelName))
			"foreign_field" => "order_id", // default: Str::snake('Order') . '_id'
			"fields" => [
				[
				  "label" => "Клієнт",
				  "name" => "client_id",
				  "type" => "integer",
				],
				[
				  "label" => "Водій",
				  "name" => "driver_id",
				  "type" => "integer",
				],
				[
				  "label" => "Дод. примітка",
				  "name" => "extra_comment",
				  "type" => "text",
				],
				[
				  "label" => "Дата доставки",
				  "name" => "delivery_date",
				  "type" => "text",
				],
				[
				  "label" => "Дата",
				  "name" => "date",
				  "type" => "text",
				],
				[
				  "label" => "Номер",
				  "name" => "rank",
				  "type" => "integer",
				],
				[
				  "label" => "Статус",
				  "name" => "status",
				  "type" => "integer",
				],
                [
                    "label" => "Вид оплати",
                    "name" => "payment_type",
                    "type" => "integer",
                ],
            ],
		],
	],
];
