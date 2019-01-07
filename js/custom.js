$(document).ready(function () {

	$('.star').on('click', function () {
      $(this).toggleClass('star-checked');
    });

	var st_price;
    $('.onoffswitch-checkbox').on('click', function () {
    	if ( $(this).prop('checked') ){
    		$('.price-now span.price_pro').text('IDR 197');
    		$('.price-now span.price_premium').text('IDR 297');
    	}else{
    		$('.price-now span.price_pro').text('IDR 250');
    		$('.price-now span.price_premium').text('IDR 450');
    	}
    });


    $('a.smooth-scroll').click(function(e){
          var snc_active = $(this).attr('href');
          $('html, body').animate({
            scrollTop: $(snc_active).offset().top
          }, 1000);
          $('a.smooth-scroll').removeClass('active');
          $(this).addClass('active');
          e.preventDefault();
      });

      // $('a.smooth-scroll').removeClass('active');

 });

$(window).load(function () {
  // $('a.nav-link.smooth-scroll').removeClass('active');
});