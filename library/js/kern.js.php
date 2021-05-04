<?php header('Content-Type: application/javascript'); ?>
var hoverObjs = [];

function showHighlight(routeName) {

	var $routeGroups = $('#highlights > path, #highlights > g');

	$.each($routeGroups, function(i, val) {
		//console.log($(val).attr('id') + ' comp to: ' + routeName);
		if($(val).attr('id').indexOf(routeName) !== -1)
		{
			var $potentialObjs = $(val).find('polygon, line, polyline, path');

			//$potentialObjs.attr('filter','url(#f1)');
			 //$potentialObjs.css('stroke-width','30px');
			 //$potentialObjs.css('stroke','white');
			 $potentialObjs.css('opacity','1');

			 hoverObjs.push($potentialObjs);
			 hoverObjs.push($(val));

			 $.each(hoverObjs, function(k, hoverItem) {

					$(hoverItem).css('opacity','1');

			});

		}
	});

}

function hideHighlights() {

	if(hoverObjs.length > 0) {

			$.each(hoverObjs, function(k, hoverItem) {
			//	console.log('clearing: '+ hoverItem.attr('id'));
//				 $(hoverItem).css('stroke-width','10px');
				 $(hoverItem).css('opacity','0');
			});

			hoverObjs = [];
		}


}  

$(document).ready(function(){

	
	//alert(); 
	
	

	$('#trip-planner-container').click(function() {
		if($('#planner-expand-contract-tab').text() != 'hide') {
			$(this).find('.min-hide').css('display', 'table-row');
			$('#planner-expand-contract-tab').text('hide');
			 $('#trip-planner-container').removeClass('minimized').addClass('expanded');
			  $('#planner-expand-contract-tab').removeClass('minimized').addClass('expanded');
		}
		
	});
	
	$('#planner-expand-contract-tab').click(function() {
		if($(this).text() == 'hide') {
			 $('#trip-planner-container').removeClass('expanded').addClass('minimized');
			 $('#planner-expand-contract-tab').removeClass('expanded').addClass('minimized');
			 $('#trip-planner-container .min-hide').css('display', 'none');
			 $('#planner-expand-contract-tab').text('expand');  
		} else {
			$('#trip-planner-container').find('.min-hide').css('display', 'table-row');
			$('#planner-expand-contract-tab').text('hide');
			$('#trip-planner-container').removeClass('minimized').addClass('expanded');
			$('#planner-expand-contract-tab').removeClass('minimized').addClass('expanded');
		}
	
	});
	
	$('#main-nav li, .area-box li, .route-info-box ul li').click(function() {
	
		window.location.href = $(this).find('a').attr('href');	
	
	});


	$("area").hover( function(){
	 	//$("#map-hovers").addClass($(this).attr("alt"));

	 }, function() {
	 	$("#map-hovers").removeClass($(this).attr("alt"));
	 	hideHighlights();
	});
	 
	$('.area-box li').hover( function() {
		var routeName = $(this).find('.route-name').attr("alt").replace('_','');
		routeName = routeName.slice(0, 1) + "_" + routeName.slice(1);
		console.log(routeName);
		showHighlight(routeName);
	}, function() {
		hideHighlights();
	});
	
	if($('#map-floaty-box').length > 0) 
		var distToTop = $('#map-floaty-box').offset().top;


	$(window).scroll(function(e){ 
		if($(window).width() > 768) {
				  $('#map-floaty-box').removeClass('static');
			$('#routes-left-col').height();
	
			//the height of the floatymap and top margin cannot exceed the height of left column.
			  $el = $('#map-floaty-box'); 
	  
			  if ($(this).scrollTop() > distToTop){ 
				//$el.css({'position': 'fixed', 'top': '0px'}); 
				var margTop = Math.min($(this).scrollTop()-distToTop, $('#routes-left-col').height()-$('#map-floaty-box').height());
				$el.css('margin-top', margTop);
				$el.css('border-top-right-radius', 0);  
		  
			  }
			  if ($(this).scrollTop() < 330 )
			  {
				//$el.css({'position': 'absolute', 'top': '0px'});
				$el.css('margin-top', 0);
				$el.css('border-top-right-radius', 10);
		
			  } 
	  } else {
		  $('#map-floaty-box').addClass('static');
	  }
	});
	
	
	$('.post-type-archive-route .area-box h2').click(function() {
	
		if($(this).parent().hasClass('minimized')) {
			$(this).parent().find('ul').show();
			$(this).parent().removeClass('minimized').addClass('expanded');
			$(this).parent().find('.open-close-text').text('Click to hide area routes');
		} else {
			$(this).parent().find('ul').hide();
			$(this).parent().removeClass('expanded').addClass('minimized');
			$(this).parent().find('.open-close-text').text('Click to show area routes');
		}
	
	}); 
	
	
	
	// auto h2 anchors in generic content 
	
	var $h2s = $('h3');
    var $anchorLinks = $('#page-anchor-links ul');
   // if ($h2s.length > 0) {
   // 	 $('#subpage-anchor-links').addClass('show');
   // }
   
    $.each($h2s, function() { 
    	var text = $(this).text();
    	$anchorLinks.append($('<li><a href="#'+text+'">'+text+'</a></li>'));
    	$(this).prepend($('<a name="'+text+'"></a>'));
    });


	$('a').click( function() {
    
    	highlightAnchorH2($(this).attr("href"));
    });
    
    
    // make schedules li click work for link
    $('#schedule-links li').click(function() {
    	window.location.href = $(this).find('a').attr('href');
    
    });
    
   
    // make generic columns the same height:
  
    
    
    if( $('body').hasClass('single-route') ) {
    	if( $("#route-left-col").height() < $('#route-side-col').height()) {
    	$("#route-left-col").height($('#route-side-col').height() - $("#route-left-col").css('margin-top') - $("#route-left-col").css('margin-bottom'));
    } else if( $("#route-left-col").height() > $('#route-side-col').height()){
   		 $("#route-side-col").height($('#route-left-col').height() - 2 );
    }
    
    }
    
  //  $('#timetable-content').css('background', shadeColor1( $('#timetable-content').css('background-color'), 60);
    
    
    // expand detail maps

    $('.single-route li.route-detail-holder').click(function(event) {
    if($(this).find('span').hasClass('min')) {
			event.preventDefault();
			var image = new Image();

		 //add image path
		 $span = $(this).find('span');
		  image.src = $(this).find('a').attr('href');
			$link = $(this).find('a');
		  //bind load event
		  $(this).append('<div class="detail-loading"></div>');
		  image.onload = function(){
			//now load next image
			$span.addClass('exp');
			$span.removeClass('min');
			$link.find('img.sml').css('display','none');
			$link.parent().find('.detail-loading').remove();
			$link.append('<img class="large" src ="'+image.src+'" />');
		
			};
		} else {
			event.preventDefault();
		
			$link = $(this);
			 $span = $(this).find('span');
			 $span.addClass('exp');
			$span.removeClass('min');
		  //bind load event
			
			//now load next image
			$span.addClass('min');
			$span.removeClass('exp');
			$link.find('img.sml').css('display','inherit');
			$link.find('img.large').remove();
		
		}
	   // 
	});
	
	
	$('.route-alert-header').click(function() {
	
		if($(this).parent().hasClass('minimized')) {
			$(this).parent().find('#alert-content').show();
			$(this).parent().removeClass('minimized').addClass('expanded');
			$(this).parent().find('#alert-click-message').text('Click to Hide');
			
		} else {
			$(this).parent().find('#alert-content').hide();
			$(this).parent().removeClass('expanded').addClass('minimized');
			$(this).parent().find('#alert-click-message').text('Click to Expand');
		
		}
	
	}); 
	
	$("h2:contains('\(FOR SENIORS AND PERSONS WITH DISABILITIES WITH VALID DISCOUNT CARD, AND YOUTHS\)')").html(function(_, html) {
   return html.replace(/(cow)/g, '<span class="discount-text">$1</span>'); 
});
	
	
	
});

$(window).load( function() {
	 // make generic columns the same height:
   
    
     if( $('body').hasClass('single-route') ) {
    	if( $("#route-left-col").height() < $('#route-side-col').height()) {
    	$("#route-left-col").height($('#route-side-col').height() - $("#route-left-col").css('margin-top') - $("#route-left-col").css('margin-bottom'));
    } else if( $("#route-left-col").height() > $('#route-side-col').height()){
   		 $("#route-side-col").height($('#route-left-col').height() - 2 );
    }
    
    
    }
    
    if (L.Browser.retina) {
    
   		 changeImage($('#logo-image')[0],"<?php echo $_GET['site_url'] ;?>/library/images/logo-2x.png");
    } 
    
    $('.single-route table').addClass('table');
});

function highlightAnchorH2(name) {
	var origCol =  $('a[name=\''+name.slice(1)+'\']').parent().css('background-color');
	$('a[name=\''+name.slice(1)+'\']').parent().css('background-color', 'yellow');
	$('a[name=\''+name.slice(1)+'\']').parent().animate( { backgroundColor: origCol }, 700);
}

function shadeColor1(color, percent) {  
    var num = parseInt(color,16),
    amt = Math.round(2.55 * percent),
    R = (num >> 16) + amt,
    G = (num >> 8 & 0x00FF) + amt,
    B = (num & 0x0000FF) + amt;
    return (0x1000000 + (R<255?R<1?0:R:255)*0x10000 + (G<255?G<1?0:G:255)*0x100 + (B<255?B<1?0:B:255)).toString(16).slice(1);
}

function changeImage(domImg,srcImage)
{
	var img = new Image();
	img.onload = function()
	{
		// Load completed
		domImg.src = this.src;
	};
	img.src = srcImage;
}