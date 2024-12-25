jQuery(document).ready(function ($) {
  // Initialize Magnific Popup for elements with the class '.open-popup-link'
  $('.open-popup-link').magnificPopup({
    type: 'inline',
    midClick: true,
    removalDelay: 300,
    mainClass: 'mfp-fade',
    callbacks: {
      open: function () {
        var post_id = $(this.st.el).closest('li').data('id');
        // Trigger AJAX request to get the description
        $.ajax({
          url: ajax_object.ajaxurl, // WordPress admin-ajax URL
          method: 'POST',
          data: {
            action: 'get_slider_description', // Action for handling AJAX in WordPress
            post_id: post_id
          },
          beforeSend: function () {
            $('.popup-content').html('Loading...');
          },
          success: function (response) {
            if (response.success) {
              $('.popup-content').html(response.data.description);
            } else {
              $('.popup-content').html('Description not available.');
            }
          },
          error: function () {
            $('.popup-content').html('Error loading description.');
          }
        });
      }
    }
  });

  // Initialize Swiper slider for elements with the class '.swiper-container'
  const swiper = new Swiper('.swiper-container', {
    loop: true,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    autoplay: {
      delay: 5000,
    },
    slidesPerView: 1,
    spaceBetween: 16,
    breakpoints: {
      1440: {
        slidesPerView: 4,
        spaceBetween: 37.33,
      },
      992: {
        slidesPerView: 3,
        spaceBetween: 26,
      },
      768: {
        slidesPerView: 2,
        spaceBetween: 20,
      },
      480: {
        slidesPerView: 1,
        spaceBetween: 16,
      },
    },
    observer: true,
    observeParents: true,
  });

  // Pause autoplay when mouse enters the swiper container
  swiper.el.addEventListener('mouseenter', function () {
    swiper.autoplay.stop();
  });

  // Resume autoplay when mouse leaves the swiper container
  swiper.el.addEventListener('mouseleave', function () {
    swiper.autoplay.start();
  });
});
