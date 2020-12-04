<?php

namespace ModernAddonsElementor\Widgets\Heading;

use ModernAddonsElementor\Inc;

class MDEL_Heading_Handler extends Inc\Handler_Widgets
{

  static function get_name()
  {
    return 'modernaddons-heading';
  }

  static function get_title()
  {
    return esc_html__('Fancy Heading', 'modern-addons-elementor');
  }

  static function get_icon()
  {
    return 'me-widget-icon eicon-heading';
  }

  static function get_categories()
  {
    return ['modernaddons'];
  }

  static function get_dir()
  {
    return MDEL_PATH . 'widgets/heading/';
  }

  static function get_url()
  {
    return MDEL_URL . 'widgets/heading/';
  }
}
