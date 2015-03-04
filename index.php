<?php
/**
 * Plugin Name: Wordpress Simple Pace
 * Plugin URI: http://git.mppi.gob.ve/janselmi/wp-servicios-intranet
 * Description: Este plugin permitira agregar el efecto de page load a cualquier plantilla
 * Author: jerry Anselmi <janselmi@mppi.gob.ve>
 * License: MIT
 * Version: 1.0
 * Text Domain: wpace
 */

define('WPACE_DIR', dirname(__FILE__));
define('WPACE_URL', plugin_dir_url(__FILE__));


include_once WPACE_DIR.'/src/WPace/WPace.php';
include_once WPACE_DIR.'/src/WPace/WPaceOptions.php';

?>