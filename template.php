<?php
/**
 * Override theme_breadcrumb().
 */
function tailwindcss_breadcrumb($variables) {
  $toggle_breadcrumb     = theme_get_setting('toggle_breadcrumb', 'tailwindcss');
  $hide_home_breadcrumb  = theme_get_setting('hide_home_breadcrumb', 'tailwindcss');

  if (!$toggle_breadcrumb) {
    return;
  }

  $breadcrumb = $variables['breadcrumb'];
  if (empty($breadcrumb)) {
    return;
  }

  if ($hide_home_breadcrumb && !empty($breadcrumb)) {
    $first_key = key($breadcrumb);
    if (strpos($breadcrumb[$first_key], 'href="' . url('<front>') . '"') !== false 
        || strpos($breadcrumb[$first_key], 'href="/"') !== false) {
      unset($breadcrumb[$first_key]);
      $breadcrumb = array_values($breadcrumb);
    }
  }

  $output = '<nav aria-label="breadcrumb" class="m-6 dark:bg-gray-800 dark:border-gray-700 bg-gray-200 rounded-lg ">';
  $output .= '<div class="p-3 inline-block">';
  $output .= '<ol class="flex items-center space-x-2 rtl:space-x-reverse text-xl font-bold text-sky-700">';

  foreach ($breadcrumb as $key => $item) {
    $output .= '<li class="flex items-center">';
    $output .= $item;
    $output .= '<span class="mx-2 text-gray-400">/</span>';
    $output .= '</li>';
  }

  $current_title = backdrop_get_title();
  if (!empty($current_title)) {
    $output .= '<li class="flex items-center">';
    $output .= '<span class="dark:text-gray-300 text-gray-500 font-normal">' . $current_title . '</span>';
    $output .= '</li>';
  }

  $output .= '</ol>';
  $output .= '</div>';
  $output .= '</nav>';

  return $output;
}

/**
 * Bind the save function to the theme settings form.
 */
function tailwindcss_form_system_theme_settings_alter(&$form, &$form_state) {
  // Bind immediate save function
  $form['#submit'][] = 'tailwindcss_save_safelist_immediate';
}

/**
 * Actual function to write to the file.
 */
function tailwindcss_write_safelist_file($all_classes) {
  $theme_path = backdrop_get_path('theme', 'tailwindcss');
  $src_dir = $theme_path . '/src';
  $safelist_path = $src_dir . '/safelist.txt';
  
  // Ensure the src directory exists
  if (!is_dir($src_dir)) {
    mkdir($src_dir, 0755, TRUE);
  }

  if (!empty($all_classes)) {
    // Clean and split classes
    $clean_classes = preg_replace('/\s+/', ' ', trim($all_classes));
    $classes = explode(' ', $clean_classes);
    $new_content = implode("\n", $classes) . "\n";
    
    // Read current content to prevent redundant writes
    $current_content = file_exists($safelist_path) ? file_get_contents($safelist_path) : '';
    
    if ($current_content !== $new_content && is_writable($src_dir)) {
      file_put_contents($safelist_path, $new_content);
    }
  } else {
    // Clear file if there are no classes
    if (file_exists($safelist_path) && is_writable($src_dir)) {
      file_put_contents($safelist_path, '');
    }
  }
}

/**
 * Read settings from JSON file and write classes to safelist.txt
 */
function tailwindcss_save_safelist_immediate($form, &$form_state) {
  // Gather all fields in an array
  $all_classes = '';
  $fields = array('site_background', 'header_background', 'footer_background');
  
  foreach ($fields as $field) {
    if (isset($form_state['values'][$field])) {
      $all_classes .= ' ' . $form_state['values'][$field];
    }
  }
  
  // Write combined classes to the file
  tailwindcss_write_safelist_file($all_classes);
}

function tailwindcss_update_safelist_from_json() {
  $config_path = config_get_config_directory('active') . '/tailwindcss.settings.json';
  if (file_exists($config_path)) {
    $settings = json_decode(file_get_contents($config_path), TRUE);
    $all_classes = '';
    $fields = array('site_background', 'header_background', 'footer_background');
    
    foreach ($fields as $field) {
      if (isset($settings[$field])) {
        $all_classes .= ' ' . $settings[$field];
      }
    }
    tailwindcss_write_safelist_file($all_classes);
  }
}

/**
 * Prepare page dark mode button
 */
function tailwindcss_preprocess_page(&$variables) {
    tailwindcss_update_safelist_from_json();
  // ==========================================
  // 1. Handle site background (site_background)
  // ==========================================
  $site_background = theme_get_setting('site_background', 'tailwindcss');
  
  if (!empty($site_background)) {
    // Clean text from extra spaces or newlines
    $clean_background = preg_replace('/\s+/', ' ', trim($site_background));
    
    // Add clean classes to the page's classes array
    $variables['classes'][] = $clean_background;
  }

}

/**
 * Prepare header dark mode button
 */
function tailwindcss_preprocess_header(&$variables) {
  $enable_dark_mode = theme_get_setting('toggle_dark_mode', 'tailwindcss');

  if ($enable_dark_mode) {
    // HTML code for the button ensuring icon dimensions and color
    $toggle_button = '
      <button id="dark-mode-toggle" type="button" class="inline-flex items-center justify-center p-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors" aria-label="تبديل الوضع الداكن">
        <svg id="icon-sun" class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
        <svg id="icon-moon" class="w-5 h-5 text-gray-800 dark:text-gray-100" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
        </svg>
      </button>';

    // Pass the button directly as raw HTML
    $variables['dark_mode_toggle'] = $toggle_button;
  } else {
    $variables['dark_mode_toggle'] = '';
  }
}

/**
 * Pass background settings to the layout file (layout.tpl.php).
 */
function tailwindcss_preprocess_layout(&$variables) {
  // Pass header background
  $variables['header_bg'] = theme_get_setting('header_background', 'tailwindcss');
  
  // Pass footer background
  $variables['footer_bg'] = theme_get_setting('footer_background', 'tailwindcss');
  
}