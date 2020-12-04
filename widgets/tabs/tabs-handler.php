<?php

namespace ModernAddonsElementor\Widgets\Tabs;

use ModernAddonsElementor\Inc;

class MDEL_Tabs_Handler extends Inc\Handler_Widgets
{

  static function get_name()
  {
    return 'modernaddons-tabs';
  }

  static function get_title()
  {
    return esc_html__('Tabs', 'modern-addons-elementor');
  }

  static function get_icon()
  {
    return 'me-widget-icon eicon-tabs';
  }

  static function get_categories()
  {
    return ['modernaddons'];
  }

  static function get_dir()
  {
    return MDEL_PATH . 'widgets/tabs/';
  }

  static function get_url()
  {
    return MDEL_URL . 'widgets/tabs/';
  }
}
