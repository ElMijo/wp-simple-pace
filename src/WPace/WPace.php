<?php
/**
 * Contiene la clase base del plugin
 *
 * @author Jerry Anselmi <jerry.anselmi@gmail.com>
 * @copyright 2015 Jerry Anselmi
 * @license MIT
 * @package WPace
 * @version 1.0
 */

/**
* Clase base del plugin
*/
class WPace extends WPaceSettings
{
    /**
     * Arreglo con los temas que se manejan actualmente.
     * @var array
     */
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

    /**
     * Arreglo con los distintos selectores css que se deben aplicar para darle color al PACE
     * @var array
     */
    private $theme_color_text = array(
        ".pace .pace-progress {background-color:{{color}};}",
        ".pace .pace-progress {background-color:{{color}};}.pace .pace-progress-inner {box-shadow: 0 0 10px {{color}}, 0 0 5px {{color}};}.pace .pace-activity{ border-top-color:{{color}};border-left-color:{{color}};}",
        ".pace .pace-progress:after {color: {{color}};}",
        ".pace .pace-activity {background-color: {{color}};}",
        ".pace .pace-progress {background-color: {{color}};color: {{color}};}.pace .pace-activity {box-shadow: inset 0 0 0 2px {{color}}, inset 0 0 0 7px #FFF;}",
        ".pace .pace-progress:before {background: {{color}};}.pace .pace-activity {border: 5px solid {{color}};}.pace .pace-activity:after {border: 5px solid {{color}};}.pace .pace-activity:before {border: 5px solid {{color}};}",
        ".pace .pace-activity {border-color: {{color}} transparent transparent;}.pace .pace-activity:before {border-color: {{color}} transparent transparent;}",
        ".pace {border: 1px solid {{color}};}.pace .pace-progress {background: {{color}};}"
    );

    function __construct()
    {
        parent::__construct();
        $this->options = get_option($this->setting_name);
        add_action('wp_enqueue_scripts', array($this,'include_scripts'));
        add_action( 'admin_enqueue_scripts', array($this,'include_scripts_admin'));
        add_action('wp_head',  array($this,'style_hidden_all'));
    }

    /**
     * Metodo que permite incluir los archivos css y javascript necesarios para la ejecución del PACE en el Front End.
     * @return void
     */
    final public function include_scripts()
    {
        wp_enqueue_style('wpace-pace', $this->get_pace_theme());
        wp_add_inline_style('wpace-pace', $this->get_color_pace_theme());
        wp_enqueue_script('wpace-pace', WPACE_URL . 'inc/js/pace.js', '1.0.0', false );
        wp_enqueue_script('wpace-core', WPACE_URL . 'inc/js/wpace.js', array('jquery','wpace-pace'), '1.0.0', false );
    }

    /**
     * Metodo que permite incluir los archivos css y javascript para el funcionamiento del plugin en el area administrativa.
     * @return void
     */
    final public function include_scripts_admin()
    {
        if(!!is_admin())
        {
            wp_enqueue_style('wp-color-picker');
            wp_enqueue_script('wpace-color', WPACE_URL.'inc/js/wpacecolor.js', array('wp-color-picker'),false,true);
        }
    }

    /**
     * Metodo que permite agregar el css necesario para esconder todos los elementos para la ejecución del PACE
     * @return void
     */
    final public function style_hidden_all()
    {
        echo '<style id="wpace-hidden-all">html body > *:not(.pace):not(script):not(style){display: none;}</style>';
    }

    /**
     * Metodo que devuelve la url del tema PACE que se debe aplicar
     * @return string     Cadena d etexto con formato url.
     */
    private function get_pace_theme()
    {
        return sprintf("%s%s%s.css",WPACE_URL,'inc/css/theme/',$this->theme_list[$this->options["tema-pace"]]);
    }

    /**
     * Este metodo permite obtener el color que se aplicara al tema PACE
     * @return string     Devuelve la cadena d etexto con los parametros css necesarios para aplicar el color al tema PACE
     */
    private function get_color_pace_theme()
    {
        $text = '';
        $theme = $this->options["tema-pace"];
        $rgba = $theme==4||$theme==6?'0.19999999999999996':($theme==10?'0.8':false);

        switch ($theme)
        {
            case 1:
                $text = $this->theme_color_text[1];
                break;
            case 6:
                $text = $this->theme_color_text[2];
                break;
            case 7:case 8:
                $text = $this->theme_color_text[3];
                break;
            case 9:
                $text = $this->theme_color_text[4];
                break;
            case 11:
                $text = $this->theme_color_text[5];
                break;
            case 12:
                $text = $this->theme_color_text[6];
                break;
            case 13:
                $text = $this->theme_color_text[7];
                break;
            default:
                $text = $this->theme_color_text[0];
                break;
        }

        $param = array("color" => $this->hex2rgb($this->options["color-base"],$rgba));

        return $this->mustache($text,$param);
    }

    /**
     * Este metodo permite unir un texto pre formateado, con el arreglo de parametros
     * @param  string $text  Cadena de texto pre formateada
     * @param  array  $param Arreglo con los parametros que queremos agregar a la cadena pre formateada
     * @return string        Cadena de texto procesada.
     */
    private function mustache($text,$param)
    {
        foreach ($param as $key => $value) {
            $text =  preg_replace("/{{{$key}}}/", $value, $text);
        }
        return $text;
    }

    /**
     * Este metodo permite convertir un color hexadecimal en rgb o rgba
     * @param  string  $hex  Color hexadecimal a convertir
     * @param  boolean $rgba Si se pasa algun valor el metodo asumira que es el valor alpha del rgb
     * @return string        Devuelve una cadena de texto con formato de color rgb o rgba
     */
    private function hex2rgb($hex,$rgba = false)
    {
        $text_rgb = 'rgb(%s,%s,%s)';
        $text_rgba = 'rgba(%s,%s,%s,%s)';
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