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

    //private $theme_color_text = ".pace .pace-progress, .pace .pace-activity{background:%s !important;}";

    private $theme_color_text = array(
        ".pace .pace-progress {background-color:{{color}};}",
        ".pace .pace-progress {background-color:{{color}};}.pace .pace-progress-inner {box-shadow: 0 0 10px {{color}}, 0 0 5px {{color}};}.pace .pace-activity{ border-top-color:{{color}};border-left-color:{{color}};}",
        ".pace .pace-progress:after {color: {{color}};}",
        ".pace .pace-activity {background-color: {{color}};}"
    );

    function __construct()
    {
        parent::__construct();
        $this->options = get_option($this->setting_name);
        add_action('wp_enqueue_scripts', array($this,'include_scripts'));
        add_action( 'admin_enqueue_scripts', array($this,'include_scripts_admin'));
        add_action('wp_head',  array($this,'style_hidden_all'));
    }

    final public function include_scripts()
    {
        wp_enqueue_style('wpace-pace', $this->get_pace_theme());
        wp_add_inline_style('wpace-pace', $this->get_color_pace_theme());
        wp_enqueue_script('wpace-pace','https://raw.githubusercontent.com/HubSpot/pace/v1.0.0/pace.min.js', '1.0.0', false );
        wp_enqueue_script('wpace-core', WPACE_URL . 'inc/js/wpace.js', array('jquery','wpace-pace'), '1.0.0', false );
    }

    final public function include_scripts_admin()
    {
        if(!!is_admin())
        {
            wp_enqueue_style('wp-color-picker');
            wp_enqueue_script('wpace-color', WPACE_URL.'inc/js/wpacecolor.js', array('wp-color-picker'),false,true);
        }
    }

    final public function style_hidden_all()
    {
        echo '<style id="wpace-hidden-all">html body > *:not(.pace):not(script):not(style){display: none;}</style>';
    }

    private function get_pace_theme()
    {
        return sprintf($this->url_theme_text,WPACE_URL,'inc/css/theme/',$this->theme_list[$this->options["tema-pace"]]);
    }

    private function get_color_pace_theme()
    {
        $text = '';
        $theme = $this->options["tema-pace"];
        $rbga = false;

        switch ($theme)
        {
            case 1:
                $text = $this->theme_color_text[1];
                break;

            case 6:
                if($theme==6)
                {
                    $rbga = '0.19999999999999996';
                }
                $text = $this->theme_color_text[2];
                break;

            case 7:
                $text = $this->theme_color_text[3];
                break;

            default:
                if($theme==4)
                {
                    $rbga = '0.19999999999999996';
                }
                $text = $this->theme_color_text[0];
                break;
        }

        $param = array("color" => $this->hex2rgb($this->options["color-base"],$rbga));

        return $this->mustache($text,$param);
    }

    private function mustache($text,$param)
    {
        foreach ($param as $key => $value) {
            $text =  preg_replace("/{{{$key}}}/", $value, $text);
        }
        return $text;
    }
    private function hex2rgb($hex,$rgba = false)
    {
        $text_rgb = 'rgb(%s,%s,%s)';
        $text_rgba = 'rgb(%s,%s,%s,%s)';
        $hex  = str_replace("#", "", $hex);
        $hex3 = strlen($hex) == 3;

        $r =hexdec(!!$hex3?substr($hex,0,1).substr($hex,0,1):substr($hex,0,2));
        $g =hexdec(!!$hex3?substr($hex,1,1).substr($hex,1,1):substr($hex,2,2));
        $b =hexdec(!!$hex3?substr($hex,2,1).substr($hex,2,1):substr($hex,4,2));

        return sprintf(!!$rgba?$text_rgba:$text_rgb,$r,$g,$b,$rgba);
    }
}
new WPace();
?>