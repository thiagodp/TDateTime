<?php

namespace PHPUtil;

/**
 * A simple Time class.
 *
 * @author	Thiago Delgado Pinto
 *
 * @see		TDateTime
 */
class TTime extends TDateTime {
	
	// CONVERSION UTILITIES ___________________________________________________

	/** @inheritDoc */
	function toString() { return $this->timeString(); }
	
	// FORMAT-SPECIFIC CONVERSIONS ____________________________________________
	
	/** @inheritDoc */
	function toDatabaseFormat() { return $this->toDatabaseTimeFormat(); }	
	
}

?>