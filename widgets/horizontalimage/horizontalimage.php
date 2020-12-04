<?php

namespace ModernAddonsElementor\Widgets\Horizontalimage;

use \ModernAddonsElementor\Widgets\Horizontalimage\MDEL_Horizontalimage_Handler as Handler;

use \ModernAddonsElementor\Utils\MDEL_Templating;
use \ModernAddonsElementor\Utils\MDEL_Helpers;

if (!defined('ABSPATH')) exit;

/**
 * Horizontal image box animation widget
 *
 * @since 1.0.0
 */
class MDEL_Horizontalimage extends \Elementor\Widget_Base
{

  private $prefix = 'mdel_horizontalimage_';

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
      $this->prefix . 'firstimage',
      [
        'label' => __('First Image', 'modern-addons-elementor'),
        'description' => __('Instant preview not available for this widget', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::MEDIA,
        'default' => [
          'url' => MDEL_Helpers::default_square_src(),
        ],
      ]
    );

    $this->add_control(
      $this->prefix . 'secondimage',
      [
        'label' => __('Second Image', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::MEDIA,
        'default' => [
          'url' => MDEL_Helpers::default_square_dark_src(),
        ],
      ]
    );

    $this->add_control(
      $this->prefix . 'imageplacement',
      [
        'label' => __('Image Placement', 'modern-addons-elementor'),
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
      $this->prefix . 'background',
      [
        'label' => __('Background Color', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'default' => '#fafafa',
        'selectors' => [
          '{{WRAPPER}} .mdel-vimg-card' => 'background: {{VALUE}}',
        ],
      ]
    );

    $this->add_control(
      $this->prefix . 'contenttype',
      [
        'label' => __('Box Content', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::SELECT2,
        'multiple' => false,
        'label_block' => true,
        'options' => [
          'custom'  => __('Custom HTML', 'modern-addons-elementor'),
          'template' => __('Elementor Saved Template', 'modern-addons-elementor'),
        ],
        'default' => 'custom',
      ]
    );

    $this->add_control(
      $this->prefix . 'customhtml',
      [
        'label' => __('Custom HTML', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::WYSIWYG,
        'placeholder' => __('Enter custom HTML here', 'modern-addons-elementor'),
        'default' => MDEL_Helpers::lorem_ipsum() . MDEL_Helpers::lorem_ipsum() . '<br><br><br>' . MDEL_Helpers::lorem_ipsum(),
        'condition' => [
          $this->prefix . 'contenttype' => 'custom'
        ]
      ]
    );

    $condition = array(
      'condition' => [
        $this->prefix . 'contenttype' => 'template'
      ]
    );

    MDEL_Templating::get_template_control($this, $this->prefix, $condition);

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

    if ($opts[$this->prefix . 'firstimage']['id'] == '') {
      $before = $opts[$this->prefix . 'firstimage']['url'];
    } else {
      $before = wp_get_attachment_image_src($opts[$this->prefix . 'firstimage']['id'], 'large');
      $before = $before[0];
    }

    if ($opts[$this->prefix . 'secondimage']['id'] == '') {
      $after = $opts[$this->prefix . 'secondimage']['url'];
    } else {
      $after = wp_get_attachment_image_src($opts[$this->prefix . 'secondimage']['id'], 'large');
      $after = $after[0];
    }

    $html = '<div class="mdel-vimg-card mdel-vimg-align-' . sanitize_html_class($opts[$this->prefix . 'imageplacement']) . '">
    
    <div class="mdel-vimg-block">
    <div class="mdel-vimg-inner">    
    <div style="background:url(' . esc_url($before) . ') no-repeat center center;" class="mdel-first-vimg"></div>
    <div style="background:url(' . esc_url($after) . ') no-repeat center center;" class="mdel-second-vimg"></div>
    </div>
    </div>

    <div class="mdel-vimg-content">';

    if ($opts[$this->prefix . 'contenttype'] == 'custom') {
      $html .= wp_kses_post($opts[$this->prefix . 'customhtml']);
    } else {
      $html .= MDEL_Templating::render_template_content($this->prefix, $opts);
    }

    $html .= '
    </div>

 </div>';

    echo $html;
  }
}
