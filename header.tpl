<html>
<head>
    <title>{$site_name} - Administration Panel</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <link href="{$baseurl}/css/tpl_admin.css" type="text/css" rel="stylesheet">
    <script src="{$baseurl}/js/jquery-1.2.6.pack.js" type="text/javascript"></script>
    <script src="{$baseurl}/js/jquery.admin-0.1.js" type="text/javascript"></script>
    <script src="{$baseurl}/js/myjavascriptadmin.js" type="text/javascript"></script>
</head>
<div id="container">
    <div id="header">
        <h1>&nbsp; {$site_name} Administration Panel</h1>
        <div id="menu">
        <ul>
            <li>{if $active_menu eq 'index'}<span>Settings</span>{else}<a href="index.php">Settings</a>{/if}</li>
            <li>{if $active_menu eq 'videos'}<span>Videos</span>{else}<a href="videos.php">Videos</a>{/if}</li>
            <li>{if $active_menu eq 'users'}<span>Users</span>{else}<a href="users.php">Users</a>{/if}</li>
            <li>{if $active_menu eq 'channels'}<span>Channels</span>{else}<a href="channels.php">Channels</a>{/if}</li>
            <li>{if $active_menu eq 'groups'}<span>Groups</span>{else}<a href="groups.php">Groups</a>{/if}</li>
            <li>{if $active_menu eq 'ads'}<span>Advertising</span>{else}<a href="ads.php">Advertising</a>{/if}</li>
        </ul>
        </div>
    </div>
    <div id="content">