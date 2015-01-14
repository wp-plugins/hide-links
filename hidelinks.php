<?php
/* ==========================================================================
 * Plugin Name: Hide Links
 * Plugin URI: http://avovkdesign.com/hidelinks-plugin.html
 * Description: Скрытие внешних ссылок с помощью JavaScript. <strong>Добавляет шоткод <code>[link]</code> и скрывает ссылки авторов комментариев</strong>.
 * Version: 1.0
 * Author: Alexandra Vovk
 * Author URI: http://avovkdesign.com/
 * License: GPLv2 or later
 * Text Domain: hidelinks
 * ========================================================================== */

/*  Copyright 2014  ALEXANDRA VOVK  (email : avovkdesign@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


require_once( plugin_dir_path( __FILE__ ) . 'class.hidelinks.php' );
add_action( 'init', array( 'Hidelinks', 'init' ) );

