
var INFO_popupValue=[{name:"PRO_timeZone",posx:93,posy:320,width:318,rowNumber:4,value:[
	{id:'-11:00,0',text:'(-11:00) Midway Island, Samoa'},
	{id:'-10:00,0',text:'(-10:00) Hawaii'},
	{id:'-09:00,1',text:'(-09:00) Alaska'},
	{id:'-08:00,1',text:'(-08:00) Pacific Time (US & Canada)'},
	{id:'-07:00,0',text:'(-07:00) Arizona'},
	{id:'-07:00,1',text:'(-07:00) Mountain Time (US & Canada)'},
	{id:'-06:00,0',text:'(-06:00) Central America, Saskatchewan'},
	{id:'-06:00,1',text:'(-06:00) Central Time (US & Canada), Guadalajara, Mexico city'},
	{id:'-05:00,0',text:'(-05:00) Indiana, Bogota, Lima, Quito, Rio Branco'},
	{id:'-05:00,1',text:'(-05:00) Eastern time (US & Canada)'},
	{id:'-04:00,1',text:'(-04:00) Atlantic time (Canada), Manaus, Santiago'},
	{id:'-04:00,0',text:'(-04:00) Caracas, La Paz'},
	{id:'-03:30,1',text:'(-03:30) Newfoundland'},
	{id:'-03:00,1',text:'(-03:00) Greenland, Brasilia, Montevideo'},
	{id:'-03:00,0',text:'(-03:00) Buenos Aires, Georgetown'},
	{id:'-02:00,1',text:'(-02:00) Mid-Atlantic'},
	{id:'-01:00,1',text:'(-01:00) Azores'},
	{id:'-01:00,0',text:'(-01:00) Cape Verde Is.'},
	{id:'00:00,0',text:'(00:00) Casablanca, Monrovia, Reykjavik'},
	{id:'00:00,1',text:'(00:00) GMT: Dublin, Edinburgh, Lisbon, London'},
	{id:'+01:00,1',text:'(+01:00) Amsterdam, Berlin, Rome, Vienna, Prague, Brussels'},
	{id:'+01:00,0',text:'(+01:00) West Central Africa'},
	{id:'+02:00,1',text:'(+02:00) Amman, Athens, Istanbul, Beirut, Cairo, Jerusalem'},
	{id:'+02:00,0',text:'(+02:00) Harare, Pretoria'},
	{id:'+03:00,1',text:'(+03:00) Baghdad, Moscow, St. Petersburg, Volgograd'},
	{id:'+03:00,0',text:'(+03:00) Kuwait, Riyadh, Nairobi, Tbilisi'},
	{id:'+03:30,0',text:'(+03:30) Tehran'},
	{id:'+04:00,0',text:'(+04:00) Abu Dhadi, Muscat'},
	{id:'+04:00,1',text:'(+04:00) Baku, Yerevan'},
	{id:'+04:30,0',text:'(+04:30) Kabul'},
	{id:'+05:00,1',text:'(+05:00) Ekaterinburg'},
	{id:'+05:00,0',text:'(+05:00) Islamabad, Karachi, Tashkent'},
	{id:'+05:30,0',text:'(+05:30) Chennai, Kolkata, Mumbai, New Delhi, Sri Jayawardenepura'},
	{id:'+05:45,0',text:'(+05:45) Kathmandu'},
	{id:'+06:00,0',text:'(+06:00) Astana, Dhaka'},
	{id:'+06:00,1',text:'(+06:00) Almaty, Nonosibirsk'},
	{id:'+06:30,0',text:'(+06:30) Yangon (Rangoon)'},
	{id:'+07:00,1',text:'(+07:00) Krasnoyarsk'},
	{id:'+07:00,0',text:'(+07:00) Bangkok, Hanoi, Jakarta'},
	{id:'+08:00,0',text:'(+08:00) Beijing, Hong Kong, Singapore, Taipei'},
	{id:'+08:00,1',text:'(+08:00) Irkutsk, Ulaan Bataar, Perth'},
	{id:'+09:00,1',text:'(+09:00) Yakutsk'},
	{id:'+09:00,0',text:'(+09:00) Seoul, Osaka, Sapporo, Tokyo'},
	{id:'+09:30,0',text:'(+09:30) Darwin'},
	{id:'+09:30,1',text:'(+09:30) Adelaide'},
	{id:'+10:00,0',text:'(+10:00) Brisbane, Guam, Port Moresby'},
	{id:'+10:00,1',text:'(+10:00) Canberra, Melbourne, Sydney, Hobart, Vladivostok'},
	{id:'+11:00,0',text:'(+11:00) Magadan, Solomon Is., New Caledonia'},
	{id:'+12:00,1',text:'(+12:00) Auckland, Wellington'},
	{id:'+12:00,0',text:'(+12:00) Fiji, Kamchatka, Marshall Is.'},
	{id:'+13:00,0',text:"(+13:00) Nuku'alofa"}
]}];
INFO_popupValue.push({name:"PRO_sUnit",posx:307,posy:270,width:58,rowNumber:2,value:[{id:'foot',text:'foot'},{id:'cm',text:'cm'}]});
INFO_popupValue.push({name:"PRO_hUnit",posx:307,posy:125,width:58,rowNumber:2,value:[{id:'foot',text:'foot'},{id:'cm',text:'cm'}]});
INFO_popupValue.push({name:"PRO_wUnit",posx:307,posy:172,width:58,rowNumber:2,value:[{id:'lb',text:'lb'},{id:'kg',text:'kg'}]});
INFO_popupValue.push({name:"PRO_month",posx:93,posy:222,width:79,rowNumber:6,value:[]});

var monthNameList=new Array("January","February","March","April","May","June","July","August","September","October","November","December");
var currentPopName,popUpChanged=false;

for(var i=0;i<12;i++){
	INFO_popupValue[INFO_popupValue.length-1].value.push({id:i+1,text:monthNameList[i]});
}
INFO_popupValue.push({name:"PRO_day",posx:190,posy:222,width:79,rowNumber:6,value:[]});

for(i=1;i<=31;i++){
	INFO_popupValue[INFO_popupValue.length-1].value.push({id:i,text:i});
}
INFO_popupValue.push({name:"PRO_year",posx:288,posy:222,width:79,rowNumber:6,value:[]});

for(i=2013;i>=1900;i--){
	INFO_popupValue[INFO_popupValue.length-1].value.push({id:i+1,text:i});
}

var back_ucode=$.cookie('back_ucode');
var back_scode=$.cookie('back_scode');
var back_ecode=$.cookie('back_ecode');

var sensorList=new Array(); 
var currentSensorID=0;
var myDate = new Date();
var my=myDate.getFullYear();
var mm=myDate.getMonth()+1;
var md=myDate.getDate();
	
var mytime=my+"-"+mm+"-"+md+" "+myDate.toLocaleTimeString();  
	
		
function monthNametoID(name){
	for(var i=0;i<monthNameList.length;i++){
		if(monthNameList[i]==name){
			return i+1;
		}
	}
	return 0;
}
function changeSex(event){
	sexID=event.data.id;
	changSexPic(sexID);

}
function changSexPic(sid){
	if(sid=="M"){sid=0;}
	if(sid=="F"){sid=1;}
	$("#INFO_sex"+sid).attr('src',"images/se_yes.png");
	$("#INFO_sex"+(1-sid)).attr('src',"images/se_no.png");
	$('#PRO_sel').fadeOut();
	sid==0 ? $('#gender').val("M"):$('#gender').val("F");
}
var timezone;
function calculate_time_zone() {
	var rightNow = new Date();
	var jan1 = new Date(rightNow.getFullYear(), 0, 1, 0, 0, 0, 0);  // jan 1st
	var june1 = new Date(rightNow.getFullYear(), 6, 1, 0, 0, 0, 0); // june 1st
	var temp = jan1.toGMTString();
	var jan2 = new Date(temp.substring(0, temp.lastIndexOf(" ")-1));
	temp = june1.toGMTString();
	var june2 = new Date(temp.substring(0, temp.lastIndexOf(" ")-1));
	var std_time_offset = (jan1 - jan2) / (1000 * 60 * 60);
	var daylight_time_offset = (june1 - june2) / (1000 * 60 * 60);
	var dst;
	if (std_time_offset == daylight_time_offset) {
		dst = "0"; // daylight savings time is NOT observed
	} else {
		// positive is southern, negative is northern hemisphere
		var hemisphere = std_time_offset - daylight_time_offset;
		if (hemisphere >= 0)
			std_time_offset = daylight_time_offset;
		dst = "1"; // daylight savings time is observed
	}
	timezone=convert(std_time_offset);
	$("#PRO_sel").val(convert(std_time_offset)+","+dst);
	$("#PRO_timeZone").val($("#PRO_sel").find("option:selected").text());
	
}

function convert(value) {
	var hours = parseInt(value);
   	value -= parseInt(value);
	value *= 60;
	var mins = parseInt(value);
   	value -= parseInt(value);
	value *= 60;
	var secs = parseInt(value);
	var display_hours = hours;
	// handle GMT case (00:00)
	if (hours == 0) {
		display_hours = "00";
	} else if (hours > 0) {
		// add a plus sign and perhaps an extra 0
		display_hours = (hours < 10) ? "+0"+hours : "+"+hours;
	} else {
		// add an extra 0 if needed 
		display_hours = (hours > -10) ? "-0"+Math.abs(hours) : hours;
	}
	
	mins = (mins < 10) ? "0"+mins : mins;
	return display_hours+":"+mins;
}

function showpop(popName){
	popUpChanged=(currentPopName!=popName);
	currentPopName=popName;
	
	for(var i=0;i<INFO_popupValue.length;i++){
		var nobj=INFO_popupValue[i];
		if(popName==nobj.name){
			$('#PRO_popup').css("left",nobj.posx);
			$('#PRO_popup').css("top",nobj.posy);
			$('#PRO_sel').width(nobj.width);
			$('#PRO_sel').attr("size",nobj.rowNumber);
			$('#PRO_sel option').each(function(){$(this).remove();}); 
			for(var j=0;j<nobj.value.length;j++){$("#PRO_sel").append("<option value='"+nobj.value[j].id+"'>"+nobj.value[j].text+"</option>");}
			if(popUpChanged){
				$("#PRO_sel").hide();
			}
			
			$("#PRO_sel").slideToggle("fast");
			break;
		}
	}
}
	
$(function(){


		//---------性别---
		for(i=0;i<2;i++){
			$('#INFO_sex'+i).css("cursor","pointer");
			$('#INFO_sex'+i).bind("click",{id:i},changeSex);
		}
		//---------时区
		$(".PRO_clickInput").bind({
			click:function(){showpop($(this).children().attr("id"));}
		});

		$('#PRO_sel').bind({
			change:function(event){
				$(this).fadeOut();
				if($("#"+currentPopName).val()==$(this).find("option:selected").text()){return;}
				$("#"+currentPopName).val($(this).find("option:selected").text());
				$("#"+currentPopName).css("color","#6b6b6b");
				var value=$("#"+currentPopName).val();
				var showValue;
				switch(currentPopName){
					case "PRO_hUnit":
					case "PRO_sUnit":
						if(value=="foot"){changeUnit("Inch");}
						if(value=="cm"){changeUnit("Metric");}
					break;
					case "PRO_wUnit":
						if(value=="lb"){changeUnit("Inch");}
						if(value=="kg"){changeUnit("Metric");}
					break;	
				}
				
			}
		});
		$(".PRO_clickText").bind({
			click:function(){$('#PRO_sel').fadeOut();}
		});
		
		$('#PRO_close').bind({
			click:function(event){hidethis();}
		});
		
		showpop("PRO_timeZone");
		calculate_time_zone();
		$('#PRO_sel').hide();
		//监听键盘，只允许输入数字和小数点
		$(".PRO_inputNumber").keypress(function(event) {
			var keyCode = event.which;
			if (keyCode == 46 || (keyCode >= 48 && keyCode <=57) ||keyCode == 8 ||keyCode == 127)
				return true;
			else
				return false;
			}).focus(function() {
				this.style.imeMode='disabled';
		});
		//----------------out暂存所有数字,全部保存为英制数值----tempH---tempW---tempS-----
		$(".PRO_inputNumber").bind({
			focusout:function(){
				//--------长度--------
				if($('#PRO_hUnit').val()=='foot'){
					$('#tempH').val(unitToMetric({from:"foot",foot:$('#PRO_h1').val(),inch:$('#PRO_h2').val()}));
					$('#tempS').val(unitToMetric({from:"foot",foot:$('#PRO_s1').val(),inch:$('#PRO_s2').val()}));
				}
				if($('#PRO_hUnit').val()=='cm'){
					$('#tempH').val(unitToMetric({from:"cm",cm:$('#PRO_h1').val()}));
					$('#tempS').val(unitToMetric({from:"cm",cm:$('#PRO_s1').val()}));
				}	
				if($('#PRO_wUnit').val()=='lb'){
					$('#tempW').val(unitToMetric({from:"lb",lb:$('#PRO_w').val()}));
				}
				if($('#PRO_wUnit').val()=='kg'){
					$('#tempW').val(unitToMetric({from:"kg",kg:$('#PRO_w').val()}));
				}
			}
				
		});
		$('.btnBack1').bind({
			mouseenter:function(){$(this).css("background-image","url('images/bt_back2.png')");},
			mouseleave:function(){$(this).css("background-image","url('images/bt_back1.png')");},
			click:function(){
				$('#PRO_infoTitle').html($(this).children().eq(1).html());
				$('.PRO_mainInfo').each( function(){$(this).hide();});
				$('#'+$(this).attr("id")+'Area').show();
				if($(this).attr("id")=="PRO_images"){
					var iframeSrc = $("#IFRAME_upload").attr("src");
                	$("#IFRAME_upload").attr("src", iframeSrc);
				}
				
			}
			
		});
		$('.PRO_mainInfo').each( function(){$(this).hide();});
		
		
		
		$('#PRO_infoArea').show();
		
		$('#PRO_submit').bind({
			click:function(){
				if($("#PRO_infoArea").css("display") =="block"){
					savePersonalInfo();
				}
				if($("#PRO_passwordArea").css("display") =="block"){
					savePassword();
				}
			}
		});
		//$('div').each(function() {$('#'+this.id).addClass("G_unselect");});
		
		$("#IFRAME_upload").attr("src","upload.php");
		getUserInfo();
			
});
function hidethis(){
	parent.hidePop('popProfile');
	
}
function savePersonalInfo(){
	$('#errInfo').html();
	if($('#PRO_userName').val()==""){
		$('#errInfo').html("Please type in your username");
		return;
	}
	
	if($('#PRO_h1').val()==""){
		$('#errInfo').html("Please input your height");
		return;
	}
	if($('#PRO_w').val()==""){
		$('#errInfo').html("Please input your weight");
		return;
	}
	if($('#PRO_month').val()=="Month" ||$('#PRO_day').val()=="Day" ||$('#PRO_year').val()=="Year" ){
		$('#errInfo').html("Please select your birthday");
		return;
	}
	if($('#PRO_s1').val()==""){
		$('#errInfo').html("Please input your step width");
		return;
	}
	

	
	$('#PRO_sel').fadeOut();
	//--------------判断个人信息------		
	
	var outData={ucode:back_ucode,scode:back_scode,ecode:back_ecode,username:$('#PRO_userName').val(),gender:$('#gender').val(),
		dob:$('#PRO_year').val()+'-'+monthNametoID($('#PRO_month').val())+'-'+$('#PRO_day').val(),height:$('#tempH').val(),
		weight:$('#tempW').val(),stepwidth:$('#tempS').val(),timezone:timezone,cdate:mytime,unit:$('#unit').val(),source:"w"
	};
	
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",
		url:'res/saveprofile.php',
		data:JSON.stringify(outData), 
        success: function (msg) {
			back_ecode=msg.ecode;
			$.cookie('back_ecode', back_ecode);
			$('#PRO_replyInfo').html("Profile updated");
			$('#PRO_reply').show();
			$('#PRO_infoArea').hide();
			
			autohide();
			if(parent.pageID==2){
				$.cookie('back_username',$('#PRO_userName').val());
				$("#INFO_name", parent.document).html($('#PRO_userName').val());
			}
		}
    });
	
}
function savePassword(){
	//--------------判断修改密码
	$('.blankRow').each(function() {$(this).html('');});
	var curpass=$('#PRO_curPass').val();
	var newpass=$('#PRO_newPass').val();
	var repass=$('#PRO_rePass').val();
	if(curpass==""){
		$('#er_1').html('Please enter current password');return;
	}
	if(newpass==""){
		$('#er_2').html('Please enter new password');return;
	}
	if(repass==""){
		$('#er_3').html('Please retype new password');return;
	}	
	
	if(newpass != repass){
		$('#er_2').html('');
		$('#er_3').html('This does not match the password entered above.');
		return;
	}
	if(newpass == curpass){
		$('#er_2').html('New password must be different with current.');
		$('#er_3').html('New password must be different with current.');
		return;
	}

	var outData={ucode:back_ucode,scode:back_scode,ecode:back_ecode,password:curpass,newpass:newpass,cdate:mytime,source:"w"};
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",url:'res/saveprofile.php',
		data:JSON.stringify(outData), 
        success: function (msg) {
			if (msg.status==401){
				$('#er_1').html('Your current password was incorrect.');
			}			
			if (msg.status==200){
				back_ecode=msg.ecode;
				$.cookie('back_ecode', back_ecode);
				$('#PRO_replyInfo').html("Password changed");
				$('#PRO_reply').show();
				$('#PRO_passwordArea').hide();
				autohide();
			}
		}
    });
}
function autohide(){
	$('body').oneTime('1s',function(){ 
				hidethis();
				parent.beginLoad();
	}); 
}
function unitToMetric(obj){
	var v1,v2;
	
	if(obj.from=="cm"){
		//v1=Number(obj.cm)/30.48; //------1英寸=2.54cm
		v1=Number(obj.cm);
		return v1;
	}
	if(obj.from=="foot"){
		v1=Number(obj.foot)+Number(obj.inch)/12;
		v1*=30.48;
		return v1;
	}
	if(obj.from=="lb"){
		//v1=obj.lb;
		v1=Number(obj.lb)*0.45359237;
		return v1;
	}
	
	if(obj.from=="kg"){
		//v1=Number(obj.kg)/0.45359237;
		v1=Number(obj.kg);
		return v1;
	}
}
function getFromTemp(obj){
	var v1,v2;
	var value=Number(obj.value);
	if(obj.to=="foot"){
		value/=30.48;
		v2=Math.floor(value);
		v1=((value-v2)*12).toFixed(0);
		return {foot:v2,inch:v1};
	}	
	if(obj.to=="cm"){
		//v1=Math.floor(2.54*value*12);
		v1=value.toFixed(0);
		return {cm:v1};
	}
	if(obj.to=="lb"){
		//v1=Math.floor(value*10)/10;
		v1=(value*2.2046+0.1).toFixed(0);
		return {lb:v1};
	}
	if(obj.to=="kg"){
		//v1=Math.floor(value/0.045359237)/10;
		v1=value.toFixed(1);
		return {kg:v1};
	}
}

function showThumb(img){
	/*
	$("#Pro_headDiv").width(img.width);
	$("#Pro_headDiv").height(img.height);
	$("#Pro_head").attr('src',"upload/head_"+$.cookie('back_userid')+".jpg");	
	*/
}
function changeThumb(imgcss){
	/*
	$('#Pro_head').css({ 
		width: imgcss.width, 
		height: imgcss.height,
		//marginLeft:imgcss.marginLeft, 
		//marginTop: imgcss.marginLeft 
	});
	$('#Pro_headDiv').css("left",imgcss.left)
	$('#Pro_headDiv').css("top",imgcss.top)
	var nobj=$('#IFRAME_upload').contents().find('#timg');
	//$("#info").html("width:"+imgcss.width+" height:"+imgcss.height+" left:"+imgcss.left+" top:"+imgcss.top+"<br>iframe<br>"+"width:"+nobj.width()+" height:"+nobj.height()+" left:"+nobj.css("marginLeft")+" top:"+nobj.css("marginTop"));
	*/
}
function getUserInfo(){
	var nmyDate = new Date();
	var nmy=nmyDate.getFullYear();
	var nmm=nmyDate.getMonth()+1;
	var nmd=nmyDate.getDate();
	
	var nmytime=nmy+"-"+nmm+"-"+nmd+" "+nmyDate.toLocaleTimeString();
	
	var outData={ucode:back_ucode,scode:back_scode,ecode:back_ecode,source:"w",cdate:nmytime};
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",
        url:'res/getinfo.php',data:JSON.stringify(outData), 
        success: function (msg) {
			dealData(msg);
        }
    });
}

function dealData(r){
	
	//var data=eval('(' + r + ')');  

	
	
	if(r.status != 200 ){return;}
	back_ecode=r.ecode;
	$.cookie('back_ecode', back_ecode);
	sensorList=r.sensorList;
	//------add in sensor list
	$('#PRO_sensor div').each(function(){$(this).remove();});
	var obj;
	for(var i=0;i<sensorList.length;i++){
		j=i+1;
		obj=sensorList[i];
		
		var power="0000"+obj.power;
		power=power.substring(power.length-4,power.length);

		var strs='<div id="sensoritem'+i+'" class="PRO_senList"><table cellpadding="0" cellspacing="0">';
		strs+='<tr height=43><td><div class="PRO_senNO">'+j+'</div></td><td width=25><img src="images/sensor'+power+'.png" />';
		strs+='</td><td><div  class="PRO_nameBack" id="sensorname'+i+'">'+obj.nickname+'</div></td></tr></table></div>';
    	$(strs).appendTo($('#PRO_sensor'));
	}
	
	showSensor();
}
function showSensor(){
	var obj=sensorList[currentSensorID];
	if (obj.dob != "0000-00-00"){
		var dob=obj.dob;
		$('#PRO_year').val(Number(dob.substring(0,4)));
		$('#PRO_month').val(monthNameList[Number(dob.substring(5,7))-1]);
		$('#PRO_day').val(Number(dob.substring(8,10)));
		$('#PRO_year').css("color","#6b6b6b");
		$('#PRO_month').css("color","#6b6b6b");
		$('#PRO_day').css("color","#6b6b6b");
	}
	if(obj.nickname != undefined){
		$('#PRO_userName').val(obj.nickname);
		
	}
	if(obj.height != undefined){
		$('#tempH').val(obj.height);
		$('#PRO_h1').val(obj.height);
	}
	if(obj.weight != undefined){
		$('#tempW').val(obj.weight);
		$('#PRO_w').val(obj.weight);
	}
	if(obj.stepwidth != undefined){
		$('#tempS').val(obj.stepwidth);
		$('#PRO_s1').val(obj.stepwidth);
	}
	$("#Pro_head").attr("src",'upload/'+obj.headimage); 
	
	$("#Pro_head").width(182);
	$("#Pro_head").height(182);
	
	if(obj.gender != undefined){
		changSexPic(obj.gender);
	}
	changeUnit(obj.unit);

}
function changeUnit(units){
	
	$('#unit').val(units);
	if(units=="Metric"){
		showValue=getFromTemp({to:"cm",value:$('#tempH').val()});
		$("#h_u1").html("cm");$("#h_u2").html("");
		$("#h_u1").width(100);$("#h_v2").hide();
		$('#PRO_h1').val(showValue.cm);
		$('#PRO_h2').val(0);
		$('#PRO_hUnit').val("cm");
		showValue=getFromTemp({to:"cm",value:$('#tempS').val()});
		$("#s_u1").html("cm");$("#s_u2").html("");
		$("#s_u1").width(100);$("#s_v2").hide();
		$('#PRO_s1').val(showValue.cm);
		$('#PRO_s2').val(0);
		$('#PRO_sUnit').val("cm");
		showValue=getFromTemp({to:"kg",value:$('#tempW').val()});
		$('#PRO_w').val(showValue.kg);
		$("#w_u").html("kg");
		$('#PRO_wUnit').val("kg");
	}
	if(units=="Inch"){
		showValue=getFromTemp({to:"foot",value:$('#tempH').val()});
		$("#h_u1").html("feet");$("#h_u2").html("inches");
		$("#h_u1").width(40);$("#h_v2").show();
		$('#PRO_h1').val(showValue.foot);
		$('#PRO_h2').val(showValue.inch);
		$('#PRO_hUnit').val("foot");
		showValue=getFromTemp({to:"foot",value:$('#tempS').val()});
		$("#s_u1").html("feet");$("#s_u2").html("inches");
		$("#s_u1").width(40);$("#s_v2").show();
		$('#PRO_s1').val(showValue.foot);
		$('#PRO_s2').val(showValue.inch);
		$('#PRO_sUnit').val("foot");
		
		showValue=getFromTemp({to:"lb",value:$('#tempW').val()});
		$('#PRO_w').val(showValue.lb);
		$("#w_u").html("lbs");
		$('#PRO_wUnit').val("lb");
	}
}
function updatedHead(headpic){
	//alert("change profile"+headpic);
	$("#Pro_head").attr("src","upload/"+headpic); 
	parent.updatedHead(headpic);
}
