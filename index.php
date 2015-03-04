<?php
/**
 * Plugin Name: Wordpress Pace
 * Plugin URI: http://git.mppi.gob.ve/janselmi/wp-servicios-intranet
 * Description: Este plugin permitira agregar el efecto de page load a cualquier plantilla
 * Author: jerry Anselmi <janselmi@mppi.gob.ve>
 * License: MIT
 * Version: 1.0
 * Text Domain: wpace
 */

define('WPACE_DIR', dirname(__FILE__));
define('WPACE_URL', plugin_dir_url(__FILE__));

/*function themeslug_header_hook( $name )
{
    //var_dump($name);
}
add_action( 'get_header', 'themeslug_header_hook' );*/

/*add_filter( 'the_content', 'portfolio_page_template', 99 );

function portfolio_page_template( $template )
{
 var_dump($template);
    if ( is_page( 'portfolio' )  ) {
        $new_template = locate_template( array( 'portfolio-page-template.php' ) );
        if ( '' != $new_template ) {
            return $new_template ;
        }
    }

    var_dump("wwwww");exit;
    return $template;
}*/
/*function my_function() {
?>
     <div id="from_my_function"></div>
<?php
}
add_action('wp_head', 'my_function');*/
?>