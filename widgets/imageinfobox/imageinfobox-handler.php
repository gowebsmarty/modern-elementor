<?php

namespace ModernAddonsElementor\Widgets\Imageinfobox;

use ModernAddonsElementor\Inc;

class MDEL_ImageInfoBox_Handler extends Inc\Handler_Widgets
{

  static function get_name()
  {
    return 'modernaddons-imageinfobox';
  }

  static function get_title()
  {
    return esc_html__('Image Info Box', 'modern-addons-elementor');
  }

  static function get_icon()
  {
    return 'me-widget-icon eicon-info-box';
  }

  static function get_categories()
  {
    return ['modernaddons'];
  }

  static function get_dir()
  {
    return MDEL_PATH . 'widgets/imageinfobox/';
  }

  static function get_url()
  {
    return MDEL_URL . 'widgets/imageinfobox/';
  }
}
