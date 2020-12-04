<?php

namespace ModernAddonsElementor\Widgets\Popcontent;

use ModernAddonsElementor\Inc;

class MDEL_Popcontent_Handler extends Inc\Handler_Widgets
{

  static function get_name()
  {
    return 'modernaddons-popcontent';
  }

  static function get_title()
  {
    return esc_html__('Pop Content', 'modern-addons-elementor');
  }

  static function get_icon()
  {
    return 'me-widget-icon eicon-photo-library';
  }

  static function get_categories()
  {
    return ['modernaddons'];
  }

  static function get_dir()
  {
    return MDEL_PATH . 'widgets/popcontent/';
  }

  static function get_url()
  {
    return MDEL_URL . 'widgets/popcontent/';
  }
}
