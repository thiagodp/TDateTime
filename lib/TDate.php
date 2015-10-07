<?php
namespace phputil;

/**
 * A simple Date class.
 *
 * @author	Thiago Delgado Pinto
 *
 * @see		TDateTime
 */
class TDate extends TDateTime {
	
	// CONVERSION UTILITIES ___________________________________________________
	
	/** @inheritDoc */
	function toString() { return $this->dateString(); }
	
	// FORMAT-SPECIFIC CONVERSIONS ____________________________________________
	
	/** @inheritDoc */
	function toDatabaseFormat() { return $this->toDatabaseDateFormat(); }
	
	/** @inheritDoc */
	function toBrazilianFormat() { return $this->toBrazilianDateFormat(); }
	
	/** @inheritDoc */
	function toAmericanFormat() { return $this->toAmericanDateFormat(); }

	// VALUE UTILITIES ________________________________________________________
	
	/** @inheritDoc */
	function newCopy() {
		return clone $this;
	}
}

?>