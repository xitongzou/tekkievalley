Hello {$uname},

{$sender_name} just uploaded a new video.
You can view his video at the following url:
<a href="{seourl rewrite="video/`$vid`" url="view_video.php?viewkey=`$key`" clean=$title}">{$title|escape:'html'}</a>

Thanks,
{$site_name}

