<?php
/*
Plugin Name: Matt's Example Code
Plugin URI:
Description: Add-on for Gravity Forms to send form data to xxxxxxx
Author: Matt
Author URI:
Version: 1.3
*/

define( 'EXAMPLE_CODE_ADDON_VERSION', '1.3' );

add_action( 'gform_loaded', array( 'Example_Code_GF_Addon', 'load' ), 5 );

class Example_code_GF_Addon {
    public static function load() {
        if ( ! method_exists( 'GFForms', 'include_addon_framework' ) ) {
            return;
        }
        require_once( 'class-example_code.php' );
        GFAddOn::register( 'GFExamplecode' );
    }
}