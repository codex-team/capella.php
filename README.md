# PHP SDK for CodeX Capella

This repository provides PHP SDK for working with the Capella API

## Installation

```bash
$ composer require capella
```

Or just clone this repository and include `src/Capella.php` to your bootstrap file.

## Usage

First, read CodeX Capella [documentation](https://github.com/codex-team/capella#readme).

#### Uploading
```php
use \Capella\Capella;

$image = Capella::upload('path-or-url-to-your-picture');

$url = $image->url();
```

[More](https://github.com/codex-team/capella.php/blob/master/docs/sdk.md#static-uploadpath)

#### Get image by known id
```php
use \Capella\Capella;

$image = Capella::image('abcdef-1234-abcd-1234');
```

[More](https://github.com/codex-team/capella.php/blob/master/docs/sdk.md#static-imageid)

#### Working with filters

```php
use \Capella\Capella;

$image = Capella::upload('picture.jpg');

$url = $image->resize(100)->url();
echo $url; // https://capella.pics/<id>/resize/100
  
$url = $image->crop(100, 200);
echo $url; // https://capella.pics/<id>/crop/100x200
```

[More](https://github.com/codex-team/capella.php/blob/master/docs/sdk.md#capellacapellaimage)

## Docs

CodeX Capella [documentation](https://github.com/codex-team/capella#readme)

Full PHP SDK [documentation](https://github.com/codex-team/capella.php/blob/master/docs/sdk.md)

## Requirements
```
php >= 5.6
php-curl
```

## Contribution
Ask a question or report a bug on the [create issue page](https://github.com/codex-team/capella.php/issues/new).

Know how to improve PHP SDK for Capella? Fork it and send pull request.

You can also write questions and suggestions to the [CodeX Team’s email](mailto:team@ifmo.su).

## License
[MIT](https://github.com/codex-team/capella.php/blob/master/LICENSE)

## Contacs
CodeX Team – [ifmo.su](https://ifmo.su)