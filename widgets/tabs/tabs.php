<?php

namespace ModernAddonsElementor\Widgets\Tabs;

use \ModernAddonsElementor\Widgets\Tabs\MDEL_Tabs_Handler as Handler;

use \ModernAddonsElementor\Utils\MDEL_Templating;
use \ModernAddonsElementor\Utils\MDEL_Helpers;

if (!defined('ABSPATH')) exit;

/**
 * Advanced Tabs widget
 *
 * @since 1.0.0
 */
class MDEL_Tabs extends \Elementor\Widget_Base
{

  private $prefix = 'mdel_tabs_';

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
      $this->prefix . 'tabstyle',
      [
        'label' => __('Tab Style', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::SELECT2,
        'multiple' => false,
        'label_block' => true,
        'options' => [
          'horizontal'  => __('Horizontal', 'modern-addons-elementor'),
          'vertical' => __('Vertical', 'modern-addons-elementor'),
        ],
        'default' => 'horizontal',
      ]
    );

    $this->add_control(
      $this->prefix . 'boxed',
      [
        'label' => __('Boxed Tabs', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => __('Enable', 'your-plugin'),
        'label_off' => __('Disable', 'your-plugin'),
        'return_value' => 'yes',
        'default' => 'no'
      ]
    );

    $this->add_control(
      $this->prefix . 'fullwidth',
      [
        'label' => __('Fullwidth', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => __('Enable', 'your-plugin'),
        'label_off' => __('Disable', 'your-plugin'),
        'return_value' => 'yes',
        'default' => 'no',
        'condition' => [
          $this->prefix . 'tabstyle' => 'horizontal'
        ]
      ]
    );

    $this->add_control(
      $this->prefix . 'leftalign',
      [
        'label' => __('Left Align Tabs', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => __('Enable', 'your-plugin'),
        'label_off' => __('Disable', 'your-plugin'),
        'return_value' => 'yes',
        'default' => 'no',
        'condition' => [
          $this->prefix . 'tabstyle' => 'horizontal'
        ]
      ]
    );

    $repeater = new \Elementor\Repeater();

    $repeater->add_control(
      'title',
      [
        'label' => __('Tab Title', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __('Tab Title', 'modern-addons-elementor'),
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
        'label' => __('Tab Content', 'modern-addons-elementor'),
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
        'label' => __('Tabs List', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::REPEATER,
        'fields' => $repeater->get_controls(),
        'default' => [
          [
            'title' => __('Tab Title #1', 'modern-addons-elementor'),
          ],
          [
            'title' => __('Tab Title #2', 'modern-addons-elementor'),
          ],
        ],
        'title_field' => '{{{ title }}}',
      ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
      $this->prefix . 'tabhover',
      [
        'label' => __('Tab Hover', 'modern-addons-elementor'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Background::get_type(),
      array_merge(
        [
          'name' => $this->prefix . 'activebackground',
          'label' => __('Active Tab Background', 'modern-addons-elementor'),
          'types' => ['classic', 'gradient'],
          'selector' => '{{WRAPPER}} .mdel-tabs ul li.ui-state-active',
        ],
        MDEL_Helpers::default_gradient()
      )
    );

    $this->add_control(
      $this->prefix . 'activeborder',
      [
        'label' => __('Active tab border color', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'default' => MDEL_Helpers::get_primary_color(),
        'selectors' => [
          '{{WRAPPER}} .mdel-tabs ul li.ui-state-active' => 'border-color: {{VALUE}}',
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

    if ($opts[$this->prefix . 'boxed'] == 'yes') {
      $extraclass .= ' mdel-tabs-boxed';
    }

    if ($opts[$this->prefix . 'fullwidth'] == 'yes') {
      $extraclass .= ' mdel-tabs-fullwidth';
    }

    if ($opts[$this->prefix . 'leftalign'] == 'yes') {
      $extraclass .= ' mdel-tabs-leftalign';
    }

    $html = '<div class="mdel-tabs mdel-tabs-' . sanitize_html_class($opts[$this->prefix . 'tabstyle']) . $extraclass . '">';

    if (isset($opts[$this->prefix . 'tablist'])) {
      $html .= '<ul>';
      for ($i = 0; $i < count($opts[$this->prefix . 'tablist']); $i++) {
        $tab = $opts[$this->prefix . 'tablist'][$i];

        ob_start();
        \Elementor\Icons_Manager::render_icon($tab['icon'], ['aria-hidden' => 'true']);
        $icon = ob_get_clean();

        $html .= '<li><a href="#mdeltabs-' . $i . '">' . $icon . esc_html($tab['title']) . '</a></li>';
      }
      $html .= '</ul>';
    }

    if (isset($opts[$this->prefix . 'tablist'])) {

      for ($i = 0; $i < count($opts[$this->prefix . 'tablist']); $i++) {
        $tab = $opts[$this->prefix . 'tablist'][$i];

        $html .= '<div id="mdeltabs-' . $i . '">';

        if ($tab[$this->prefix . 'tabtype'] == 'custom') {
          $html .= wp_kses_post($tab[$this->prefix . 'tabhtml']);
        } else {
          $html .= MDEL_Templating::render_template_content($this->prefix, $tab);
        }

        $html .= '</div>';
      }
    }

    echo $html;
  }
}
