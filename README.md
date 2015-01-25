# TDateTime
A simple but useful extension for PHP's [DateTime](http://php.net/manual/en/class.datetime.php) class. PHP >= 5.4

Available classes:
- [TDateTime](https://github.com/thiagodp/TDateTime/blob/master/lib/TDateTime.php)
- [TDate](https://github.com/thiagodp/TDateTime/blob/master/lib/TDate.php)
- [TTime](https://github.com/thiagodp/TDateTime/blob/master/lib/TTime.php)

Installation via [Composer](https://getcomposer.org/):
```shell
composer require thiagodp/tdatetime:dev-master
```

Example on how to use it:
```php
<?php
require 'TDateTime.php';

use PHPUtil\TDateTime; // Allow to use TDateTime without the namespace

// Create a datetime using the right timezone
$dt1 = new TDateTime( '2015-01-20 09:10:55', new \DateTimeZone( 'America/Sao_Paulo' ) );
echo '<br />', $dt1; // 2015-01-20 09:10:55

// Easy-to-use methods to get/change date and time attributes
$dt1->addOneDay();
echo '<br />', $dt1->day(); // 21
echo '<br />', $dt1->dateString(); // 2015-01-21
echo '<br />', $dt1->timeString(); // 09:10:55

// Clonnable
$dt2 = clone $dt1;
echo '<br />', $dt2;  // 2015-01-21 09:10:55

// Chainable
$dt2->subYears( 1 )->addMonths( 11 )->setDay( 31 ); // (2014-12-31)

// Allow to change the format for the current instance
$dt2->setLocalDateTimeFormat( TDateTime::AMERICAN_DATETIME_FORMAT );
echo '<br />', $dt2; // 12/31/2014 09:10:55

// Allow to change the format of all instances, but respect local format modifications!
TDateTime::setGlobalDateTimeFormat( TDateTime::BRAZILIAN_DATETIME_FORMAT );

echo '<br />', $dt1; // 21/01/2015 09:10:55 -> Brazilian datetime format
echo '<br />', $dt2; // 12/31/2014 09:10:55 -> American datetime format (respect local formatting)

// Easy comparison
echo '<br />', $dt2->before( $dt1 );					// true (1)
echo '<br />', $dt1->between( $dt2, new TDateTime() );	// true (1)
echo '<br />', $dt1->equalTo( $dt2 ) ? '=' : '!=';		// !=
?>
```
[Take a look](https://github.com/thiagodp/TDateTime/blob/master/lib/TDateTime.php). Enjoy it!
