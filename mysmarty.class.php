<?php

class STemplate {

   function STemplate() {
        global $Smarty;
        if (!isset($Smarty)) {
            $Smarty = new Smarty;
        }
    }

    function create() {
        global $Smarty;
        $Smarty = new Smarty();
        $Smarty->compile_check = true;
        $Smarty->debugging = false;
        $Smarty->template_dir = dirname(__FILE__) . "/../../templates";
        $Smarty->compile_dir  = dirname(__FILE__) . "/../../templates_c";

        return true;
    }
    
    function setCompileDir($dir_name) {
        global $Smarty;
        if (!isset($Smarty)) {
            STemplate::create();
        }
        $Smarty->compile_dir = $dir_name;
    }

    function setType($type) {
        global $Smarty;
        if (!isset($Smarty)) {
            STemplate::create();
        }
        $Smarty->type = $type;
    }

    function assign($var, $value) {
        global $Smarty;
        if (!isset($Smarty)) {
            STemplate::create();
        }
        $Smarty->assign($var, $value);
    }

    function setTplDir($dir_name = null) {
        global $Smarty;
        if (!isset($Smarty)) {
            STemplate::create();
        }
        if (!$dir_name) {
            $Smarty->template_dir = dirname(__FILE__) . "/../../templates/default";
        } else {
            $Smarty->template_dir = $dir_name;
        }
    }

    function setModule($module) {
        global $Smarty;
        if (!isset($Smarty)) {
            STemplate::create();
        }
        $Smarty->theme = $module;
        $Smarty->type  = "module";
    }

    function setTheme($theme) {
        global $Smarty;
        if (!isset($Smarty)) {
            STemplate::create();
        }
        /*
        if (!file_exists(dirname(__FILE__) . "/../../templates/" . $theme)) {
            $theme = "default";
        } */
        $Smarty->template_dir = dirname(__FILE__) . "/../../templates/" . $theme;
        $Smarty->compile_dir  = dirname(__FILE__) . "/../../templates_c/" . $theme;
        $Smarty->theme        = $theme;
        $Smarty->type         = "theme";
    }

    function getTplDir() {
        global $Smarty;
        if (!isset($Smarty)) {
            STemplate::create();
        }
        return $Smarty->template_dir;
    }

    function display($filename) {
        global $Smarty;
        if (!isset($Smarty)) {
            STemplate::create();
        }
        $Smarty->display($filename);
    }

    function fetch($filename) {
        global $Smarty;
        if (!isset($Smarty)) {
            STemplate::create();
        }
        return $Smarty->fetch($filename);
    }
    
    function gzip_encode()
    {
        global $Smarty;
        if (!isset($Smarty)) {
            STemplate::create();
        }
        return $Smarty->gzip_encode();
    }
    
    function getVars() {
        global $Smarty;
        if (!isset($Smarty)) {
            STemplate::create();
        }
        return $Smarty->get_template_vars();
    }
}
?>