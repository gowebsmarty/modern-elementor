<?php

namespace ModernAddonsElementor\Widgets\Button;

use \ModernAddonsElementor\Widgets\Button\MDEL_Button_Handler as Handler;

use \ModernAddonsElementor\Utils\MDEL_Helpers;

if (!defined('ABSPATH')) exit;

/**
 * Fancy button widget.
 *
 * @since 1.0.0
 */
class MDEL_Button extends \Elementor\Widget_Base
{

  private $prefix = 'mdel_button_';

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
      $this->prefix . 'title',
      [
        'label' => __('Button Text', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __('Button Text', 'modern-addons-elementor'),
      ]
    );

    $this->add_control(
      $this->prefix . 'icon',
      [
        'label' => __('Button Icon', 'text-domain'),
        'type' => \Elementor\Controls_Manager::ICONS,
        'default' => [
          'value' => 'fas fa-star',
          'library' => 'solid',
        ],
      ]
    );

    $this->add_control(
      $this->prefix . 'button_link',
      [
        'label' => __('Button Link', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::URL,
        'placeholder' => __('https://your-link.com', 'modern-addons-elementor'),
        'show_external' => true,
        'default' => [
          'url' => '',
          'is_external' => false,
          'nofollow' => true,
        ]
      ]
    );

    $this->add_control(
      $this->prefix . 'icon_align',
      [
        'label' => __('Icon Alignment', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::CHOOSE,
        'options' => [
          'left' => [
            'title' => __('Left', 'modern-addons-elementor'),
            'icon' => 'fa fa-align-left',
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

    $this->add_control(
      $this->prefix . 'button_align',
      [
        'label' => __('Button Alignment', 'modern-addons-elementor'),
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
      $this->prefix . 'hoverbackground',
      [
        'label'   => esc_html__('Design & Colors', 'modern-addons-elementor'),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      $this->prefix . 'skin',
      [
        'label' => __('Skin', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::SELECT2,
        'multiple' => false,
        'label_block' => true,
        'options' => [
          'simple'  => __('Simple color or gradient background', 'modern-addons-elementor'),
          'multigradient' => __('Multi gradient animation', 'modern-addons-elementor'),
          'neon' => __('Neon animation', 'modern-addons-elementor'),
          'ripple' => __('Ripple effect', 'modern-addons-elementor'),
          'bordertobg' => __('Border to fill background', 'modern-addons-elementor'),
          'cliptobg' => __('Text Clip to fill background (no icon)', 'modern-addons-elementor'),
        ],
        'default' => 'simple',
      ]
    );

    $this->add_control(
      $this->prefix . 'hoverspeed',
      [
        'label' => __('Hover Animation Speed in Seconds', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'min' => 0,
        'max' => 15,
        'step' => 0.5,
        'default' => 0.5,
        'conditions' => [
          'relation' => 'and',
          'terms' => [
            [
              'name' => $this->prefix . 'skin',
              'operator' => '!=',
              'value' => 'simple'
            ],
            [
              'name' => $this->prefix . 'skin',
              'operator' => '!=',
              'value' => 'ripple'
            ]
          ]
        ],
        'selectors' => [
          '{{WRAPPER}} .mdel-fancy-button,{{WRAPPER}} .mdel-fancy-button:before,{{WRAPPER}} .mdel-button-skin-cliptobg .mdel-btn-text,{{WRAPPER}} .mdel-button-skin-cliptobg .mdel-btn-clipbg' => 'transition-duration: {{VALUE}}s',
          '{{WRAPPER}} .mdel-button-skin-multigradient' => 'animation-duration: {{VALUE}}s'
        ],
      ]
    );

    $this->add_control(
      $this->prefix . 'textcolor',
      [
        'label' => __('Button Text Color', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'default' => '#fff',
        'selectors' => [
          '{{WRAPPER}} .mdel-fancy-button:not(.mdel-button-skin-bordertobg) i,{{WRAPPER}} .mdel-fancy-button:not(.mdel-button-skin-bordertobg) svg,{{WRAPPER}} .mdel-fancy-button:not(.mdel-button-skin-bordertobg) span' => 'color: {{VALUE}}'
        ],
        'conditions' => [
          'relation' => 'and',
          'terms' => [
            [
              'name' => $this->prefix . 'skin',
              'operator' => '!=',
              'value' => 'bordertobg'
            ],
            [
              'name' => $this->prefix . 'skin',
              'operator' => '!=',
              'value' => 'cliptobg'
            ]
          ]
        ],
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Background::get_type(),
      array_merge(
        [
          'name' => $this->prefix . 'background',
          'label' => __('Primary Background', 'modern-addons-elementor'),
          'types' => ['classic', 'gradient'],
          'selector' => '{{WRAPPER}} .mdel-fancy-button',
          'conditions' => [
            'relation' => 'and',
            'terms' => [
              [
                'name' => $this->prefix . 'skin',
                'operator' => '!=',
                'value' => 'multigradient'
              ],
              [
                'name' => $this->prefix . 'skin',
                'operator' => '!=',
                'value' => 'bordertobg'
              ],
              [
                'name' => $this->prefix . 'skin',
                'operator' => '!=',
                'value' => 'cliptobg'
              ]
            ]
          ]
        ],
        MDEL_Helpers::default_gradient()
      )
    );

    $this->add_control(
      $this->prefix . 'bordertobgcolor',
      [
        'label' => __('Button Color', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'default' => MDEL_Helpers::get_primary_color(),
        'selectors' => [
          '{{WRAPPER}} .mdel-button-skin-bordertobg span,{{WRAPPER}} .mdel-button-skin-bordertobg i,{{WRAPPER}} .mdel-button-skin-bordertobg svg' => 'color: {{VALUE}}',
          '{{WRAPPER}} .mdel-button-skin-bordertobg' => 'border-color: {{VALUE}}',
          '{{WRAPPER}} .mdel-button-skin-bordertobg:hover' => 'background: {{VALUE}}',
        ],
        'condition' => [
          $this->prefix . 'skin' => 'bordertobg'
        ]
      ]
    );

    for ($i = 1; $i <= 4; $i++) {
      $this->add_control(
        $this->prefix . 'multicolor' . $i,
        [
          'label' => __('Color', 'modern-addons-elementor') . ' ' . $i,
          'type' => \Elementor\Controls_Manager::COLOR,
          'scheme' => [
            'type' => \Elementor\Scheme_Color::get_type(),
            'value' => \Elementor\Scheme_Color::COLOR_1,
          ],
          'condition' => [
            $this->prefix . 'skin' => 'multigradient'
          ]
        ]
      );
    }

    $this->add_control(
      $this->prefix . 'glowcolor',
      [
        'label' => __('Neon Glow Color', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'default' => MDEL_Helpers::$primary_lighter_color,
        'selectors' => [
          '{{WRAPPER}} .mdel-button-skin-neon:before' => 'background: {{VALUE}}',
        ],
        'condition' => [
          $this->prefix . 'skin' => 'neon'
        ]
      ]
    );

    $this->add_control(
      $this->prefix . 'cliptobg_type',
      [
        'label' => __('Clip Type', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => __('Image', 'your-plugin'),
        'label_off' => __('Gradient', 'your-plugin'),
        'return_value' => 'yes',
        'default' => 'yes',
        'condition' => [
          $this->prefix . 'skin' => 'cliptobg'
        ]
      ]
    );

    $this->add_control(
      $this->prefix . 'cliptobg_img',
      [
        'label' => __('Choose Image', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::MEDIA,
        'default' => [
          'url' => \Elementor\Utils::get_placeholder_image_src(),
        ],
        'conditions' => [
          'relation' => 'and',
          'terms' => [
            [
              'name' => $this->prefix . 'cliptobg_type',
              'operator' => '==',
              'value' => 'yes'
            ],
            [
              'name' => $this->prefix . 'skin',
              'operator' => '==',
              'value' => 'cliptobg'
            ]
          ]
        ]
      ]
    );

    $this->add_control(
      $this->prefix . 'clipcolorleft',
      [
        'label' => __('Clip Color Left', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'conditions' => [
          'relation' => 'and',
          'terms' => [
            [
              'name' => $this->prefix . 'cliptobg_type',
              'operator' => '!=',
              'value' => 'yes'
            ],
            [
              'name' => $this->prefix . 'skin',
              'operator' => '==',
              'value' => 'cliptobg'
            ]
          ]
        ]
      ]
    );

    $this->add_control(
      $this->prefix . 'clipcolorright',
      [
        'label' => __('Clip Color Right', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'conditions' => [
          'relation' => 'and',
          'terms' => [
            [
              'name' => $this->prefix . 'cliptobg_type',
              'operator' => '!=',
              'value' => 'yes'
            ],
            [
              'name' => $this->prefix . 'skin',
              'operator' => '==',
              'value' => 'cliptobg'
            ]
          ]
        ]
      ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
      $this->prefix . 'design_style',
      [
        'label'   => esc_html__('Basic', 'modern-addons-elementor'),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      $this->prefix . 'border_radius',
      [
        'label' => __('Border Radius', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px'],
        'selectors' => [
          '{{WRAPPER}} .mdel-fancy-button,{{WRAPPER}} .mdel-button-skin-neon:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
        ],
        'default' => [
          'top' => 0,
          'right' => 0,
          'bottom' => 0,
          'left' => 0,
          'unit' => 'px',
          'isLinked' => true,
        ]
      ]
    );

    $this->add_responsive_control(
      $this->prefix . 'inner_padding',
      [
        'label' => __('Button Inner Padding', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%'],
        'selectors' => [
          '{{WRAPPER}} .mdel-fancy-button:not(.mdel-button-skin-cliptobg)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
          '{{WRAPPER}} .mdel-button-skin-cliptobg span,{{WRAPPER}} .mdel-button-skin-cliptobg span:before' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
        ],
        'default' => [
          'top' => 15,
          'right' => 25,
          'bottom' => 15,
          'left' => 25,
          'unit' => 'px',
          'isLinked' => false,
        ],
        'devices' => ['desktop', 'tablet', 'mobile'],
        'mobile_default' => [
          'top' => 10,
          'right' => 20,
          'bottom' => 10,
          'left' => 20,
          'unit' => 'px',
        ],
      ]
    );

    $this->add_control(
      $this->prefix . 'elements_margin',
      [
        'label' => __('Margin b/w Button and Icon', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px'],
        'selectors' => [
          '{{WRAPPER}} .mdel-fancy-button span,{{WRAPPER}} .mdel-fancy-button i,{{WRAPPER}} .mdel-fancy-button svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
        ],
        'default' => [
          'top' => 0,
          'right' => 5,
          'bottom' => 0,
          'left' => 5,
          'unit' => 'px',
          'isLinked' => false,
        ]
      ]
    );

    $this->add_control(
      $this->prefix . 'font_family',
      [
        'label' => __('Font Family', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::FONT,
        //'default' => "'Open Sans', sans-serif",
        'selectors' => [
          '{{WRAPPER}} .mdel-fancy-button span' => 'font-family: {{VALUE}}',
        ],
      ]
    );

    $this->add_responsive_control(
      $this->prefix . 'font_size',
      [
        'label' => __('Font Size', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range' => [
          'px' => [
            'min' => 10,
            'max' => 200,
            'step' => 1,
          ]
        ],
        'default' => [
          'unit' => 'px',
          'size' => 16,
        ],
        'devices' => ['desktop', 'tablet', 'mobile'],
        'desktop_default' => [
          'size' => 16,
          'unit' => 'px',
        ],
        'tablet_default' => [
          'size' => 16,
          'unit' => 'px',
        ],
        'mobile_default' => [
          'size' => 14,
          'unit' => 'px',
        ],
        'selectors' => [
          '{{WRAPPER}} .mdel-fancy-button' => 'font-size: {{SIZE}}{{UNIT}};',
        ],
        'devices' => ['desktop', 'tablet', 'mobile'],
      ]
    );

    $this->add_control(
      $this->prefix . 'font_weight',
      [
        'label' => __('Font Weight', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::CHOOSE,
        'options' => [
          'normal' => [
            'title' => __('Normal', 'modern-addons-elementor'),
            'icon' => 'fab fa-yahoo',
          ],
          'semibold' => [
            'title' => __('Semi Bold', 'modern-addons-elementor'),
            'icon' => 'fab fa-amilia',
          ],
          'bold' => [
            'title' => __('Bold', 'modern-addons-elementor'),
            'icon' => 'fas fa-bold',
          ]
        ],
        'default' => 'normal',
        'toggle' => true,
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

    $icon = '';
    if ($opts[$this->prefix . 'skin'] != 'cliptobg') {
      ob_start();
      \Elementor\Icons_Manager::render_icon($opts[$this->prefix . 'icon'], ['aria-hidden' => 'true']);
      $icon = ob_get_clean();
    }

    $target = $opts[$this->prefix . 'button_link']['is_external'] ? ' target="_blank"' : '';
    $nofollow = $opts[$this->prefix . 'button_link']['nofollow'] ? ' rel="nofollow"' : '';

    $styler = $textstyler = $extraclass = '';

    if ($opts[$this->prefix . 'skin'] == 'multigradient') {
      $styler .= 'background-image:linear-gradient(90deg';

      for ($j = 1; $j <= 4; $j++) {
        $styler .= ',' . $opts[$this->prefix . 'multicolor' . $j];
      }

      $styler .= ',' . $opts[$this->prefix . 'multicolor1'] . ');';
    } else if ($opts[$this->prefix . 'skin'] == 'cliptobg') {

      if ($opts[$this->prefix . 'cliptobg_type'] == 'yes') {
        $textstyler = 'background:url(' . $opts[$this->prefix . 'cliptobg_img']['url'] . ') no-repeat center center;';

        $icon = '<span class="mdel-btn-clipbg" style="' . esc_attr($textstyler) . '"></span>';
        $extraclass = 'mdel-cliptobg-image';
      } else {

        $cleft = $opts[$this->prefix . 'clipcolorleft'];
        $cright = $opts[$this->prefix . 'clipcolorright'];

        $styler = 'border-image: linear-gradient(90deg, ' . $cleft . ' 0%, ' . $cright . ' 100%);';
        $textstyler = 'background-image:linear-gradient(90deg, ' . $cleft . ' 0%, ' . $cright . ' 100%);';

        $icon = '<span class="mdel-btn-clipbg" style="background: linear-gradient(90deg, ' . esc_attr($cleft) . ' 0%, ' . esc_attr($cright) . ' 100%);"></span>';
        $extraclass = 'mdel-cliptobg-gradient';
      }
    }

    $html = '<div class="mdel-fancy-button-holder mdel-justify-' . sanitize_html_class($opts[$this->prefix . 'button_align']) . '">

    <a href="' . esc_url($opts[$this->prefix . 'button_link']['url']) . '"' . $target . $nofollow . ' class="mdel-fancy-button mdel-icon-align-' . sanitize_html_class($opts[$this->prefix . 'icon_align']) . ' mdel-font-weight-' . sanitize_html_class($opts[$this->prefix . 'font_weight']) . ' mdel-button-skin-' . sanitize_html_class($opts[$this->prefix . 'skin']) . ' ' . sanitize_html_class($extraclass) . '" style="' . esc_attr($styler) . '">' . $icon . '<span style="' . esc_attr($textstyler) . '" class="mdel-btn-text">' . esc_html($opts[$this->prefix . 'title']) . '</span></a>

    </div>';

    echo $html;
  }
}
