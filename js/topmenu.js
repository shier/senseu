var afterLoginJump=0;
var afterLoginUrl="";
var menuList=new Array();
menuList[1]="index.php";
menuList[2]="senseu.php";
menuList[3]="howitworks.php";
//menuList[4]="http://www.indiegogo.com/projects/sense-u-the-world-s-first-all-in-one-activity-tracker-to-connect-your-family/"
menuList[4]="purchase.php";
var myDate = new Date();
var my=myDate.getFullYear();
var mm=myDate.getMonth()+1;
var md=myDate.getDate();
	
var mytime=my+"-"+mm+"-"+md+" "+myDate.toLocaleTimeString();  
	
$(function(){
	$('<div id="popupReg"><iframe id="popupRegFrame" scrolling="no" frameborder="0" width=368px height=363px></iframe></div>').appendTo($('#main',parent.document));
	$("#popupReg",parent.document).css({width:"368px",height:"363px",position:"absolute","z-index":110,display:"none"});
	$('<div id="darkBack"></div>').insertBefore($("#main",parent.document));
	$("#darkBack",parent.document).css({position:"absolute","z-index":109,left:"0px",top:"0px","background-color":"black",opacity:0.75,display:"none"});
	$('<div id="footer" class="areaFrame"><iframe width=1000 height=60 src="footer.php" scrolling="no" frameborder="0"></iframe></div>').appendTo($('#main',parent.document));
	var str='<div id="popProfile" class="G_smallRound">';
	str+='<iframe width=924 height=525 frameborder="0" scrolling="no" src="" id="frameProfile"></iframe></div>';
	$(str).appendTo($('#main',parent.document));
	$("#popProfile",parent.document).css({position:"absolute","z-index":111,display:"none"});
	$('<div id="wait" class="G_smallRound" style="width:500px; height:300px;background-color:#fbfcfe;display:none;z-index:112;position:absolute"><table height=100% width=100%><tr><td style="padding-left:65px"><span style="font-size:56px; color:#6cba00; font-weight:100" id="waitTitle">Coming Soon</span><br /><span style="font-size:14px; color:#8b8c8e; line-height:20px"  id="waitContent">Something cool is on the way. Please come back again later.</span></td></tr></table><div id="regClose"><img src="images/s_close.gif" /></div></div>').appendTo($('#main',parent.document));
	$("#regClose",parent.document).css({position:"absolute",left:"478px",top:"5px",cursor:"pointer"});
	$("#regClose",parent.document).click(function(){parent.hidewait();});
	$('#up_btnLogin').click(function(){
		//$.cookie('afterLoginJump','');
		checkLogin();
	});
	$('#alreadylogin').hide();
	$('#reg').click(function(){
		//$.cookie('afterLoginJump','');
		$('#upWrongInfo').html('');
  		showSignUp();
	});
	$('#passwordt').bind ({
		focusin: function(event){
			var v=$('#passwordt').val();
			if(v=="password"){
				$('#passwordt').hide();
				$('#up_loginPass').show();
				$('#up_loginPass').focus();
			}
		}
	});
	$('#up_loginEmail').bind ({
		focusin: function(event){
			var v=$('#up_loginEmail').val();
			if(v=="email"){
				$('#up_loginEmail').val('');
				$('#up_loginEmail').css("color","black");
			}
		},
		focusout: function(event){
			var v=$('#up_loginEmail').val();
			if(v==""){
				$('#up_loginEmail').val("email");
				$('#up_loginEmail').css("color","#cccccc");
			}
		}
	});
	$('#up_loginPass').bind ({
		focusout: function(event){
			var v=$('#up_loginPass').val();
			if(v==""){
				$('#up_loginPass').hide();
				$('#passwordt').show();
			}
		}
	});
	$('#up_loginPass').hide();
	$('#up_loginPass').css("color","#000000");
	$('#logout').bind({
		click:function(event){processLogout();}
	});	
	if($.cookie('back_loginMode')=='1'){
		processLogin();
	}else{
		$('#newlogin').show();
	}

	$('#btn_profile').bind({
			click:function(event){showProfileSetup();}
	});
	$('#btn_Guide').bind({
			click:function(event){parent.showwait("Coming Soon","Something cool is on the way. Please comeback again later.");}
	});
	$('#logo').bind({
		click:function(event){parent.location='index.php';}
	});	
	$('#btn_profile').mouseover(function(){$(this).addClass('G_menuOver'); });
	$('#btn_profile').mouseout(function(){$(this).removeClass('G_menuOver'); });
	$('#btn_Guide').mouseover(function(){$(this).addClass('G_menuOver'); });
	$('#btn_Guide').mouseout(function(){$(this).removeClass('G_menuOver'); });
	
	parent.document.title="Welcome to Sense-U: The World's First All-in-One Activity Tracker to Connect Your Family";

	for(i=1;i<5;i++){
		if(i != parent.pageID){
			$('#menu'+i).addClass("homeMenuBtn");
			$('#menu'+i).attr("mid",i);
			$('#menu'+i).click(function(){
			//alert($(this).attr("mid"))
				if($(this).attr("mid")==2  && $.cookie('back_loginMode')==null){
					afterLoginJump=parseInt($(this).attr("mid"));
					$.cookie('afterLoginJump', menuList[afterLoginJump]);
					popupReg();
					
				}else{				
					parent.location=menuList[$(this).attr("mid")];
				}
			});
			$('#menu'+i).mouseover(function(){$(this).addClass('G_menuOver'); });
			$('#menu'+i).mouseout(function(){$(this).removeClass('G_menuOver'); });
		}
	}
	$("#up_loginPass").keypress(function(event) {
		var keyCode = event.which;
		if (keyCode == 13)
				checkLogin();
			}).focus(function() {
				this.style.imeMode='disabled';
	});
	if(parent.pageID==1){
		parent.checkForget();
	}
	$('#regtable').hide();
});

function showSignUp(){
	//$("#darkBack",parent.document).fadeTo(0,0.77);
	parent.showPop('popupReg','signup');
	//parent.document.getElementById('popupRegFrame').contentWindow.showSignUp();
}



//---------------------check login
function checkLogin(){
	$('.blankRow').html("");
	
	var jmail=$('#up_loginEmail').val();
	var jpass=$('#up_loginPass').val();
	var errInfo=$('#up_loginWrong');
	if(jmail=="" || jmail=="email" ){
		popupReg({mail:"",pass:jpass,mode:"email",err:"Please enter your email address."});
       	return false;
    }
	var reg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/; 
	if(!reg.test(jmail)){
		popupReg({mail:jmail,pass:jpass,mode:"email",err:"Please use a valid email address."});
       	 return false;
    }
	if(jpass=="" ){
		popupReg({mail:jmail,pass:jpass,mode:"pass",err:"Please enter your password."});
       	return false;
    }
	if($('#saveEmailCookies').attr('checked')=='checked'){
		$.cookie('userEmail', jmail,{path:'/', expires:1000});
	}else{
		$.cookie('userEmail', null);
	};
	
	$.cookie('tempEmail', jmail);
	$('#up_btnLogin').css('cursor','auto');
	$('#up_btnLogin').unbind("click");
	$('.up_loginInput').attr('disabled', "disabled");
	
	var outData={email:jmail,password:jpass,ndate:mytime,source:"w"};
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",
		url:'res/login.php',
        data:JSON.stringify(outData), 
        success: function (msg) {dealLoginRes(msg);},
 		error: function(XMLHttpRequest, textStatus, errorThrown) {
			enableLoginArea();
            popupReg({mail:jmail,pass:jpass,mode:"email",err:"unknown error."});
		}
    });

}
	function dealLoginRes(value){
		enableLoginArea();
		var jmail=$('#up_loginEmail').val();
		var jpass=$('#up_loginPass').val();
		if(value.status==101){
			popupReg({mail:jmail,pass:jpass,mode:"pass",err:"Either username or password were incorrect."});
		}else{
			
			$.cookie('back_ucode', value.userInfo.ucode);
			$.cookie('back_scode', value.userInfo.scode);
			$.cookie('back_ecode', value.userInfo.ecode);
			$.cookie('back_loginMode', "1");
			/*
			if($.cookie('afterLoginJump') == null ){
				location="topmenu.php"
			}else{
				var newurl=$.cookie('afterLoginJump');
				$.cookie('afterLoginJump',null);
				parent.location=newurl;
				
			}*/
			parent.location="senseu.php";
		}
	}
	function enableLoginArea(){
		$('#up_btnLogin').css('cursor','pointer');
		$('#up_btnLogin').click(function(){checkLogin();});
		$('.up_loginInput').removeAttr("disabled"); 
	}
function popupReg(pere){
	//parent.showPop('popupReg');
	parent.showPop('popupReg','login');
	//parent.document.getElementById('popupRegFrame').contentWindow.showLogin(pere);
	
}
function showProfileSetup(){
		
	parent.showPop('popProfile');
	$("#frameProfile", parent.document).attr("src","profile.php");
}
	
function processLogin(){
	$('#alreadylogin').show();
	$('#newlogin').hide();
	parent.hidePop('popProfile');
}
function processLogout(){
	$('#up_loginEmail').val("email");
	$('#up_loginEmail').css("color","#cccccc");
	$('#up_loginPass').val("");
	$('#up_loginPass').hide();
	$('#up_loginPasst').show();
	$('#alreadylogin').hide();
	$('#newlogin').show();
	$.cookie('back_ucode', null);
	$.cookie('back_scode', null);
	$.cookie('back_ecode', null);
	$.cookie('back_loginMode', null);

	parent.location='index.php';

}