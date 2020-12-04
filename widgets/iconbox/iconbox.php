<?php

namespace ModernAddonsElementor\Widgets\Iconbox;

use \ModernAddonsElementor\Widgets\Iconbox\MDEL_Iconbox_Handler as Handler;

use \ModernAddonsElementor\Utils\MDEL_Icon_Content;

if (!defined('ABSPATH')) exit;

/**
 * Icon box widget
 *
 * @since 1.0.0
 */
class MDEL_Iconbox extends \Elementor\Widget_Base
{

  private $prefix = 'mdel_iconbox_';

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

    MDEL_Icon_Content::get_controls($this, $this->prefix, array(), '#222');

    $this->end_controls_section();

    $this->mdel_design_controls();
  }

  /**
   * Design related settings
   *
   * @since 1.0.0
   * @return void
   */
  protected function mdel_design_controls()
  {
    $this->start_controls_section(
      $this->prefix . 'design_style',
      [
        'label'   => esc_html__('Design', 'modern-addons-elementor'),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      $this->prefix . 'iconboxskin',
      [
        'label' => __('Box Style', 'modern-addons-elementor'),
        'description' => __('SKEW: Give left & right padding of 20px to parent section', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::SELECT2,
        'multiple' => false,
        'label_block' => true,
        'options' => [
          'normal' => __('Normal Grid', 'modern-addons-elementor'),
          'skewed' => __('Skewed background', 'modern-addons-elementor'),
          'fader' => __('Background visible on hover', 'modern-addons-elementor'),
          'shine' => __('Shine on hover', 'modern-addons-elementor'),
          'shaded' => __('Half shaded', 'modern-addons-elementor'),
        ],
        'default' => 'normal',
      ]
    );

    $this->add_control(
      $this->prefix . 'shadeangle',
      [
        'label' => __('Shade Angle', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::SELECT2,
        'multiple' => false,
        'label_block' => true,
        'options' => [
          'left' => __('Left', 'modern-addons-elementor'),
          'center' => __('Center', 'modern-addons-elementor'),
          'right' => __('Right', 'modern-addons-elementor'),
        ],
        'default' => 'center',
        'condition' => [
          $this->prefix . 'iconboxskin' => 'shaded'
        ]
      ]
    );

    $this->add_control(
      $this->prefix . 'iconboxhover',
      [
        'label' => __('Icon box hover glow color', 'modern-addons-elementor'),
        'description' => __('Set to #ffffff to disable this hover effect', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'default' => '#ffffff',
        'selectors' => [
          '{{WRAPPER}} .mdel-icon-content:hover' => 'box-shadow:0px 0px 20px {{VALUE}};'
        ]
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Background::get_type(),
      [
        'name' => $this->prefix . 'iconboxbackground',
        'label' => __('Background', 'modern-addons-elementor'),
        'types' => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .mdel-iconbox-background,{{WRAPPER}} .mdel-iconbox-skin-normal,{{WRAPPER}} .mdel-iconbox-skin-shine',
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

    $html = MDEL_Icon_Content::render_icon_content($this->prefix, $opts, true);

    echo $html;
  }
}
