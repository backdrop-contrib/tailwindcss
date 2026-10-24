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
 * تنفيذ الإعدادات على مستوى وسم <html>
 */
function tailwindcss_preprocess_html(&$variables) {
  $site_background = theme_get_setting('site_background', 'tailwindcss');
  if (!empty($site_background)) {
    $variables['classes_array'][] = $site_background;
  }

  // // التصحيح: استخدام اسم المفتاح الصحيح toggle_dark_mode
  // $enable_dark_mode = theme_get_setting('toggle_dark_mode', 'tailwindcss');
  // $variables['enable_dark_mode'] = $enable_dark_mode;
}

/**
 * تجهيز زر الوضع الداكن للصفحة (الدالة الرسمية والصحيحة)
 */
function tailwindcss_preprocess_page(&$variables) {
  // استخدام المفتاح الصحيح الموحد
  $enable_dark_mode = theme_get_setting('toggle_dark_mode', 'tailwindcss');
  
  if ($enable_dark_mode) {
    $toggle_button = '
      <button id="dark-mode-toggle" type="button" class="fixed bottom-6 left-6 z-50 p-3 rounded-full bg-gray-200 dark:bg-gray-800 text-gray-800 dark:text-gray-200 shadow-lg hover:scale-110 transition-transform" aria-label="تبديل الوضع الداكن">
        <svg id="icon-sun" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        <svg id="icon-moon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
      </button>
    ';
    $variables['dark_mode_toggle'] = $toggle_button;
  } else {
    $variables['dark_mode_toggle'] = '';
  }
}

/**
 * تجهيز زر الوضع الداكن للهيدر
 */
function tailwindcss_preprocess_header(&$variables) {
  $enable_dark_mode = theme_get_setting('toggle_dark_mode', 'tailwindcss');
  
  if ($enable_dark_mode) {
    // كود HTML للزر مع التأكد من إضافة أبعاد ولون واضح للأيقونة
    $toggle_button = '
      <button id="dark-mode-toggle" type="button" class="inline-flex items-center justify-center p-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors" aria-label="تبديل الوضع الداكن">
        <svg id="icon-sun" class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
        <svg id="icon-moon" class="w-5 h-5 text-gray-800 dark:text-gray-100" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
        </svg>
      </button>';

    // نمرر الزر مباشرة كـ HTML صريح
    $variables['dark_mode_toggle'] = $toggle_button;
  } else {
    $variables['dark_mode_toggle'] = '';
  }
}