<?php

namespace ModernAddonsElementor;

defined('ABSPATH') || exit;

/**
 * Autoloader.
 * Dynamic class loading.
 *
 * @since 1.0.0
 */
if (!class_exists('\ModernAddon\Autoloader')) :

  class Autoloader
  {

    /**
     * Run autoloader.
     *
     * @since 1.0.0
     * @access public
     */
    public static function run()
    {
      spl_autoload_register([__CLASS__, 'autoload']);
    }

    /**
     * Autoload.
     * For a given class, check if it exist and load it.
     *
     * @since 1.0.0
     * @access private
     * @param string $class Class name.
     */
    private static function autoload($class_name)
    {

      // If the class being requested does not start with our prefix
      // we know it's not one in our project.
      if (false === strpos($class_name, 'ModernAddonsElementor')) {
        return;
      }

      // Split the class name into an array to read the namespace and class.
      $file_parts = explode('\\', $class_name);

      ///print_r($file_parts);

      // Do a reverse loop through $file_parts to build the path to the file.
      $namespace = '';
      for ($i = count($file_parts) - 1; $i > 0; $i--) {
        // Read the current component of the file part.
        $current = strtolower($file_parts[$i]);
        $current = str_ireplace('MDEL_', '', $current);
        $current = str_ireplace('_', '-', $current);

        if (count($file_parts) - 1 === $i) {
          $file_name = "$current.php";
        } else {
          if ($i == 1) {
            $namespace = $current . $namespace;
          } else {
            $namespace = '/' . $current . $namespace;
          }
        }
      }

      $filepath  = plugin_dir_path(__FILE__) . trailingslashit($namespace);
      $filepath .= $file_name;

      if (file_exists($filepath)) {
        require_once($filepath);
      }
    }
  }

endif;
