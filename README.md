# Bingogg/slugify

> Converts a string into a slug. 
> Port from simon/slugify

Developed by [Pavlo Harashchenko](https://p-h-h.com) in Tallinn, Europe with the help of 
[cocur/slugify](https://github.com/cocur/slugify).
[simov/slugify](https://github.com/simov/slugify).

## Features

-   Port package simov/slugify to php
-   Provides custom replacements.
-   No external dependencies.
-   PSR-4 compatible.
-   Compatible with PHP >= 7.
-   Integrations for [Laravel](http://laravel.com)

## Installation

You can install Slugify through [Composer](https://getcomposer.org):

```shell
composer require bingogg14/slugify
```

Slugify requires the Multibyte String extension from PHP. Typically you can use the configure option `--enable-mbstring` while compiling PHP. More information can be found in the [PHP documentation](http://php.net/manual/en/mbstring.installation.php).

Further steps may be needed for [integrations](#integrations).

## Usage

Generate a slug:

```php
use Bingogg\Slugify\Slugify;

$slugify = new Slugify();
echo $slugify->slugify("Hello World!"); // hello-world
```

You can also change the separator used by `Slugify`:

```php
echo $slugify->slugify("Hello World!", "_"); // hello_world
```

The library also contains `Bingogg\Slugify\SlugifyInterface`. Use this interface whenever you need to type hint an
instance of `Slugify`.

### Contributing

We really appreciate if you report bugs and errors in the transliteration, especially if you are a native speaker of
the language and question. Feel free to ask for additional languages in the issues, but please note that the
maintainer of this repository does not speak all languages. If you can provide a Pull Request with rules for
a new language or extend the rules for an existing language that would be amazing.

Submit PR. Thank you very much. 🇺🇦

### Code of Conduct

In the interest of fostering an open and welcoming environment, we as contributors and maintainers pledge to making participation in our project and our community a harassment-free experience for everyone, regardless of age, body size, disability, ethnicity, gender identity and expression, level of experience, nationality, personal appearance, race, religion, or sexual identity and orientation.

The full Code of Conduct can be found [here](https://github.com/bingogg14/slugify/blob/master/CODE_OF_CONDUCT.md).

This project is no place for hate. If you have any problems please contact Pavlo: [bingogg14@gmail.com](mailto:bingogg14@gmail.com) 🇺🇦


## Integrations

### Laravel

Slugify also provides a service provider to integrate into Laravel (versions 4.1 and later).

In your Laravel project's `app/config/app.php` file, add the service provider into the "providers" array:

```php
'providers' => array(
    "Bingogg\Slugify\Bridge\Laravel\SlugifyServiceProvider",
)
```

And add the facade into the "aliases" array:

```php
'aliases' => array(
    "Slugify" => "Bingogg\Slugify\Bridge\Laravel\SlugifyFacade",
)
```

You can then use the `Slugify::slugify()` method in your controllers:

```php
$url = Slugify::slugify("welcome to the homepage");
```

After that you can retrieve the `Bingogg\Slugify\Slugify` service (or the `slugify` alias) and generate a slug.

## Change Log

### Version 1.4.5 (11 April 2023)

- Public beta version port

## Authors

-   [Pavlo Harashchenko](https://p-h-h.com) 

## License

The MIT License (MIT)

Copyright (c) 2023 Pavlo Harashchenko

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
documentation files (the "Software"), to deal in the Software without restriction, including without limitation the
rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit
persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the
Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
