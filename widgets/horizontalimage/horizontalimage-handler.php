<?php

namespace ModernAddonsElementor\Widgets\Horizontalimage;

use ModernAddonsElementor\Inc;

class MDEL_Horizontalimage_Handler extends Inc\Handler_Widgets
{

  static function get_name()
  {
    return 'modernaddons-horizontalimage';
  }

  static function get_title()
  {
    return esc_html__('Horizontal Image Card', 'modern-addons-elementor');
  }

  static function get_icon()
  {
    return 'me-widget-icon eicon-image-rollover';
  }

  static function get_categories()
  {
    return ['modernaddons'];
  }

  static function get_dir()
  {
    return MDEL_PATH . 'widgets/horizontalimage/';
  }

  static function get_url()
  {
    return MDEL_URL . 'widgets/horizontalimage/';
  }
}
