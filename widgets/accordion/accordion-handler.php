<?php

namespace ModernAddonsElementor\Widgets\Accordion;

use ModernAddonsElementor\Inc;

class MDEL_Accordion_Handler extends Inc\Handler_Widgets
{

  static function get_name()
  {
    return 'modernaddons-accordion';
  }

  static function get_title()
  {
    return esc_html__('Accordion', 'modern-addons-elementor');
  }

  static function get_icon()
  {
    return 'me-widget-icon eicon-accordion';
  }

  static function get_categories()
  {
    return ['modernaddons'];
  }

  static function get_dir()
  {
    return MDEL_PATH . 'widgets/accordion/';
  }

  static function get_url()
  {
    return MDEL_URL . 'widgets/accordion/';
  }
}
