<?php
class CRemember
{
    function check()
    {
        if (!isset($_SESSION['UID']) && isset($_COOKIE['remember'])) {
            $browser    = (isset($_SERVER['HTTP_USER_AGENT'])) ? sha1($_SERVER['HTTP_USER_AGENT']) : NULL;
            $ip         = (isset($_SERVER['REMOTE_ADDR']) && long2ip(ip2long($_SERVER['REMOTE_ADDR']))) ? ip2long($_SERVER['REMOTE_ADDR']) : NULL;
            $cookie     = unserialize($_COOKIE['remember']);
            if (is_array($cookie)) {
                if ($cookie['check'] == md5($browser . $ip)) {
                    global $conn;
                    $sql    = "SELECT UID, username, email, emailverified, photo, fname, pwd, logintime
                               FROM signup
                               WHERE username = '" .mysql_real_escape_string($cookie['username']). "',
                               AND pwd = '" .mysql_real_escape_string($cookie['password']). "'
                               LIMIT 1";
                    $rs     = $conn->execute($sql);
                    if ($conn->Affected_Rows() === 1) {
                        $user = $rs->getrows();
                        $sql  = "UPDATE signup SET logintime = '" .time(). "' WHERE username = '" .mysql_real_escape_string($user['0']['username']). "' LIMIT 1";
                        $conn->execute($sql);
                        $_SESSION['myUID']          = $user['0']['UID'];
                        $_SESSION['UID']            = $user['0']['UID'];
                        $_SESSION['EMAIL']          = $user['0']['email'];
                        $_SESSION['USERNAME']       = $user['0']['username'];
                        $_SESSION['EMAILVERIFIED']  = $user['0']['emailverified'];
                        CRemember::set($user['0']['username'], $user['0']['pwd']);
                    }
                }
            }
        }
    }
    
    function set($username, $password)
    {
        $browser    = (isset($_SERVER['HTTP_USER_AGENT'])) ? sha1($_SERVER['HTTP_USER_AGENT']) : NULL;
        $ip         = (isset($_SERVER['REMOTE_ADDR']) && long2ip(ip2long($_SERVER['REMOTE_ADDR']))) ? ip2long($_SERVER['REMOTE_ADDR']) : NULL;
        $user       = array('username' => $username, 'password' => $password, 'check' => md5($browser . $ip));
        $cookie     = serialize($user);
        setcookie('remember', $cookie, time()+60*60*24*100, '/');
    }
    
    function del()
    {
        setcookie('remember', '', time()-60*60*24*100, '/');
    }
}
?>
