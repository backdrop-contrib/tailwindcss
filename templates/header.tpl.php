<?php
/**
 * @file
 * Display generic site information such as logo, site name, etc.
 */
?>

<div class="container mx-auto px-4 py-4 flex flex-col md:flex-row md:items-center justify-between gap-4">

  <?php if ($site_name || $site_slogan || $logo): ?>
    <div class="flex flex-col sm:flex-row sm:items-center gap-3">
      <?php if ($site_name || $logo): ?>
        <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" class="group inline-flex items-center gap-3 text-gray-900 hover:text-indigo-600 transition-colors duration-200">
          <?php if ($logo): ?>
            <div class="<?php print implode(' ', $logo_wrapper_classes); ?> flex-shrink-0">
              <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" class="h-10 w-auto object-contain transition-transform group-hover:scale-105" <?php print backdrop_attributes($logo_attributes); ?> />
            </div>
          <?php endif; ?>

          <?php if ($site_name): ?>
            <span class="text-3xl md:text-3xl font-bold tracking-tight text-gray-900 group-hover:text-indigo-600">
              <?php print $site_name; ?>
            </span>
          <?php endif; ?>
        </a>
      <?php endif; ?>

      <?php if ($site_slogan): ?>
        <div class="text-sm text-gray-500 font-normal border-r border-gray-200 pr-3 rtl:border-r-0 rtl:border-l rtl:pl-3 rtl:pr-0">
          <?php print $site_slogan; ?>
        </div>
      <?php endif; ?>
    </div>
  <?php endif; ?>

  <?php if ($menu): ?>
    <nav class="header-menu flex items-center justify-end gap-4 block ltr:ml-auto rtl:mr-auto">
      <?php print $menu; ?>
    </nav>
  <?php endif; ?>

</div>