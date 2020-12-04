<?php

namespace ModernAddonsElementor\Widgets\Pricingtable;

use ModernAddonsElementor\Inc;

class MDEL_Pricingtable_Handler extends Inc\Handler_Widgets
{

  static function get_name()
  {
    return 'modernaddons-pricingtable';
  }

  static function get_title()
  {
    return esc_html__('Pricing Table', 'modern-addons-elementor');
  }

  static function get_icon()
  {
    return 'me-widget-icon eicon-price-table';
  }

  static function get_categories()
  {
    return ['modernaddons'];
  }

  static function get_dir()
  {
    return MDEL_PATH . 'widgets/pricingtable/';
  }

  static function get_url()
  {
    return MDEL_URL . 'widgets/pricingtable/';
  }
}
