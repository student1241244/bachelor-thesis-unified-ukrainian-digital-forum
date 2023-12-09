<?php

namespace App\Console\Commands;

use File;
use Packages\Generator\App\GenerateService;
use Illuminate\Console\Command;

class GenerateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:package {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates new package.';

    private $generateService;


    /**
     * Create a new command instance.
     *
     * @param GenerateService $generateService
     * @return void
     */
    public function __construct(GenerateService $generateService)
    {
        parent::__construct();
        $this->generateService = $generateService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $file = $this->argument('file');
        if ($file) {
            $this->generateService->setConfigFromFile($file)->handle();
        } else {
            $this->getOutput()->setDecorated(true);

            $data = $this->configurePackage();
        }
    }

    protected function configurePackage()
    {
        $this->comment('Configure Package');

        $data = [
            'author_name' => [
                'question' => 'Your name',
                'default' => config('generator.developer.author_name'),
            ],
            'author_username' => [
                'question' => 'Your Github username',
                'default' => config('generator.developer.author_username')
            ],
            'author_email' => [
                'question' => 'Your email address',
                'default' => config('generator.developer.author_email')
            ],
            'author_website' => [
                'question' => 'Your website',
                'default' => config('generator.developer.author_website')
            ],
            'vendor' => [
                'question' => 'Package vendor',
                'default' => config('generator.developer.vendor')
            ],
            'package_name' => [
                'question' => 'Package name',
            ],
            'package_description' => [
                'question' => 'Package very short description'
            ],
            'vendor\\:package_name\\' => [
                'question' => 'PSR-4 namespace'
            ],
        ];

        $data = $this->askQuestions($data);

        /*
        $this->table([
            'Setting',
            'Value'
        ], $data);
        */

        dump($data);

        if ($this->confirm('Is the package information correct?')) {
            (new GenerateService())->setConfig($data)->handle();
        }

        $this->line('Package configuration saved.');
    }

    protected function askQuestions($data)
    {
        foreach ($data as $key => $values) {

            if($key=='vendor\\:package_name\\') {
                $values['default'] = $data['vendor'] . '\\' . $data['package_name'];
            }

            if($key=='package_description') {
                $values['default'] = $data['package_name'] . ' package.';
            }

            $data[$key] = $this->ask($values['question'], array_get($values, 'default'));
            $this->line($data[$key]);
        }

        $modelName = $this->ask('Model name (singular) ?', str_singular($data['package_name']));

        $data['models'][$modelName] = [];
        $data = $this->askModelFieldSlug($data, $modelName);
        $data = $this->askModelFields($data, $modelName);

        while ($this->confirm('To add a new model?')) {
            $otherModelName = $this->ask('Model name (singular) ?');
            $data['models'][$otherModelName] = [];
            $data = $this->askModelFieldSlug($data, $otherModelName);
            $data = $this->askModelFields($data, $otherModelName);
        }

        return $data;
    }

    /**
     * @param array $data
     * @param string $modelName
     * @return array
     */
    protected function askModelFieldSlug(array $data, string $modelName): array
    {
        if ($this->confirm("To add a slug field to model: $modelName ?", "yes")) {
            $field = [
                'required' => false,
                'type' => 'text',
                'name' => 'slug',
            ];
            $data['models'][$modelName]['fields'][] = $field;
        }

        return $data;
    }

    /**
     * @param array $data
     * @param string $modelName
     * @return array
     */
    protected function askModelFields(array $data, string $modelName): array
    {
        $mapTypes = [
            1 => 'text',
            2 => 'boolean',
            3 => 'textarea',
            4 => 'image',
            5 => 'editor',
            6 => 'timestamp',
            7 => 'integer',
            8 => 'double',
        ];

        $hintTypes = [];
        foreach ($mapTypes as $k => $v) {
            $hintTypes[] = "$k - $v";
        }
        $hintTypes = implode('; ', $hintTypes);

        while ($this->confirm("To add a new field to model: $modelName ?")) {
            $field = ['name' => $this->ask("Field name ?")];

            $field['type'] = $this->ask("'Enter field type: [$hintTypes]", 1);
            if (!isset($mapTypes[$field['type']])) {
                $field['type'] = 1;
            }
            $field['type'] = $mapTypes[$field['type']];

            if (in_array($field['type'], ['text', 'textarea', 'editor'])) {
                $field['translatable'] = $this->confirm("Translatable field?");
            }

            $data['models'][$modelName]['fields'][] = $field;
        }

        return $data;
    }
}
