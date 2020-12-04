<?php

namespace ModernAddonsElementor\Utils;

/**
 * Helper static methods for backend
 * 
 * @since 1.0.0
 */
class MDEL_Helpers
{

  public static $default_primary_color = '#CC0C82';
  public static $primary_lighter_color = '#EEAEE3';
  public static $default_secondary_color = '#760674';

  /**
   * Check if user have selected a gradient/color scheme
   * 
   * return primary color in selected gradient
   *
   * @since 1.0.0
   * @return void
   */
  public static function get_primary_color()
  {
    $opts = (FALSE !== get_option('mdel_opts')) ? get_option('mdel_opts') : array();

    if ($opts['customprimary'] != '' && $opts['customsecondary'] != '') {
      return $opts['customprimary'];
    }

    if (isset($opts['primarycolor'])) {
      return $opts['primarycolor'];
    }

    return self::$default_primary_color;
  }

  /**
   * Check if user have selected a gradient/color scheme
   * 
   * return secondary color in selected gradient
   *
   * @since 1.0.0
   * @return void
   */
  public static function get_secondary_color()
  {
    $opts = (FALSE !== get_option('mdel_opts')) ? get_option('mdel_opts') : array();

    if ($opts['customprimary'] != '' && $opts['customsecondary'] != '') {
      return $opts['customsecondary'];
    }

    if (isset($opts['secondarycolor'])) {
      return $opts['secondarycolor'];
    }

    return self::$default_secondary_color;
  }

  /**
   * No preview notice for editor control section
   *
   * @since 1.0.0
   * @return void
   */
  public static function no_preview($handle, $prefix)
  {
    $handle->add_control(
      $prefix . 'note',
      [
        'label' => __('Note:', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::RAW_HTML,
        'raw' => '<strong>' . __('Instant preview not available for this widget. Please view on front-end.', 'modern-addons-elementor') . '</strong>',
        'content_classes' => 'mdel-info',
      ]
    );
  }

  /**
   * Pre-defined color presets/gradients to choose from
   *
   * @since 1.0.0
   * @return void
   */
  public static function color_presets()
  {

    $presets = array(
      array('#CC0C83', '#760674'),
      array('#CC0C82', '#EEAEE3'),
      array('#EEBD89', '#D13ABD'),
      array('#9600FF', '#AEBAF8'),
      array('#BB73E0', '#FF8DDB'),
      array('#0CCDA3', '#C1FCD3'),
      array('#C973FF', '#AEBAF8'),
      array('#B60F46', '#D592FF'),
      array('#A3C9E2', '#9618F7'),
      array('#849B5C', '#BFFFC7'),
      array('#E5AAC3', '#9A52C7'),
      array('#C22ED0', '#5FFAE0'),
      array('#0C7BB3', '#F2BAE8'),
      array('#58126A', '#F6B2E1'),
      array('#07A3B2', '#D9ECC7'),
      array('#50D5B7', '#067D68'),
      array('#A96F44', '#F2ECB6'),
      array('#ED765E', '#E3BDE5'),
      array('#F6A09A', '#8A1F1D'),
      array('#AF6480', '#F6B2E1'),
      array('#4B086D', '#ACC0FE'),
      array('#ED765E', '#FEA858'),
      array('#B51F1A', '#F98EF6'),
      array('#FFAFBD', '#FFC3A0'),
      array('#2193B0', '#6DD5ED'),
      array('#CC2B5E', '#753A88'),
      array('#EE9CA7', '#FFDDE1'),
      array('#DBC3C7', '#2C3E50'),
      array('#DE6262', '#FFB88C'),
      array('#06BEB6', '#48B1BF'),
      array('#EB3349', '#F45C43'),
      array('#56AB2F', '#A8E063'),
      array('#02AAB0', '#00CDAC'),
      array('#000428', '#004E92'),
      array('#7B4397', '#DC2430'),
      array('#43CEA2', '#185A9D'),
      array('#4568DC', '#B06AB3'),
      array('#4CA1AF', '#C4E0E5'),
      array('#FF5F6D', '#FFC371'),
      array('#36D1DC', '#5B86E5'),
      array('#141E30', '#243B55'),
      array('#ED4264', '#FFEDBC'),
      array('#FF9966', '#FF5E62'),
      array('#AA076B', '#61045F'),
      array('#2682E6', '#A529F2'),
    );

    return $presets;
  }

  /**
   * Find the primary & secondary colors of a choosen color preset
   *
   * @since 1.0.0
   * @param integer $find
   * @return void
   */
  public static function find_color_preset($find)
  {
    $presets = self::color_presets();

    $flag = false;
    foreach ($presets as $ky => $preset) {
      $fnd = array_search(strtoupper("#$find"), $preset);
      if (FALSE !== $fnd || $fnd === 0) {
        $flag = $ky;
      }
    }

    $key = $flag;

    return $presets[$key];

    if (FALSE === $flag) {
      return NULL;
    }
  }

  /**
   * Dummy lorem ipsum text
   *
   * @since 1.0.0
   * @return void
   */
  public static function lorem_ipsum()
  {
    $default = 'Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Curabitur aliquet quam id dui posuere blandit. Curabitur aliquet quam id dui posuere blandit.';

    return $default;
  }

  /**
   * Portrait image placeholder
   *
   * @since 1.0.0
   * @return void
   */
  public static function default_portrait_src()
  {
    $img = MDEL_URL . 'assets/img/default-portrait.jpg';

    return $img;
  }

  /**
   * Portrait image darker placeholder
   *
   * @since 1.0.0
   * @return void
   */
  public static function default_square_src()
  {
    $img = MDEL_URL . 'assets/img/default-square.jpg';

    return $img;
  }

  /**
   * Square image placeholder
   *
   * @since 1.0.0
   * @return void
   */
  public static function default_square_dark_src()
  {
    $img = MDEL_URL . 'assets/img/default-square-dark.jpg';

    return $img;
  }

  /**
   * Default gradient
   *
   * @since 1.0.0
   * @return void
   */
  public static function default_gradient($angle = 90, $location = 0)
  {
    return array(
      'fields_options' => [
        'background' => [
          'default' => 'gradient'
        ],
        'color' => [
          'default' => self::get_primary_color()
        ],
        'color_stop' => [
          'default' => [
            'size' => $location
          ]
        ],
        'color_b' => [
          'default' => self::get_secondary_color()
        ],
        'gradient_angle' => [
          'default' => [
            'unit' => 'deg',
            'size' => $angle,
          ],
        ]
      ],
    );
  }

  /**
   * Available widgets of Modern Addons
   *
   * @return array
   */
  public static function widgets_list()
  {

    $widgets = array('Imageinfobox', 'Button', 'Heading', 'Flipbox', 'Popcontent', 'Iconbox', 'Blockquote', 'Beforeafter', 'Tabs', 'Accordion', 'Horizontalimage', 'Pricingtable', 'Teammember', 'Testimonials', 'Contactform7');

    return $widgets;
  }
}
