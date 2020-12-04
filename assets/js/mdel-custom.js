(function ($) {
  'use strict';

  //Before after image slider
  $('.mdel-ba-slider').each(function () {
    $(this).beforeAfter();
  });

  //Tabs
  $(".mdel-tabs-horizontal").tabs({
    show: {
      effect: "fade",
      duration: 800
    }
  });

  $(".mdel-tabs-vertical").tabs({
    show: {
      effect: "fade",
      duration: 800
    }
  }).addClass("ui-tabs-vertical ui-helper-clearfix");
  $(".mdel-tabs-vertical li").removeClass("ui-corner-top").addClass("ui-corner-left");

  //Accordion
  $(".mdel-accordion").accordion({
    heightStyle: "content"
  });

  //Testimonials
  $('.mdel-testimonials-carousel ul').bxSlider({
    auto: true
  });

  //Contact form 7
  // $('body').on('focus change blur focusin active', '.mdel-contact-form7 input:not(.wpcf7-submit)', function () {
  //   $(this).closest('label').addClass("mdel-active");
  // });

  // $('.mdel-contact-form7 input:not(.wpcf7-submit)').focus(function () {
  //   $(this).closest('label').addClass("mdel-active");
  // });

  // $('.mdel-contact-form7 input:not(.wpcf7-submit)').focusout(function () {
  //   if ($(this).val() != '') {
  //     $(this).closest('label').removeClass("mdel-active");
  //   }
  // });

  // $('.mdel-contact-form7 input:not(.wpcf7-submit)').each(function () {
  //   if ($(this).val() != '') {
  //     $(this).closest('label').addClass("mdel-active");
  //   }
  // });

})(jQuery);