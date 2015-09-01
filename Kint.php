<?php
/**
 * Yiint is a extension for using the Kint debugging tool
 *
 * https://github.com/raveren/kint
 */

Yii::import( 'application.extensions.Kint.KintBase' );

class Kint extends KintBase
{
  public function init()
  {
    if ( is_readable( KINT_DIR . 'config.php' ) ) {
    	require KINT_DIR . 'config.php';
    }

    # init settings
    if ( !empty( $GLOBALS['_kint_settings'] ) ) {
    	KintBase::enabled( $GLOBALS['_kint_settings']['enabled'] );

    	foreach ( $GLOBALS['_kint_settings'] as $key => $val ) {
    		property_exists( 'Kint', $key ) and KintBase::$$key = $val;
    	}

    	unset( $GLOBALS['_kint_settings'], $key, $val );
    }

    if ( !function_exists( 'd' ) ) {
    	/**
    	 * Alias of KintBase::dump()
    	 *
    	 * @return string
    	 */
    	function d()
    	{
    		if ( !KintBase::enabled() ) return '';
    		$_ = func_get_args();
    		return call_user_func_array( array( 'Kint', 'dump' ), $_ );
    	}
    }

    if ( !function_exists( 'dd' ) ) {
    	/**
    	 * Alias of KintBase::dump()
    	 * [!!!] IMPORTANT: execution will halt after call to this function
    	 *
    	 * @return string
    	 * @deprecated
    	 */
    	function dd()
    	{
    		if ( !KintBase::enabled() ) return '';

    		echo "<pre>Kint: dd() is being deprecated, please use ddd() instead</pre>\n";
    		$_ = func_get_args();
    		call_user_func_array( array( 'Kint', 'dump' ), $_ );
    		die;
    	}
    }

    if ( !function_exists( 'ddd' ) ) {
    	/**
    	 * Alias of KintBase::dump()
    	 * [!!!] IMPORTANT: execution will halt after call to this function
    	 *
    	 * @return string
    	 */
    	function ddd()
    	{
    		if ( !KintBase::enabled() ) return '';
    		$_ = func_get_args();
    		call_user_func_array( array( 'Kint', 'dump' ), $_ );
    		die;
    	}
    }

    if ( !function_exists( 's' ) ) {
    	/**
    	 * Alias of KintBase::dump(), however the output is in plain htmlescaped text and some minor visibility enhancements
    	 * added. If run in CLI mode, output is pure whitespace.
    	 *
    	 * To force rendering mode without autodetecting anything:
    	 *
    	 *  KintBase::enabled( KintBase::MODE_PLAIN );
    	 *  KintBase::dump( $variable );
    	 *
    	 * [!!!] IMPORTANT: execution will halt after call to this function
    	 *
    	 * @return string
    	 */
    	function s()
    	{
    		$enabled = KintBase::enabled();
    		if ( !$enabled ) return '';

    		if ( $enabled === KintBase::MODE_WHITESPACE ) { # if already in whitespace, don't elevate to plain
    			$restoreMode = KintBase::MODE_WHITESPACE;
    		} else {
    			$restoreMode = KintBase::enabled( # remove cli colors in cli mode; remove rich interface in HTML mode
    				PHP_SAPI === 'cli' ? KintBase::MODE_WHITESPACE : KintBase::MODE_PLAIN
    			);
    		}

    		$params = func_get_args();
    		$dump   = call_user_func_array( array( 'Kint', 'dump' ), $params );
    		KintBase::enabled( $restoreMode );
    		return $dump;
    	}
    }

    if ( !function_exists( 'sd' ) ) {
    	/**
    	 * @see s()
    	 *
    	 * [!!!] IMPORTANT: execution will halt after call to this function
    	 *
    	 * @return string
    	 */
    	function sd()
    	{
    		$enabled = KintBase::enabled();
    		if ( !$enabled ) return '';

    		if ( $enabled !== KintBase::MODE_WHITESPACE ) {
    			KintBase::enabled(
    				PHP_SAPI === 'cli' ? KintBase::MODE_WHITESPACE : KintBase::MODE_PLAIN
    			);
    		}

    		$params = func_get_args();
    		call_user_func_array( array( 'Kint', 'dump' ), $params );
    		die;
    	}
    }
  }
}
