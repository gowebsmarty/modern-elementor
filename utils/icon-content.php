<?php

namespace ModernAddonsElementor\Utils;

/**
 * Helper class for icon box based widgets
 * 
 * @since 1.0.0
 */
class MDEL_Icon_Content
{

  public static function get_controls($obj, $prefix, $condition = array(), $textcolor = '#fff')
  {

    $obj->add_control(
      $prefix . 'icon',

      array_merge(
        [
          'label' => __('Icon', 'text-domain'),
          'type' => \Elementor\Controls_Manager::ICONS,
          'default' => [
            'value' => 'fas fa-crown',
            'library' => 'solid',
          ]
        ],
        $condition
      )

    );

    $obj->add_control(
      $prefix . 'iconoverlay',
      array_merge(
        [
          'label' => __('Icon Overlay', 'modern-addons-elementor'),
          'type' => \Elementor\Controls_Manager::SWITCHER,
          'label_on' => __('Show', 'your-plugin'),
          'label_off' => __('Hide', 'your-plugin'),
          'return_value' => 'yes',
          'default' => 'no',
        ],
        $condition
      )
    );

    $obj->add_control(
      $prefix . 'icontitle',
      array_merge(
        [
          'label' => __('Title', 'modern-addons-elementor'),
          'type' => \Elementor\Controls_Manager::TEXT,
          'default' => __('Featured Title', 'modern-addons-elementor'),
          'placeholder' => __('Type your heading here', 'modern-addons-elementor'),
        ],
        $condition
      )
    );

    $obj->add_control(
      $prefix . 'icondesc',
      array_merge(
        [
          'label' => __('Description', 'modern-addons-elementor'),
          'description' => __('Leave empty to hide description', 'modern-addons-elementor'),
          'type' => \Elementor\Controls_Manager::TEXTAREA,
          'rows' => 10,
          'placeholder' => __('Type your description here', 'modern-addons-elementor'),
          'default' => MDEL_Helpers::lorem_ipsum()
        ],
        $condition
      )
    );

    $obj->add_control(
      $prefix . 'iconbuttontext',
      array_merge(
        [
          'label' => __('Button Text', 'modern-addons-elementor'),
          'description' => __('Leave empty to hide button', 'modern-addons-elementor'),
          'type' => \Elementor\Controls_Manager::TEXT,
          'placeholder' => __('Read More', 'modern-addons-elementor'),
        ],
        $condition
      )
    );

    $obj->add_control(
      $prefix . 'iconbuttonlink',
      array_merge(
        [
          'label' => __('Button Link', 'modern-addons-elementor'),
          'type' => \Elementor\Controls_Manager::URL,
          'placeholder' => __('https://your-link.com', 'modern-addons-elementor'),
          'show_external' => true,
          'default' => [
            'url' => '',
            'is_external' => true,
            'nofollow' => true,
          ],
        ],
        $condition
      )
    );

    $obj->add_control(
      $prefix . 'iconboxlink',
      array_merge(
        [
          'label' => __('Entire Box Link', 'modern-addons-elementor'),
          'description' => __('Entire icon box will be linked & button will not be shown. Please leave this empty if you want button.', 'modern-addon-elementor'),
          'type' => \Elementor\Controls_Manager::URL,
          'placeholder' => __('https://your-link.com', 'modern-addons-elementor'),
          'show_external' => true,
          'default' => [
            'url' => '',
            'is_external' => true,
            'nofollow' => true,
          ],
        ],
        $condition
      )
    );

    $obj->add_control(
      $prefix . 'iconalign',
      array_merge(
        [
          'label' => __('Alignment', 'modern-addons-elementor'),
          'type' => \Elementor\Controls_Manager::CHOOSE,
          'options' => [
            'left' => [
              'title' => __('Left', 'modern-addons-elementor'),
              'icon' => 'fa fa-align-left',
            ],
            'center' => [
              'title' => __('Center', 'modern-addons-elementor'),
              'icon' => 'fa fa-align-center',
            ],
            'right' => [
              'title' => __('Right', 'modern-addons-elementor'),
              'icon' => 'fa fa-align-right',
            ],
          ],
          'default' => 'center',
          'toggle' => true,
        ],
        $condition
      )
    );

    $obj->add_responsive_control(
      $prefix . 'iconpadding',
      array_merge(
        [
          'label' => __('Icon box Padding', 'modern-addons-elementor'),
          'type' => \Elementor\Controls_Manager::DIMENSIONS,
          'size_units' => ['px'],
          'selectors' => [
            '{{WRAPPER}} .mdel-icon-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
          ],
          'default' => [
            'top' => 20,
            'right' => 20,
            'bottom' => 20,
            'left' => 20,
            'unit' => 'px',
            'isLinked' => true,
          ],
          'devices' => ['desktop', 'tablet', 'mobile'],
        ],
        $condition
      )
    );

    $obj->add_control(
      $prefix . 'textcolor',
      array_merge(
        [
          'label' => __('Text Color', 'modern-addons-elementor'),
          'type' => \Elementor\Controls_Manager::COLOR,
          'scheme' => [
            'type' => \Elementor\Scheme_Color::get_type(),
            'value' => \Elementor\Scheme_Color::COLOR_1,
          ],
          'default' => $textcolor,
          'selectors' => [
            '{{WRAPPER}} .mdel-icon-content i,{{WRAPPER}} .mdel-icon-content svg,{{WRAPPER}} .mdel-icon-content h3,{{WRAPPER}} .mdel-icon-content p,{{WRAPPER}} .mdel-icon-content a' => 'color: {{VALUE}}'
          ],
        ],
        $condition
      )
    );
  }

  public static function render_icon_content($prefix, $opts, $standalone = false)
  {

    ob_start();
    \Elementor\Icons_Manager::render_icon($opts[$prefix . 'icon'], ['aria-hidden' => 'true']);
    $icon = ob_get_clean();

    if ($opts[$prefix . 'iconoverlay'] === 'yes') {
      $icon = '<span class="mdel-iconbox-overlay">' . $icon . '</span>';
    }

    $iconheading = ($opts[$prefix . 'icontitle'] != '') ? '<h3>' . esc_html($opts[$prefix . 'icontitle']) . '</h3>' : '';

    $target = $opts[$prefix . 'iconbuttonlink']['is_external'] ? ' target="_blank"' : '';
    $nofollow = $opts[$prefix . 'iconbuttonlink']['nofollow'] ? ' rel="nofollow"' : '';

    $link = $backgrounddiv = $extraclass = $wraplinkstart = $wraplinkend = '';

    if ($opts[$prefix . 'iconbuttontext'] != '') {
      $link = '<a href="' . esc_url($opts[$prefix . 'iconbuttonlink']['url']) . '"' . $target . $nofollow . '>' . esc_html($opts[$prefix . 'iconbuttontext']) . '</a>';
    }

    //if (isset($opts[$prefix . 'iconboxbackground'])) {
    $backgrounddiv = '<div class="mdel-iconbox-background"></div>';
    //}

    if (isset($opts[$prefix . 'iconboxskin']) && $opts[$prefix . 'iconboxskin'] == 'shaded') {
      $backgrounddiv .= '<div class="mdel-iconbox-shade mdel-shade-' . sanitize_html_class($opts[$prefix . 'shadeangle']) . '"></div>';
    }

    if (isset($opts[$prefix . 'iconboxskin'])) {
      $extraclass = ' mdel-iconbox-skin-' . sanitize_html_class($opts[$prefix . 'iconboxskin']);
    }

    $paragraph = '';
    if ($opts[$prefix . 'icondesc'] != '') {
      $paragraph = '<p class="mdel-text-align-' . sanitize_html_class($opts[$prefix . 'iconalign']) . '">' . esc_html($opts[$prefix . 'icondesc']) . '</p>';
    }

    //since 1.0.2
    if ($opts[$prefix . 'iconboxlink']['url'] != '') {
      $target = $opts[$prefix . 'iconboxlink']['is_external'] ? ' target="_blank"' : '';
      $nofollow = $opts[$prefix . 'iconboxlink']['nofollow'] ? ' rel="nofollow"' : '';
      $link = ''; //no button

      $wraplinkstart = '<a href="' . esc_url($opts[$prefix . 'iconboxlink']['url']) . '"' . $target . $nofollow . ' class="mdel-iconbox-link">';
      $wraplinkend = '</a>';
    }

    if ($standalone && $opts[$prefix . 'iconboxhover'] != '#ffffff') {
      $extraclass .= ' mdel-iconbox-shadow';
    }

    $html = $wraplinkstart . '
    <div class="mdel-icon-content mdel-direction-column mdel-justify-' . sanitize_html_class($opts[$prefix . 'iconalign']) . $extraclass . '">    
    ' . $backgrounddiv . '
    ' . $icon . $iconheading . '  
    ' . $paragraph . '  
    ' . $link . '    
    </div>
    ' . $wraplinkend;

    return $html;
  }
}
