<?php

namespace ModernAddonsElementor\Widgets\Beforeafter;

use ModernAddonsElementor\Inc;

class MDEL_Beforeafter_Handler extends Inc\Handler_Widgets
{

  static function get_name()
  {
    return 'modernaddons-beforeafter';
  }

  static function get_title()
  {
    return esc_html__('Before After Slider', 'modern-addons-elementor');
  }

  static function get_icon()
  {
    return 'me-widget-icon eicon-image-before-after';
  }

  static function get_categories()
  {
    return ['modernaddons'];
  }

  static function get_dir()
  {
    return MDEL_PATH . 'widgets/beforeafter/';
  }

  static function get_url()
  {
    return MDEL_URL . 'widgets/beforeafter/';
  }
}
