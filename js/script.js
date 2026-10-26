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
      $('body').addClass('no-background-blend-mode');
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
 * Activate light/dark mode toggle button.
 */
Backdrop.behaviors.darkModeToggle = {
  attach: function(context, settings) {
    // Search for the button in the current context (supports AJAX)
    var toggleBtn = document.getElementById('dark-mode-toggle');
    
    // Check if button exists and hasn't been processed yet
    if (!toggleBtn || toggleBtn.hasAttribute('data-dark-mode-processed')) {
      return;
    }
    
    // ✅ This is the condition: if button doesn't exist, stop immediately
    if (!toggleBtn || toggleBtn.hasAttribute('data-dark-mode-processed')) {
      return; 
    }
    
    // Mark the button to prevent duplicate processing
    toggleBtn.setAttribute('data-dark-mode-processed', 'true');

    var iconSun = document.getElementById('icon-sun');
    var iconMoon = document.getElementById('icon-moon');
    
    // Function to update icons based on mode
    function updateIcons(isDark) {
      if (isDark) {
        if (iconSun) iconSun.classList.remove('hidden');
        if (iconMoon) iconMoon.classList.add('hidden');
      } else {
        if (iconSun) iconSun.classList.add('hidden');
        if (iconMoon) iconMoon.classList.remove('hidden');
      }
    }

    // 1. Check saved visitor preference or system settings
    var userPref = localStorage.getItem('theme');
    var systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    
    var isDark = (userPref === 'dark') || (!userPref && systemPrefersDark);

    // Apply initial mode
    if (isDark) {
      document.body.classList.add('dark');
      updateIcons(true);
    } else {
      document.body.classList.remove('dark');
      updateIcons(false);
    }

    // 2. Activate button on click
    toggleBtn.addEventListener('click', function() {
      var currentlyDark = document.body.classList.toggle('dark');
      localStorage.setItem('theme', currentlyDark ? 'dark' : 'light');
      updateIcons(currentlyDark);
    });
  }
};

})(jQuery);