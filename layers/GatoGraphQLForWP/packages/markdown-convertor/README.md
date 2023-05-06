# Markdown Convertor

<!--
[![Build Status][ico-travis]][link-travis]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Software License][ico-license]](LICENSE.md)
[![Latest Version on Packagist][ico-version]][link-packagist]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Total Downloads][ico-downloads]][link-downloads]
-->

Convert Markdown to HTML

## Install

Via Composer

``` bash
composer require gato-graphql/markdown-convertor
```

## Development

The source code is hosted on the [PoP monorepo](https://github.com/leoloso/PoP), under [`GatoGraphQL/packages/markdown-convertor`](https://github.com/leoloso/PoP/tree/master/layers/GatoGraphQL/packages/markdown-convertor).

## Usage

Initialize the component:

``` php
\PoP\Root\App::stockAndInitializeModuleClasses([([
    \GatoGraphQL\MarkdownConvertor\Module::class,
]);
```

## PHP versions

Requirements:

- PHP 8.1+ for development
- PHP 7.1+ for production

### Supported PHP features

Check the list of [Supported PHP features in `leoloso/PoP`](https://github.com/leoloso/PoP/blob/master/docs/supported-php-features.md)

### Preview downgrade to PHP 7.1

Via [Rector](https://github.com/rectorphp/rector) (dry-run mode):

```bash
composer preview-code-downgrade
```

## Standards

[PSR-1](https://www.php-fig.org/psr/psr-1), [PSR-4](https://www.php-fig.org/psr/psr-4) and [PSR-12](https://www.php-fig.org/psr/psr-12).

To check the coding standards via [PHP CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer), run:

``` bash
composer check-style
```

To automatically fix issues, run:

``` bash
composer fix-style
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

To execute [PHPUnit](https://phpunit.de/), run:

``` bash
composer test
```

## Static Analysis

To execute [PHPStan](https://github.com/phpstan/phpstan), run:

``` bash
composer analyse
```

## Report issues

To report a bug or request a new feature please do it on the [PoP monorepo issue tracker](https://github.com/leoloso/PoP/issues).

## Contributing

We welcome contributions for this package on the [PoP monorepo](https://github.com/leoloso/PoP) (where the source code for this package is hosted).

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email leo@getpop.org instead of using the issue tracker.

## Credits

- [Leonardo Losoviz][link-author]
- [All Contributors][link-contributors]

## License

GNU General Public License v2 (or later). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/gato-graphql/markdown-convertor.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-GPLv2-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/gato-graphql/markdown-convertor/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/gato-graphql/markdown-convertor.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/gato-graphql/markdown-convertor.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/gato-graphql/markdown-convertor.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/gato-graphql/markdown-convertor
[link-travis]: https://travis-ci.org/gato-graphql/markdown-convertor
[link-scrutinizer]: https://scrutinizer-ci.com/g/gato-graphql/markdown-convertor/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/gato-graphql/markdown-convertor
[link-downloads]: https://packagist.org/packages/gato-graphql/markdown-convertor
[link-author]: https://github.com/leoloso
[link-contributors]: ../../../../../../contributors