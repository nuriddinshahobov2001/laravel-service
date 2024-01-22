<?php

namespace Zintel\LaravelService\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeServiceCommand extends Command
{
    protected $signature = 'make:service {name} {--m=}';
    protected $description = 'Create a new service with index, store, update, delete methods';

    public function handle()
    {
        $name = $this->argument('name');
        $model = $this->option('m');
        $servicesDirectory = app_path('Services');
        if (!File::isDirectory($servicesDirectory)) {
            File::makeDirectory($servicesDirectory, 0755, true);
        }
        $currentDirectory = $servicesDirectory;
        $directories = explode('/', $name);
        $filename = array_pop($directories);

        foreach ($directories as $dir) {
            $dir = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $dir);
            $currentDirectory .= DIRECTORY_SEPARATOR . $dir;
            if (!File::isDirectory($currentDirectory)) {
                File::makeDirectory($currentDirectory, 0755, true);
            }
        }

        $filePath = $currentDirectory . DIRECTORY_SEPARATOR . $filename . 'Service.php';
        File::put($filePath, $this->generateServiceFileContent($name,$filename, $model));
        $this->info('Service created successfully!');
//        $this->info('This service already exists!');
    }

    protected function generateServiceFileContent($name, $filename, $model)
    {
        $namespace = dirname($name);
        $modelImport = $model ? "use App\Models\\{$model};" : '';

        $content = "<?php\n\nnamespace App\Services\\" . str_replace('/', '\\', $namespace) . ";\n\n{$modelImport}\n\nclass {$filename}Service\n{\n";

        $content .= $this->generateMethod('index');

        $content .= $this->generateMethod('store');

        $content .= $this->generateMethod('update');

        $content .= $this->generateMethod('delete');

        $content .= "}\n";

        return $content;
    }

    protected function generateMethod($methodName)
    {
        return "    public function {$methodName}(\$data)\n    {\n        // Your {$methodName} method logic here using \$data\n    }\n\n";
    }
}
