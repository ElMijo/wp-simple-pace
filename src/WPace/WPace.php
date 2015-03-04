<?php


/**
* Clase base del plugin
*/
class WPace
{

    function __construct()
    {
        add_action('wp_enqueue_scripts', array($this,'include_scripts'));
    }

    final public function include_scripts()
    {
        wp_enqueue_style( 'wpace-pace', WPACE_URL.'inc/js/pace/pace.css' );
        wp_add_inline_style('wpace-pace', "html body > *:not(.pace):not(script):not(style){display: none;}");
        wp_enqueue_script( 'wpace-pace','https://raw.githubusercontent.com/HubSpot/pace/v1.0.0/pace.min.js', '1.0.0', false );
        wp_enqueue_script( 'wpace-core', WPACE_URL . 'inc/js/wpace.js', array('jquery','wpace-pace'), '1.0.0', false );
    }
}
new WPace();
?>