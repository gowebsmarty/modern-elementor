<?php

namespace ModernAddonsElementor\Widgets\Blockquote;

use ModernAddonsElementor\Inc;

class MDEL_Blockquote_Handler extends Inc\Handler_Widgets
{

  static function get_name()
  {
    return 'modernaddons-blockquote';
  }

  static function get_title()
  {
    return esc_html__('Blockquote', 'modern-addons-elementor');
  }

  static function get_icon()
  {
    return 'me-widget-icon eicon-blockquote';
  }

  static function get_categories()
  {
    return ['modernaddons'];
  }

  static function get_dir()
  {
    return MDEL_PATH . 'widgets/blockquote/';
  }

  static function get_url()
  {
    return MDEL_URL . 'widgets/blockquote/';
  }
}
