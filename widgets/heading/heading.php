<?php

namespace ModernAddonsElementor\Widgets\Heading;

use \ModernAddonsElementor\Widgets\Heading\MDEL_Heading_Handler as Handler;
use \ModernAddonsElementor\Utils\MDEL_Helpers;

if (!defined('ABSPATH')) exit;

/**
 * Fancy heading widget.
 *
 * @since 1.0.0
 */
class MDEL_Heading extends \Elementor\Widget_Base
{

  private $prefix = 'mdel_heading_';

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
      $this->prefix . 'headingtitle',
      [
        'label' => __('Heading Text', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __('Heading Text', 'modern-addons-elementor'),
        'placeholder' => __('Type your heading here', 'modern-addons-elementor'),
      ]
    );

    $this->add_control(
      $this->prefix . 'type',
      [
        'label' => __('Heading Tag', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::SELECT2,
        'multiple' => false,
        'label_block' => false,
        'options' => [
          'h1' => __('H1', 'modern-addons-elementor'),
          'h2' => __('H2', 'modern-addons-elementor'),
          'h3' => __('H3', 'modern-addons-elementor'),
          'h4' => __('H4', 'modern-addons-elementor'),
          'h5' => __('H5', 'modern-addons-elementor'),
          'h6' => __('H6', 'modern-addons-elementor'),
        ],
        'default' => 'h2',
      ]
    );

    $this->add_control(
      $this->prefix . 'textalign',
      [
        'label' => __('Text Align', 'modern-addons-elementor'),
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
        'default' => 'left',
        'toggle' => true,
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
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => $this->prefix . 'typography',
        'label' => __('Typography', 'modern-addons-elementor'),
        'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
        'selector' => '{{WRAPPER}} .mdel-fancy-heading',
      ]
    );

    $this->add_control(
      $this->prefix . 'skin',
      [
        'label' => __('Heading Style', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::SELECT2,
        'multiple' => false,
        'label_block' => false,
        'options' => [
          'simple' => __('Simple Color', 'modern-addons-elementor'),
          'dual' => __('Dual Color', 'modern-addons-elementor'),
          'gradient' => __('Gradient Color', 'modern-addons-elementor'),
          'image' => __('Image Clipped', 'modern-addons-elementor'),
        ],
        'default' => 'gradient',
      ]
    );

    $this->add_control(
      $this->prefix . 'color',
      [
        'label' => __('Heading Color', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'default' => '#222',
        'selectors' => [
          '{{WRAPPER}} .mdel-fancy-heading' => 'color: {{VALUE}}'
        ],
        'condition' => [
          $this->prefix . 'skin' => 'simple'
        ]
      ]
    );

    $this->add_control(
      $this->prefix . 'dualfirst',
      [
        'label' => __('First Word Color', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'default' => MDEL_Helpers::get_primary_color(),
        'condition' => [
          $this->prefix . 'skin' => 'dual'
        ]
      ]
    );

    $this->add_control(
      $this->prefix . 'dualsecond',
      [
        'label' => __('Further Heading Color', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'default' => MDEL_Helpers::get_secondary_color(),
        'selectors' => [
          '{{WRAPPER}} .mdel-fancy-heading' => 'color: {{VALUE}}'
        ],
        'condition' => [
          $this->prefix . 'skin' => 'dual'
        ]
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Background::get_type(),
      array_merge(
        [
          'name' => $this->prefix . 'gradient',
          'label' => __('Heading Gradient', 'modern-addons-elementor'),
          'types' => ['gradient'],
          'selector' => '{{WRAPPER}} .mdel-fancy-heading',
          'condition' => [
            $this->prefix . 'skin' => 'gradient'
          ]
        ],
        MDEL_Helpers::default_gradient()
      )
    );

    $this->add_control(
      $this->prefix . 'image',
      [
        'label' => __('Heading Image', 'modern-addons-elementor'),
        'description' => __('Clipped', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::MEDIA,
        'default' => [
          'url' => \Elementor\Utils::get_placeholder_image_src(),
        ],
        'condition' => [
          $this->prefix . 'skin' => 'image'
        ]
      ]
    );

    $this->add_control(
      $this->prefix . 'imageposition',
      [
        'label' => __('Background Position', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::SELECT2,
        'multiple' => false,
        'label_block' => false,
        'options' => [
          'top-center' => __('Top Center', 'modern-addons-elementor'),
          'center-center' => __('Center Center', 'modern-addons-elementor'),
          'bottom-center' => __('Bottom Center', 'modern-addons-elementor'),
        ],
        'default' => 'center-center',
        'condition' => [
          $this->prefix . 'skin' => 'image'
        ]
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

    $this->add_inline_editing_attributes($this->prefix . 'headingtitle', 'basic');

    $imgarr = isset($opts[$this->prefix . 'image']) ? wp_get_attachment_image_src((int) $opts[$this->prefix . 'image']['id'], 'large') : '';

    $img = ($imgarr == '') ? '' : $imgarr[0];

    $styler = '';

    if ($opts[$this->prefix . 'skin'] == 'image') {
      $styler = 'background-image:url(' . $img . ');';
      $styler .= 'background-position:' . str_ireplace('-', ' ', $opts[$this->prefix . 'imageposition']) . ';';
    }

    $tag = is_array($opts[$this->prefix . 'type']) ? 'h2' : $opts[$this->prefix . 'type'];

    $headingtext = $opts[$this->prefix . 'headingtitle'];

    if ($opts[$this->prefix . 'skin'] == 'dual') {

      $firstspace = stripos($headingtext, ' ');

      $headingwords = explode(' ', $headingtext);

      $headingtext = '<span style="color:' . esc_attr($opts[$this->prefix . 'dualfirst']) . ';">' . wp_kses_post($headingwords[0]) . '</span>' . wp_kses_post(substr($headingtext, $firstspace));
    }

    $html = '<' . wp_kses($tag, array('h1', 'h2', 'h3', 'h4', 'h5', 'h6')) . ' class="mdel-fancy-heading elementor-inline-editing mdel-text-align-' . sanitize_html_class($opts[$this->prefix . 'textalign']) . ' mdel-heading-skin-' . sanitize_html_class($opts[$this->prefix . 'skin']) . '" ' . $this->get_render_attribute_string($this->prefix . 'headingtitle') . ' style="' . esc_attr($styler) . '">' . $headingtext . '</' . wp_kses($tag, array('h1', 'h2', 'h3', 'h4', 'h5', 'h6')) . '>';

    echo $html;
  }
}
