<?php


/**
* Clase base del plugin
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

    final public function menu_options()
    {
        add_theme_page('Opciones Pace', 'Pace', $this->user_capability,$this->menu_slug, array($this,'menu_options_view'));
    }

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
                    'id'       => 'color-base',
                    'title'    => 'Color Base',
                    'type'     => 'color',
                    'sanitize' => 'sanitize_hex_color',
/*                    'attrs' => array(
                        'class' => 'regular-text'
                    )*/
                ),
            )
        );
    }
}
new WPaceSettings();
?>