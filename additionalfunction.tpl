{php}
 function insert_additional_data(){
	global $config,$conn;	
				if ($config['approve'] == 1) {$active = "and active = '1'";}
                $sql = "SELECT count(*) as total from video where type='public' $active"; 
                $ars = $conn->Execute($sql); 
                $grandtotalpublic = $ars->fields['total'];
                STemplate::assign('grandtotalpublic',$grandtotalpublic+0); 

                $sql = "SELECT count(*) as total from video where type='private' $active"; 
                $ars = $conn->Execute($sql); 
                $grandtotalprivate  = $ars->fields['total']; 
                STemplate::assign('grandtotalprivate',$grandtotalprivate+0); 

                $sql = "SELECT count(*) as total from signup $query"; 
                $ars = $conn->Execute($sql); 
                $grandtotaluser  = $ars->fields['total']; 
                STemplate::assign('grandtotaluser',$grandtotaluser+0); 			
//stats end
				$sql="SELECT * from channel ORDER BY rand() LIMIT 5 ";
				$rs = $conn->Execute($sql);
				$channellist = $rs->getrows();
				STemplate::assign('channellist',$channellist);
				
				#get latest video on db 
				#end get latest video on db 				
				$sql = "SELECT * from video where type='public' $active ORDER BY VID DESC LIMIT 5 "; 
                $rs = $conn->Execute($sql); 
                $footerLatestVideo = $rs->getrows();
				STemplate::assign('footerLatestVideo',$footerLatestVideo); 
				//Recent TAGS

				$featuredtagsquery="SELECT keyword from video where type='public' $active order by addtime desc limit 20";
				$recenttags=cloudTags($featuredtagsquery);
				STemplate::assign('recenttagsfooter',$recenttags);
 }
{/php}