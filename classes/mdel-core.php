<?php

defined('ABSPATH') || exit;

if (!class_exists('ModernAddons')) :
  final class ModernAddons
  {
    /**
     * Plugin Version
     *
     * @since 1.0.0
     * @var string The plugin version.
     */
    const VERSION = MDEL_VERSION;

    /**
     * Minimum Elementor Version
     *
     * @since 1.0.0
     * @var string Minimum Elementor version required to run the plugin.
     */

    const MINIMUM_ELEMENTOR_VERSION = '2.4.0';

    /**
     * Minimum PHP Version
     *
     * @since 1.0.0
     * @var string Minimum PHP version required to run the plugin.
     */
    const MINIMUM_PHP_VERSION = '5.6';

    /**
     * Constructor
     *
     * @since 1.0.0
     * @access public
     */
    public function __construct()
    {
      add_action('init', array($this, 'i18n'));
      $this->init();
    }

    /**
     * Load Textdomain
     *
     * Load plugin localization files.
     * Fired by `init` action hook.
     *
     * @since 1.0.0
     * @access public
     */
    public function i18n()
    {
      load_plugin_textdomain('modern-addons-elementor', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }

    /**
     * Initialize the plugin
     *
     * Checks for basic plugin requirements, if one check fail don't continue,
     * if all check have passed include the plugin class.
     *
     * Fired by `plugins_loaded` action hook.
     *
     * @since 1.0.0
     * @access public
     */
    public function init()
    {
      // Check if Elementor installed and activated.
      if (!did_action('elementor/loaded')) {
        add_action('admin_notices', array($this, 'mdel_missing_elementor'));
        return;
      }
      // Check for required Elementor version.
      if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
        add_action('admin_notices', array($this, 'mdel_failed_elementor_version'));
        return;
      }
      // Check for required PHP version.
      if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
        add_action('admin_notices', array($this, 'mdel_failed_php_version'));
        return;
      }

      //All good to go
      add_action('elementor/init', [$this, 'mdel_elementor_widget_category']);

      add_action('elementor/init', function () {
        include_once MDEL_PATH . 'start.php';
      });
    }

    /**
     * Site doesn't have Elementor
     *
     * @since 1.0.0
     * @access public
     */
    public function mdel_missing_elementor()
    {
      if (isset($_GET['activate'])) {
        unset($_GET['activate']);
      }

      if (file_exists(WP_PLUGIN_DIR . '/elementor/elementor.php')) {
        $btn['label'] = esc_html__('Activate Elementor', 'modern-addons-elementor');
        $btn['url'] = wp_nonce_url('plugins.php?action=activate&plugin=elementor/elementor.php&plugin_status=all&paged=1', 'activate-plugin_elementor/elementor.php');
      } else {
        $btn['label'] = esc_html__('Install Elementor', 'modern-addons-elementor');
        $btn['url'] = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=elementor'), 'install-plugin_elementor');
      }

      echo '<div class="notice notice-error">
        <p>' . __('Modern Addons requires Elementor to be installed and activated.', 'modern-adddons-elementor') . ' <a href="' . $btn['url'] . '">' . $btn['label'] . '</a></p>
    </div>';
    }

    /**
     * Site doesn't have required minimum Elementor version
     *
     * @since 1.0.0
     * @access public
     */
    public function mdel_failed_elementor_version()
    {
      echo '<div class="notice notice-error">
        <p>' . sprintf(__('Modern Addons requires minimum Elementor version of %s.', 'modern-adddons-elementor'), self::MINIMUM_ELEMENTOR_VERSION) . '</p>
    </div>';
    }


    /**
     * Site doesn't have required minimum PHP version
     *
     * @since 1.0.0
     * @access public
     */
    public function mdel_failed_php_version()
    {
      echo '<div class="notice notice-error">
        <p>' . sprintf(__('Modern Addons requires minimum PHP version of %s.', 'modern-adddons-elementor'), self::MINIMUM_PHP_VERSION) . '</p>
    </div>';
    }

    /**
     * Register custom widget category in Elementor's editor
     *
     * @since 1.0.0
     * @access public
     */
    public function mdel_elementor_widget_category($elements_manager)
    {
      \Elementor\Plugin::$instance->elements_manager->add_category(
        'modernaddons',
        [
          'title' => esc_html__('Modern Addons', 'modern-addons-elementor'),
          'icon' => 'fa fa-plug',
        ]
      );
    }
  }

  new ModernAddons();

endif;
