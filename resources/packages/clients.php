<?php

return [
    "author_name" => "author",
    "author_username" => "cms",
    "author_email" => "contact@cms.com",
    "author_website" => "http://cms.com",
    "package_name" => "Clients",
    "package_description" => "Clients package.",
    "models" => [
        "Client" => [
            "table" => "clients", // default: $modelName
            "name_singular" => "Client", // default: $modelName
            "name_plural" => "Clients", // // default: Str::plural($modelName)
            "navigation" => [
                "color" => "#EB5757",
                "icon" => "fa-folder",
                "rank" => 5,
            ],
            "route" => "clients", // default: Str::snake(Str::plural($modelName))
            "foreign_field" => "client_id", // default: Str::snake('Client') . '_id'
            "fields" => [
                [
                    "label" => "Вулиця",
                    "name" => "street",
                    "type" => "text",
                ],
                [
                    "label" => "Номер будинку",
                    "name" => "house_number",
                    "type" => "text",
                ],
                [
                    "label" => "Номер квартири",
                    "name" => "flat_number",
                    "type" => "text",
                ],
                [
                    "label" => "Номер корпусу",
                    "name" => "case_number",
                    "type" => "text",
                ],
                [
                    "label" => "Номер телефону",
                    "name" => "phone",
                    "type" => "text",
                ],
                [
                    "label" => "Номер телефону 2",
                    "name" => "phone_2",
                    "type" => "text",
                    "required" => false,
                ],
                [
                    "label" => "Номер телефону 3",
                    "name" => "phone_3",
                    "type" => "text",
                    "required" => false,
                ],
                [
                    "label" => "Назва організації",
                    "name" => "name",
                    "type" => "text",
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
