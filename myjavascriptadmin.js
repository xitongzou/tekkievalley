

function pollAnsBox(myID){

	Me=document.getElementById(myID);
	if(Me.value==""){
		  Me.style.background="#3366FF";
		
	}
	else{		
		Me.style.background="#FFFFFF";
		xy=Me.value;
		for (i=0;i<Me.value;i++ ){		
			var x=document.getElementById('tblViweAnsBox').insertRow(0);
			var y=x.insertCell(0);
			var z=x.insertCell(1);
			y.innerHTML='Answer ' + (xy-i);			
			z.innerHTML='<INPUT TYPE=text SIZE=40 NAME=voteAnsBox'+i+' ID=voteAnsBox'+i+' onBlur=txtBoxValidation("voteAnsBox'+i+'","#EAEAEA","#FF0033")>';
		}
	}
	
}

// ## Delete row of a Tabile
	function delteRow(){
		var x=document.getElementById('tblViweAnsBox').rows.length-1;

		for (var i=x;i>=0;i--){
					document.getElementById('tblViweAnsBox').deleteRow(i);
			}
	}


	function fxvalidation(){
		var flag=true;
		var x=document.getElementById('tblViweAnsBox').rows.length-1;

		// ## Question text
		flag=txtBoxValidation('txtQtn','#EAEAEA','#FF0033');

		// ## Questin qty
		flag=txtBoxValidation('txtPollAnsQty','#EAEAEA','#FF0033');
		
		
		for ( i=x; i>=0; i-- )
		{
			targetID='voteAnsBox'+i;
			if (document.getElementById(targetID).value==""){
				txtBoxValidation(targetID,'#EAEAEA','#FF0033');
				flag=false;
				break;
			}
				
							
		}

		return flag;
	}
  




// !!!!!! Input validation empty

	function txtBoxValidation(myId,defaultColor,errColor){
		
		// # My property
		try{	
			me=document.getElementById(myId);

			if(me.value==""){	
				me.style.background=errColor;
				me.setFocus;
				return false;
			}
			else{
				me.style.background=defaultColor;
				me.setFocus;
				return true;
			}
		}
		catch(Err){
			return 'Err';
		}
	}

// END 



function fxShowAccInfo(a,b){
	showMe(a);
	hideMe(b);	
}

/*function pollAnsBox($num){
	alert($num);
}
*/