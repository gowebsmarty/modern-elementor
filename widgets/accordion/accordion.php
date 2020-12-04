<?php

namespace ModernAddonsElementor\Widgets\Accordion;

use \ModernAddonsElementor\Widgets\Accordion\MDEL_Accordion_Handler as Handler;

use \ModernAddonsElementor\Utils\MDEL_Templating;
use \ModernAddonsElementor\Utils\MDEL_Helpers;

if (!defined('ABSPATH')) exit;

/**
 * Advanced accordion widget
 *
 * @since 1.0.0
 */
class MDEL_Accordion extends \Elementor\Widget_Base
{

  private $prefix = 'mdel_accordion_';

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
      $this->prefix . 'boxed',
      [
        'label' => __('Boxed Style', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => __('Enable', 'your-plugin'),
        'label_off' => __('Disable', 'your-plugin'),
        'return_value' => 'yes',
        'default' => 'yes'
      ]
    );

    $this->add_control(
      $this->prefix . 'accordionstyle',
      [
        'label' => __('Accordion Tab Style', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::SELECT2,
        'multiple' => false,
        'label_block' => true,
        'options' => [
          'one'  => __('Style One', 'modern-addons-elementor'),
          'two' => __('Style Two - require icons', 'modern-addons-elementor'),
        ],
        'default' => 'one',
      ]
    );

    $repeater = new \Elementor\Repeater();

    $repeater->add_control(
      'title',
      [
        'label' => __('Accordion Title', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __('Accordion Title', 'modern-addons-elementor'),
        'label_block' => true,
      ]
    );

    $repeater->add_control(
      'icon',
      [
        'label' => __('Icon', 'text-domain'),
        'type' => \Elementor\Controls_Manager::ICONS,
        'default' => [
          'value' => '',
          'library' => 'solid',
        ],
      ]
    );

    $repeater->add_control(
      $this->prefix . 'tabtype',
      [
        'label' => __('Accordion Content', 'modern-addons-elementor'),
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

    $repeater->add_control(
      $this->prefix . 'tabhtml',
      [
        'label' => __('Custom HTML', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::WYSIWYG,
        'placeholder' => __('Enter custom HTML here', 'modern-addons-elementor'),
        'condition' => [
          $this->prefix . 'tabtype' => 'custom'
        ]
      ]
    );

    $condition = array(
      'condition' => [
        $this->prefix . 'tabtype' => 'template'
      ]
    );

    MDEL_Templating::get_template_control($repeater, $this->prefix, $condition);


    $this->add_control(
      $this->prefix . 'tablist',
      [
        'label' => __('Accordions List', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::REPEATER,
        'fields' => $repeater->get_controls(),
        'default' => [
          [
            'title' => __('Accordion Title #1', 'modern-addons-elementor'),
          ],
          [
            'title' => __('Accordion Title #2', 'modern-addons-elementor'),
          ],
        ],
        'title_field' => '{{{ title }}}',
      ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
      $this->prefix . 'tabhover',
      [
        'label' => __('Accordion Hover', 'modern-addons-elementor'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Background::get_type(),
      array_merge(
        [
          'name' => $this->prefix . 'activebackground',
          'label' => __('Active Accordion Background', 'modern-addons-elementor'),
          'types' => ['classic', 'gradient'],
          'selector' => '{{WRAPPER}} .mdel-accordion h3.ui-state-active',
        ],
        MDEL_Helpers::default_gradient()
      )
    );

    $this->add_control(
      $this->prefix . 'activeborder',
      [
        'label' => __('Active Accordion border color', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'default' => MDEL_Helpers::get_primary_color(),
        'selectors' => [
          '{{WRAPPER}} .mdel-accordion h3.ui-state-active' => 'border-color: {{VALUE}}',
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

    $extraclass = '';

    if ($opts[$this->prefix . 'boxed'] != 'yes') {
      $extraclass .= ' mdel-accordion-not-boxed';
    }

    if ($opts[$this->prefix . 'accordionstyle'] == 'two') {
      $extraclass .= ' mdel-accordion-style-2';
    }

    $html = '<div class="mdel-accordion ' . $extraclass . '">';

    if (isset($opts[$this->prefix . 'tablist'])) {

      for ($i = 0; $i < count($opts[$this->prefix . 'tablist']); $i++) {
        $tab = $opts[$this->prefix . 'tablist'][$i];

        if ($tab[$this->prefix . 'tabtype'] == 'custom') {
          $accordioncontent = wp_kses_post($tab[$this->prefix . 'tabhtml']);
        } else {
          $accordioncontent = MDEL_Templating::render_template_content($this->prefix, $tab);
        }

        $accordtitle = $tab['title'];
        if ($opts[$this->prefix . 'accordionstyle'] == 'two') {
          $accordtitle = '<span class="accordion-title-2">' . esc_html($accordtitle) . '</span>';
        }

        ob_start();
        \Elementor\Icons_Manager::render_icon($tab['icon'], ['aria-hidden' => 'true']);
        $icon = ob_get_clean();

        $html .= '<h3>' . $icon . $accordtitle . '</h3>';
        $html .= '<div>' . $accordioncontent . '</div>';
      }
    }

    $html .= '</div>';

    echo $html;
  }
}
