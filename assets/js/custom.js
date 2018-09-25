
/*Basic jQuery*/
(function( $ ) {
	
	"use strict";
	
	$( document ).ready(function() {

		//Range Slider
		if( $('.range-slider').length ){
		
			var range_ele;
		
			var cp_val = $(".compare-payment-hidden-json").val();		
			cp_val = ($).parseJSON( cp_val );

			$('.range-slider').rangeslider({
				polyfill: false,
				onInit: function() { 
					compare_payment( cp_val, $('.range-slider').val() );
				},
				onSlide: function(position, value) {
					$( range_ele ).text(value);
					compare_payment( cp_val, value );
				},
			});
			var def_value = $('.range-slider').val();
			$( ".range-slider" ).next(".rangeslider").prepend( '<div class="rangeslider__parts"><div class="rangeslider__parts__part"></div><div class="rangeslider__parts__part"></div><div class="rangeslider__parts__part"></div></div>' );
			$( ".range-slider" ).next(".rangeslider").find(".rangeslider__handle").append( '<div class="rangeslider__tooltip__value"><span>$</span> <span class="range-value">'+ def_value +'</span><div>Transaction</div></div>');
			range_ele = $( ".range-slider" ).next(".rangeslider").find(".range-value");
		}
	  
	}); // document ready end
	
	function compare_payment( cp_val, range_value ){
		
		var i = 0, cheap_cal = '';
		var cheap_arr = [];
		var cheap_txt = [];
		$.each( cp_val, function( key, cp_child_json ) {
			
			var cp_ele = $('#' + key);
			var t = parseFloat( ( ( ( range_value / 100 ) * cp_child_json.trans_fee ) + parseFloat( cp_child_json.additional_fee ) ) ).toFixed(2);
			var cp_trans = cp_child_json.min_trans_fee < t ? t : compare_json.stripe_arr[2];
			if( cp_child_json.compare_trans == 'no' ){
				cheap_arr[i] = cp_trans;
				cheap_txt[i++] = cp_child_json.title;
			}
			$(cp_ele).find(".payment-val-update").text(cp_trans);
			
			if( cp_child_json.compare_trans == 'yes' ){
				$.each(cheap_arr, function( index, cvalue ) {
					cheap_cal = cheap_cal + '<p class="alert-success">We are '+ parseFloat( cvalue / cp_trans ).toFixed(2) +'% cheaper! than '+ cheap_txt[index] +'</p>';
				});
				$(cp_ele).find(".cheap-cal-wrap").empty().html( cheap_cal );
			}
			
		});
		
	}

})( jQuery );

