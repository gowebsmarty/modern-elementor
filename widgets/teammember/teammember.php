<?php

namespace ModernAddonsElementor\Widgets\Teammember;

use \ModernAddonsElementor\Widgets\Teammember\MDEL_Teammember_Handler as Handler;

use \ModernAddonsElementor\Utils\MDEL_Helpers;

if (!defined('ABSPATH')) exit;

/**
 * Individual team member widget
 *
 * @since 1.0.0
 */
class MDEL_Teammember extends \Elementor\Widget_Base
{

  private $prefix = 'mdel_teammember_';

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

    $this->add_control(
      $this->prefix . 'skin',
      [
        'label' => __('Style', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::SELECT2,
        'multiple' => false,
        'label_block' => true,
        'options' => [
          'one'  => __('Style One', 'modern-addons-elementor'),
          'two' => __('Style Two', 'modern-addons-elementor'),
        ],
        'default' => 'one',
      ]
    );

    $this->add_control(
      $this->prefix . 'memberimage',
      [
        'label' => __('Member Image', 'modern-addons-elementor'),
        'description' => __('Please use portraits of same size', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::MEDIA,
        'default' => [
          'url' => MDEL_Helpers::default_portrait_src(),
        ],
      ]
    );

    $this->add_control(
      $this->prefix . 'membername',
      [
        'label' => __('Member Name', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __('Member Name', 'modern-addons-elementor')
      ]
    );

    $this->add_control(
      $this->prefix . 'membertitle',
      [
        'label' => __('Member Position', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __('Business Manager', 'modern-addons-elementor')
      ]
    );

    $this->add_control(
      $this->prefix . 'memberinfo',
      [
        'label' => __('Member Intro', 'modern-addons-elementor'),
        'description' => __('Keep it small to keep it responsive', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::TEXTAREA,
        'rows' => 10,
        'placeholder' => __('Type your description here', 'modern-addons-elementor'),
      ]
    );


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
      $this->prefix . 'text_align',
      [
        'label' => __('Text Alignment', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::CHOOSE,
        'options' => [
          'left' => [
            'title' => __('Left', 'modern-addons-elementor'),
            'icon' => 'fa fa-align-left',
          ],
          'center' => [
            'title' => __('Center', 'modern-addons-elementor'),
            'icon' => 'fa fa-align-center',
          ],
          'right' => [
            'title' => __('Right', 'modern-addons-elementor'),
            'icon' => 'fa fa-align-right',
          ],
        ],
        'default' => 'center',
        'toggle' => true,
      ]
    );

    $this->add_control(
      $this->prefix . 'borderradius',
      [
        'label' => __('Border Radius', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['px', '%'],
        'range' => [
          'px' => [
            'min' => 0,
            'max' => 500,
            'step' => 2,
          ],
          '%' => [
            'min' => 0,
            'max' => 100,
          ],
        ],
        'default' => [
          'unit' => '%',
          'size' => 0,
        ],
        'selectors' => [
          '{{WRAPPER}} .mdel-member,{{WRAPPER}} .mdel-member-skin-two' => 'border-radius: {{SIZE}}{{UNIT}};',
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

    if ($opts[$this->prefix . 'memberimage']['id'] == '') {
      $before = $opts[$this->prefix . 'memberimage']['url'];
    } else {
      $before = wp_get_attachment_image_src($opts[$this->prefix . 'memberimage']['id'], 'large');
      $before = $before[0];
    }

    $paintdiv = $greyclass = '';

    if ($opts[$this->prefix . 'skin'] == 'one') {
      $greyclass = 'mdel-grey';
      $paintdiv = '
      <div class="mdel-member-paint">
        <img src="' . esc_url($before) . '" class="mdel-paint">
      </div>';
    }

    $intro = isset($opts[$this->prefix . 'memberinfo']) ? $opts[$this->prefix . 'memberinfo'] : '';


    $html = '<div class="mdel-team-member mdel-member-skin-' . sanitize_html_class($opts[$this->prefix . 'skin']) . ' mdel-text-align-' . sanitize_html_class($opts[$this->prefix . 'text_align']) . '">
    <div class="mdel-member">
      <img src="' . esc_url($before) . '" class="mdel-grey">
      ' . $paintdiv . '
    </div>
    <div class="mdel-member-data">
      <h3>' . esc_html($opts[$this->prefix . 'membername']) . '</h3>
      <div class="mdel-member-position">' . esc_html($opts[$this->prefix . 'membertitle']) . '</div>
      <div class="mdel-member-content">
        <p>' . esc_html($intro) . '</p>
      </div>
    </div>
 </div>';

    echo $html;
  }
}
