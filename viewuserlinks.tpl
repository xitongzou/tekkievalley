{insert name=id_to_name assign=uname un=$UID}
{insert name=video_count assign=publicvdo uid=$UID type=public}
{insert name=video_count assign=privatvdo uid=$UID type=private}
{insert name=favour_count assign=favcount uid=$UID}
{insert name=group_count assign=grpcount uid=$UID}
{insert name=friends_count assign=friendcount uid=$UID}
{insert name=playlist_count assign=playcount uid=$UID}
<a href="{seourl rewrite="users/`$uname`" url="uprofile.php?UID=`$UID`"}">{translate item='global.profile'}</a>|
<a href="{seourl rewrite="users/`$uname`/videos/public" url="uvideos.php?UID=`$UID`&type=public"}">{translate item='global.public_videos'} ({$publicvdo})</a>|
<a href="{seourl rewrite="users/`$uname`/videos/private" url="uvideos.php?UID=`$UID`&type=private"}">{translate item='global.private_videos'} ({$privatvdo})</a>|
<a href="{seourl rewrite="users/`$uname`/favorites" url="ufavour.php?UID=`$UID`"}">{translate item='global.favorites'} ({$favcount})</a>|
<a href="{seourl rewrite="users/`$uname`/friends" url="ufriends.php?UID=`$UID`"}">{translate item='menu.friends'} ({$friendcount})</a>|
<a href="{seourl rewrite="users/`$uname`/playlists" url="uplaylist.php?UID=`$UID`"}">{translate item='global.playlists'} ({$playcount})</a>|
<a href="{seourl rewrite="users/`$uname`/groups" url="ugroups.php?UID=`$UID`"}">{translate item='menu.groups'} ({$grpcount})</a>
