var iconID=0
var pageID=1; // homepage
var t=n=0;
var nextIconID=0
var count=6;
var clickIconID=1;
document.write("<script type='text/javascript' src='js/reglogin.js'></"+"script>"); 
$(function(){
	for(i=0;i<count;i++){
		$('<div id="icon'+i+'" class="iconItem"></div>').appendTo($('#iconList'));	
		$('#icon'+i).css("background","url(images/icon"+i+"_0.png)");
	}
	
	count=$('#videoWindow div').length;
	$('#videoWindow div:not(:first-child)').hide();
	$('#buy').click(function(){
		location.href="purchase.php";
	});
	//t=setInterval("showAuto()", 9000);
	showAuto();
	
});

function autoshow(){
	$('body').oneTime('6s','autoload',function(){ showAuto()}); 
}
function showIcon(){
	for(i=0;i<count;i++){
		obj=$("#icon"+i)
		if(i==iconID){
			obj.html('<img src="images/icon'+i+'_1.png" />');
			obj.unbind();
			$("#icon"+i+" img").fadeIn();
			//obj.css("cursor","default");
		}else{
			obj.html('');
			//obj.bind("mouseenter",{id:i},showover);
			//obj.bind("mouseleave",{id:i},showout);
			//obj.bind("click",{id:i},jumppage);
			//obj.css("cursor","pointer");
		}
	}
}

function showover(event){
	$('#icon'+event.data.id).html('<img src="images/icon'+event.data.id+'_2.png" />');
	$('#icon'+event.data.id+' img').fadeIn();
}
function showout(event){
	$('#icon'+event.data.id+' img').fadeOut();
}
function jumppage(event){
	iconID=event.data.id
	showAuto();
	
}

function showAuto(){
	$('body').stopTime ();
	for(var i=0;i<count;i++){
		i==iconID ? $("#videoWindow div").eq(i).fadeIn():$("#videoWindow div").eq(i).fadeOut()
	}
  	showIcon()
	iconID==count-1 ? iconID=0:iconID++
  	$('body').oneTime('6s','autoload',function(){ showAuto()}); 
}