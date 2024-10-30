<?php
/*

Copyright 2008 MagicToolbox (email : support@magictoolbox.com)
Plugin Name: Magic Touch
Plugin URI: http://www.magictoolbox.com/magictouch/
Description: Magic Touch<sup>&#8482;</sup> lets you zoom into images to inspect them in perfect detail. Try out some <a target="_blank" href="http://www.magictoolbox.com/magictouch_integration/">customisation options</a>.
Version: 5.11.12
Author: MagicToolbox
Author URI: http://www.magictoolbox.com/

*/

/*
    WARNING: DO NOT MODIFY THIS FILE!

    NOTE: If you want change Magic Touch settings
            please go to plugin page
            and click 'Magic Touch Configuration' link in top navigation sub-menu.
*/

if(!function_exists('magictoolbox_WordPress_MagicTouch_init')) {
    /* Include MagicToolbox plugins core funtions */
    require_once(dirname(__FILE__)."/magictouch/plugin.php");
}

//MagicToolboxPluginInit_WordPress_MagicTouch ();
register_activation_hook( __FILE__, 'WordPress_MagicTouch_activate');

register_deactivation_hook( __FILE__, 'WordPress_MagicTouch_deactivate');

magictoolbox_WordPress_MagicTouch_init();
?>