<?php


/**
* Clase base del plugin
*/
class WPaceOptions
{
    function __construct()
    {
        add_action('admin_menu', array($this,'menu_options'));
    }

    final public function menu_options()
    {
        add_theme_page('Opciones Pace', 'Pace', 'edit_theme_options','wp-simple-pace', array($this,'menu_options_view'));
    }

    final public function menu_options_view()
    {
        $titulo = get_admin_page_title();

        include WPACE_DIR.'/inc/template/options.phtml';
    }
}
new WPaceOptions();
?>