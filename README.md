CSVMapper
=========
Official repo stats

[![Build Status](https://travis-ci.org/danieleorler/CSVMapper.png?branch=master)](https://travis-ci.org/danieleorler/CSVMapper)
[![Coverage Status](https://coveralls.io/repos/danieleorler/CSVMapper/badge.png?branch=master)](https://coveralls.io/r/danieleorler/CSVMapper?branch=master)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/danieleorler/CSVMapper/badges/quality-score.png?s=e6f13eb26e9961b0edf02a1fec1e49143a7975ca)](https://scrutinizer-ci.com/g/danieleorler/CSVMapper/)

CSVMapper is a PHP library which parses CSV files.

It allows to map the file to an array by defining some file configurations and each (wanted) columns properties.

File Settings
=============

CSVMapper needs to now where the file is located and which is the columns separator.

It il also possible to specify how many columns are expected so that it aborts if the number of columns doesn't match.

```php
    $setting = new SettingManager();
    $config->set_setting('folder','./tests');
    $config->set_setting('filename','myfile.csv');
    $config->set_setting('separator',';');
    $config->set_setting('columns_allowed',3);
```

Mappings
========

CSVMapper extracts only the columns which are defined with mappings.
With a mapping it is possible to specify the position of the column, which function to apply to the value and how to test the value.

```php
    $mapping = new MappingManager();
    // retrieve column number 1 (counting from 0) and label it as year
    $mapping->set_mapping("year", array('key'=>1,'fn'=>FALSE,'test'=>FALSE));
    // retrieve column number 2 (counting from 0) and label it as temperature, apply to each value the function 'return floatval($input);'
    $mapping->set_mapping("temperature", array('key'=>2, 'fn'=>create_function('$input','return floatval($input);'),'test'=>FALSE));
```

