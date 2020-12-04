<?php

namespace ModernAddonsElementor\Widgets\Pricingtable;

use ModernAddonsElementor\Utils\MDEL_Helpers;
use \ModernAddonsElementor\Widgets\Pricingtable\MDEL_Pricingtable_Handler as Handler;

if (!defined('ABSPATH')) exit;

/**
 * Pricing table widget
 *
 * @since 1.0.0
 */
class MDEL_Pricingtable extends \Elementor\Widget_Base
{

  private $prefix = 'mdel_pricingtable_';

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
      $this->prefix . 'darkmode',
      [
        'label' => __('Dark Mode', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => __('Enable', 'your-plugin'),
        'label_off' => __('Disable', 'your-plugin'),
        'return_value' => 'yes',
        'default' => 'no',
      ]
    );

    $this->add_control(
      $this->prefix . 'featured',
      [
        'label' => __('Popular Badge', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => __('Show', 'your-plugin'),
        'label_off' => __('Hide', 'your-plugin'),
        'return_value' => 'yes',
        'default' => 'no',
      ]
    );

    $this->add_control(
      $this->prefix . 'featuredtitle',
      [
        'label' => __('Most Popular Title', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __('Most Popular', 'modern-addons-elementor'),
        'placeholder' => __('Type your title here', 'modern-addons-elementor'),
        'condition' => [
          $this->prefix . 'featured' => 'yes'
        ]
      ]
    );

    $this->add_control(
      $this->prefix . 'title',
      [
        'label' => __('Pricing Title', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __('Deluxe', 'modern-addons-elementor'),
        'placeholder' => __('Type your title here', 'modern-addons-elementor')
      ]
    );

    $this->add_control(
      $this->prefix . 'currency',
      [
        'label' => __('Currency Symbol', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __('$', 'modern-addons-elementor'),
      ]
    );

    $this->add_control(
      $this->prefix . 'cost',
      [
        'label' => __('Price', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __('9.99', 'modern-addons-elementor'),
      ]
    );

    $this->add_control(
      $this->prefix . 'features',
      [
        'label' => __('Features', 'modern-addons-elementor'),
        'description' => __('Describe in bulleted list item format', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::WYSIWYG,
        'default' => '<ul><li>Feature Item One</li><li>Feature Item Two</li><li>Feature Item Three</li><li>Feature Item Four</li></ul>',
      ]
    );

    $this->add_control(
      $this->prefix . 'buttontext',
      [
        'label' => __('Button Text', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __('Buy Now', 'modern-addons-elementor')
      ]
    );

    $this->add_control(
      $this->prefix . 'buttonlink',
      [
        'label' => __('Button Link', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::URL,
        'placeholder' => __('https://your-link.com', 'modern-addons-elementor'),
        'show_external' => true,
        'default' => [
          'url' => '',
          'is_external' => false,
          'nofollow' => false,
        ],
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

    $this->add_group_control(
      \Elementor\Group_Control_Background::get_type(),
      array_merge(
        [
          'name' => $this->prefix . 'background',
          'label' => __('Background Color', 'modern-addons-elementor'),
          'types' => ['classic', 'gradient'],
          'selector' => '{{WRAPPER}} .mdel-pricing',
          'condition' => [
            $this->prefix . 'skin' => 'one'
          ]
        ],
        MDEL_Helpers::default_gradient(45, 50)
      )
    );

    $this->add_group_control(
      \Elementor\Group_Control_Background::get_type(),
      array_merge(
        [
          'name' => $this->prefix . 'twobackground',
          'label' => __('Background Color', 'modern-addons-elementor'),
          'types' => ['classic', 'gradient'],
          'selector' => '{{WRAPPER}} .mdel-pricing-skin-two .mdel-pricing-headinner',
          'condition' => [
            $this->prefix . 'skin' => 'two'
          ]
        ],
        MDEL_Helpers::default_gradient(45, 50)
      )
    );

    $this->add_group_control(
      \Elementor\Group_Control_Background::get_type(),
      array_merge(
        [
          'name' => $this->prefix . 'btnbackground',
          'label' => __('Button Color', 'modern-addons-elementor'),
          'types' => ['classic', 'gradient'],
          'selector' => '{{WRAPPER}} .mdel-pricing',
          'condition' => [
            $this->prefix . 'skin' => 'two'
          ]
        ],
        MDEL_Helpers::default_gradient(45, 50)
      )
    );

    $this->add_responsive_control(
      $this->prefix . 'pricefont',
      [
        'label' => __('Price Font Size', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range' => [
          'px' => [
            'min' => 14,
            'max' => 150,
            'step' => 1,
          ],
        ],
        'default' => [
          'unit' => 'px',
          'size' => 52,
        ],
        'devices' => ['desktop', 'tablet', 'mobile'],
        'selectors' => [
          '{{WRAPPER}} .mdel-pricing-cost span' => 'font-size: {{SIZE}}{{UNIT}};',
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

    $mode = 'light';

    if ('yes' === $opts[$this->prefix . 'darkmode']) {
      $mode = 'dark';
    }

    $target = $opts[$this->prefix . 'buttonlink']['is_external'] ? ' target="_blank"' : '';
    $nofollow = $opts[$this->prefix . 'buttonlink']['nofollow'] ? ' rel="nofollow"' : '';

    $html = '<div class="mdel-pricing mdel-pricing-' . sanitize_html_class($mode) . ' mdel-pricing-skin-' . sanitize_html_class($opts[$this->prefix . 'skin']) . '">
    <div class="mdel-pricing-head">
    <div class="mdel-pricing-headinner">';

    if ('yes' === $opts[$this->prefix . 'featured']) {
      $html .= '<div class="mdel-pricing-popular">' . esc_html($opts[$this->prefix . 'featuredtitle']) . '</div>';
    }

    $html .= '<div class="mdel-pricing-title">' . esc_html($opts[$this->prefix . 'title']) . '</div>
    <div class="mdel-pricing-cost">
      <strong>' . esc_html($opts[$this->prefix . 'currency']) . '</strong> <span>' . esc_html($opts[$this->prefix . 'cost']) . '</span>
    </div>
    </div><!--mdel-pricing-headinner-->

    </div>

    <div class="mdel-pricing-list">
    ' . wp_kses_post($opts[$this->prefix . 'features']) . '
    </div>

    <a href="' . esc_url($opts[$this->prefix . 'buttonlink']['url']) . '"' . $target . $nofollow . ' class="mdel-pricing-btn">' . esc_html($opts[$this->prefix . 'buttontext']) . '</a>

    </div>';

    echo $html;
  }
}
