$( document ).ready(function() {

	let wbBtn = $('#b2top-button');


	$(window).scroll(function () {
		if ($(window).scrollTop() > 300) {
			wbBtn.addClass('show');
		} else {
			wbBtn.removeClass('show');
		}
	});

	wbBtn.on('click', function (e) {
		e.preventDefault();
		$('html, body').animate({
			scrollTop: 0
		}, '300');


		/*
		e.preventDefault();
		$("html, body").scrollTop(0);
		*/

	});


	$('.bn_cube').each(function (i, el) {
		console.log(Number($(el).html()));
		if (Number($(el).html()) > 0 ) {
			$(el).css('background','#c63939');
		}

	});


});

