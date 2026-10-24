(function ($) {

"use strict";

Backdrop.behaviors.toggles = {
  attach: function(context, settings) {
    var $toggles = $(context).find('[data-toggle]').once('toggle');

    $toggles.on('click', function(){
      var $this = $(this);
      var $target = $('[data-toggleable="' + $this.attr('data-toggle') + '"]');
      $target.toggleClass('js-toggled');
    });
  }
};

/**
 * Override tableDragHandle().
 */
Backdrop.theme.prototype.tableDragHandle = function() {
  return '<a href="#" title="' + Backdrop.t('Drag to re-order') + '" class="tabledrag-handle"><div class="handle"><div class="handle-inner">&nbsp;</div></div></a>';
};

/**
 * Tests for background-blend-mode used on some hero elements
 *
 * @return {boolean} True if browser supports background-blend-mode.
 *
 */
Backdrop.featureDetect.backgroundBlendMode = function() {
  var $body = $('body'),
  $testElement = $('<div style="background-blend-mode: luminosity; width: 0; height: 0;"></div>');

  if ($body.hasClass('has-background-blend-mode')) {
    return true;
  } else if ($body.hasClass('no-background-blend-mode')) {
    return false;
  } else {
    $body.append($testElement);
    if ($testElement.css('background-blend-mode') === 'luminosity') {
      $('body').addClass('has-background-blend-mode');
      $testElement.remove();
      return true;
    }
    else {
      $body.addClass('no-background-blend-mode');
      $testElement.remove();
      return false;
    }
  }
}

$(document).ready(function() {
  Backdrop.featureDetect.backgroundBlendMode();
  Backdrop.featureDetect.flexbox();
});

/**
 * تفعيل زر التبديل بين الوضع الفاتح والداكن.
 */
Backdrop.behaviors.darkModeToggle = {
  attach: function(context, settings) {
    // البحث عن الزر في السياق الحالي (يدعم AJAX)
    var toggleBtn = document.getElementById('dark-mode-toggle');
    
    // التحقق من وجود الزر ولم يتم معالجته مسبقاً
    if (!toggleBtn || toggleBtn.hasAttribute('data-dark-mode-processed')) {
      return;
    }
    
    // ✅ هذا هو الشرط الذي نتحدث عنه: إذا لم يوجد الزر، توقف فوراً
    if (!toggleBtn || toggleBtn.hasAttribute('data-dark-mode-processed')) {
      return; 
    }
    
    // وضع علامة على الزر لمنع تكرار المعالجة
    toggleBtn.setAttribute('data-dark-mode-processed', 'true');

    var iconSun = document.getElementById('icon-sun');
    var iconMoon = document.getElementById('icon-moon');
    
    // دالة لتحديث الأيقونات بناءً على الوضع
    function updateIcons(isDark) {
      if (isDark) {
        if (iconSun) iconSun.classList.remove('hidden');
        if (iconMoon) iconMoon.classList.add('hidden');
      } else {
        if (iconSun) iconSun.classList.add('hidden');
        if (iconMoon) iconMoon.classList.remove('hidden');
      }
    }

    // 1. التحقق من تفضيل الزائر المحفوظ أو إعدادات النظام
    var userPref = localStorage.getItem('theme');
    var systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    
    var isDark = (userPref === 'dark') || (!userPref && systemPrefersDark);

    // تطبيق الوضع الأولي
    if (isDark) {
      document.body.classList.add('dark');
      updateIcons(true);
    } else {
      document.body.classList.remove('dark');
      updateIcons(false);
    }

    // 2. تفعيل الزر عند النقر
    toggleBtn.addEventListener('click', function() {
      var currentlyDark = document.body.classList.toggle('dark');
      localStorage.setItem('theme', currentlyDark ? 'dark' : 'light');
      updateIcons(currentlyDark);
    });
  }
};

})(jQuery);
