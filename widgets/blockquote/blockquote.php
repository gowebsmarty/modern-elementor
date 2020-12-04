<?php

namespace ModernAddonsElementor\Widgets\Blockquote;

use ModernAddonsElementor\Utils\MDEL_Helpers;
use \ModernAddonsElementor\Widgets\Blockquote\MDEL_Blockquote_Handler as Handler;

if (!defined('ABSPATH')) exit;

/**
 * Image with Info Box animation.
 *
 * @since 1.0.0
 */
class MDEL_Blockquote extends \Elementor\Widget_Base
{

  private $prefix = 'mdel_blockquote_';

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
      $this->prefix . 'icon',
      [
        'label' => __('Icon', 'text-domain'),
        'type' => \Elementor\Controls_Manager::ICONS,
        'default' => [
          'value' => 'fas fa-quote-right',
          'library' => 'solid',
        ],
      ]
    );

    $this->add_control(
      $this->prefix . 'text',
      [
        'label' => __('Blockquote Text', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::TEXTAREA,
        'rows' => 10,
        'default' => MDEL_Helpers::lorem_ipsum(),
        'placeholder' => __('Type your blockquote text', 'modern-addons-elementor'),
      ]
    );

    $this->add_control(
      $this->prefix . 'color',
      [
        'label' => __('Blockquote Color', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'selectors' => [
          '{{WRAPPER}} .mdel-blockquote-content blockquote,{{WRAPPER}} .mdel-blockquote-content i,{{WRAPPER}} .mdel-blockquote-content svg' => 'color: {{VALUE}}',
        ],
        'default' => '#999'
      ]
    );

    $this->add_control(
      $this->prefix . 'fontsize',
      [
        'label' => __('Font Size', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range' => [
          'px' => [
            'min' => 14,
            'max' => 100,
            'step' => 2
          ],
        ],
        'default' => [
          'unit' => 'px',
          'size' => 30,
        ],
        'selectors' => [
          '{{WRAPPER}} .mdel-blockquote-content blockquote' => 'font-size: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      $this->prefix . 'padding',
      [
        'label' => __('Padding', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px'],
        'default' => [
          'top' => 60,
          'right' => 60,
          'bottom' => 60,
          'left' => 60,
          'unit' => 'px',
          'isLinked' => true,
        ],
        'selectors' => [
          '{{WRAPPER}} .mdel-blockquote-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      $this->prefix . 'iconpostop',
      [
        'label' => __('Icon Position from Top', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range' => [
          'px' => [
            'min' => 0,
            'max' => 100,
            'step' => 5
          ],
        ],
        'default' => [
          'unit' => 'px',
          'size' => 20,
        ],
        'selectors' => [
          '{{WRAPPER}} .mdel-blockquote-content i,{{WRAPPER}} .mdel-blockquote-content svg' => 'top: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      $this->prefix . 'iconposleft',
      [
        'label' => __('Icon Position from Left', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['%'],
        'range' => [
          '%' => [
            'min' => 0,
            'max' => 100,
          ],
        ],
        'default' => [
          'unit' => '%',
          'size' => 95,
        ],
        'selectors' => [
          '{{WRAPPER}} .mdel-blockquote-content i,{{WRAPPER}} .mdel-blockquote-content svg' => 'left: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->end_controls_section();
  }


  /**
   * Render oEmbed widget output on the frontend.
   *
   * Written in PHP and used to generate the final HTML.
   *
   * @since 1.0.0
   * @access protected
   */
  protected function render()
  {

    $opts = $this->get_settings_for_display();

    ob_start();
    \Elementor\Icons_Manager::render_icon($opts[$this->prefix . 'icon'], ['aria-hidden' => 'true']);
    $icon = ob_get_clean();

    $html = '<div class="mdel-blockquote-content">
    ' . $icon . '
    <blockquote>' . esc_html($opts[$this->prefix . 'text']) . '</blockquote>    
    </div>';

    echo $html;
  }
}
