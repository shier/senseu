var menuList=new Array();
menuList[11]="privacy.php"
menuList[12]="about.php"
menuList[13]="help.php"
menuList[14]="download.php"
$(function(){

	for(var i=11;i<15;i++){
		if(i != parent.pageID){
			$('#menu'+i).addClass("G_bottomMenuTextBtn");
			$('#menu'+i).attr("mid",i)
			$('#menu'+i).click(function(){
				//alert(menuList[$(this).attr("mid")]);
				
				parent.location=menuList[$(this).attr("mid")];
			
			});
			$('#menu'+i).mouseover(function(){$(this).addClass('G_menuOver'); });
			$('#menu'+i).mouseout(function(){$(this).removeClass('G_menuOver'); });
		}
	}
});
