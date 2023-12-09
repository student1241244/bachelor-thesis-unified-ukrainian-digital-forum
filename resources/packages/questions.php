<?php

return [
	"author_name" => "author",
	"author_username" => "cms",
	"author_email" => "contact@cms.com",
	"author_website" => "http://cms.com",
	"package_name" => "Questions",
	"package_description" => "Questions package.",
	"models" => [
		"Question" => [
			"table" => "questions", // default: $modelName
			"name_singular" => "Question", // default: $modelName
			"name_plural" => "Questions", // // default: Str::plural($modelName)
			"navigation" => [
				"color" => "#999000",
				"icon" => "fa-folder",
				"rank" => 10,
			],
			"route" => "questions",
			"foreign_field" => "question_id",
			"fields" => [
                [
                    "label" => "Author",
                    "name" => "user_id",
                    "type" => \Packages\Generator\App\Generators\Base::FIELD_TYPE_FOREIGN,
                    "relation" => [
                        "class" => "\Packages\Dashboard\App\Models\User",
                        "table" => "questions",
                        "label" => "email",
                    ],
                    "rules" => [
                        "required" => false,
                    ],
                ],
                [
				    "label" => "Title",
				    "name" => "title",
				    "type" => "text",
				],
                [
				    "label" => "Body",
				    "name" => "body",
				    "type" => \Packages\Generator\App\Generators\Base::FIELD_TYPE_TEXTAREA,
				],
            ],
		],
		"Comment" => [
			"table" => "comments", // default: $modelName
			"name_singular" => "Comment", // default: $modelName
			"name_plural" => "Comments", // // default: Str::plural($modelName)
			"navigation" => [
				"color" => "#999000",
				"icon" => "fa-folder",
				"rank" => 10,
			],
			"route" => "questions/comments",
			"foreign_field" => "comment_id",
			"fields" => [
                [
                    "label" => "Question",
                    "name" => "question_id",
                    "type" => \Packages\Generator\App\Generators\Base::FIELD_TYPE_FOREIGN,
                    "relation" => [
                        "class" => "\App\Models\Question",
                        "table" => "questions",
                        "label" => "title",
                    ],
                    "rules" => [
                        "required" => false,
                    ],
                ],
                [
                    "label" => "Author",
                    "name" => "user_id",
                    "type" => \Packages\Generator\App\Generators\Base::FIELD_TYPE_FOREIGN,
                    "relation" => [
                        "class" => "\Packages\Dashboard\App\Models\User",
                        "table" => "questions",
                        "label" => "email",
                    ],
                    "rules" => [
                        "required" => false,
                    ],
                ],
                [
				    "label" => "Body",
				    "name" => "body",
				    "type" => "text",
				],
                [
				    "label" => "Images",
				    "name" => "images",
				    "type" => "image",
				],
            ],
		],
    ],
];
