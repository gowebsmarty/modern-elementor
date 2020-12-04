<?php

namespace ModernAddonsElementor\Widgets\Testimonials;

use \ModernAddonsElementor\Widgets\Testimonials\MDEL_Testimonials_Handler as Handler;

use \ModernAddonsElementor\Utils\MDEL_Helpers;

if (!defined('ABSPATH')) exit;

/**
 * Testimonial carousel widget
 *
 * @since 1.0.0
 */
class MDEL_Testimonials extends \Elementor\Widget_Base
{

  private $prefix = 'mdel_testimonials_';

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
      $this->prefix . 'testimonial_align',
      [
        'label' => __('Alignment', 'modern-addons-elementor'),
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

    $repeater = new \Elementor\Repeater();

    $repeater->add_control(
      $this->prefix . 'image',
      [
        'label' => __('Image', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::MEDIA,
        'default' => [
          'url' => MDEL_Helpers::default_square_dark_src(),
        ],
      ]
    );

    $repeater->add_control(
      $this->prefix . 'rating',
      [
        'label' => __('Rating', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'min' => 1,
        'max' => 5,
        'step' => 0.5,
        'default' => 4.5
      ]
    );

    $repeater->add_control(
      $this->prefix . 'name',
      [
        'label' => __('Name', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __('Author Name', 'modern-addons-elementor'),
        'label_block' => true,
      ]
    );

    $repeater->add_control(
      $this->prefix . 'title',
      [
        'label' => __('Title', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __('Business Manager', 'modern-addons-elementor'),
        'label_block' => true,
      ]
    );

    $repeater->add_control(
      $this->prefix . 'testimony',
      [
        'label' => __('Testimony', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::TEXTAREA,
        'rows' => 10,
        'default' => MDEL_Helpers::lorem_ipsum(),
        'placeholder' => __('Type testimonial content here', 'modern-addons-elementor'),
      ]
    );

    $this->add_control(
      $this->prefix . 'testimonialslist',
      [
        'label' => __('Testimonials', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::REPEATER,
        'fields' => $repeater->get_controls(),
        'default' => [
          [
            'name' => __('Author One', 'modern-addons-elementor'),
          ],
          [
            'name' => __('Author Two', 'modern-addons-elementor'),
          ],
        ],
        'title_field' => '{{{ name }}}',
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
      $this->prefix . 'textcolor',
      [
        'label' => __('Text Color', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'default' => '#333',
        'selectors' => [
          '{{WRAPPER}} .mdel-testimony,{{WRAPPER}} h4,{{WRAPPER}} small' => 'color: {{VALUE}}'
        ]
      ]
    );

    $this->add_control(
      $this->prefix . 'starcolor',
      [
        'label' => __('Star Color', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'default' => '#F38526',
        'selectors' => [
          '{{WRAPPER}} i,{{WRAPPER}} svg' => 'color: {{VALUE}}'
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

    $align = $opts[$this->prefix . 'testimonial_align'];

    $html = '<div class="mdel-testimonials-carousel">
    <ul class="mdel-testimonial-align-' . sanitize_html_class($align) . '">';

    if (isset($opts[$this->prefix . 'testimonialslist'])) {
      foreach ($opts[$this->prefix . 'testimonialslist'] as $item) {

        if ($item[$this->prefix . 'image']['id'] == '') {
          $img = $item[$this->prefix . 'image']['url'];
        } else {
          $img = wp_get_attachment_image_src($item[$this->prefix . 'image']['id'], 'thumbnail');
          $img = $img[0];
        }

        $testimonial = '<div class="mdel-testimony">' . esc_html($item[$this->prefix . 'testimony']) . '</div>';

        $testimonial .= '<div class="mdel-testimonial-rating">';

        for ($r = 1; $r <= $item[$this->prefix . 'rating']; $r++) {
          $testimonial .= '<i class="fas fa-star"></i>';
        }

        if (is_float($item[$this->prefix . 'rating'])) {
          $testimonial .= '<i class="fas fa-star-half-alt"></i>';
        }

        $testimonial .= '</div>';

        $testimonial .= '<div class="mdel-testimonial-writer">
        
        <div class="mdel-testi-img"><img src="' . esc_url($img) . '"/></div>
        <div class="mdel-testi-autho"><h4>' . esc_html($item[$this->prefix . 'name']) . '</h4><small>' . esc_html($item[$this->prefix . 'title']) . '</small></div>

        </div>';

        $html .= '<li>' . wp_kses_post($testimonial) . '</li>';
      }
    }

    $html .= '
    </ul>
    </div>';

    echo $html;
  }
}
