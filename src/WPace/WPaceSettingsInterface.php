<?php
/**
 * Contiene la interfaz necesaria para crear las opciones en wordpress
 *
 * @author Jerry Anselmi <jerry.anselmi@gmail.com>
 * @copyright 2015 Jerry Anselmi
 * @license MIT
 * @package WPace
 * @version 1.0
 */

/**
 * Clase que contiene la interfaz de las opciones
 */
interface WPaceSettingsInterface
{
    /**
     * Metodo que devuelve un arreglo de ajustes
     * @return array
     */
    public function get_settings();
}