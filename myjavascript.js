
// !!!!!!! RATING PROCESS 

	function fxRate(vkey,rate,idToHide,idToShow,vid){
		cp.call(baseurl+'ajax/myajaxphp.php','process_data',return_data,rate,vid);
		hideMe(idToHide);
		showMe(idToShow);
	}

			function return_data(restul){
				
				// Collect the number of BLUE star
			var cnt=restul.getElementsByTagName('trate').item(0).firstChild.data;				
					hideMe('idViewVoteResult');
			if(cnt!='exist')
			{
				// # Show the vote 
				var x=document.getElementById('idVoteView').rows[0].cells;
					x[1].innerHTML=restul.getElementsByTagName('tvote').item(0).firstChild.data;

				
					
					if(cnt>6)
					{
						cnt=6;
					}	
					else if (cnt<0)
					{
						cnt=0;
					}
					
					blank_star=6-cnt;

					var x=document.getElementById('tblViewResult').rows[0].cells;
					
					for (i=0;i<cnt;i++ )
					{
							x[i].innerHTML='<img src='+imgurl+'/star.gif>';
					}
					
					for (j=cnt;j<5;j++ )
					{
							x[j].innerHTML='<img src=' + imgurl+'/blank_star.gif>';
					}
			}
			else
			{
				var x=document.getElementById('voteProcessthank').innerHTML="<FONT COLOR=#FF0000 >You already vote this video</FONT>";
			}
				
				return false;
			}
// RATING PROCESS END  


// !!!!!!! My voting process 

		function fxVote(voteId)
		{
				voteAnswer=document.getElementById('opAns').value;
		
				if(voteAnswer=='')
				{
					alert('Select any one');
				}
				else
				{
						cp.call(baseurl+'/ajax/myajaxphp.php','process_Vote',return_vote_result,voteId,voteAnswer);
				}
		}
					function return_vote_result(result)
					{
					var xx=result.getElementsByTagName('result').item(0).firstChild.data;
					if (xx=='1'){
							count=result.getElementsByTagName('count').item(0).firstChild.data;
							for (var  ii=0; ii<count  ; ii++ ){

								 var vv='A1'+ii;
								 var pp='P1'+ii;	
								
								vv=result.getElementsByTagName(vv).item(0).firstChild.data;
								pp=result.getElementsByTagName(pp).item(0).firstChild.data;
								
								// # Generate Voring table
								var tt=document.getElementById('tblVoteResult').insertRow(0);
								var y=tt.insertCell(0);
								var z=tt.insertCell(1);
								y.innerHTML=vv;
								z.innerHTML=pp +'%';
							
								if(vv==""){
									break;
								}
							}
							insertInToTable('tblPResult', 0,0,'Vote result');
							// # Hide the previous tale
							hideMe('divviewvresult');
							hideMe('tblVote');

					}
					else if(xx>1)
					{
						insertInToTable('tblPResult', 0,0,'<font color=#FF0000><B>Sorry you already voted..</B></FONT>');
						viewVote(xx);
							// # Hide the previous table
							//showMe('divviewvresult');
							hideMe('tblVote');
					}
				}


 // END

 // VIEW VOTE
function viewVote(pollId)
{
		cp.call(baseurl+'/ajax/myajaxphp.php','view_vote',return_view_vote,pollId);
}
		function return_view_vote(result){
			var xx;
			if (1){
					count=result.getElementsByTagName('count').item(0).firstChild.data;
					for (var  ii=0; ii<count  ; ii++ ){

						 var vv='A1'+ii;
						 var pp='P1'+ii;
						
						vv=result.getElementsByTagName(vv).item(0).firstChild.data;
						pp=result.getElementsByTagName(pp).item(0).firstChild.data;
						
						// # Generate Voring table
						var tt=document.getElementById('tblViewVoteResult').insertRow(0);
						var y=tt.insertCell(0);
						var z=tt.insertCell(1);
						y.innerHTML=vv;
						z.innerHTML=pp +'%';
					
				if(vv==""){
					break;
				}
			}
			insertInToTable('tblViewVote', 0,0,'Current vote status');
		}
		
	}



// !!!!!!!! SEND COMMENT PROCESS

	function fxSendComments(idToHide,commentId,uid,vid){
		comment_value=document.getElementById(commentId).value;
		if(comment_value==''){
			alert(' Comment box is empty !!');
		}
		else{
			hideMe(idToHide);	
			cp.call(baseurl+'/ajax/myajaxphp.php','process_comments',return_comment_response,comment_value,uid,vid);
		}		
		
	}

			function return_comment_response(restul){
				
				msg_number = restul.getElementsByTagName('a').item(0).firstChild.data;
				if(msg_number==0){
					showMe('divComResult2');
				} else if ( msg_number==1) {
					showMe('divComResult1');
				} else{
					showMe('divComResult3');
				}
			}
// END

// RECENT VIEW PROCESS
	var current_position=4;
	function recentview(amount,flag){
		
		gflag="viewrecent";
		if(flag=='next')
		{		
				var start=current_position
					current_position=current_position+amount;
				var end=current_position;
				if(dbreport!='1'){

				}

			sql="SELECT VID, title, viewtime, vkey from video where viewtime<>'0000-00-00 00:00:00' order by viewtime desc limit "+start + " , " +end;  
			executeDB(sql);	
			//alert(sql);
 			if(dbreport<0)
			{
					end=current_position;
					current_position=current_position-amount;
					start=current_position;
					alert("End");

			}
		}

		if(flag=='prev')
		{
			var end=current_position;
				current_position=current_position-amount;
			var start=current_position;

			if(start<0){
				start=amount;
				end=start+amount;
				alert("End");
			}

			sql="SELECT VID, title, viewtime, vkey from video where viewtime<>'0000-00-00 00:00:00' order by viewtime desc limit "+start + " , " +end;  
			executeDB(sql);
		}
	}
//END


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
			z.innerHTML='<INPUT TYPE=text SIZE=40 NAME=voteAnsBox'+i+' ID=voteAnsBox'+i+' onBlur=txtBoxValidation(voteAnsBox'+i+', #EAEAEA,#FF0033) >';
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
  

function fxShowAccInfo(a,b){
	showMe(a);
	hideMe(b);	
}

function fxReportVideo(hidediv, uid, vid ) {
	if ( uid == '0' ) {
		hideMe(hidediv);
		showMe('reportVideoLogin');
	} else {
		showMe('reportVideoBox');
		
	}
}

function fxFeatureVideo( uid, vid ) {
	if ( uid == '0' ) {
		hideMe('featureVideoSuccess');
		hideMe('featureVideoFailed');
		showMe('featureVideoLogin');
	} else {
		cp.call(baseurl+'/ajax/myajaxphp.php','featureVideo', featureVideoResponse, uid, vid);
	}
}

function featureVideoResponse( feature_result ) {
	var feature_response_id=feature_result.getElementsByTagName('featureVideoMessage').item(0).firstChild.data;
	if ( feature_response_id == '0' ) {
		hideMe('featureVideoFailed');
		hideMe('featureVideoLogin');
		showMe('featureVideoSuccess');
	} else {
		hideMe('featureVideoSuccess');
		hideMe('featureVideoLogin');
		showMe('featureVideoFailed');
	}
}

function fxReportVideo( uid, vid ) {
	if ( uid == '0' ) {
		hideMe('reportVideoSuccess');
		hideMe('reportVideoFailed');
		showMe('reportVideoLogin');
	} else {
		cp.call(baseurl+'/ajax/myajaxphp.php','reportVideo', reportVideoResponse, uid, vid);
	}
}

function reportVideoResponse( report_result ) {
	var report_response_id=report_result.getElementsByTagName('reportVideoMessage').item(0).firstChild.data;
	if ( report_response_id == '0' ) {
		hideMe('reportVideoFailed');
		hideMe('reportVideoLogin');
		showMe('reportVideoSuccess');
	} else {
		hideMe('reportVideoSuccess');
		hideMe('reportVideoLogin');
		showMe('reportVideoFailed');
	}
}

function fxAddFavorite( hidediv, uid, vid, vuid ) {	
	hideMe(hidediv);
	if ( uid == '0' ) {
		hideMe('addToFavLink');
		hideMe('addToFavSuccess');
		hideMe('addToFavFailed');
		hideMe('addToFavAlready');
		hideMe('addToFavOwner');
		showMe('addToFavLogin');	
	} else if ( uid == vuid ) {	
		hideMe('addToFavLink');
		hideMe('addToFavSuccess');
		hideMe('addToFavFailed');
		hideMe('addToFavAlready');
		hideMe('addToFavLogin');
		showMe('addToFavOwner');
	} else {
		cp.call(baseurl+'/ajax/myajaxphp.php','addToFavorites', addToFavoritesResponse, uid, vid, vuid);
	}
}

function addToFavoritesResponse( fav_result ) {
	var fav_response_id=fav_result.getElementsByTagName('addFavMessage').item(0).firstChild.data;
	if( fav_response_id == '2' ) {
		hideMe('addToFavLink');
		hideMe('addToFavSuccess');
		hideMe('addToFavFailed');
		hideMe('addToFavLogin');
		hideMe('addToFavOwner');
		showMe('addToFavAlready');
	} else if( fav_response_id == '0' ) {
		hideMe('addToFavLink');
		hideMe('addToFavFailed');
		hideMe('addToFavAlready');
		hideMe('addToFavLogin');
		hideMe('addToFavOwner');
		showMe('addToFavSuccess');
	} else {
		hideMe('addToFavLink');
		hideMe('addToFavSuccess');
		hideMe('addToFavAlready');
		hideMe('addToFavLogin');
		hideMe('addToFavOwner');
		showMe('addToFavFailed');
	}
}

function pollAnsBox($num){
	alert($num);
}

function showRelatedVideos()
{
    var tabRelatedVideos = document.getElementById('tabRelatedVideos');
    var tabUservideos = document.getElementById('tabUserVideos');
    tabUservideos.className = "";
    tabRelatedVideos.className = "tabactive";
    hideMe('userVideos');
    showMe('relatedVideos');
}

function showUserVideos()
{
    var tabRelatedVideos = document.getElementById('tabRelatedVideos');
    var tabUservideos = document.getElementById('tabUserVideos');
    tabRelatedVideos.className = "";
    tabUservideos.className = "tabactive";
    hideMe('relatedVideos');
    showMe('userVideos');
}
