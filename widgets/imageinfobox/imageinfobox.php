<?php

namespace ModernAddonsElementor\Widgets\Imageinfobox;

use \ModernAddonsElementor\Widgets\Imageinfobox\MDEL_ImageInfoBox_Handler as Handler;

use \ModernAddonsElementor\Utils\MDEL_Helpers;

if (!defined('ABSPATH')) exit;

/**
 * Image with Info Box animation.
 *
 * @since 1.0.0
 */
class MDEL_Imageinfobox extends \Elementor\Widget_Base
{

  private $prefix = 'mdel_imageinfobox_';

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
          'icon'  => __('Icon Clip', 'modern-addons-elementor'),
          'image' => __('Image Clip', 'modern-addons-elementor'),
        ],
        'default' => 'icon',
      ]
    );

    $this->add_control(
      $this->prefix . 'image',
      [
        'label' => __('Choose Image', 'modern-addons-elementor'),
        'description' => __('Portrait images are best for this widget', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::MEDIA,
        'default' => [
          'url' => MDEL_Helpers::default_portrait_src(),
        ],
      ]
    );

    $this->add_control(
      $this->prefix . 'icon',
      [
        'label' => __('Info Icon', 'text-domain'),
        'type' => \Elementor\Controls_Manager::ICONS,
        'default' => [
          'value' => 'fas fa-info',
          'library' => 'solid',
        ],
        'condition' => [
          $this->prefix . 'skin' => 'icon'
        ]
      ]
    );

    $this->add_control(
      $this->prefix . 'glowingicon',
      [
        'label' => __('Make Icon Glow', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => __('Yes', 'your-plugin'),
        'label_off' => __('No', 'your-plugin'),
        'return_value' => 'yes',
        'default' => 'yes',
        'condition' => [
          $this->prefix . 'skin' => 'icon'
        ]
      ]
    );

    $this->add_control(
      $this->prefix . 'title',
      [
        'label' => __('Headline', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __('Awesome Headline', 'modern-addons-elementor'),
        'placeholder' => __('Type your headline here', 'modern-addons-elementor'),
      ]
    );

    $this->add_control(
      $this->prefix . 'description',
      [
        'label' => __('Info Box Content', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::WYSIWYG,
        'default' => MDEL_Helpers::lorem_ipsum(),
        'placeholder' => __('Type your content here', 'modern-addons-elementor'),
      ]
    );

    $this->add_control(
      $this->prefix . 'readmore',
      [
        'label' => __('Show Read More Button', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => __('Show', 'your-plugin'),
        'label_off' => __('Hide', 'your-plugin'),
        'return_value' => 'yes',
        'default' => 'yes',
      ]
    );

    $this->add_control(
      $this->prefix . 'readmore_title',
      [
        'label' => __('Button Text', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __('Read More', 'modern-addons-elementor'),
        'condition' => [
          $this->prefix . 'readmore' => 'yes'
        ],
        //'placeholder' => __('Type your headline here', 'modern-addons-elementor'),
      ]
    );

    $this->add_control(
      $this->prefix . 'readmore_link',
      [
        'label' => __('Button Link', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::URL,
        'placeholder' => __('https://your-link.com', 'modern-addons-elementor'),
        'show_external' => true,
        'default' => [
          'url' => '',
          'is_external' => false,
          'nofollow' => true,
        ],
        'condition' => [
          $this->prefix . 'readmore' => 'yes'
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
          '{{WRAPPER}} .mdel-fancy-img-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
          '{{WRAPPER}} .mdel-fancy-img-text img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'default' => [
          'top' => 10,
          'right' => 10,
          'bottom' => 10,
          'left' => 10,
          'unit' => 'px',
          'isLinked' => true,
        ],
        'condition' => [
          $this->prefix . 'skin' => 'icon'
        ]
      ]
    );

    $this->add_control(
      $this->prefix . 'inner_padding',
      [
        'label' => __('Inner Padding', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', 'em'],
        'selectors' => [
          '{{WRAPPER}} .mdel-fancy-img-subcontent' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
        'default' => 'left',
        'toggle' => true,
      ]
    );

    $this->add_control(
      $this->prefix . 'hoverspeed',
      [
        'label' => __('Hover Animation Speed in Seconds', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'min' => 1,
        'max' => 5,
        'step' => 1,
        'default' => 1,
        'condition' => [
          $this->prefix . 'skin' => 'icon'
        ]
      ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
      $this->prefix . 'hoverbackground',
      [
        'label'   => esc_html__('Background and Colors', 'modern-addons-elementor'),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Background::get_type(),
      array_merge(
        [
          'name' => $this->prefix . 'background',
          'label' => __('Hover Background', 'modern-addons-elementor'),
          'types' => ['classic', 'gradient'],
          'selector' => '{{WRAPPER}} .mdel-fancy-img-content',
          'condition' => [
            $this->prefix . 'skin' => 'icon'
          ]
        ],
        MDEL_Helpers::default_gradient(45)
      )
    );

    $this->add_control(
      $this->prefix . 'glowcolor',
      [
        'label' => __('Info Icon Glow Color', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'default' => MDEL_Helpers::$primary_lighter_color,
        'selectors' => [
          '{{WRAPPER}} .mdel-fancy-img-text:not(.disableglow):before' => 'background: {{VALUE}}',
        ],
        'condition' => [
          $this->prefix . 'skin' => 'icon'
        ]
      ]
    );

    $this->add_control(
      $this->prefix . 'textcolor',
      [
        'label' => __('Text Content Color', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'default' => '#fff',
        'selectors' => [
          '{{WRAPPER}} .mdel-fancy-img-text p,{{WRAPPER}} .mdel-fancy-img-text a,{{WRAPPER}} .mdel-fancy-img-text h3' => 'color: {{VALUE}}',
          '{{WRAPPER}} .mdel-fancy-img-text a' => 'border-color: {{VALUE}}'
        ],
      ]
    );

    $this->add_control(
      $this->prefix . 'iconcolor',
      [
        'label' => __('Info Icon Color', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'default' => '#fff',
        'selectors' => [
          '{{WRAPPER}} .mdel-fancy-img-text i,{{WRAPPER}} .mdel-fancy-img-text svg' => 'color: {{VALUE}}'
        ],
        'condition' => [
          $this->prefix . 'skin' => 'icon'
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

    $this->add_inline_editing_attributes($this->prefix . 'title', 'basic');

    if ($opts[$this->prefix . 'image']['id'] == '') {
      $img = '<img src="' . esc_attr($opts[$this->prefix . 'image']['url']) . '"/>';
    } else {
      $img = wp_get_attachment_image((int) $opts[$this->prefix . 'image']['id'], 'large');
    }

    $iconglow = $opts[$this->prefix . 'glowingicon'] === 'yes' ? '' : ' disableglow';

    $icon = '';
    if ($opts[$this->prefix . 'skin'] == 'icon') {
      ob_start();
      \Elementor\Icons_Manager::render_icon($opts[$this->prefix . 'icon'], ['aria-hidden' => 'true']);
      $icon = ob_get_clean();
    } else {
      $iconglow .= ' mdel-imginfo-skin-imageclip';
    }

    $html = '<div class="mdel-fancy-img-text' . $iconglow . '">      
    ' . $img . '
      <div class="mdel-fancy-img-content" style="transition-duration:' . esc_attr($opts[$this->prefix . 'hoverspeed']) . 's">
        <span class="mdel-fancy-opener">' . $icon . '</span>
        <div class="mdel-fancy-img-subcontent" style="text-align:' . esc_attr($opts[$this->prefix . 'text_align']) . '">
        <h3 ' . $this->get_render_attribute_string($this->prefix . 'title') . '>' . esc_html($opts[$this->prefix . 'title']) . '</h3>
        <p>' . wp_kses_post($opts[$this->prefix . 'description']) . '</p>
        ';

    if ($opts[$this->prefix . 'readmore'] === 'yes') {
      $target = $opts[$this->prefix . 'readmore_link']['is_external'] ? ' target="_blank"' : '';
      $nofollow = $opts[$this->prefix . 'readmore_link']['nofollow'] ? ' rel="nofollow"' : '';

      $html .= '<a href="' . $opts[$this->prefix . 'readmore_link']['url'] . '"' . $target . $nofollow . ' class="mdel-fancy-img-btn">' . esc_html($opts[$this->prefix . 'readmore_title']) . '</a>';
    }

    $html .= '</div>
      </div>

    </div>';

    echo $html;
  }
}
