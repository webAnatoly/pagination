# Pagination

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://github.com/dnoegel/php-xdg-base-dir/blob/master/LICENSE)

A library to split results into multiple pages

## Install

Via Composer

``` bash
$ composer require webanatoly/pagination
```

## Usage

``` php
$obj = new Pagination\DirPager(
  new Pagination\PagesList(),
  'photos',
  3,
  2);
echo "<pre>";
print_r($obj->getItems());
echo "</pre>";
echo "<p>$obj</p>";
```

``` php
$obj = new Pagination\FilePager(
  new Pagination\ItemsRange(),
  'largetextfile.txt');
echo "<pre>";
print_r($obj->getItems());
echo "</pre>";
echo "<p>$obj</p>";
```

``` php
try {
  $pdo = new PDO(
    'mysql:host=localhost;dbname=test',
    'root',
    '',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
  $obj = new Pagination\PdoPager(
    new Pagination\ItemsRange(),
    $pdo,
    'table_name');
  echo "<pre>";
  print_r($obj->getItems());
  echo "</pre>";
  echo "<p>$obj</p>";
}
catch (PDOException $e) {
  echo "Can't connect to database";
}
```

## License

The MIT License (MIT). Please see [License File](https://github.com/dnoegel/php-xdg-base-dir/blob/master/LICENSE) for more information.