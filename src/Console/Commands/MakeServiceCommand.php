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

        // Создаем директорию Services, если ее нет
        if (!File::isDirectory($servicesDirectory)) {
            File::makeDirectory($servicesDirectory, 0755, true);
        }

        $directories = explode('/', $name);
        $filename = array_pop($directories);

        // Строим полный путь с учетом вложенных директорий
        $currentDirectory = $servicesDirectory;
        foreach ($directories as $dir) {
            $currentDirectory .= DIRECTORY_SEPARATOR . $dir;
            if (!File::isDirectory($currentDirectory)) {
                File::makeDirectory($currentDirectory, 0755, true);
            }
        }

        $filePath = $currentDirectory . DIRECTORY_SEPARATOR . $filename . 'Service.php';

        if (File::exists($filePath)) {
            $this->error('Service already exists!');
            return;
        }

        File::put($filePath, $this->generateServiceFileContent($name, $filename, $model));
        $this->info('Service created successfully: ' . $filePath);
    }

    protected function generateServiceFileContent($fullName, $className, $model)
    {
        $namespace = 'App\Services';

        // Добавляем поддиректории к namespace
        $subDirs = explode('/', dirname($fullName));
        $subDirs = array_filter($subDirs); // Удаляем пустые элементы
        if (!empty($subDirs)) {
            $namespace .= '\\' . implode('\\', $subDirs);
        }

        // Формируем импорт модели
        $modelImport = $model ? "use App\Models\\" . str_replace('/', '\\', $model) . ";" : '';

        $content = "<?php\n\n";
        $content .= "namespace {$namespace};\n\n";
        $content .= $modelImport ? $modelImport . "\n\n" : '';
        $content .= "class {$className}Service\n{\n";

        // Добавляем стандартные методы
        $content .= $this->generateMethod('index');
        $content .= $this->generateMethod('store');
        $content .= $this->generateMethod('update');
        $content .= $this->generateMethod('delete');

        $content .= "}\n";

        return $content;
    }

    protected function generateMethod($methodName)
    {
        return "    public function {$methodName}(\$data)\n    {\n        // Your {$methodName} method logic here\n    }\n\n";
    }
}