<h1 align="center">GraphQL & Relay for Laravel</h1>

<p align="center">
<a href="https://travis-ci.org/LaraComponents/graphql"><img src="https://travis-ci.org/LaraComponents/graphql.svg?branch=master" alt="Build Status"></a>
<a href="https://github.com/LaraComponents/graphql/releases"><img src="https://img.shields.io/github/release/LaraComponents/graphql.svg?style=flat-square" alt="Latest Version"></a>
<a href="https://scrutinizer-ci.com/g/LaraComponents/graphql"><img src="https://img.shields.io/scrutinizer/g/LaraComponents/graphql.svg?style=flat-square" alt="Quality Score"></a>
<a href="https://styleci.io/repos/77400544"><img src="https://styleci.io/repos/77400544/shield" alt="StyleCI"></a>
<a href="https://packagist.org/packages/LaraComponents/graphql"><img src="https://img.shields.io/packagist/dt/LaraComponents/graphql.svg?style=flat-square" alt="Total Downloads"></a>
<a href="https://github.com/LaraComponents/graphql/blob/master/LICENSE"><img src="https://img.shields.io/badge/license-MIT-blue.svg" alt="Software License"></a>
</p>

## Introduction
GraphQL & Relay for Laravel

## Requirements

- PHP 5.6.4+ or newer
- Laravel 5.4 or newer

## Installation

Require this package with composer:

```bash
composer require laracomponents/graphql
```

Open your config/app.php and add the following to the providers array:

```php
'providers' => [
    // ...
    LaraComponents\GraphQL\ServiceProvider::class,
],
```

Publish the configuration file:

```bash
php artisan vendor:publish --provider="LaraComponents\GraphQL\ServiceProvider"
```
## Simple Usage

Create a schema:

```bash
$ php artisan make:graphql:scheme DefaultSchema
```

Create a type:

```bash
$ php artisan make:graphql:type UserType
 Which type would you like to create?:
  [0] AbstractType
  [1] AbstractScalarType
  [2] AbstractObjectType
  [3] AbstractMutationObjectType
  [4] AbstractInputObjectType
  [5] AbstractInterfaceType
  [6] AbstractEnumType
  [7] AbstractListType
  [8] AbstractUnionType
```

Create a field:

```bash
$ php artisan make:graphql:field UsersField
```

## Documentation

All detailed documentation is available on the main GraphQL repository – [http://github.com/youshido/graphql/](http://github.com/youshido/graphql/).

## License

The MIT License (MIT). Please see [License File](https://github.com/LaraComponents/graphql/blob/master/LICENSE) for more information.
