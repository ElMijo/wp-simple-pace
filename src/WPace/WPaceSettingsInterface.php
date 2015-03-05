<?php
/**
 * Clase que contiene la estructura base de los ajustes
 */
interface WPaceSettingsInterface
{
    /**
     * Metodo que devuelve un arreglo de ajustes
     * @return array
     */
    public function get_settings();
}