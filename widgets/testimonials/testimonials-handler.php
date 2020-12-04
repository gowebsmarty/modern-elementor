<?php

namespace ModernAddonsElementor\Widgets\Testimonials;

use ModernAddonsElementor\Inc;

class MDEL_Testimonials_Handler extends Inc\Handler_Widgets
{

  static function get_name()
  {
    return 'modernaddons-testimonials';
  }

  static function get_title()
  {
    return esc_html__('Testimonials', 'modern-addons-elementor');
  }

  static function get_icon()
  {
    return 'me-widget-icon eicon-testimonial-carousel';
  }

  static function get_categories()
  {
    return ['modernaddons'];
  }

  static function get_dir()
  {
    return MDEL_PATH . 'widgets/testimonials/';
  }

  static function get_url()
  {
    return MDEL_URL . 'widgets/testimonials/';
  }
}
