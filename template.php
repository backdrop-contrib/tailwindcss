<?php

/**
 * Override theme_breadcrumb().
 */
function tailwindcss_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];

  // إذا كانت المصفوفة فارغة، لا تعرض شيئًا.
  if (empty($breadcrumb)) {
    return;
  }

  // الحاوية الرئيسية: خلفية رمادية فاتحة، حواف دائرية، وحشوة داخلية.
  $output = '<nav aria-label="breadcrumb" class="m-6 bg-gray-200 rounded-lg ">';
  $output .= '<div class="p-3 inline-block">';
  $output .= '<ol class="flex items-center space-x-2 rtl:space-x-reverse text-xl font-bold text-sky-700">';

  // 1. طباعة الروابط (الآباء)
  foreach ($breadcrumb as $key => $item) {
    $output .= '<li class="flex items-center">';
    $output .= $item;
    // إضافة فاصل بعد كل رابط (بما أننا سنضيف العنوان في النهاية)
    $output .= '<span class="mx-2 text-gray-400">/</span>';
    $output .= '</li>';
  }

  // 2. جلب عنوان الصفحة الحالية وإضافته في النهاية
  $current_title = backdrop_get_title();
  if (!empty($current_title)) {
    $output .= '<li class="flex items-center">';
    // نعرض العنوان كنص عادي (غير قابل للنقر) بلون رمادي غامق
    $output .= '<span class="text-gray-500 font-normal">' . $current_title . '</span>';
    $output .= '</li>';
  }

  $output .= '</ol>';
  $output .= '</div>';
  $output .= '</nav>';

  return $output;
}