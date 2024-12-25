jQuery(document).ready(function ($) {
  $('.open-popup-link').magnificPopup({
    type: 'inline', // Use inline content
    midClick: true, // Allow opening the popup on middle click
    removalDelay: 300, // Delay before removing the popup
    mainClass: 'mfp-fade' // Fade-in/out effect
  });

  const swiper = new Swiper('.swiper-container', {
    loop: true, // Enables infinite loop
    pagination: {
      el: '.swiper-pagination',
      clickable: true, // Enable clicking to navigate
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    autoplay: {
      delay: 5000, // Autoplay slides every 5 seconds
    },
    slidesPerView: 1, // Show one slide at a time
    spaceBetween: 10, // Space between slides
  });
});
