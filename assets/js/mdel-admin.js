(function ($) {
  'use strict';

  $(".mdel-sidebar a").click(function () {
    event.preventDefault();

    var id = $(this).attr('href');

    $(".mdel-inner-section").fadeOut('fast').removeClass("active").promise().done(function () {
      $(id).fadeIn("fast").addClass("active");
    });

    $(".mdel-sidebar a").removeClass("active");

    $(this).addClass("active");

  });

})(jQuery);