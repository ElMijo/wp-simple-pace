<?php


/**
* Clase base del plugin
*/
class WPace extends WPaceSettings
{

    private $theme_list = array(
        'minimal',
        'flash',
        'barbershop',
        'macosx',
        'fillleft',
        'flattop',
        'bigcounter',
        'cornerindicator',
        'bounce',
        'loadingbar',
        'centercircle',
        'centeratom',
        'centerradar',
        'centersimple'
    );

    private $url_theme_text = "%s%s%s.css";

    private $theme_color_text = ".pace .pace-progress, .pace .pace-activity{background:%s !important;}";

    function __construct()
    {
        parent::__construct();
        $this->options = get_option($this->setting_name);
        add_action('wp_enqueue_scripts', array($this,'include_scripts'));
        add_action( 'admin_enqueue_scripts', array($this,'include_scripts_admin'));
    }

    final public function include_scripts()
    {

        wp_enqueue_style('wpace-pace', $this->get_pace_theme());
        wp_add_inline_style('wpace-pace', "html body > *:not(.pace):not(script):not(style){display: none;}");
        wp_add_inline_style('wpace-pace', sprintf($this->theme_color_text,$this->options["color-base"]));
        wp_enqueue_script( 'wpace-pace','https://raw.githubusercontent.com/HubSpot/pace/v1.0.0/pace.min.js', '1.0.0', false );
        wp_enqueue_script( 'wpace-core', WPACE_URL . 'inc/js/wpace.js', array('jquery','wpace-pace'), '1.0.0', false );
    }

    final public function include_scripts_admin()
    {
        if(!!is_admin())
        {
            wp_enqueue_style('wp-color-picker');
            wp_enqueue_script('wpace-color', WPACE_URL.'inc/js/wpacecolor.js', array('wp-color-picker'),false,true);
        }
    }

    private function get_pace_theme()
    {
        return sprintf($this->url_theme_text,WPACE_URL,'inc/css/theme/',$this->theme_list[$this->options["tema-pace"]]);
    }

    private function get_color_pace_theme()
    {
        $this->options["color-base"];
    }
}
new WPace();
?>