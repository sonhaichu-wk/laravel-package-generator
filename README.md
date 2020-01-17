# Generator for laravel package development

- [Generator for laravel package development](#generator-for-laravel-package-development)
  - [Installation](#installation)
  - [Configuration](#configuration)
  - [Commands](#commands)

## Installation

-   Create `/modules` in laravel framework.
-   Copy package source code to `/modules` folder.
-   Change `composer.json` file:

```
"require-dev": {
    ...
    "sonhaichu/generator": "@dev"
},
...
"repositories": [
    {
        "type": "path",
        "url": "./modules/generator"
    }
]
```

-   Run `composer install` command.
-   Run this command `php artisan vendor:publish` and select `HaiCS\Laravel\Generator\Providers\GeneratorServiceProvider`.

## Configuration

Add this content to `config/filesystems.php`

```php
'disks' => [

    ...

    'root' => [
        'driver' => 'local',
        'root' => base_path(),
    ],

],
```

## Commands

| Command                                                                  | Description                                       |
| ------------------------------------------------------------------------ | ------------------------------------------------- |
| `php artisan make:package {name}`                                        | Create a package scaffolding folder               |
| `php artisan make:package:test {packageName} {testName}`                 | Create a test class in package                    |
| `php artisan make:package:entity {packageName} {entityName}`             | Create an entity class in package                 |
| `php artisan make:package:controller {packageName} {controllerName}`     | Create a controller class in package              |
| `php artisan make:package:repository {packageName} {repositoryName}`     | Create a repositoy class and interface in package |
| `php artisan make:package:validator {packageName} {validatorName}`       | Create a validator class in package               |
| `php artisan make:package:command {packageName} {commandName}`           | Create a command class in package                 |
| `php artisan make:package:provider {packageName} {providerName}`         | Create a service provider class in package        |
| `php artisan make:package:transformer {packageName} {transformerName}`   | Create a transformer class in package             |
| `php artisan make:package:event {packageName} {eventName}`               | Create an event class in package                  |
| `php artisan make:package:listener {packageName} {listenerName}`         | Create a listener class in package                |
| `php artisan make:package:notification {packageName} {notificationName}` | Create a notification class in package            |
| `php artisan make:package:migration {packageName} {migrationName}`       | Create a migration file in package                |
