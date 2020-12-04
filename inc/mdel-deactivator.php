<?php

namespace ModernAddonsElementor;

class MDEL_Deactivator
{

  public static function deactivate()
  {
    delete_option('mdel_opts');
  }
}

MDEL_Deactivator::deactivate();
