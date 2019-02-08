$(document).ready(function () {

	$('.star').on('click', function () {
      $(this).toggleClass('star-checked');
    });

	var st_price;
    $(".monthly-button").show();
    $(".yearly-button").hide();
    $('.onoffswitch-checkbox').on('click', function () {
    	if ( $(this).prop('checked') ){
    		$('.price-now span.price_pro').text('197,000,-');
    		$('.price-now span.price_premium').text('297,000,-');
        $(".monthly-button").show();
        $(".yearly-button").hide();
    	}else{
    		$('.price-now span.price_pro').text('250,000,-');
    		$('.price-now span.price_premium').text('450,000,-');
        $(".monthly-button").hide();
        $(".yearly-button").show();
    	}
    });


    $('a.smooth-scroll, .scroll-syarat, .scroll-tentang, .scroll-disclaimer, .scroll-earnings').click(function(e){
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