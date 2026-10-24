<?php
// في ملف theme-settings.php الخاص بقالبك

function tailwindcss_form_system_theme_settings_alter(&$form, &$form_state) {

  // 1. إنشاء حاوية التبويبات العمودية
  $form['tailwindcss_tabs'] = array(
    '#type' => 'vertical_tabs',
    '#default_tab' => 'edit-background-options', // (اختياري) التبويب المحدد افتراضيًا
    '#prefix' => '<h2><small>' . t('tailwindcss Settings') . '</small></h2>',
    '#weight' => -10,    
  );

  // 2. تبويب إعدادات الخلفية
  $form['background_options'] = array(
    '#type' => 'fieldset',
    '#title' => t('إعدادات الخلفية'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
    '#group' => 'tailwindcss_tabs', // المفتاح: الربط بحاوية التبويبات
  );

  // إضافة حقول الخلفية إلى تبويب background_options
  $form['background_options']['site_background'] = array(
    '#type' => 'select',
    '#title' => t('لون خلفية الموقع'),
    '#options' => array(
      'bg-white' => t('أبيض'),
      'bg-gray-100' => t('رمادي فاتح'),
      'bg-gray-900' => t('رمادي داكن'),
    ),
    '#default_value' => theme_get_setting('site_background', 'tailwindcss'),
  );
// خيار تفعيل الوضع الداكن
  $form['background_options']['toggle_dark_mode'] = array(
    '#type' => 'checkbox',
    '#title' => t('تفعيل الوضع الداكن (Dark Mode)'),
    // 1. أضفنا 'tailwindcss' هنا لكي يتم جلب القيمة من جدول إعدادات الثيم الصحيح
    '#default_value' => theme_get_setting('toggle_dark_mode', 'tailwindcss'),
    '#description' => t('عند تفعيله، سيتم تطبيق الوضع الداكن على الموقع بالكامل باستخدام كلاسات Tailwind.'),
  );

  // 3. تبويب إعدادات Breadcrumbs
  $form['breadcrumb_options'] = array(
    '#type' => 'fieldset',
    '#title' => t('إعدادات مسار التنقل'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
    '#group' => 'tailwindcss_tabs', // المفتاح: الربط بنفس حاوية التبويبات
  );

  // 1. خيار إظهار/إخفاء مسار التنقل بالكامل
  $form['breadcrumb_options']['toggle_breadcrumb'] = array(
    '#type' => 'checkbox',
    '#title' => t('إظهار مسار التنقل (Breadcrumbs)'),
    '#default_value' => theme_get_setting('toggle_breadcrumb', 'tailwindcss'),
    '#description' => t('عند إلغاء التحديد، سيتم إخفاء مسار التنقل من جميع صفحات الموقع.'),
  );

  // 2. خيار إخفاء رابط الصفحة الرئيسية فقط
  $form['breadcrumb_options']['hide_home_breadcrumb'] = array(
    '#type' => 'checkbox',
    '#title' => t('إخفاء رابط "الصفحة الرئيسية" من مسار التنقل'),
    '#default_value' => theme_get_setting('hide_home_breadcrumb', 'tailwindcss'),
    '#description' => t('سيؤدي هذا إلى إزالة رابط الصفحة الرئيسية من بداية المسار مع الإبقاء على بقية الروابط.'),
    '#states' => array(
      'visible' => array(
        ':input[name="toggle_breadcrumb"]' => array('checked' => TRUE),
      ),
    ),
  );

    // تبويب لاستعادة الإعدادات
  $form['reset_options'] = array(
    '#type' => 'fieldset',
    '#title' => t('إعادة تعيين'),
    '#group' => 'tailwindcss_tabs',
  );
  
  $form['reset_options']['reset_info'] = array(
    '#markup' => '<p>' . t('لإعادة تعيين الإعدادات، قم بحذف القيم وتغييرها يدوياً، أو استخدم زر مسح الكاش.') . '</p>',
  );

}