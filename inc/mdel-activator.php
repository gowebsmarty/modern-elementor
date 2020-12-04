<?php

namespace ModernAddonsElementor;

class MDEL_Activator
{

  public static function activate()
  {
    include_once plugin_dir_path(__DIR__) . 'autoloader.php';
    \ModernAddonsElementor\Autoloader::run();

    wp_schedule_single_event(time() + 9000, 'mdel_show_reviewrequest');
  }
}

MDEL_Activator::activate();
