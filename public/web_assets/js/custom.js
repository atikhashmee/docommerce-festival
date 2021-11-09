// =========================
function flashMessage(type, header = "", message = "") {
    if (type === 'success') {
      $item =  $('.added-message');
      if (header!== "") {
        $item.find('.p_name').text(header)
      }
      if (message !== "") {
        $item.find('.p_desc').text(message)
      }
      $item.addClass("active").delay(2000).queue(function(){
        $(this).removeClass("active").dequeue();
      });
    }
}
$(document).ready(function () {

    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
          $('#back-to-top').fadeIn();
        } else {
          $('#back-to-top').fadeOut();
        }
      });
      // scroll body to 0px on click
      $('#back-to-top').click(function () {
        $('body,html').animate({
          scrollTop: 0
        }, 700);
        return false;
      });
  


  $('.add-wishlist-switch').click(function () {
    $(".added-message").find(".textChange").text("wishlist");
    $('.added-message').addClass("active").delay(2000).queue(function(){
      $(this).removeClass("active").dequeue();
      $(".added-message").find(".textChange").text("cart");
    });
  });



  //  product details zoom

  $("#zoom_01").ezPlus({
    containLensZoom: true, gallery: 'gallery_01', cursor: 'pointer', galleryActiveClass: 'active'
  });


  var owl = $('.stores-slide');
  owl.owlCarousel({
      loop:true,
      margin:10,
      autoplay:true,
      autoplayTimeout:2000,
      autoplayHoverPause: true,
      responsiveClass:true,
      responsive:{
        0:{
            items:3,
            nav:false
        },
        600:{
            items:4,
            nav:false
        },
        1000:{
            items:8,
            nav:false
        }
    }
  });
  $('.play').on('click',function(){
      owl.trigger('play.owl.autoplay',[1000])
  })
  $('.stop').on('click',function(){
      owl.trigger('stop.owl.autoplay')
  })



  // addPriceCart

  $('[data-quantity="plus"]').click(function(e){
    // Stop acting like a button
    e.preventDefault();
    // Get the field name
    fieldName = $(this).attr('data-field');
    // Get its current value
    var currentVal = parseInt($('input[name='+fieldName+']').val());
    // If is not undefined
    if (!isNaN(currentVal)) {
        // Increment
        $('input[name='+fieldName+']').val(currentVal + 1);
    } else {
        // Otherwise put a 0 there
        $('input[name='+fieldName+']').val(0);
    }
});
// This button will decrement the value till 0
$('[data-quantity="minus"]').click(function(e) {
    // Stop acting like a button
    e.preventDefault();
    // Get the field name
    fieldName = $(this).attr('data-field');
    // Get its current value
    var currentVal = parseInt($('input[name='+fieldName+']').val());
    // If it isn't undefined or its greater than 0
    if (!isNaN(currentVal) && currentVal > 1) {
        // Decrement one
        $('input[name='+fieldName+']').val(currentVal - 1);
    } else {
        // Otherwise put a 0 there
        $('input[name='+fieldName+']').val(1);
    }
});
  
$('.different_address_swt').click(function () {
  $('.different_address_div').toggle('slow');
  $(this).toggleClass('active')
});  

  
});