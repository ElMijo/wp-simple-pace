<?php
/**
 * Contiene la clase para crear las opciones del plugin
 *
 * @author Jerry Anselmi <jerry.anselmi@gmail.com>
 * @copyright 2015 Jerry Anselmi
 * @license MIT
 * @package WPace
 * @version 1.0
 */

/**
* Clase que contiene las opciones del plugin
*/
class WPaceSettings  extends WPaceSettingsFactory  implements WPaceSettingsInterface
{

    /**
     * slug del plugin
     * @var string
     */
    protected $menu_slug = 'wp-simple-pace';

    /**
     * capability de los roles de usuario
     * @var string
     */
    private $user_capability = 'edit_theme_options';

    /**
     * capability para los roles administrativos
     * @var string
     */
    private $admin_capability = 'manage_options';

    function __construct()
    {
        parent::__construct();
        add_action('admin_menu', array($this,'menu_options'));
    }

    /**
     * Metodo que permite registrar el submenu el plugin
     * @return void
     */
    final public function menu_options()
    {
        add_theme_page(__('Pace Opciones',WPACE_DOMAIN), 'Pace', $this->user_capability,$this->menu_slug, array($this,'menu_options_view'));
    }

    /**
     * Metodo que se encarga de imprimir la vista del sub menu
     * @return void
     */
    final public function menu_options_view()
    {
        $titulo = get_admin_page_title();

        include WPACE_DIR.'/inc/template/options.phtml';
    }
    /**
     * @see ServiciosIntranetAjustesInterface::get_settings
     */
    public function get_settings()
    {
        return array(
            'estilo' => array(
                array(
                    'id'    => 'color-base',
                    'title' => __('Color Base',WPACE_DOMAIN),
                    'type'  => 'color'
                ),
                array(
                    'id'    => 'tema-pace',
                    'title' => __('Tema',WPACE_DOMAIN),
                    'type'  => 'select',
                    'list'  => array(
                        'Minimal',
                        'Flash',
                        'Barber Shop',
                        'Mac OSX',
                        'Fill Left',
                        'Flat Top',
                        'Big Counter',
                        'Corner Indicator',
                        'Bounce',
                        'Loading Bar',
                        'Center Circle',
                        'Center Atom',
                        'Center Radar',
                        'Center Simple'
                    )
                ),
            )
        );
    }
}
?>