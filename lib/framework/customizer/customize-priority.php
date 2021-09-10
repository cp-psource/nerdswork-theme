<?php
//Do not allow direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

/**
 * Generates priority to be used in customizer controls/sections etc
 * Originally inspired from Theme Foundry's Make theme prioritizer
 * 
 */
class CB_Cutomizer_Prioritizer {
	
	var $initial_priority = 0;
	var $increment = 0;
	var $current_priority = 0;

	/**
	 * Set the initial properties on init.
	 *
	 * @param  int                    $initial_priority    Value to being the counter.
	 * @param  int                    $increment           Value to increment the counter by.
	 * @return CB_Cutomizer_Prioritizer
	 */
	public function __construct( $initial_priority = 100, $increment = 100 ) {
		$this->initial_priority = absint( $initial_priority );
		$this->increment        = absint( $increment );
		$this->current_priority = $this->initial_priority;
	}

	/**
	 * Get the current value.
	 */
	public function get() {
		return $this->current_priority;
	}

	/**
	 * Increment the priority.
	 */
	public function inc( $increment = 0 ) {
		if ( 0 === $increment ) {
			$increment = $this->increment;
		}
		$this->current_priority += absint( $increment );
	}

	/**
	 * Increment by the $this->increment value.
	 *
	 */
	public function add() {
		
		$priority = $this->get();
		$this->inc();
		return $priority;
	}

	/**
	 * Change the current priority and/or increment value.
	 *
	 */
	public function set( $new_priority = null, $new_increment = null ) {
		if ( ! is_null( $new_priority ) ) {
			$this->current_priority = absint( $new_priority );
		}
		if ( ! is_null( $new_increment ) ) {
			$this->increment = absint( $new_increment );
		}
	}

	/**
	 * Reset the counter.
	 */
	public function reset() {
		$this->current_priority = $this->initial_priority;
	}
}