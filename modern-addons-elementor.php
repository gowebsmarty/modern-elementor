<?php

/**
 *
 * Modern addons for Elementor page builder
 *
 * Plugin Name:       Modern Addons for Elementor
 * Plugin URI:        https://modernelementor.com
 * Description:       The last Elementor addon you need to create stunning premium design elements with Elementor page builder and pure CSS3 animations
 * Version:           1.1.2
 * Author:            Go Web Smarty
 * Author URI:        https://gowebsmarty.com
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       modern-addons-elementor
 * Domain Path:       /languages
 *
 * @author      Go Web Smarty
 * @category    Plugin
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 *
 */

//exit on direct access
defined('ABSPATH') || exit;

/**
 * Definitions
 */

define('MDEL_VERSION', '1.1.2');
define('MDEL_BASENAME', plugin_basename(__FILE__));
define('MDEL_NAME', 'Modern Addons Elementor');
define('MDEL_PATH', plugin_dir_path(__FILE__));
define('MDEL_URL', trailingslashit(plugin_dir_url(__FILE__)));
define('MDEL_SLUG', 'modern-addons-elementor');
define('MDEL_TX',  'modern-addons-elementor'); //textdomain

/**
 * Freemius integration
 * 
 * @since 1.0.1
 */
if (!function_exists('mdel_fs')) {

  function mdel_fs()
  {
    global $mdel_fs;

    if (!isset($mdel_fs)) {
      // Include Freemius SDK.
      require_once dirname(__FILE__) . '/freemius/start.php';

      $mdel_fs = fs_dynamic_init(array(
        'id'                  => '5795',
        'slug'                => 'modern-addons-elementor',
        'type'                => 'plugin',
        'public_key'          => 'pk_cd4ee6a9fefc45b614cb61db1a411',
        'is_premium'          => false,
        'has_addons'          => false,
        'has_paid_plans'      => false,
        'menu'                => array(
          'slug'           => 'modern-addons',
          'contact'        => false,
        ),
      ));
    }

    return $mdel_fs;
  }

  // Init Freemius.
  mdel_fs();

  // Signal that SDK was initiated.
  do_action('mdel_fs_loaded');
}

/**
 * Plugin Activator/Deactivator hooks
 * 
 * @since 1.0.0
 */

function mdel_activate()
{
  require_once plugin_dir_path(__FILE__) . 'inc/mdel-activator.php';
}

function mdel_deactivate()
{
  require_once MDEL_PATH . 'inc/mdel-deactivator.php';
}

register_activation_hook(__FILE__, 'mdel_activate');
register_deactivation_hook(__FILE__, 'mdel_deactivate');

/**
 * Welcome redirector
 *
 * @since 1.0.0
 * @param string $plugin
 * @return void
 */
// function mdel_activation_redirect($plugin)
// {
//   if ($plugin == plugin_basename(__FILE__)) {
//     exit(wp_redirect(admin_url('admin.php?page=modern-addons')));
//   }
// }
///add_action('activated_plugin', 'mdel_activation_redirect');

/**
 * Sets review flag to show review request
 * 
 * @since 1.0.1
 */
add_action('mdel_show_reviewrequest', 'mdel_set_review_flag');

if (!function_exists('mdel_set_review_flag')) {
  function mdel_set_review_flag()
  {
    update_option('mdel_show_review', 1);
  }
}


if (function_exists('mdel_fs') && !function_exists('mdel_fs_custom_connect_message')) {
  /**
   * Opt-in custom message
   *
   * @since 1.1.1
   * @param string $message
   * @return void
   */
  function mdel_fs_custom_connect_message($message)
  {
    $current_user = wp_get_current_user();

    return sprintf(
      esc_html__('Howdy %1$s') . ',<br>' .
        __('We <b>HIGHLY</b> recommend to Opt-in to get BEST support!. Never miss an important update - opt in to our security & feature updates notifications, and non-sensitive diagnostic tracking with <a href="https://freemius.com/wordpress/usage-tracking/5795/modern-addons-elementor/" target="_blank">Freemius</a>. If you skip this, that\'s okay! <b>Modern Addons</b> will still work just fine.', 'modern-addons-elementor'),
      ucfirst($current_user->user_nicename)
    );
  }

  mdel_fs()->add_filter('connect_message', 'mdel_fs_custom_connect_message');
}

/**
 * Core file responsible for everything
 * 
 * @since 1.0.0
 */

add_action('plugins_loaded', function () {
  require_once MDEL_PATH . 'classes/mdel-core.php';
}, 1);
