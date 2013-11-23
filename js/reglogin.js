//------------解决https跳转问题

var url = location.href; 
var paraString = url.substring(0,5)

if(paraString=="http:"){
	var restStr=url.substring(5,url.length)	
	location.href="https:"+restStr
}
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-7840951-15']);
_gaq.push(['_trackPageview']);

	function resizeDisplay(){
		var ww=$(window).width();
		var wh=$(window).height();
		
		pageID==1 ? fleft=(ww-1000)/2: fleft=(ww-$('#main').width())/2
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
		
		if(ww<1000){ww=1000}
		$('#maxContent').width(ww);
		
		if(ww>1440){
			$('#maxContent').css("left",(ww-1440)/2);
			$('#videoWindow').css("left",0)
			$('#btnGroup').css("left",420)
			$('#buy').css("left",1024);
		}else{
			$('#maxContent').css("left",0);
			
			$('#videoWindow').css("left",(ww-1440)/2)
			$('#btnGroup').css("left",420+(ww-1440)/2)
			$('#buy').css("left",1024+(ww-1440)/2);
		}
		
	}
	function changepos(w,h,s,f,pname){
		
		var nleft=(w-$('#'+pname).width())/2;
		var ntop=(h-$('#'+pname).height())/2+s;
		nleft-=f;
		$('#'+pname).css("left",nleft);
		$('#'+pname).css("top",ntop);
		
	}
	
	function resizeArea(){
		var ww=$(window).width();
		if(ww<1000){ww=1000}
		var wh=$(window).height();
		var ws=$(window).scrollTop();
		$('#darkBack').css('top',ws);
		$('#darkBack').width(ww);
		$('#darkBack').height(wh);
		pageID==1 ? fleft=(ww-1000)/2: fleft=(ww-$('#main').width())/2
		//var fleft=(ww-$('#main').width())/2
		if(fleft<0){fleft=0}
		$('#main').css("left",fleft);
		
		changepos(ww,wh,ws,fleft,'popupReg');
		changepos(ww,wh,ws,fleft,'popProfile');
		changepos(ww,wh,ws,fleft,'wait');
		
		if(pageID==1 ){
			changepos(ww,wh,ws,fleft,'homeVideo');
			adjMax();
		}
		if(pageID==3){
			adjMax();
		}
		if(pageID==2){
			$('#lightBack').css('top',ws);
			$('#lightBack').width(ww);
			$('#lightBack').height(wh);
			
			changepos(ww,wh,ws,fleft,'Frame_goalSetup');
			changepos(ww,wh,ws,fleft,'Frame_search');
		}
		
	};
	function changePosition(){
		var wh=$(window).height();
		var ws=$(window).scrollTop();
		$('#popupReg').css("top",(wh-$('#popupReg').height())/2+ws);
		$('#darkBack').css('top',ws);
		$('#popProfile').css("top",(wh-$('#popProfile').height())/2+ws);
		$('#wait').css("top",(wh-$('#wait').height())/2+ws);
		if(pageID==2){
			$('#lightBack').css('top',ws);
			$('#Frame_goalSetup').css("top",(wh-$('#Frame_goalSetup').height())/2+ws);
			$('#Frame_search').css("top",(wh-$('#Frame_search').height())/2+ws);
		}
	}

	function hidePop(pname){
		$('.slider-nav').show();
		$('.orbit-bullets').show();
		$('.timer').show();
		$('#darkBack').hide();
		$('#'+pname).hide();
	}	
	function showPop(pname,pare){
		//$('#darkBack').fadeTo(0,0.77);
		resizeArea();
		$('.slider-nav').hide();
		$('.orbit-bullets').hide();
		$('.timer').hide();
		$('#darkBack').fadeIn(50)
		$('#'+pname).show();
		if(pname=="popupReg"){
			$('#popupRegFrame').attr("src","popupreg.php?act="+pare)	
		}
	}
	function showwait(title,content){
		resizeArea();
		$('#darkBack').fadeIn(50)
		$('#waitTitle').html(title);
		$('#waitContent').html(content)
		var oldtop=$('#wait').css("top");
		$('#wait').show();
		$('#wait').css("top",400);
		
		$('#wait').animate({top:oldtop});
		
	}
	function hidewait(){
		$('#darkBack').hide();	
		$('#wait').hide();
	}
	$(function(){
		
		$(window).resize(function(){resizeArea();});
		$(window).scroll(function(){changePosition();});
		//$("#topmenu").attr("src","topmenu.php");
		$('<div id="topMenuArea"><iframe id="topmenu" src="topmenu.php" scrolling="no" frameborder="0" width=1000px height=112px></iframe></div>').prependTo($('#main'));
		$('#maxContent').css("top", 112);
		
		resizeDisplay();
		/*
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		*/
	});
	
function checkMobile(){
	var browser={
    versions:function(){
           var u = navigator.userAgent, app = navigator.appVersion;
           return {//移动终端浏览器版本信息
                trident: u.indexOf('Trident') > -1, //IE内核
                presto: u.indexOf('Presto') > -1, //opera内核
                webKit: u.indexOf('AppleWebKit') > -1, //苹果、谷歌内核
                gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1, //火狐内核
                mobile: !!u.match(/AppleWebKit.*Mobile.*/)||!!u.match(/AppleWebKit/), //是否为移动终端
                ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端
                android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1, //android终端或者uc浏览器
                iPhone: u.indexOf('iPhone') > -1 || u.indexOf('Mac') > -1, //是否为iPhone或者QQHD浏览器
                iPad: u.indexOf('iPad') > -1, //是否iPad
                webApp: u.indexOf('Safari') == -1 //是否web应该程序，没有头部与底部
            };
         }(),
         language:(navigator.browserLanguage || navigator.language).toLowerCase()
	}
	/*
	document.writeln("语言版本: "+browser.language);
	document.writeln(" 是否为移动终端: "+browser.versions.mobile);
	document.writeln(" ios终端: "+browser.versions.ios);
	document.writeln(" android终端: "+browser.versions.android);
	document.writeln(" 是否为iPhone: "+browser.versions.iPhone);
	document.writeln(" 是否iPad: "+browser.versions.iPad);
	document.writeln(navigator.userAgent);
	*/
	return  browser.versions.mobile;
}