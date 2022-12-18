# TDateTime

[![Build Status](https://travis-ci.org/thiagodp/TDateTime.svg?branch=master)](https://travis-ci.org/thiagodp/TDateTime)

Easy-to-use date and time extensions for PHP's [DateTime](http://php.net/manual/en/class.datetime.php) class.

* No external dependencies.
* Unit-tested
* Semantic versioning
* PHP >= 5.2

## Installation

Installation via [Composer](https://getcomposer.org/):
```shell
composer require phputil/tdatetime
```

## Documentation

Available classes:
- [phputil\TDateTime](https://github.com/thiagodp/TDateTime/blob/master/lib/TDateTime.php) (extends PHP's `\DateTime`)
- [phputil\TDate](https://github.com/thiagodp/TDateTime/blob/master/lib/TDate.php) (extends `phputil\TDateTime`)
- [phputil\TTime](https://github.com/thiagodp/TDateTime/blob/master/lib/TTime.php) (extends `phputil\TDateTime`)

📖 [See the Wiki](https://github.com/thiagodp/TDateTime/wiki).

## Examples
```php
<?php
require 'vendor/autoload.php';

use phputil\TDateTime; // Allow to use TDateTime without the namespace name

// Creating a datetime
$dt1 = new TDateTime( '2015-01-20 09:10:55' );
echo $dt1; // 2015-01-20 09:10:55

// Creating a datetime with timezone
$dt1 = new TDateTime( '2015-01-20 09:10:55', new \DateTimeZone( 'America/Sao_Paulo' ) );
echo $dt1;

// Easy-to-use methods to get/change date and time attributes
$dt1->addOneDay();        // Adds one day
echo $dt1->day();         // 21
echo $dt1->dateString();  // 2015-01-21
echo $dt1->timeString();  // 09:10:55

// Clonnable
$dt2 = clone $dt1;
echo $dt2; // 2015-01-21 09:10:55

// Chainnable setter methods
$dt2->subYears( 1 )->addMonths( 11 )->setDay( 31 ); // 2014-12-31

// Allow to change the format for the current instance
$dt2->setLocalDateTimeFormat( TDateTime::AMERICAN_DATETIME_FORMAT );
echo $dt2; // 12/31/2014 09:10:55

// Allow to change the format of ALL instances, but respect local format modifications!
TDateTime::setGlobalDateTimeFormat( TDateTime::BRAZILIAN_DATETIME_FORMAT );
echo $dt1; // 21/01/2015 09:10:55 -> Brazilian datetime format
echo $dt2; // 12/31/2014 09:10:55 -> American datetime format (respect local formatting)

// Easy comparison
echo $dt2->before( $dt1 ); // true
echo $dt1->between( $dt2, new TDateTime() ); // true
echo $dt1->equalTo( $dt2 ) ? '=' : '!='; // !=

// Validation (version 1.1+)
echo $dt1->isValidDatabaseDate( '2000/01/31' ); // true
echo $dt1->isValidAmericanDate( '01/31/2000' ); // true
echo $dt1->isValidBrazilianDate( '31/01/2000' ); // true
echo $dt1->isValidDatabaseDateTime( '2000/01/31 23:59:59' ); // true
echo $dt1->isValidAmericanDateTime( '01/31/2000 23:59:59' ); // true
echo $dt1->isValidBrazilianDateTime( '31/01/2000 23:59:59' ); // true
echo $dt1->isValidTime( '23:59:59' ); // true
echo $dt1->isValidSimpleTime( '23:59' ); // true
?>
```

## License

[LGPL](LICENSE) © [Thiago Delgado Pinto](https://github.com/thiagodp)