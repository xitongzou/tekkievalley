{if $smarty.request.gid eq ""}
|<a href="{seourl rewrite="group/`$smarty.request.urlkey`/`$answers[0].GID`" url="groups_home.php?urlkey=`$smarty.request.urlkey`&gid=`$answers[0].GID`"}">{translate item='global.group_home'}</a>
|<a href="{seourl rewrite="group/`$smarty.request.urlkey`/videos/`$answers[0].GID`" url="gvideos.php?urlkey=`$smarty.request.urlkey`&amp;gid=`$answers[0].GID`"}">{translate item='global.videos'}</a>
|<a href="{seourl rewrite="group/`$smarty.request.urlkey`/members/`$answers[0].GID`" url="gmembers.php?urlkey=`$smarty.request.urlkey`&amp;gid=`$answers[0].GID`"}">{translate item='global.group_members'}</a>
{insert name=getfield assign=owner_id field='OID' table='group_own' qfield=GID qvalue=$answers[0].GID}{if $smarty.session.UID eq $owner_id and $gupload eq "owner_only"}|<a href="{seourl rewrite="group/add/video/`$smarty.request.urlkey`/`$answers[0].GID`" url="add_video.php?urlkey=`$smarty.request.urlkey`&amp;gid=`$answers[0].GID`"}">{translate item='global.add_videos'}</a>{/if}
{if $gupload ne "owner_only"}|<a href="{seourl rewrite="group/add/video/`$smarty.request.urlkey`/`$answers[0].GID`" url="add_video.php?urlkey=`$smarty.request.urlkey`&amp;gid=`$answers[0].GID`"}">{translate item='global.add_videos'}</a>{/if}
|<a href="{$baseurl}/invite_members.php?urlkey={$smarty.request.urlkey}&amp;gid={$answers[0].GID}">{translate item='global.invite_members'}</a>
{else}
|<a href="{seourl rewrite="group/`$smarty.request.urlkey`/`$smarty.request.gid`" url="groups_home.php?urlkey=`$smarty.request.urlkey`&amp;gid=`$smarty.request.gid`"}">{translate item='global.group_home'}</a>
|<a href="{seourl rewrite="group/`$smarty.request.urlkey`/videos/`$smarty.request.gid`" url="gvideos.php?urlkey=`$smarty.request.urlkey`&amp;gid=`$smarty.request.gid`"}">{translate item='global.videos'}</a>
|<a href="{seourl rewrite="group/`$smarty.request.urlkey`/members/`$smarty.request.gid`" url="gmembers.php?urlkey=`$smarty.request.urlkey`&amp;gid=`$smarty.request.gid`"}">{translate item='global.group_members'}</a>
{insert name=getfield assign=owner_id field='OID' table='group_own' qfield=GID qvalue=$smarty.request.gid}{if $smarty.session.UID eq $owner_id and $gupload eq "owner_only"}|<a href="{seourl rewrite="group/add/video/`$smarty.request.urlkey`/`$smarty.request.gid`" url="add_video.php?urlkey=`$smarty.request.urlkey`&amp;gid=`$smarty.request.gid`"}">{translate item='global.add_videos'}</a>{/if}
{if $gupload ne "owner_only"}|<a href="{seourl rewrite="group/add/video/`$smarty.request.urlkey`/`$smarty.request.gid`" url="add_video.php?urlkey=`$smarty.request.urlkey`&amp;gid=`$smarty.request.gid`"}">{translate item='global.add_videos'}</a>{/if}
|<a href="{$baseurl}/invite_members.php?urlkey={$smarty.request.urlkey}&amp;gid={$smarty.request.gid}">{translate item='global.invite_members'}</a>
{/if} 