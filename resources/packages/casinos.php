<?php

return [
    "author_name" => "author",
    "author_username" => "cms",
    "author_email" => "contact@cms.com",
    "author_website" => "http://cms.com",
    "package_name" => "Casinos",
    "package_description" => "Casinos package.",
    "models" => [
        "Casino" => [
            "table" => "casinos", // default: $modelName
            "name_singular" => "Casino", // default: $modelName
            "name_plural" => "Casinos", // // default: Str::plural($modelName)
            "navigation" => [
                "color" => "#EB5757",
                "icon" => "fa-folder",
                "rank" => 5,
            ],
            "route" => "casinos", // default: Str::snake(Str::plural($modelName))
            "foreign_field" => "casino_id", // default: Str::snake('Casino') . '_id'
            "fields" => [
                [
                    "label" => "Логотип",
                    "name" => "logo",
                    "type" => "image",
                    "required" => true,
                ],
                [
                    "label" => "Количество звезд",
                    "name" => "starts_number",
                    "type" => "text",
                    "required" => true,
                ],
                [
                    "label" => "Оценка",
                    "name" => "score",
                    "type" => "text",
                    "required" => true,
                ],
                [
                    "label" => "Количество голосов",
                    "name" => "votes_number",
                    "type" => "text",
                    "required" => true,
                ],
                [
                    "label" => "Лицензия",
                    "name" => "licence",
                    "type" => "image",
                    "required" => false,
                ],
                [
                    "label" => "Минимальный депозит",
                    "name" => "min_deposit",
                    "type" => "text",
                    "required" => true,
                ],
                [
                    "label" => "Бонус",
                    "name" => "bonus",
                    "type" => "text",
                    "required" => true,
                ],
                [
                    "label" => "Количество бесплатных оборотов",
                    "name" => "number_of_free_spins",
                    "type" => "text",
                    "required" => false,
                ],
                [
                    "label" => "Предложение1",
                    "name" => "proposal1",
                    "type" => "textarea",
                    "required" => true,
                ],
                [
                    "label" => "Предложение2",
                    "name" => "proposal2",
                    "type" => "textarea",
                    "required" => true,
                ],
                [
                    "label" => "Предложение3",
                    "name" => "proposal3",
                    "type" => "textarea",
                    "required" => false,
                ],
                [
                    "label" => "Платежные системы",
                    "name" => "payment_systems",
                    "type" => "textarea",
                    "required" => false,
                ],
                [
                    "label" => "Надпись на бадже блока",
                    "name" => "badge_text",
                    "type" => "textarea",
                    "required" => false,
                ],
                [
                    "label" => "Рецензия",
                    "name" => "review",
                    "type" => "textarea",
                    "required" => false,
                ],
                [
                    "label" => "Посети казино",
                    "name" => "visit_casino",
                    "type" => "textarea",
                    "required" => true,
                ],
                [
                    "label" => "Описание",
                    "name" => "description",
                    "type" => "textarea",
                    "required" => true,
                ],
                [
                    "label" => "Месяц и год",
                    "name" => "month_and_year",
                    "type" => "text",
                    "required" => false,
                ],
                [
                    "label" => "Лучшее казино",
                    "name" => "is_best",
                    "type" => "boolean",
                    "required" => true,
                ],
                [
                    "label" => "Кнопка \"играть сейчас\"",
                    "name" => "btn_play_now",
                    "type" => "text",
                    "required" => false,
                ],
                [
                    "label" => "Ссылка на страницу казино",
                    "name" => "page_link",
                    "type" => "text",
                    "required" => true,
                ],
            ],
        ],
    ],
];
