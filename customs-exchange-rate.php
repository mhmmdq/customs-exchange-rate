<?php
/**
 * @package customs exchange rate
 * @author mhmmdq <mhmmdq@mhmmdq.ir>
 * @license MIT
 * @link https://github.com/mhmmdq/customs-exchange-rate
 * @version 0.1.0
 */
/*
Plugin Name: نرخ ارز گمرکی
Plugin URI: https://github.com/mhmmdq/customs-exchange-rate
Description: افزونه ای برای نمایش نرخ ارزهای گمرکی
Author: Mhmmdq
Version: 0.1.0
Author URI: https://mhmmdq.ir
*/



define('CER_VERSION' , '0.1.0');
define("CER_PLUGIN_PATH" , __DIR__ . '/');
define('CER_PLUGIN_URL' , plugins_url('/' , CER_PLUGIN_PATH));
define('CER_BASENAME' , plugin_basename(CER_PLUGIN_PATH));
define("CER_ASSETS_URL" , CER_PLUGIN_URL . 'asstes/');

if(!file_exists(CER_PLUGIN_PATH . 'vendor/autoload.php'))
    die('Please install the dependency');

    require_once CER_PLUGIN_PATH . 'vendor/autoload.php';


add_action('admin_notices' , 'cer_wellcome_message');

function cer_wellcome_message() {
    $message = 'ارز های گمرکی در وبسایت شما هر روز یک بار در اول بازدید بروز خواهند شد';
	$html_message = sprintf( '<div class="notice" style="padding:10px;"> %s </div>', $message);
	echo $html_message;
}


new \Mhmmdq\Wordpress\Cer\Scraper;
new \Mhmmdq\Wordpress\Cer\ElementorWidgets;