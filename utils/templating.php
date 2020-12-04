<?php

namespace ModernAddonsElementor\Utils;

use Elementor\Frontend;

/**
 * Helper class related to saved templates
 * 
 * @since 1.0.0
 */
class MDEL_Templating
{

  /**
   * Get templates list with IDs
   *
   * @since 1.0.0
   * @return void
   */
  public static function get_template_control($handle, $prefix, $condition = array())
  {

    $args = array(
      'post_type' => 'elementor_library',
      'post_status' => 'publish',
      'posts_per_page' => -1
    );

    wp_reset_query();

    $templates = get_posts($args);

    $options = array();
    foreach ($templates as $item) {
      $options[$item->ID] = $item->post_title;
    }


    $handle->add_control(
      $prefix . 'section_list',
      array_merge(
        [
          'label' => __('Choose Section', 'modern-addons-elementor'),
          'type' => \Elementor\Controls_Manager::SELECT2,
          'multiple' => false,
          'label_block' => true,
          'options' => $options,
        ],
        $condition
      )
    );
  }

  /**
   * Forms list of Contact form 7
   *
   * @since 1.0.0
   * @return void
   */
  public static function get_cf7_list_control($handle, $prefix)
  {

    $args = array('post_type' => 'wpcf7_contact_form', 'posts_per_page' => -1);
    $cf7forms = get_posts($args);

    $options = array();
    foreach ($cf7forms as $cf7) {
      $options[$cf7->ID] = $cf7->post_title;
    }

    $handle->add_control(
      $prefix . 'cf7_list',
      [
        'label' => __('Choose Contact Form', 'modern-addons-elementor'),
        'type' => \Elementor\Controls_Manager::SELECT2,
        'multiple' => false,
        'label_block' => true,
        'options' => $options,
      ]
    );
  }

  /**
   * Render Elementor saved section using section ID
   *
   * @since 1.0.0
   * @return void
   */
  public static function render_template_content($prefix, $opts)
  {

    $sectionID = (int) $opts[$prefix . 'section_list'];

    $frontend = new Frontend;

    $tempcontent = $frontend->get_builder_content($sectionID, true);

    return $tempcontent;
  }
}
