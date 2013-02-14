	function hoverTab(tabData){
		tabData.style.backgroundPosition = " 0% -50px";
		tabData.style.lineHeight = "24px";
	}
	
	function outTab(tabData){
		tabData.style.backgroundPosition = " 0% -25px";
	}
	
	function executeTab(tabData){
		tabData.className = "tabactive";
		tabData.style.backgroundPosition = " 0% -0px";
		tabData.onmouseover=function(){};
		tabData.onmouseout=function(){};
	}
	
	function showTabData(idForDisplay){
		var tabFeatured = document.getElementById('tab-featured'); 
		var tabToprated = document.getElementById('tab-toprated');
		var tabMostview = document.getElementById('tab-mostview');
		
		var featuretab = document.getElementById('featuretab');
		var topratedtab = document.getElementById('topratedtab');
		var mostviewedtab = document.getElementById('mostviewedtab');
		
		tabFeatured.style.display = "none";
		tabToprated.style.display = "none";
		tabMostview.style.display = "none";
		 
		featuretab.className = "";
		topratedtab.className = "";
		mostviewedtab.className = "";
		
		featuretab.style.backgroundPosition = " 0% -25px";
		topratedtab.style.backgroundPosition = " 0% -25px";
		mostviewedtab.style.backgroundPosition = " 0% -25px";
		
		featuretab.onmouseover=function(){hoverTab(this);}
		topratedtab.onmouseover=function(){hoverTab(this);}
		mostviewedtab.onmouseover=function(){hoverTab(this);}
		
		featuretab.onmouseout=function(){outTab(this);}
		topratedtab.onmouseout=function(){outTab(this);}
		mostviewedtab.onmouseout=function(){outTab(this);}
		
		if (idForDisplay == "featured"){	
			tabFeatured.style.display = "block";
			executeTab(featuretab);
		}			
		else if(idForDisplay == "toprated"){
			tabToprated.style.display = "block";
			executeTab(topratedtab);			
		}
		else if(idForDisplay == "mostview"){
			tabMostview.style.display = "block";
			executeTab(mostviewedtab);
		}
		
 	}