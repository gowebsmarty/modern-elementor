<?php

namespace ModernAddonsElementor\Widgets\Flipbox;

use \ModernAddonsElementor\Widgets\Flipbox\MDEL_Flipbox_Handler as Handler;
use \ModernAddonsElementor\Utils\MDEL_Helpers;

use \ModernAddonsElementor\Utils\MDEL_Icon_Content;

if (!defined('ABSPATH')) exit;

/**
 * Image flip animation widget.
 *
 * @since 1.0.0
 */
class MDEL_Flipbox extends \Elementor\Widget_Base
{

  private $prefix = 'mdel_flipbox_';

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

    $this->add_responsive_control(
      $this->prefix . 'height',
      [
        'label' => __('Minimum Height', 'modern-addons-elementor'),
        'description' => __('Choose minimum height that fills both front & back contents', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range' => [
          'px' => [
            'min' => 200,
            'max' => 1500,
            'step' => 10,
          ],
        ],
        'default' => [
          'unit' => 'px',
          'size' => 400,
        ],
        'devices' => ['desktop', 'tablet', 'mobile'],
        'selectors' => [
          '{{WRAPPER}} .mdel-flipper' => 'min-height: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->start_controls_tabs(
      'content_tabs'
    );

    $this->start_controls_tab(
      'content_front',
      [
        'label' => __('Front', 'modern-addons-elementor'),
      ]
    );

    $this->add_control(
      $this->prefix . 'fronttype',
      [
        'label' => __('Content Type', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::SELECT2,
        'multiple' => false,
        'label_block' => true,
        'options' => [
          'empty' => __('Empty', 'modern-addons-elementor'),
          'iconcontent' => __('Icon with Content', 'modern-addons-elementor'),
          'custom' => __('Custom Content', 'modern-addons-elementor'),
        ],
        'default' => 'empty',
      ]
    );

    $condition = [
      'condition' => [
        $this->prefix . 'fronttype' => 'iconcontent'
      ]
    ];

    MDEL_Icon_Content::get_controls($this, $this->prefix . 'front_', $condition);

    $this->add_control(
      $this->prefix . 'frontflip_custom',
      [
        'label' => __('Custom HTML', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::WYSIWYG,
        'default' => __('', 'modern-addons-elementor'),
        'placeholder' => __('Custom HTML content can be placed here', 'modern-addons-elementor'),
        'condition' => [
          $this->prefix . 'fronttype' => 'custom'
        ]
      ]
    );

    $this->add_control(
      $this->prefix . 'frontflip_horizontal',
      [
        'label' => __('Align Items Horizontally', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => __('Yes', 'your-plugin'),
        'label_off' => __('No', 'your-plugin'),
        'return_value' => 'yes',
        'default' => 'no',
        'condition' => [
          $this->prefix . 'fronttype' => 'custom'
        ]
      ]
    );

    $this->end_controls_tab();

    $this->start_controls_tab(
      'content_back',
      [
        'label' => __('Back', 'modern-addons-elementor'),
      ]
    );

    $this->add_control(
      $this->prefix . 'backtype',
      [
        'label' => __('Content Type', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::SELECT2,
        'multiple' => false,
        'label_block' => true,
        'options' => [
          'empty' => __('Empty', 'modern-addons-elementor'),
          'iconcontent' => __('Icon with Content', 'modern-addons-elementor'),
          'custom' => __('Custom Content', 'modern-addons-elementor'),
        ],
        'default' => 'iconcontent',
      ]
    );

    $condition = [
      'condition' => [
        $this->prefix . 'backtype' => 'iconcontent'
      ]
    ];

    MDEL_Icon_Content::get_controls($this, $this->prefix . 'back_', $condition);

    $this->add_control(
      $this->prefix . 'backflip_custom',
      [
        'label' => __('Custom HTML', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::WYSIWYG,
        'default' => __('', 'modern-addons-elementor'),
        'placeholder' => __('Custom HTML content can be placed here', 'modern-addons-elementor'),
        'condition' => [
          $this->prefix . 'backtype' => 'custom'
        ]
      ]
    );

    $this->add_control(
      $this->prefix . 'backflip_horizontal',
      [
        'label' => __('Align Items Horizontally', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => __('Yes', 'your-plugin'),
        'label_off' => __('No', 'your-plugin'),
        'return_value' => 'yes',
        'default' => 'no',
        'condition' => [
          $this->prefix . 'backtype' => 'custom'
        ]
      ]
    );

    $this->end_controls_tab();


    $this->end_controls_tabs();

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

    $this->start_controls_tabs(
      'design_tabs'
    );


    $this->start_controls_tab(
      'design_front',
      [
        'label' => __('Front', 'modern-addons-elementor'),
      ]
    );

    $this->add_responsive_control(
      $this->prefix . 'frontpadding',
      [
        'label' => __('Front box Padding', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px'],
        'selectors' => [
          '{{WRAPPER}} .mdel-flipper .mdel-front' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'default' => [
          'top' => 20,
          'right' => 20,
          'bottom' => 20,
          'left' => 20,
          'unit' => 'px',
          'isLinked' => true,
        ],
        'devices' => ['desktop', 'tablet', 'mobile'],
        'condition' => [
          $this->prefix . 'fronttype' => 'custom'
        ]
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Background::get_type(),
      [
        'name' => $this->prefix . 'front_background',
        'label' => __('Background', 'modern-addons-elementor'),
        'types' => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .mdel-flipper .mdel-front',
        'fields_options' => [
          'background' => [
            'default' => 'classic'
          ],
          'image' => [
            'default' => [
              'url' => MDEL_Helpers::default_square_src()
            ]
          ],
          'position' => [
            'default' => 'center center'
          ]
        ]
      ]
    );

    $this->end_controls_tab();

    $this->start_controls_tab(
      'design_back',
      [
        'label' => __('Back', 'modern-addons-elementor'),
      ]
    );

    $this->add_responsive_control(
      $this->prefix . 'backpadding',
      [
        'label' => __('Back box Padding', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px'],
        'selectors' => [
          '{{WRAPPER}} .mdel-flipper .mdel-back' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'default' => [
          'top' => 20,
          'right' => 20,
          'bottom' => 20,
          'left' => 20,
          'unit' => 'px',
          'isLinked' => true,
        ],
        'devices' => ['desktop', 'tablet', 'mobile'],
        'condition' => [
          $this->prefix . 'backtype' => 'custom'
        ]
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Background::get_type(),
      array_merge(
        [
          'name' => $this->prefix . 'back_background',
          'label' => __('Background', 'modern-addons-elementor'),
          'types' => ['classic', 'gradient'],
          'selector' => '{{WRAPPER}} .mdel-flipper .mdel-back',
        ],
        MDEL_Helpers::default_gradient()
      )
    );

    $this->end_controls_tab();


    $this->end_controls_tabs();

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

    $front_horizontal = ($opts[$this->prefix . 'frontflip_horizontal'] === 'yes') ? ' mdel-flex-direction-horizontal' : '';
    $back_horizontal = ($opts[$this->prefix . 'backflip_horizontal'] === 'yes') ? ' mdel-flex-direction-horizontal' : '';

    $html = '<div class="mdel-flip-box">
    <div class="mdel-flipper">
    
<div class="mdel-front' . $front_horizontal . '">';

    if ($opts[$this->prefix . 'fronttype'] == 'iconcontent') {

      $html .= MDEL_Icon_Content::render_icon_content($this->prefix . 'front_', $opts);
    } else if ($opts[$this->prefix . 'fronttype'] == 'custom') {

      $html .= wp_kses_post($opts[$this->prefix . 'frontflip_custom']);
    }

    $html .= '</div>
<div class="mdel-back' . $back_horizontal . '">';

    if ($opts[$this->prefix . 'backtype'] == 'iconcontent') {

      $html .= MDEL_Icon_Content::render_icon_content($this->prefix . 'back_', $opts);
    } else if ($opts[$this->prefix . 'backtype'] == 'custom') {

      $html .= wp_kses_post($opts[$this->prefix . 'backflip_custom']);
    }

    $html .= '</div>

    </div>
    </div>';

    echo $html;
  }
}
