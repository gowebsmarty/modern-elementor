<?php

namespace ModernAddonsElementor\Widgets\Beforeafter;

use \ModernAddonsElementor\Widgets\Beforeafter\MDEL_Beforeafter_Handler as Handler;
use \ModernAddonsElementor\Utils\MDEL_Helpers;

if (!defined('ABSPATH')) exit;

/**
 * Before After image slider
 *
 * @since 1.0.0
 */
class MDEL_Beforeafter extends \Elementor\Widget_Base
{

  private $prefix = 'mdel_beforeafter_';

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

    MDEL_Helpers::no_preview($this, $this->prefix);

    $this->add_control(
      $this->prefix . 'beforeimage',
      [
        'label' => __('Before Image', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::MEDIA,
        'default' => [
          'url' => MDEL_Helpers::default_square_src(),
        ],
      ]
    );

    $this->add_control(
      $this->prefix . 'afterimage',
      [
        'label' => __('After Image', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::MEDIA,
        'default' => [
          'url' => MDEL_Helpers::default_square_dark_src(),
        ],
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

    if ($opts[$this->prefix . 'beforeimage']['id'] == '') {
      $before = $opts[$this->prefix . 'beforeimage']['url'];
    } else {
      $before = wp_get_attachment_image_src($opts[$this->prefix . 'beforeimage']['id'], 'large');
      $before = $before[0];
    }

    if ($opts[$this->prefix . 'afterimage']['id'] == '') {
      $after = $opts[$this->prefix . 'afterimage']['url'];
    } else {
      $after = wp_get_attachment_image_src($opts[$this->prefix . 'afterimage']['id'], 'large');
      $after = $after[0];
    }

    $html = '<div class="mdel-ba-slider">
    <img src="' . esc_url($after) . '">
    <div class="resize">
        <img src="' . esc_url($before) . '">
    </div>
    <span class="handle"></span>
 </div>';

    echo $html;
  }
}
