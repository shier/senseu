
var back_ucode=$.cookie('back_ucode');
var back_scode=$.cookie('back_scode');
var back_ecode=$.cookie('back_ecode');
var msgID=0;
var msgList=new Array();
$(function(){
	$('.accept').button();
	$('.accept').click(function() {acceptFriend();});
	$('.decline').button();
	$('.decline').click(function() {declineFriend();});
	getMsg();
	//addWarning('k')
	
});
function getMsg(){
	back_ecode=$.cookie('back_ecode');
	var outData={ucode:back_ucode,scode:back_scode,ecode:back_ecode,source:"w"};
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",
			url:'res/getmsg.php',
        	data:JSON.stringify(outData), 
        	success: function (msg) {
				addWarning(msg);
        	}
    	});
}
function addWarning(r){
	if(r.status != 200){return;}
	msgList=r.msglist;
	rebuildList();
}
function rebuildList(){
	msglen=msgList.length;
	var strs;
	msglen>1? strs="<ul class='diaporama1'>":strs="";
	
	for(i=0;i<msglen;i++){
		
		if(msglen>1){strs+='<li>';}
		strs+='<img src="images/empty.png" width=369 height=150 />';
		strs+='<div class="msg_head"><img src="upload/'+msgList[i].head+'" width=50 height=50></div>';
 		strs+='<div class="msg_name">'+msgList[i].nickname+'</div>';
		strs+='<div class="msg_text">'+msgList[i].message+'</div>';
		strs+='<button class="accept" id="accept'+i+'">Accept</button><button class="decline" id="declin'+i+'">Decline</button>';
		
		if(msglen>1){strs+='</li>';};
	}
	if(msglen>1){strs+="</ul>";};
	$("#picList").html(strs);
	if(msglen>1){
		$(".diaporama1").jDiaporama({
			animationSpeed: "slow",
			auto: false,
			onrollover:false,
			infos:false,
		
		});
	}
	$('.accept').bind({
			click:function(event){deal($(this).attr("id"));}
	});	
	$('.decline').bind({
			click:function(event){deal($(this).attr("id"));}
	});	
}
function deal(id){
	type=id.substring(0,6);
	msgID=id.substring(6,id.length);
	back_ecode=$.cookie('back_ecode');
	var outData={ucode:back_ucode,scode:back_scode,ecode:back_ecode,source:"w",type:type,num:msgList[msgID].scode};
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",
			url:'res/dealmsg.php',
        	data:JSON.stringify(outData), 
        	success: function (msg) {
				reDeal(msg);
        	}
    });
	
}

function reDeal(r){
	if(r.status != 200){return;}
	var temp=msgList.splice(msgID,1);
	rebuildList();
	parent.showMessage(msgList.length);
}