<?php
// In your theme's theme-settings.php file

function tailwindcss_form_system_theme_settings_alter(&$form, &$form_state) {

  // 1. Create vertical tabs container
  $form['tailwindcss_tabs'] = array(
    '#type' => 'vertical_tabs',
    '#default_tab' => 'edit-background-options', // (Optional) Default selected tab
    '#prefix' => '<h2><small>' . t('tailwindcss Settings') . '</small></h2>',
    '#weight' => -10,    
  );

  // 2. Background settings tab
  $form['background_options'] = array(
    '#type' => 'fieldset',
    '#title' => t('Background settings'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
    '#group' => 'tailwindcss_tabs', // Key: Link to tabs container
  );

  // Background field (supports gradients and multiple colors)
  $form['background_options']['site_background'] = array(
    '#type' => 'textfield',
    '#title' => t('Site background classes (< body >)'),
    '#default_value' => theme_get_setting('site_background', 'tailwindcss'),
    '#description' => t('Enter Tailwind background classes. Examples:<br>
      <code>bg-white dark:bg-gray-900</code><br>
      <code>bg-gradient-to-b from-sky-100 via-slate-100 to-white</code>'),
    '#size' => 60, // Field width approximately
    '#maxlength' => 255, // Maximum number of characters

  );
    // ... (after site_background field) ...

  // Header background
  $form['background_options']['header_background'] = array(
    '#type' => 'textfield',
    '#title' => t('Site Header classes (< header >)'),
    '#default_value' => theme_get_setting('header_background', 'tailwindcss'),
    '#description' => t('Examples : <code>bg-white dark:bg-gray-800</code>'),
    '#size' => 60,
  );

  // Footer background
  $form['background_options']['footer_background'] = array(
    '#type' => 'textfield',
    '#title' => t('Site Footer classes (< footer >)'),
    '#default_value' => theme_get_setting('footer_background', 'tailwindcss'),
    '#description' => t('Examples : <code>bg-gray-900 text-white</code>'),
    '#size' => 60,
  );
  
  // 3. Breadcrumb settings tab
  $form['dark_mode'] = array(
    '#type' => 'fieldset',
    '#title' => t('Dark Mode settings'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
    '#group' => 'tailwindcss_tabs', // Key: Link to the same tabs container
  );
  // Dark mode activation option
  $form['dark_mode']['toggle_dark_mode'] = array(
    '#type' => 'checkbox',
    '#title' => t('Enable Dark Mode'),
    // 1. Added 'tailwindcss' here to fetch the value from the correct theme settings table
    '#default_value' => theme_get_setting('toggle_dark_mode', 'tailwindcss'),
    '#description' => t('When enabled, dark mode will be applied site-wide using Tailwind classes.'),
  );

  // 3. Breadcrumb settings tab
  $form['breadcrumb_options'] = array(
    '#type' => 'fieldset',
    '#title' => t('Breadcrumb settings'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
    '#group' => 'tailwindcss_tabs', // Key: Link to the same tabs container
  );

  // 1. Option to show/hide breadcrumbs entirely
  $form['breadcrumb_options']['toggle_breadcrumb'] = array(
    '#type' => 'checkbox',
    '#title' => t('Show breadcrumbs'),
    '#default_value' => theme_get_setting('toggle_breadcrumb', 'tailwindcss'),
    '#description' => t('When unchecked, breadcrumbs will be hidden from all site pages.'),
  );

  // 2. Option to hide the home page link only
  $form['breadcrumb_options']['hide_home_breadcrumb'] = array(
    '#type' => 'checkbox',
    '#title' => t('Hide "Home" link from breadcrumb'),
    '#default_value' => theme_get_setting('hide_home_breadcrumb', 'tailwindcss'),
    '#description' => t('Removes the Home link from the beginning of the breadcrumb trail while keeping the remaining links.'),
    '#states' => array(
      'visible' => array(
        ':input[name="toggle_breadcrumb"]' => array('checked' => TRUE),
      ),
    ),
  );

}
