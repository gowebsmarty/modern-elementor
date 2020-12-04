<?php

namespace ModernAddonsElementor\Inc;

if (!defined('ABSPATH')) {
  exit();
}

use \ModernAddonsElementor\Utils\MDEL_Helpers;

/**
 * Class responsible for all admin side tasks
 * 
 * @since 1.0.0
 */
class MDEL_Admin
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

  /**
   * Admin hooks
   * 
   * @since 1.0.0
   */
  public function __construct()
  {
    add_action('admin_init', [$this, 'mdel_save_settings']);
  }

  /**
   * Register admin side menu page
   *
   * @since 1.0.0
   * @return void
   */
  public function register_admin_page()
  {
    add_menu_page('Modern Addons', 'Modern Addons', 'manage_options', 'modern-addons', [$this, 'mdel_settings_page_callback'], MDEL_URL . 'assets/img/icon.png', 59);
  }

  /**
   * Admin page HTML callback
   *
   * @since 1.0.0
   * @return void
   */
  public function mdel_settings_page_callback()
  {
    $presets = MDEL_Helpers::color_presets();

    $savedopts = (FALSE !== get_option('mdel_opts')) ? get_option('mdel_opts') : array();

    $selected_primary = isset($savedopts['customprimary']) ? $savedopts['customprimary'] : '';
    $selected_secondary = isset($savedopts['customsecondary']) ? $savedopts['customsecondary'] : '';

    $coloropts = '<div class="mdel-color-scheme">';

    foreach ($presets as $preset) {
      $primary = $preset[0];
      $secondary = $preset[1];

      if (isset($savedopts['primarycolor']) && $savedopts['primarycolor'] == $primary && $selected_primary == '' && $selected_secondary == '') {
        $selected = ' checked';
      } else {
        $selected = '';
      }

      $coloropts .= '<span style="background:linear-gradient(180deg, ' . $primary . ', ' . $secondary . ');"><input type="radio" name="mdel-colorscheme" value="' . str_ireplace('#', '', $primary) . '"' . $selected . '><span></span></span>';
    }

    $coloropts .= '</div>';


    $btn = '<button type="submit" name="mdel-save" class="mdel-save-btn">' . __('Save Settings', 'modern-addons-elementor') . '</button>';

    $html = '<div class="wrap" id="modern-addons-admin">
    
    <div class="mdel-sidebar">
      <img src="' . MDEL_URL . 'assets/img/logo.png" class="mdel-logo"/>
      <a href="#mdel-dashboard" class="active"><i class="eicon-dashboard"></i><h3>' . __('DASHBOARD', 'modern-addons-elementor') . '</h3></a>
      <a href="#mdel-colors"><i class="eicon-paint-brush"></i><h3>' . __('COLOR SCHEME', 'modern-addons-elementor') . '</h3></a>
      <a href="#mdel-widgets"><i class="eicon-navigator"></i><h3>' . __('WIDGETS', 'modern-addons-elementor') . '</h3></a>      
    </div>
    <div class="mdel-content">
    <form method="post">
        <div class="mdel-inner-section active" id="mdel-dashboard">
          <div class="mdel-head"><h3>' . __('Dashboard', 'modern-addons-elementor') . '</h3>' . $btn . '</div>
          <img class="mdel-dash-banner" src="' . MDEL_URL . 'assets/img/banner.png"/>
        </div>
        <div class="mdel-inner-section" id="mdel-widgets">
          <div class="mdel-head"><h3>' . __('Widgets', 'modern-addons-elementor') . '</h3>' . $btn . '</div>
          <div class="mdel-active-widgets">
    ' . $this->mdel_available_widgets() . '
          </div>
        </div>
        <div class="mdel-inner-section" id="mdel-colors">
          <div class="mdel-head"><h3>' . __('Default Colors', 'modern-addons-elementor') . '</h3>' . $btn . '</div>
          <p>' . __('To save your precious time, We have some super cool gradient combinations to choose from. All Modern addon based widgets will initially inherit below selected primary + secondary (gradient) color by default unless you override/customize the colors for specific widgets.', 'modern-addons-elementor') . '</p>
          ' . $coloropts . '
          <h3>' . __('Want to use your own custom colors?', 'modern-addons-elementor') . '</h3>
          <p>' . __('Input your primary and secondary color codes in hex format (Both fields are required). Empty these inputs to use one of above pre-defined gradient preset.', 'modern-addons-elementor') . '</p>
          <div class="mdel-custom-colors">
            <input type="text" name="custom-colorone" value="' . esc_attr($selected_primary) . '" placeholder="#ffffff">
            <input type="text" name="custom-colortwo" value="' . esc_attr($selected_secondary) . '" placeholder="#000000">
          </div>
        </div>
    ' . wp_nonce_field('mdel-opts', 'save-mdel-settings', false, false) . '    
    </form>    
    </div>

    </div>';

    echo $html;
  }

  public function mdel_save_settings()
  {

    if (isset($_POST['save-mdel-settings'])) {

      if (!wp_verify_nonce($_POST['save-mdel-settings'], 'mdel-opts')) {
        die('Unauthorized request');
        exit();
      }

      $chosen_widgets = array_map('sanitize_text_field', $_POST['mdelwidgets']);
      $chosen_widgets = array_map('strtolower', $chosen_widgets);
      $save_widgets = $chosen_widgets;

      if (!isset($_POST['mdel-colorscheme']) || empty($_POST['mdel-colorscheme'])) {
        $cscheme = 'CC0C82'; //default first color scheme
      } else {
        $cscheme = sanitize_text_field($_POST['mdel-colorscheme']);
      }

      $choosen_preset = MDEL_Helpers::find_color_preset($cscheme);

      $new = array(
        'colorscheme' => $choosen_preset,
        'primarycolor' => $choosen_preset[0],
        'secondarycolor' => $choosen_preset[1],
        'customprimary' => sanitize_text_field($_POST['custom-colorone']), //overrides above color opts
        'customsecondary' => sanitize_text_field($_POST['custom-colortwo']), //overrides above color opts
        'enabledwidgets' => $save_widgets
      );

      update_option('mdel_opts', $new);

      add_action('admin_notices', [$this, 'mdel_settings_saved_notice']);
    }
  }

  public function mdel_settings_saved_notice()
  {
    echo '<div class="notice notice-success is-dismissible">
      <p>' . __('Settings Saved', 'modern-addons-elementor') . '!</p>
    </div>';
  }

  public function mdel_available_widgets()
  {

    $inputsHTML = '';

    $allselected = false;

    $existing = (FALSE !== get_option('mdel_opts')) ? get_option('mdel_opts') : array();

    $activewidgets = (isset($existing['enabledwidgets'])) ? $existing['enabledwidgets'] : array();

    if (empty($activewidgets)) {
      $allselected = true;
    }

    foreach (MDEL_Helpers::widgets_list() as $widget) {
      $name = esc_attr(strtolower($widget));

      if ($allselected || in_array($name, $activewidgets)) {
        $checked = 'checked';
      } else {
        $checked = '';
      }

      $inputsHTML .= '<div class="available-wdgt">
      <h4>' . esc_html($widget) . '</h4>
      <input type="checkbox" name="mdelwidgets[]" value="' . $name . '" id="' . $name . '" class="toggle-light"' . $checked . '>
      <label for="' . $name . '"></label>
      </div>';
    }

    return $inputsHTML;
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
    }

    return self::$instance;
  }
}
