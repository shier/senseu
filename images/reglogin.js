	function resizeDisplay(){
		var ww=$(window).width();
		var wh=$(window).height();
		var fleft=(ww-$('#main').width())/2
		if(fleft>=0){
			$('#main').css("left",fleft);
		}
		if(pageID==1 || pageID==3){
			adjMax();
		}
	}
	function adjMax(){
		var ww=$(window).width();
		var wh=$(window).height();
		$('#maxContent').width(ww);
		if(ww<1000){ww=1000}
		$('#maxContent').height(wh);
		if(ww>1440){
			$('#maxContent').css("left",(ww-1440)/2);
			$('#videoWindow').css("left",0)
		}else{
			$('#maxContent').css("left",0);
			
			$('#videoWindow').css("left",(ww-1440)/2)
			
		}
	}
	function resizeArea(){
		var ww=$(window).width();
		if(ww<1000){ww=1000}
		var wh=$(window).height();
		var ws=$(window).scrollTop();
		$('#darkBack').css('top',ws);
		$('#darkBack').width(ww);
		$('#darkBack').height(wh);
		var fleft=(ww-$('#main').width())/2
		if(fleft<0){fleft=0}
		$('#main').css("left",fleft);
		var nleft=(ww-$('#popupReg').width())/2;
		var ntop=(wh-$('#popupReg').height())/2+ws;
		nleft-=fleft;
		$('#popupReg').css("left",nleft);
		$('#popupReg').css("top",ntop);
		nleft=(ww-$('#popProfile').width())/2;
		ntop=(wh-$('#popProfile').height())/2+ws;
		nleft-=fleft;
		$('#popProfile').css("left",nleft);
		$('#popProfile').css("top",ntop);
		if(pageID==1 || pageID==3){
			adjMax();
		}
		if(pageID==2){
			$('#lightBack').css('top',ws);
			$('#lightBack').width(ww);
			$('#lightBack').height(wh);
			nleft=(ww-$('#Frame_goalSetup').width())/2;
			ntop=(wh-$('#Frame_goalSetup').height())/2+ws;
			nleft-=fleft;
			$('#Frame_goalSetup').css("left",nleft);
			$('#Frame_goalSetup').css("top",ntop);
		}
		
	};
	function changePosition(){
		var wh=$(window).height();
		var ws=$(window).scrollTop();
		$('#popupReg').css("top",(wh-$('#popupReg').height())/2+ws);
		$('#darkBack').css('top',ws);
		$('#popProfile').css("top",(wh-$('#popProfile').height())/2+ws);
		if(pageID==2){
			$('#lightBack').css('top',ws);
			$('#Frame_goalSetup').css("top",(wh-$('#Frame_goalSetup').height())/2+ws);
		}
	}

	function hidePop(pname){
		$('.slider-nav').show();
		$('.orbit-bullets').show();
		$('.timer').show();
		$('#darkBack').hide();
		$('#'+pname).hide();
	}	
	function showPop(pname){
		//$('#darkBack').fadeTo(0,0.77);
		resizeArea();
		$('.slider-nav').hide();
		$('.orbit-bullets').hide();
		$('.timer').hide();
		$('#darkBack').show();	
		$('#'+pname).show();
	}
	$(function(){
		$(window).resize(function(){resizeArea();});
		$(window).scroll(function(){changePosition();});
		//$("#topmenu").attr("src","topmenu.php");
		$('<div id="topMenuArea"><iframe id="topmenu" src="topmenu.php" scrolling="no" frameborder="0" width=1000px height=112px></iframe></div>').prependTo($('#main'));
		resizeDisplay();
	});