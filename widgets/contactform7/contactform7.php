<?php

namespace ModernAddonsElementor\Widgets\Contactform7;

use \ModernAddonsElementor\Widgets\Contactform7\MDEL_Contactform7_Handler as Handler;

use \ModernAddonsElementor\Utils\MDEL_Templating;
use \ModernAddonsElementor\Utils\MDEL_Helpers;

if (!defined('ABSPATH')) exit;

/**
 * Styled Contact form 7 widget
 *
 * @since 1.0.0
 */
class MDEL_Contactform7 extends \Elementor\Widget_Base
{

  private $prefix = 'mdel_contactform7_';

  public function get_name()
  {
    return Handler::get_name();
  }

  public function get_title()
  {
    return Handler::get_title();
  }

  public function get_icon()
  {
    return Handler::get_icon();
  }

  public function get_categories()
  {
    return Handler::get_categories();
  }

  /**
   * Register widget controls.
   *
   * Adds different input fields to allow the user to change and customize the widget settings.
   *
   * @since 1.0.0
   * @access protected
   */
  protected function _register_controls()
  {
    $this->start_controls_section(
      $this->prefix . 'content',
      [
        'label' => __('Content', 'modern-addons-elementor'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );

    MDEL_Templating::get_cf7_list_control($this, $this->prefix);

    $this->add_control(
      $this->prefix . 'buttoncolor',
      [
        'label' => __('Button Color', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'default' => MDEL_Helpers::get_primary_color(),
        'selectors' => [
          '{{WRAPPER}} .wpcf7-submit' => 'background: {{VALUE}}'
        ]
      ]
    );

    $this->add_control(
      $this->prefix . 'insidelabels',
      [
        'label' => __('Show Labels Inside Input', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => __('Yes', 'your-plugin'),
        'label_off' => __('No', 'your-plugin'),
        'return_value' => 'yes',
        'default' => 'no',
      ]
    );


    $this->end_controls_section();
  }


  /**
   * Render widget output on the frontend.
   *
   * @since 1.0.0
   * @access protected
   */
  protected function render()
  {

    $opts = $this->get_settings_for_display();

    $cform = do_shortcode('[contact-form-7 id="' . (int) $opts[$this->prefix . 'cf7_list'] . '"]');

    $cform = str_ireplace('<label>', '<label><span class="mdel-label">', $cform);

    $cform = str_ireplace('<span class="wpcf7-form-control-wrap', '</span><span class="wpcf7-form-control-wrap', $cform);

    $extraclass = '';

    if ($opts[$this->prefix . 'insidelabels'] === 'yes') {
      $extraclass = ' mdel-inside-labels';
    }

    $html = '<div class="mdel-contact-form7' . $extraclass . '">
    ' . $cform . '
    </div>';

    echo $html;
  }
}
