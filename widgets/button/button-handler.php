<?php

namespace ModernAddonsElementor\Widgets\Button;

use ModernAddonsElementor\Inc;

class MDEL_Button_Handler extends Inc\Handler_Widgets
{

  static function get_name()
  {
    return 'modernaddons-button';
  }

  static function get_title()
  {
    return esc_html__('Modern Button', 'modern-addons-elementor');
  }

  static function get_icon()
  {
    return 'me-widget-icon eicon-dual-button';
  }

  static function get_categories()
  {
    return ['modernaddons'];
  }

  static function get_dir()
  {
    return MDEL_PATH . 'widgets/button/';
  }

  static function get_url()
  {
    return MDEL_URL . 'widgets/button/';
  }
}
