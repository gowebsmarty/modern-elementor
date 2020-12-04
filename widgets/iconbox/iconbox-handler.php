<?php

namespace ModernAddonsElementor\Widgets\Iconbox;

use ModernAddonsElementor\Inc;

class MDEL_Iconbox_Handler extends Inc\Handler_Widgets
{

  static function get_name()
  {
    return 'modernaddons-iconbox';
  }

  static function get_title()
  {
    return esc_html__('Icon Box', 'modern-addons-elementor');
  }

  static function get_icon()
  {
    return 'me-widget-icon eicon-icon-box';
  }

  static function get_categories()
  {
    return ['modernaddons'];
  }

  static function get_dir()
  {
    return MDEL_PATH . 'widgets/iconbox/';
  }

  static function get_url()
  {
    return MDEL_URL . 'widgets/iconbox/';
  }
}
