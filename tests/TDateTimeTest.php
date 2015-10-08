<?php
namespace phputil\Tests;

require_once 'lib/TDateTime.php'; // phpunit will be executed from the project root

use PHPUnit_Framework_TestCase;
use phputil\TDateTime;

/**
 * Tests TDateTime.
 *
 * @author	Thiago Delgado Pinto
 */
class TDateTimeTest extends PHPUnit_Framework_TestCase {
	
	private $tz = null;
	private $dt = null;
	
	function setUp() {
		$this->tz = new \DateTimeZone( 'America/Sao_Paulo' );
		$this->dt = new TDateTime( '2014-12-31 12:30:25', $this->tz );
	}
	
	// YEAR ___________________________________________________________________
	
	function testYear() {
		$this->assertEquals( 2014, $this->dt->year() );
	}
	
	function testSetYear() {
		$this->assertEquals( 2015, $this->dt->setYear( 2015 )->year() );
	}
	
	function testLeapYear() {
		$this->assertFalse( $this->dt->isLeapYear() );
		$this->assertTrue( $this->dt->setYear( 2016 )->isLeapYear() );
	}
	
	function testAddYears() {
		$this->dt->addYears( 5 );
		$this->assertEquals( 2019, $this->dt->year() );
	}
	
	function testSubYears() {
		$this->dt->subYears( 5 );
		$this->assertEquals( 2009, $this->dt->year() );
	}
	
	// MONTH ___________________________________________________________________
	
	function testMonth() {
		$this->assertEquals( 12, $this->dt->month() );
	}
	
	function testSetMonth() {
		$this->assertEquals( 1, $this->dt->setMonth( 1 )->month() );
	}
	
	function testDaysInMonth() {
		$this->assertEquals( 31, $this->dt->daysInMonth() );
		$this->assertEquals( 30, $this->dt->subDays( 31 )->daysInMonth() );
	}
	
	function testAddMonths() {
		$this->dt->addMonths( 1 );
		$this->assertEquals( 1, $this->dt->month() );
	}
	
	function testSubMonths() {
		$this->dt->subMonths( 1 );
		$this->assertEquals( '2014-12-01', $this->dt->dateString() );
	}	
	
	// DAY ____________________________________________________________________
	
	function testDay() {
		$this->assertEquals( 31, $this->dt->day() );
	}
	
	function testSetDay() {
		$this->assertEquals( 30, $this->dt->setDay( 30 )->day() );
	}
	
	function testDayOfYear() {
		$this->assertEquals( 365, $this->dt->dayOfYear() );
		$this->assertEquals( 1, ( new TDateTime( '2015-01-01' ) )->dayOfYear() );
	}
	
	function testDayOfWeek() {
		$this->assertEquals( TDateTime::WEDNESDAY, $this->dt->dayOfWeek() );
		$this->assertEquals( TDateTime::THURSDAY, ( new TDateTime( '2015-01-01' ) )->dayOfWeek() );
	}
	
	function testWeekOfYear() {
		$this->assertEquals( 1, ( new TDateTime( '2015-01-01' ) )->weekOfYear() ); // Thursday
		$this->assertEquals( 1, ( new TDateTime( '2015-01-04' ) )->weekOfYear() ); // Sunday
		$this->assertEquals( 2, ( new TDateTime( '2015-01-05' ) )->weekOfYear() ); // Monday (Sunday + 1)
	}
	
	function testAge() {
		$stephenHawkingBirthDate = new TDateTime( '1942-01-08' );
		$ageInTheDayBeforeBirthdateOf2015 = $stephenHawkingBirthDate->age( new \DateTime( '2015-01-07' ) );
		$this->assertEquals( 72, $ageInTheDayBeforeBirthdateOf2015 );
		$ageInBirthdateOf2015 = $stephenHawkingBirthDate->age( new \DateTime( '2015-01-08' ) );
		$this->assertEquals( 73, $ageInBirthdateOf2015 );
	}
	
	function testAddDays() {
		$this->dt->addDays( 1 );
		$this->assertEquals( '2015-01-01', $this->dt->dateString() );
	}
	
	function testSubDays() {
		$this->dt->subDays( 1 );
		$this->assertEquals( '2014-12-30', $this->dt->dateString() );
	}
	
	// HOUR ___________________________________________________________________
	
	function testHour() {
		$this->assertEquals( 12, $this->dt->hour() );
	}
	
	function testSetHour() {
		$this->assertEquals( 11, $this->dt->setHour( 11 )->hour() );
	}
	
	function testPm() {
		$this->assertTrue( $this->dt->isPm() );
	}
	
	function testAm() {
		$this->dt->setTime( 11, 59, 59 );
		$this->assertTrue( $this->dt->isAm() );
	}
	
	function testDaylightSavingTime() {
		$this->assertTrue( $this->dt->isDaylightSavingTime() );
		$this->dt->setDate( 2015, 6, 1 );
		$this->assertFalse( $this->dt->isDaylightSavingTime() );
	}
	
	function testUtcOffset() {
		// -02:00 it's in DST
		$this->assertEquals( '-02:00', $this->dt->utcOffset() );
		// Not in DST
		$this->dt->setDate( 2015, 6, 1 );
		// -03:00 when it's not
		$this->assertEquals( '-03:00', $this->dt->utcOffset() );
	}
	
	function testAddHours() {
		$this->dt->addHours( 1 );
		$this->assertEquals( 13, $this->dt->hour() );
	}
	
	function testSubHours() {
		$this->dt->subHours( 1 );
		$this->assertEquals( 11, $this->dt->hour() );
	}
	
	// MINUTE _________________________________________________________________
	
	function testMinute() {
		$this->assertEquals( 30, $this->dt->minute() );
	}
	
	function testSetMinute() {
		$this->assertEquals( 29, $this->dt->setMinute( 29 )->minute() );
	}
	
	function testAddMinutes() {
		$this->dt->addMinutes( 1 );
		$this->assertEquals( 31, $this->dt->minute() );
	}
	
	function testSubMinutes() {
		$this->dt->subMinutes( 1 );
		$this->assertEquals( 29, $this->dt->minute() );
	}
	
	// SECOND _________________________________________________________________
	
	function testSecond() {
		$this->assertEquals( 25, $this->dt->second() );
	}
	
	function testSetSecond() {
		$this->assertEquals( 24, $this->dt->setSecond( 24 )->second() );
	}
	
	function testAddSeconds() {
		$this->dt->addSeconds( 1 );
		$this->assertEquals( 26, $this->dt->second() );
	}
	
	function testSubSeconds() {
		$this->dt->subSeconds( 1 );
		$this->assertEquals( 24, $this->dt->second() );
	}
	
	// DIFF ___________________________________________________________________
	
	function testDiffInYears() {
		// One second before, expect 0 years
		$dt2 = new \DateTime( '2015-12-31 12:30:24', clone $this->tz );
		$this->assertEquals( 0, $this->dt->diffInYears( $dt2 ) );
		// Exactly a year later, expect 1 year
		$dt3 = new \DateTime( '2015-12-31 12:30:25', clone $this->tz );
		$this->assertEquals( 1, $this->dt->diffInYears( $dt3 ) );
	}
	
	function testDiffInMonths() {
		$dt2 = new \DateTime( '2015-12-31 12:30:24', clone $this->tz );
		$this->assertEquals( 11, $this->dt->diffInMonths( $dt2 ) );
		
		$dt3 = new \DateTime( '2015-12-31 12:30:25', clone $this->tz );
		$this->assertEquals( 12, $this->dt->diffInMonths( $dt3 ) );
	}
	
	function testDiffInDays() {
		$dt2 = new \DateTime( '2015-12-31 12:30:24', clone $this->tz );
		$this->assertEquals( 364, $this->dt->diffInDays( $dt2 ) );
		
		$dt3 = new \DateTime( '2015-12-31 12:30:25', clone $this->tz );
		$this->assertEquals( 365, $this->dt->diffInDays( $dt3 ) );
	}
	
	function testDiffInHours() {
		$dt2 = new \DateTime( '2014-12-31 11:30:25', clone $this->tz );
		$this->assertEquals( -1, $this->dt->diffInHours( $dt2, false ) );
		$this->assertEquals(  1, $this->dt->diffInHours( $dt2, true ) );
		
		$dt3 = new \DateTime( '2014-12-31 13:30:25', clone $this->tz );
		$this->assertEquals( +1, $this->dt->diffInHours( $dt3, false ) );
	}
	
	function testDiffInMinutes() {
		$dt2 = new \DateTime( '2014-12-31 12:29:25', clone $this->tz );
		$this->assertEquals( -1, $this->dt->diffInMinutes( $dt2, false ) );
		$this->assertEquals(  1, $this->dt->diffInMinutes( $dt2, true ) );
		
		$dt3 = new \DateTime( '2014-12-31 12:31:25', clone $this->tz );
		$this->assertEquals( +1, $this->dt->diffInMinutes( $dt3, false ) );
	}
	
	function testDiffInSeconds() {
		$dt2 = new \DateTime( '2014-12-31 12:30:24', clone $this->tz );
		$this->assertEquals( -1, $this->dt->diffInSeconds( $dt2, false ) );
		$this->assertEquals(  1, $this->dt->diffInSeconds( $dt2, true ) );
		
		$dt3 = new \DateTime( '2014-12-31 12:30:26', clone $this->tz );
		$this->assertEquals( +1, $this->dt->diffInSeconds( $dt3, false ) );
	}
	
	// VALUE UTILITIES ________________________________________________________

	function testClearDate() {
		$this->dt->clearDate();
		$expected = ( new \DateTime( '0000-00-00 12:30:25', clone $this->tz ) )->format( 'Y-m-d H:i:s' );
		$this->assertEquals( $expected, $this->dt->toString() );
	}
	
	function testClearTime() {
		$this->dt->clearTime();
		$expected = ( new \DateTime( '2014-12-31 00:00:00', clone $this->tz ) )->format( 'Y-m-d H:i:s' );
		$this->assertEquals( $expected, $this->dt->toString() );
	}
	
	function testClear() {
		$this->dt->clear();
		$expected = ( new \DateTime( '0000-00-00 00:00:00', clone $this->tz ) )->format( 'Y-m-d H:i:s' );
		$this->assertEquals( $expected, $this->dt->toString() );
	}
	
	function testCopyDate() {
		$dt2 = ( new TDateTime() )->copyDate( $this->dt );
		$this->assertEquals( $this->dt->dateString(), $dt2->dateString() );
	}
	
	function testCopyTime() {
		$dt2 = ( new TDateTime() )->copyTime( $this->dt );
		$this->assertEquals( $this->dt->timeString(), $dt2->timeString() );
	}
	
	function testCopy() {
		$dt2 = ( new TDateTime() )->copy( $this->dt );
		$this->assertEquals( $this->dt->toString(), $dt2->toString() );
	}
	
	function testNewCopy() {
		$dt2 = $this->dt->newCopy();
		$this->assertEquals( $this->dt->toString(), $dt2->toString() );
	}
	
	// COMPARISON UTILITIES ___________________________________________________
	
	function testComparisons() {
		$dtMin = $this->dt->newCopy()->subSeconds( 1 );
		$dtMax = $this->dt->newCopy()->addSeconds( 1 );
		
		$this->assertTrue( $dtMax->after( $this->dt ) );
		$this->assertTrue( $dtMax->greaterThan( $this->dt ) );
		$this->assertTrue( $dtMax->greaterThanOrEqualTo( $this->dt ) );
		$this->assertTrue( $dtMax->greaterThanOrEqualTo( $dtMax ) );
		
		$this->assertTrue( $dtMin->before( $this->dt ) );
		$this->assertTrue( $dtMin->lessThan( $this->dt ) );
		$this->assertTrue( $dtMin->lessThanOrEqualTo( $this->dt ) );
		$this->assertTrue( $dtMin->lessThanOrEqualTo( $dtMin ) );
		
		$this->assertTrue( $this->dt->equalTo( $this->dt->newCopy() ) );
		$this->assertTrue( $this->dt->notEqualTo( $dtMin ) );
		
		$this->assertTrue( $this->dt->between( $dtMin, $dtMax ) );
		$this->assertTrue( $this->dt->between( $this->dt, $this->dt ) );
	}
	
	// CONVERSION UTILITIES ___________________________________________________
	
	function testFromDateTime() {
		$dt2 = new \DateTime( '2015-01-01 15:15:15', clone $this->tz );
		$this->dt->fromDateTime( $dt2 );
		$this->assertEquals( $dt2->format( 'Y-m-d H:i:s' ), $this->dt->toString() );
	}
	
	// FORMAT-SPECIFIC CONVERSIONS ____________________________________________
	
	// MAGIC METHODS __________________________________________________________
	
	function testToString() {
		$this->assertEquals( $this->dt->toString(), (string) $this->dt );
	}
	
	function testClone() {
		$dt2 = clone $this->dt;
		$this->assertEquals( $this->dt, $dt2 );
	}
	
}
