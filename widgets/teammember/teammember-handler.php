<?php

namespace ModernAddonsElementor\Widgets\Teammember;

use ModernAddonsElementor\Inc;

class MDEL_Teammember_Handler extends Inc\Handler_Widgets
{

  static function get_name()
  {
    return 'modernaddons-teammember';
  }

  static function get_title()
  {
    return esc_html__('Team Member', 'modern-addons-elementor');
  }

  static function get_icon()
  {
    return 'me-widget-icon eicon-person';
  }

  static function get_categories()
  {
    return ['modernaddons'];
  }

  static function get_dir()
  {
    return MDEL_PATH . 'widgets/teammember/';
  }

  static function get_url()
  {
    return MDEL_URL . 'widgets/teammember/';
  }
}
