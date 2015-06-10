<?php
/**
 * @package    Cherry_Framework
 * @subpackage Class
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2015, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Search Form static.
 */
class cherry_slider_static extends cherry_register_static {

	/**
	 * Callback-method for registered static.
	 *
	 * @since 4.0.0
	 */
	public function callback() {
		//get_search_form( true );
		if( class_exists('Cherry_Slider_Data') ){
			$slider = new Cherry_Slider_Data;
			$slider->the_slider();
		}
	}
}

/**
 * Registration for Search Form static.
 */
new cherry_slider_static(
	array(
		'id'      => 'simple-slider',
		'name'    => __( 'Simple Slider', 'cherry' ),
		'options' => array(
			'col-lg'   => 'none',
			'col-md'   => 'none',
			'col-sm'   => 'none',
			'col-xs'   => 'none',
			'class'    => 'pull-left',
			'position' => 3,
			'area'     => 'header-top',
		)
	)
);