<?php

defined('ABSPATH') || exit;

use \ModernAddonsElementor\Inc\MDEL_Admin;
use \ModernAddonsElementor\Utils\MDEL_Helpers;

/**
 * Initiate all necessary classes, hooks, configs.
 *
 * @since 1.0.0
 */
class MDEL_Starter
{

  /**
   * The plugin instance.
   *
   * @since 1.0.0
   * @access public
   * @static
   *
   * @var Starter
   */
  public static $instance = null;

  private $opts, $activewidgets;

  /**
   * Construct the plugin object.
   *
   * @since 1.0.0
   * @access public
   */
  public function __construct()
  {
    //Register class autoloader
    $this->registrar_autoloader();

    // Enqueue frontend scripts.
    add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend']);

    // Enqueue admin scripts.
    add_action('admin_enqueue_scripts', [$this, 'enqueue_admin']);
    add_action('elementor/editor/after_enqueue_scripts', [$this, 'enqueue_admin']);

    // Register widgets
    add_action('elementor/widgets/widgets_registered', [$this, 'register_widgets']);

    // Register Widget Styles
    add_action('elementor/frontend/after_enqueue_styles', [$this, 'widget_styles']);

    //Register menu page
    add_action('admin_menu', [$this, 'mdel_settings_page']);

    //Review request
    add_action('admin_notices', [$this, 'mdel_request_review']);
    add_action('admin_init', [$this, 'mdel_review_handler']);

    $getopts = get_option('mdel_opts');
    $this->opts = (FALSE != $getopts) ? $getopts : array();

    $this->activewidgets = isset($this->opts['enabledwidgets']) ? (empty($this->opts['enabledwidgets']) ? array_map('strtolower', MDEL_Helpers::widgets_list()) : $this->opts['enabledwidgets']) : array_map('strtolower', MDEL_Helpers::widgets_list());
  }

  public function mdel_settings_page()
  {
    MDEL_Admin::instance()->register_admin_page();
  }

  /**
   * Enqueue scripts
   *
   * Enqueue js and css to frontend.
   *
   * @since 1.0.0
   * @access public
   */
  public function enqueue_frontend()
  {
    if (in_array('beforeafter', $this->activewidgets)) {
      wp_enqueue_style('MDEL-before-after-css', MDEL_URL . 'assets/lib/css/before-after.min.css');
      wp_enqueue_script('MDEL-before-after-js', MDEL_URL . 'assets/lib/js/before-after.min.js', array('jquery'), MDEL_VERSION, TRUE);
    }

    if (in_array('testimonials', $this->activewidgets)) {
      wp_enqueue_style('MDEL-bxslider-css', MDEL_URL . 'assets/lib/css/jquery.bxslider.min.css');
      wp_enqueue_script('MDEL-bxslider-js', MDEL_URL . 'assets/lib/js/jquery.bxslider.min.js', array('jquery'), MDEL_VERSION, TRUE);
    }

    if (in_array('tabs', $this->activewidgets)) {
      wp_enqueue_script("jquery-ui-tabs");
    }

    if (in_array('accordion', $this->activewidgets)) {
      wp_enqueue_script("jquery-ui-accordion");
    }

    if (in_array('tabs', $this->activewidgets) || in_array('accordion', $this->activewidgets)) {
      wp_enqueue_style('mdel-ui-theme', MDEL_URL . 'assets/lib/css/jquery-ui.min.css', FALSE, MDEL_VERSION, 'all');
    }

    wp_enqueue_script('MDEL-custom-js', MDEL_URL . 'assets/js/mdel-custom.js', array('jquery'), MDEL_VERSION, TRUE);
  }

  /**
   * Enqueue scripts
   *
   * Enqueue custom js and css to admin.
   *
   * @since 1.0.0
   * @access public
   */
  public function enqueue_admin()
  {
    wp_enqueue_style('mdel-admin-css', MDEL_URL . 'assets/css/mdel-admin.css', FALSE, MDEL_VERSION);
    wp_enqueue_script('mdel-admin-js', MDEL_URL . 'assets/js/mdel-admin.js', array('jquery'), MDEL_VERSION, true);
  }

  /**
   * Widget registrar.
   *
   * Retrieve all the registered widgets
   * using `elementor/widgets/widgets_registered` action.
   *
   * @since 1.0.0
   * @access public
   */
  public function register_widgets($widgets_manager)
  {
    foreach (MDEL_Helpers::widgets_list() as $element) {
      if (in_array(strtolower($element), $this->activewidgets)) { //If widget enabled by user
        $widgetclass = '\ModernAddonsElementor\Widgets\\' . $element . '\MDEL_' . $element;

        if (class_exists($widgetclass)) {
          \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new $widgetclass());
        }
      }
    }
  }

  /**
   * Global CSS file enqueue for Frontend
   *
   * @return void
   */
  public function widget_styles()
  {
    wp_enqueue_style('modernAddons', plugins_url('/assets/css/global.min.css', __FILE__), FALSE, MDEL_VERSION, 'all');
  }

  /**
   * Autoloader.
   *
   * @since 1.0.0
   * @access private
   */
  private function registrar_autoloader()
  {
    require_once plugin_dir_path(__FILE__) . 'autoloader.php';

    \ModernAddonsElementor\Autoloader::run();
  }


  /**
   * Disable class cloning and throw an error on object clone.
   *
   * The whole idea of the singleton design pattern is that there is a single
   * object. Therefore, we don't want the object to be cloned.
   *
   * @access public
   * @since 1.0.0
   */
  public function __clone()
  {
    _doing_it_wrong(__FUNCTION__, esc_html__('Cloning is forbidden.', 'modern-addons-elementor'), '1.0.0');
  }


  /**
   * Disable unserializing of the class.
   *
   * @access public
   * @since 1.0.0
   */
  public function __wakeup()
  {
    _doing_it_wrong(__FUNCTION__, esc_html__('Unserializing instances of this class is forbidden.', 'modern-addons-elementor'), '1.0.0');
  }


  /**
   * Singleton Instance.
   *
   * Ensures only one instance of the plugin class is loaded or can be loaded.
   *
   * @since 1.0.0
   * @access public
   * @static
   *
   * @return Handler An instance of the class.
   */
  public static function instance()
  {
    if (is_null(self::$instance)) {

      self::$instance = new self();

      do_action('modernaddons/loaded');
    }

    return self::$instance;
  }

  /**
   * Request review on admin side
   *
   * @since 1.0.1
   * @return void
   */
  public function mdel_request_review()
  {

    $showflag = get_option('mdel_show_review');
    $already_did = wp_nonce_url(admin_url('admin.php?page=modern-addons'), 'mdel_reviewed', 'mdelrated');
    $remind_later = wp_nonce_url(admin_url('admin.php?page=modern-addons'), 'mdel_review_later', 'mdellater');

    $html = '<div class="notice notice-info mdel-admin-review">
      <div class="mdel-review-box">
        <img src="' . MDEL_URL . 'assets/img/mini-icon.png"/>
        <p>Looks like you are having fun using <b>Modern addons for Elementor</b> plugin. Can you please take a moment to rate us with 5 star review and boost our motivation to build more & more unique elements.</p>
      </div>
      <a class="mdel-lets-review mdelrevbtn" href="https://wordpress.org/support/plugin/modern-addons-elementor/reviews/#new-post" rel="nofollow" target="_blank">Rate plugin</a>
      <a class="mdel-did-review mdelrevbtn" href="' . $already_did . '" rel="nofollow">I already did</a>
      <a class="mdel-later-review mdelrevbtn" href="' . $remind_later . '" rel="nofollow">Remind me later</a>
    </div>';

    if (FALSE != $showflag && $showflag == 1) {
      echo $html;
    }
  }

  /**
   * Handles review box actions
   *
   * @since 1.0.1
   * @return void
   */
  public function mdel_review_handler()
  {

    if (isset($_GET['mdelrated'])) {

      if (!wp_verify_nonce($_GET['mdelrated'], 'mdel_reviewed')) {
        wp_die('Unauthorized request');
      }

      delete_option('mdel_show_review');
    } else if (isset($_GET['mdellater'])) {

      if (!wp_verify_nonce($_GET['mdellater'], 'mdel_review_later')) {
        wp_die('Unauthorized request');
      }

      delete_option('mdel_show_review');
      wp_schedule_single_event(strtotime('+3 day', time()), 'mdel_show_reviewrequest');
    }
  }
}

// Initiate the instance.
MDEL_Starter::instance();
