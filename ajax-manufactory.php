<?php

/*
Plugin Name: AJAX Manufactury
Plugin URI: http://e-wm.org/ajax-manufactory/
Description: Really simple-to-use library which moves Wordpress AJAX usability to the new level
Version: 1.5.2.7
Author: Epsilon Web Manufactory
Author URI: http://e-wm.org/
License: GPL3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Copyright: Epsilon Web Manufactory
Text Domain: wpjxm_lang
Domain Path: /lang/
*/

/*  Copyright 2013-2016 Epsilon Web Manufactory
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *  @copyright 2013-2016
 *  @license GPL v3
 *  @version 1.5.2.7
 *  @package AJAX Manufactory
 *  @author Epsilon Web Manufactory
 */

define('JX_VERSION', '1.5.2.7');

register_activation_hook(__FILE__, 'wpjxm_activate_plugin');
register_deactivation_hook(__FILE__, 'wpjxm_deactivate_plugin');

function wpjxm_activate_plugin() {
	if(!function_exists('register_post_status')) {
		deactivate_plugins(basename(dirname( __FILE__ )).'/'.basename (__FILE__));
		wp_die( __( "This plugin requires WordPress 3.0 or newer. Please update your WordPress installation to activate this plugin.", 'wpjxm_lang' ));
	}
}

function wpjxm_deactivate_plugin() {
}

add_action('init', 'wpjxm_init');
function wpjxm_init() {
	wp_enqueue_script('wpjxm_script', plugins_url('js/jx.js', __FILE__), array('jquery'), JX_VERSION);
	add_filter('plugin_row_meta', 'wpjxm_plugin_links', 10, 2);
	
	add_action('wp_ajax_nopriv_wpjxm_action', 'wpjxm_action_ajax_0');
	add_action('wp_ajax_wpjxm_action', 'wpjxm_action_ajax_1');
}

function wpjxm_plugin_links($links, $file) {
	if (basename($file) == basename(__FILE__)) {
		$links[] = '<a href="http://e-wm.org/ajax-manufactory/#documentation" target="_blank">'.__('Documentation', 'wpjxm_lang').'</a>';
	}
	return $links;
}

add_action('wp_enqueue_scripts', 'wpjxm_custom_js');
add_action('admin_head', 'wpjxm_custom_js');
function wpjxm_custom_js() {
	?><script type="text/javascript">
		var wpjxm_ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
		var wpjxm_action = "wpjxm_action";
	</script><?php
}

add_action('plugins_loaded', 'wpjxm_load_plugin_textdomain');
function wpjxm_load_plugin_textdomain() {
	load_plugin_textdomain( 'wpjxm_lang', false, dirname(plugin_basename(__FILE__)).'/lang/');
}
function wpjxm_action_ajax($has_priv = false) {
	$jx = new wpjxmResponse();
	$jx->has_priv = $has_priv;
	if (($data = $jx->getData()) !== false) {
		if (isset($data['jx_action'])) {
			
			do_action('jx_'.$data['jx_action'], $jx, $data);
			
			echo $jx->getJSON();
			exit();
		}
	}
}
function wpjxm_action_ajax_0() {
	wpjxm_action_ajax(false);
}
function wpjxm_action_ajax_1() {
	wpjxm_action_ajax(true);
}

if (!class_exists('wpjxmResponse')) {
class wpjxmResponse {
	
	public $data = array();
	public $has_priv = false;
	
	protected $xresponse = array();
	
	function console($msg) {
		$this->xresponse[] = array('cn', $msg);
	}
	
	function alert($msg) {
		$this->xresponse[] = array('al', $msg);
	}

	function html($id, $data) {
		$this->xresponse[] = array('as', $id, $data);
	}
	
	function redirect($url = '', $delay = 0) {
		$this->xresponse[] = array('rd', $url, $delay);
	}
	
	function reload(){
		$this->xresponse[] = array('rl');
	}
	
	function script($script = '') {
		$this->xresponse[] = array('js', $script);
	}
	
	function call($function_name, $params = array()) {
		$this->xresponse[] = array('cl', $function_name, $params);
	}
	
	function variable($var, $value) {
		$this->xresponse[] = array('vr', $var, $value);
	}
	
	function setResponse($a) {
		$this->xresponse = $a;
	}
	
	function getJSON() {
		return json_encode($this->xresponse);
	}
	
	function getData() {
		if ((isset($_POST['__xr'])) && ($_POST['__xr'] == 1)) {
			$post = isset($_POST['z']) ? json_decode(stripslashes($_POST['z']), true) : array();
			$this->data = $post;
			return $post;
		} else {
			return false;
		}
	}
}
}
