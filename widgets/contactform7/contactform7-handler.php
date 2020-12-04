<?php

namespace ModernAddonsElementor\Widgets\Contactform7;

use ModernAddonsElementor\Inc;

class MDEL_Contactform7_Handler extends Inc\Handler_Widgets
{

  static function get_name()
  {
    return 'modernaddons-contactform7';
  }

  static function get_title()
  {
    return esc_html__('Contact form 7', 'modern-addons-elementor');
  }

  static function get_icon()
  {
    return 'me-widget-icon eicon-form-horizontal';
  }

  static function get_categories()
  {
    return ['modernaddons'];
  }

  static function get_dir()
  {
    return MDEL_PATH . 'widgets/contactform7/';
  }

  static function get_url()
  {
    return MDEL_URL . 'widgets/contactform7/';
  }
}
