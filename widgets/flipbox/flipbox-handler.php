<?php

namespace ModernAddonsElementor\Widgets\Flipbox;

use ModernAddonsElementor\Inc;

class MDEL_Flipbox_Handler extends Inc\Handler_Widgets
{

  static function get_name()
  {
    return 'modernaddons-flipbox';
  }

  static function get_title()
  {
    return esc_html__('Flip Box', 'modern-addons-elementor');
  }

  static function get_icon()
  {
    return 'me-widget-icon eicon-flip-box';
  }

  static function get_categories()
  {
    return ['modernaddons'];
  }

  static function get_dir()
  {
    return MDEL_PATH . 'widgets/flipbox/';
  }

  static function get_url()
  {
    return MDEL_URL . 'widgets/flipbox/';
  }
}
