<?php

namespace PHPUtil;

/**
 * A simple but useful PHP's DateTime extension. (PHP >= 5.2.0)
 *
 * @author	Thiago Delgado Pinto
 *
 * @see		http://php.net/manual/en/class.datetime.php
 * @see		http://php.net/manual/en/timezones.php
 */
class TDateTime extends \DateTime {
	
	//
	// Days of week
	//
	const SUNDAY	= 0;
	const MONDAY	= 1;
	const TUESDAY	= 2;
	const WEDNESDAY	= 3;
	const THURSDAY	= 4;
	const FRIDAY	= 5;
	const SATURDAY	= 6;
	
	//
	// Useful constants
	//
	const MONTHS_PER_YEAR		= 12;
	const WEEKS_PER_MONTH		= 4;
	const DAYS_PER_WEEK			= 7;
	const SECONDS_PER_MINUTE	= 60;
	const MINUTES_PER_HOUR		= 60;
	
	//
	// Some date and time formats
	//	
	const DATABASE_DATETIME_FORMAT		= 'Y-m-d H:i:s';
	const DATABASE_DATE_FORMAT			= 'Y-m-d';
	const DATABASE_TIME_FORMAT			= 'H:i:s';
	const DATABASE_SIMPLE_TIME_FORMAT	= 'H:i';
	
	const AMERICAN_DATETIME_FORMAT		= 'm/d/Y H:i:s';
	const AMERICAN_DATE_FORMAT			= 'm/d/Y';
	const AMERICAN_TIME_FORMAT			= 'H:i:s';
	const AMERICAN_SIMPLE_TIME_FORMAT	= 'H:i';

	const BRAZILIAN_DATETIME_FORMAT		= 'd/m/Y H:i:s';
	const BRAZILIAN_DATE_FORMAT			= 'd/m/Y';
	const BRAZILIAN_TIME_FORMAT			= 'H:i:s';
	const BRAZILIAN_SIMPLE_TIME_FORMAT	= 'H:i';
	
	const DEFAULT_DATETIME_FORMAT		= self::DATABASE_DATETIME_FORMAT;
	const DEFAULT_DATE_FORMAT			= self::DATABASE_DATE_FORMAT;
	const DEFAULT_TIME_FORMAT			= self::DATABASE_TIME_FORMAT;
	const DEFAULT_SIMPLE_TIME_FORMAT	= self::DATABASE_SIMPLE_TIME_FORMAT;
	
	//
	// Global formats, used by all instances.
	//
	private static $globalDateTimeFormat	= self::DEFAULT_DATETIME_FORMAT;
	private static $globalDateFormat		= self::DEFAULT_DATE_FORMAT;
	private static $globalTimeFormat		= self::DEFAULT_TIME_FORMAT;
	private static $globalSimpleTimeFormat	= self::DEFAULT_SIMPLE_TIME_FORMAT;
	
	//
	// Local formats, used only by current instance.
	// Overrides the global format only for the current instance.
	//
	private $localDateTimeFormat	= null;
	private $localDateFormat		= null;
	private $localTimeFormat		= null;
	private $localSimpleTimeFormat	= null;
	
	
	
	// ATTRIBUTE HANDLING _____________________________________________________
	
	static function getGlobalDateTimeFormat() { return self::$globalDateTimeFormat; }
	static function setGlobalDateTimeFormat( $format ) { self::$globalDateTimeFormat = $format; }
	
	static function getGlobalDateFormat() { return self::$globalDateFormat; }
	static function setGlobalDateFormat( $format ) { self::$globalDateFormat = $format; }
	
	static function getGlobalTimeFormat() { return self::$globalTimeFormat; }
	static function setGlobalTimeFormat( $format ) { self::$globalTimeFormat = $format; }
	
	static function getGlobalSimpleTimeFormat() { return self::$globalSimpleTimeFormat; }
	static function setGlobalSimpleTimeFormat( $format ) { self::$globalSimpleTimeFormat = $format; }
	
	
	function getLocalDateTimeFormat() { return $this->localDateTimeFormat; }
	function setLocalDateTimeFormat( $format ) { $this->localDateTimeFormat = $format; return $this; }
	
	function getLocalDateFormat() { return $this->localDateFormat; }
	function setLocalDateFormat( $format ) { $this->localDateFormat = $format; return $this; }
	
	function getLocalTimeFormat() { return $this->localTimeFormat; }
	function setLocalTimeFormat( $format ) { $this->localTimeFormat = $format; return $this; }
	
	function getLocalSimpleTimeFormat() { return $this->localSimpleTimeFormat; }
	function setLocalSimpleTimeFormat( $format ) { $this->localSimpleTimeFormat = $format; return $this; }
	
	
	function dateTimeFormat() {
		return $this->getLocalDateTimeFormat() === null
			? self::getGlobalDateTimeFormat()
			: $this->getLocalDateTimeFormat()
			;
	}
	
	function dateFormat() {
		return $this->getLocalDateFormat() === null
			? self::getGlobalDateFormat()
			: $this->getLocalDateFormat()
			;
	}
	
	function timeFormat() {
		return $this->getLocalTimeFormat() === null
			? self::getGlobalTimeFormat()
			: $this->getLocalTimeFormat()
			;
	}
	
	function simpleTimeFormat() {
		return $this->getLocalSimpleTimeFormat() === null
			? self::getGlobalSimpleTimeFormat()
			: $this->getLocalSimpleTimeFormat()
			;
	}
	
	// YEAR ___________________________________________________________________
	
	function year() { return (int) $this->format( 'Y' ); }
	function setYear( $year ) { $this->setDate( $year, $this->month(), $this->day() ); return $this; }
	
	function isLeapYear() { return (bool) $this->format( 'L' ); }
	
	function addYears( $years ) { $this->add( $this->createYearInterval( $years ) ); return $this; }
	function addOneYear() { return $this->addYears( 1 ); }
	function plusYears( $years ) { return $this->addYears( $years ); }
	function plusOneYear() { return $this->addYears( 1 ); }
	
	function subYears( $years ) { $this->sub( $this->createYearInterval( $years ) ); return $this; }
	function subOneYear() { return $this->subYears( 1 ); }
	function minusYears( $years ) { return $this->subYears( $years ); }
	function minusOneYear() { return $this->subYears( 1 ); }
	
	function createYearInterval( $years ) { return new \DateInterval( 'P' . $years . 'Y' ); }
	
	// MONTH __________________________________________________________________
	
	function month() { return (int) $this->format( 'm' ); }
	function setMonth( $month ) { $this->setDate( $this->year(), $month, $this->day() ); return $this; }
	
	function daysInMonth() { return (int) $this->format( 't' ); }
	
	/** Add ($month * 30) days */
	function addMonths( $months ) { $this->add( $this->createMonthInterval( $months ) ); return $this; }
	/** Add 30 days */
	function addOneMonth() { return $this->addMonths( 1 ); }
	function plusMonths( $months ) { return $this->addMonths( $months ); }
	function plusOneMonth() { return $this->addMonths( 1 ); }
	
	/** Subtract ($month * 30) days */
	function subMonths( $months ) { $this->sub( $this->createMonthInterval( $months ) ); return $this; }
	/** Subtract 30 days */
	function subOneMonth() { return $this->subMonths( 1 ); }
	function minusMonths( $months ) { return $this->subMonths( $months ); }
	function minusOneMonth() { return $this->subMonths( 1 ); }
	
	function createMonthInterval( $months ) { return new \DateInterval( 'P' . $months . 'M' ); }
	
	// DAY ____________________________________________________________________
	
	function day() { return (int) $this->format( 'd' ); }
	function setDay( $day ) { $this->setDate( $this->year(), $this->month(), $day ); return $this; }
	
	function dayOfYear() { return 1 + $this->format( 'z' ); }
	function dayOfWeek() { return (int) $this->format( 'w' ); }
	/* According to ISO-8601, weeks start on Monday. */
	function weekOfYear() { return (int) $this->format( 'W' ); }
	/* By default, $currentDate is today */
	function age( \DateTime $currentDate = null ) {
		$dt = $currentDate === null ? new \DateTime() : $currentDate;
		return $this->diffInYears( $dt );
	}
	
	function isSunday() { return $this->dayOfWeek() == self::SUNDAY; }
	function isSaturday() { return $this->dayOfWeek() == self::SATURDAY; }
	function isWeekend() { return $this->isSaturday() || $this->isSunday(); }
	
	function addDays( $days ) { $this->add( $this->createDayInterval( $days ) ); return $this; }
	function addOneDay() { return $this->addDays( 1 ); }
	function plusDays( $days ) { return $this->addDays( $days ); }
	function plusOneDay() { return $this->addDays( 1 ); }
	
	function subDays( $days ) { $this->sub( $this->createDayInterval( $days ) ); return $this; }
	function subOneDay() { return $this->subDays( 1 ); }
	function minusDays( $days ) { return $this->subDays( $days ); }
	function minusOneDay() { return $this->subDays( 1 ); }
	
	function createDayInterval( $days ) { return new \DateInterval( 'P' . $days . 'D' ); }	
	
	// HOUR ___________________________________________________________________
	
	function hour() { return (int) $this->format( 'G' ); }
	function setHour( $hour ) { $this->setTime( $hour, $this->minute(), $this->second() ); return $this; }
	
	function isAm() { return 'AM' == $this->format( 'A' ); }
	function isPm() { return 'PM' == $this->format( 'A' ); }
	
	function isDaylightSavingTime() { return (bool) $this->format( 'I' ); }
	/** This method is aware of DaylightSavingTime (DST) */
	function utcOffset() {		
		$seconds = $this->getOffset();
		$hours = abs( $seconds / 3600 );
		$minutes = abs( $seconds % 3600 );
		$str = ( $seconds < 0 ? '-' : '+' )
			. ( $hours < 10 ? '0' : '' ) . $hours 
			. ':' 
			. ( $minutes < 10 ? '0' : '' ) . $minutes
			;
		return $str;
	}
	
	function timezoneName() { return getTimezone() !== null ? getTimezone()->getName() : ''; }
	
	function addHours( $hours ) { $this->add( $this->createHourInterval( $hours ) ); return $this; }
	function addOneHour() { return $this->addHours( 1 ); }
	function plusHours( $hours ) { return $this->addHours( $hours ); }
	function plusOneHour() { return $this->addHours( 1 ); }
	
	function subHours( $hours ) { $this->sub( $this->createHourInterval( $hours ) ); return $this; }
	function subOneHour() { return $this->subHours( 1 ); }
	function minusHours( $hours ) { return $this->subHours( $hours ); }
	function minusOneHour() { return $this->subHours( 1 ); }
	
	function createHourInterval( $hours ) { return new \DateInterval( 'PT' . $hours . 'H' ); }
	
	// MINUTE _________________________________________________________________
	
	function minute() { return (int) $this->format( 'i' ); }
	function setMinute( $minute ) { $this->setTime( $this->hour(), $minute, $this->second() ); return $this; }
	
	function addMinutes( $minutes ) { $this->add( $this->createMinuteInterval( $minutes ) ); return $this; }
	function addOneMinute() { return $this->addMinutes( 1 ); }
	function plusMinutes( $minutes ) { return $this->addMinutes( $minutes ); }
	function plusOneMinute() { return $this->addMinutes( 1 ); }
	
	function subMinutes( $minutes ) { $this->sub( $this->createMinuteInterval( $minutes ) ); return $this; }
	function subOneMinute() { return $this->subMinutes( 1 ); }
	function minusMinutes( $minutes ) { return $this->subMinutes( $minutes ); }
	function minusOneMinute() { return $this->subMinutes( 1 ); }
	
	function createMinuteInterval( $minutes ) { return new \DateInterval( 'PT' . $minutes . 'M' ); }
	
	// SECOND _________________________________________________________________
	
	function second() { return (int) $this->format( 's' ); }
	function setSecond( $second ) { $this->setTime( $this->hour(), $this->minute(), $second ); return $this; }
	
	function addSeconds( $seconds ) { $this->add( $this->createSecondInterval( $seconds ) ); return $this; }
	function addOneSecond() { return $this->addSeconds( 1 ); }
	function plusSeconds( $seconds ) { return $this->addSeconds( $seconds ); }
	function plusOneSecond() { return $this->addSeconds( 1 ); }
	
	function subSeconds( $seconds ) { $this->sub( $this->createSecondInterval( $seconds ) ); return $this; }
	function subOneSecond() { return $this->subSeconds( 1 ); }
	function minusSeconds( $seconds ) { return $this->subSeconds( $seconds ); }
	function minusOneSecond() { return $this->subSeconds( 1 ); }
	
	function createSecondInterval( $seconds ) { return new \DateInterval( 'PT' . $seconds . 'S' ); }
	
	// MICRO __________________________________________________________________
	
	function micro() { return (int) $this->format( 'u' ); }
	
	// DIFF ___________________________________________________________________
	
	function diffInYears( \DateTime $dateTime, $absolute = true ) {
		return (int) $this->diff( $dateTime, $absolute )->format( '%r%y' );
	}

	function diffInMonths( \DateTime $dateTime, $absolute = true ) {
		$yearMonths = $this->diffInYears( $dateTime, $absolute ) * self::MONTHS_PER_YEAR;
		return $yearMonths + $this->diff( $dateTime, $absolute )->format( '%r%m' );
	}
	
	function diffInDays( \DateTime $dateTime, $absolute = true ) {
		return (int) $this->diff( $dateTime, $absolute )->format( '%r%a' );
	}
	
	function diffInWeeks( \DateTime $dateTime, $absolute = true ) {
		return (int) $this->diffInDays( $dateTime, $absolute ) / self::DAYS_PER_WEEK;
	}
	
	function diffInHours( \DateTime $dateTime, $absolute = true ) {
		return (int) $this->diffInMinutes( $dateTime, $absolute ) / self::MINUTES_PER_HOUR;
	}
	
	function diffInMinutes( \DateTime $dateTime, $absolute = true ) {
		return (int) $this->diffInSeconds( $dateTime, $absolute ) / self::SECONDS_PER_MINUTE;
	}
	
	function diffInSeconds( \DateTime $dateTime, $absolute = true ) {
		$seconds = $dateTime->getTimestamp() - $this->getTimestamp();
		return $absolute ? abs( $seconds ) : $seconds;
	}
	
	// VALUE UTILITIES ________________________________________________________
	
	function clearDate() { $this->setDate( 0, 0, 0 ); return $this; }
	function clearTime() { $this->setTime( 0, 0, 0 ); return $this; }
	function clear() { return $this->clearDate()->clearTime(); }
	
	function copyDate( \DateTime $dateTime ) {
		$year = (int) $dateTime->format( 'Y' );
		$month = (int) $dateTime->format( 'm' );
		$day = (int) $dateTime->format( 'd' );
		$this->setDate( $year, $month, $day );
		return $this;
	}
	
	function copyTime( \DateTime $dateTime ) {
		$hour = (int) $dateTime->format( 'G' );
		$minute = (int) $dateTime->format( 'i' );
		$second = (int) $dateTime->format( 's' );
		$this->setTime( $hour, $minute, $second );
		return $this;
	}
	
	function copyDateTime( \DateTime $dateTime ) {
		return $this->copyDate( $dateTime )->copyTime( $dateTime );
	}
	
	function copy( \DateTime $dateTime ) { // Same as fromDateTime
		$this->fromDateTime( $dateTime );
		
		if ( ! ( $dateTime instanceof TDateTime ) ) { return $this; }
		$this->localDateTimeFormat = $dateTime->localDateTimeFormat;
		$this->localDateFormat = $dateTime->localDateFormat;
		$this->localTimeFormat = $dateTime->localTimeFormat;
		$this->localSimpleTimeFormat = $dateTime->localSimpleTimeFormat;
		
		return $this;
	}
	
	function newCopy() {
		return clone $this;
	}
	
	// COMPARISON UTILITIES ___________________________________________________
	
	function after( \DateTime $dateTime ) { return $this > $dateTime; }
	function before( \DateTime $dateTime ) { return $this < $dateTime; }
	
	function between( \DateTime $min, \DateTime $max ) {
		return $min < $max
			? $this >= $min && $this <= $max
			: $this >= $max && $this <= $min
			;
	}
	
	function greaterThan( \DateTime $dateTime ) { return $this > $dateTime; }
	function greaterThanOrEqualTo( \DateTime $dateTime ) { return $this >= $dateTime; }
	
	function lessThan( \DateTime $dateTime ) { return $this < $dateTime; }
	function lessThanOrEqualTo( \DateTime $dateTime ) { return $this <= $dateTime; }
	
	function equalTo( \DateTime $dateTime ) { return $this == $dateTime; }
	function notEqualTo( \DateTime $dateTime ) { return $this != $dateTime; }
	
	// CONVERSION UTILITIES ___________________________________________________
	
	function toString() { return $this->format( $this->dateTimeFormat() ); }
	function dateString() { return $this->format( $this->dateFormat() ); }
	function timeString() { return $this->format( $this->timeFormat() ); }
	function simpleTimeString() { return $this->format( $this->simpleTimeFormat() ); }	
	
	function fromString( $text, \DateTimeZone $timezone = null ) {
		return $this->fromDateTime( new \DateTime( $text, $timezone ) );
	}
	
	function fromDateString( $text, \DateTimeZone $timezone = null ) {
		return $this->parse( $this->dateFormat(), $text, $timezone );
	}
	
	function fromTimeString( $text, \DateTimeZone $timezone = null ) {
		return $this->parse( $this->timeFormat(), $text, $timezone );
	}
		
	function fromSimpleTimeString( $text, \DateTimeZone $timezone = null ) {
		return $this->parse( $this->simpleTimeFormat(), $text, $timezone );
	}
	
	function fromDateTime( \DateTime $dateTime ) {
		$timezone = $dateTime->getTimezone();
		if ( $timezone !== false ) {
			$this->setTimezone( $timezone );
		}
		$this->setTimestamp( $dateTime->getTimestamp() );
		return $this;
	}
	
	function parse( $format , $time, \DateTimeZone $timezone = null ) {
		return $this->fromDateTime( $this->createFromFormat( $format, $time, $timezone ) );
	}		
	
	// FORMAT-SPECIFIC CONVERSIONS ____________________________________________
	
	function toDatabaseString() { return $this->format( self::DATABASE_DATETIME_FORMAT ); }
	function toDatabaseDateString() { return $this->format( self::DATABASE_DATE_FORMAT ); }
	function toDatabaseTimeString() { return $this->format( self::DATABASE_TIME_FORMAT ); }
	function toDatabaseSimpleTimeString() { return $this->format( self::DATABASE_SIMPLE_TIME_FORMAT ); }

	function fromDatabaseString( $text, \DateTimeZone $timezone = null ) {
		return $this->parse( self::DATABASE_DATETIME_FORMAT, $text, $timezone ); }
	
	function fromDatabaseDateString( $text, \DateTimeZone $timezone = null ) {
		return $this->parse( self::DATABASE_DATE_FORMAT, $text, $timezone ); }
	
	function fromDatabaseTimeString( $text, \DateTimeZone $timezone = null ) {
		return $this->parse( self::DATABASE_TIME_FORMAT, $text, $timezone ); }
	
	
	function toBrazilianString() { return $this->format( self::BRAZILIAN_DATETIME_FORMAT ); }
	function toBrazilianDateString() { return $this->format( self::BRAZILIAN_DATE_FORMAT );	}
	function toBrazilianTimeString() { return $this->format( self::BRAZILIAN_TIME_FORMAT );	}
	function toBrazilianSimpleTimeString() { return $this->format( self::BRAZILIAN_SIMPLE_TIME_FORMAT ); }
	
	function fromBrazilianString( $text, \DateTimeZone $timezone = null ) {
		return $this->parse( self::BRAZILIAN_DATETIME_FORMAT, $text, $timezone ); }
	
	function fromBrazilianDateString( $text, \DateTimeZone $timezone = null ) {
		return $this->parse( self::BRAZILIAN_DATE_FORMAT, $text, $timezone ); }
		
	function fromBrazilianTimeString( $text, \DateTimeZone $timezone = null ) {
		return $this->parse( self::BRAZILIAN_TIME_FORMAT, $text, $timezone ); }
		
	function fromBrazilianSimpleTimeString( $text, \DateTimeZone $timezone = null ) {
		return $this->parse( self::BRAZILIAN_SIMPLE_TIME_FORMAT, $text, $timezone ); }
		
	
	function toAmericanString() { return $this->format( self::AMERICAN_DATETIME_FORMAT ); }
	function toAmericanDateString() { return $this->format( self::AMERICAN_DATE_FORMAT ); }
	function toAmericanTimeString() { return $this->format( self::AMERICAN_TIME_FORMAT ); }
	function toAmericanSimpleTimeString() { return $this->format( self::AMERICAN_SIMPLE_TIME_FORMAT ); }
	
	function fromAmericanString( $text, \DateTimeZone $timezone = null ) {
		return $this->parse( self::AMERICAN_DATETIME_FORMAT, $text, $timezone ); }
	
	function fromAmericanDateString( $text, \DateTimeZone $timezone = null ) {
		return $this->parse( self::AMERICAN_DATE_FORMAT, $text, $timezone ); }
		
	function fromAmericanTimeString( $text, \DateTimeZone $timezone = null ) {
		return $this->parse( self::AMERICAN_TIME_FORMAT, $text, $timezone ); }
		
	function fromAmericanSimpleTimeString( $text, \DateTimeZone $timezone = null ) {
		return $this->parse( self::AMERICAN_SIMPLE_TIME_FORMAT, $text, $timezone ); }	
	
	
	// MAGIC METHODS __________________________________________________________
	
	function __toString() {
		return $this->toString();
	}
	
}

?>