# Ynet Framework

A lightweight PHP framework for building web applications and APIs that can also serve as a backend for React Native applications.

## Requirements

- PHP 8.0 or higher
- Composer
- Apache with mod_rewrite enabled (or equivalent setup on other web servers)

## Installation

1. Clone this repository
2. Run `php install.php` to set up the directory structure and install dependencies
3. Configure your web server to point to the `public` directory
4. Update the database configuration in `config/app.php`

## Directory Structure

- `app/`: Application code (controllers, models, etc.)
- `core/`: Core framework components
- `public/`: Publicly accessible files (entry point, assets)
- `config/`: Configuration files
- `resources/`: Templates, assets, etc.
- `routes/`: Route definitions
- `storage/`: Logs, cache, uploads
- `vendor/`: Dependencies (managed by Composer)

## Routing

Routes are defined in the `routes/` directory. Example:

```php
$app->router->get('/', function() {
    return 'Welcome to Ynet Framework!';
});