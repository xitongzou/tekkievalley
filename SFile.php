<?php
class SFile {
    var $_root_dir;

    function create() {
        return new SFile();
    }

    function setRoot($dir) {
        global $SFile;
        if (!isset($SFile)) SFile::create();
        $SFile->_root_dir = $dir;
    }

    function getRoot() {
        global $SFile;
        if (!isset($SFile)) SFile::create();
        return $SFile->_root_dir;
    }

    //------------------------------
    function isExists($filename, $directory = null) {
        global $SFile;
        if (!isset($SFile)) SFile::create();
        if ($directory) {
            $filename = $SFile->_root_dir . "/" . $directory . "/" . $filename;
        } else {
            $filename = $SFile->_root_dir . "/" . $filename;
        }
        return file_exists($filename);
    }

    function delete($filename, $directory = null) {
        global $SFile;
        if (!isset($SFile)) SFile::create();
        if ($directory) {
            $filename = $SFile->_root_dir . "/" . $directory . "/" . $filename;
        } else {
            $filename = $SFile->_root_dir . "/" . $filename;
        }
        unlink($filename);
    }


    function read($filename, $directory = null) {
        global $SFile;
        if (!isset($SFile)) SFile::create();
        if ($directory) {
            $filename = $SFile->_root_dir . "/" . $directory . "/" . $filename;
        } else {
            $filename = $SFile->_root_dir . "/" . $filename;
        }
        @$fd = fopen ($filename, "r");
        if (!$fd) {
            return false;
        }
        $buffer = "";
        while (!feof ($fd)) {
            $buffer .= fgets($fd, 4096);
        }
        fclose ($fd);
        return $buffer;
    }

    function getModificationTime($filename, $directory = null) {
        global $SFile;
        if (!isset($SFile)) SFile::create();
        if ($directory) {
            $filename = $SFile->_root_dir . "/" . $directory . "/" . $filename;
        } else {
            $filename = $SFile->_root_dir . "/" . $filename;
        }

        return filemtime($filename);
   }



    function write($filename, $content, $directory = null) {
        global $SFile;
        if (!isset($SFile)) SFile::create();
        if ($directory) {
            $filename = $SFile->_root_dir . "/" . $directory . "/" . $filename;
        } else {
            $filename = $SFile->_root_dir . "/" . $filename;
        }
        $fp = fopen($filename, 'w');
        fwrite($fp, $content);
        return true;
    }

    function getDir($directory = "", $get_dirs = false, $mask = null) {
        global $SFile;
        if (!isset($SFile)) SFile::create();

        if ($directory) {
            $filename = $SFile->_root_dir . "/" . $directory . "/";
        } else {
            $filename = $SFile->_root_dir . "/";
        }
        if ($handle = opendir($filename)) {
            while (false !== ($file = readdir($handle))) {
                if (!eregi("^\.", $file)) {
                    if ($get_dirs) {
                        if (is_dir($filename . "/" . $file)) {
                            if (($mask and (eregi($mask, $file))) or (!$mask)) {
                                $files[] = $file;
                            }
                        }
                    } else {
                        if (!is_dir($filename . "/" . $file)) {
                            if (($mask and (eregi($mask, $file))) or (!$mask)) {
                                $files[] = $file;
                            }
                        }
                    }
                }
            }
            closedir($handle);
        }
        if (isset($files)) {
            sort($files);
            return $files;
        } else {
            return false;
        }
    }

    function saveHttp($filename, $http_name, $directory = null) {
        global $SFile;
        if (!isset($SFile)) SFile::create();
        if ($directory) {
            $filename = $SFile->_root_dir . "/" . $directory . "/" . $filename;
        } else {
            $filename = $SFile->_root_dir . "/" . $filename;
        }

        if (file_exists($filename)) {
            return false;
        }
        copy($_FILES[$http_name]["tmp_name"], $filename);
        return true;

    }

    function makeDir($filename, $directory = null) {
        global $SFile;
        if (!isset($SFile)) SFile::create();
        if ($directory) {
            $filename = $SFile->_root_dir . "/" . $directory . "/" . $filename;
        } else {
            $filename = $SFile->_root_dir . "/" . $filename;
        }
        mkdir($filename, 0777);
    }

    function removeDir($filename, $directory = null) {

        global $SFile;
        if (!isset($SFile)) SFile::create();
        if ($directory) {
            $filename = /*$SFile->_root_dir . "/" . */$directory . "/" . $filename;
        } else {
            $filename = /*$SFile->_root_dir . "/" . */$filename;
        }

        $content = SFile::getDir($filename);

        foreach ($content as $fn) {
            SFile::delete($fn, $filename);
        }
        rmdir($SFile->_root_dir . "/" . $filename);
    }

    function renameDir($old_filename, $new_filename, $directory = null) {
        global $SFile;
        if (!isset($SFile)) SFile::create();
        if ($directory) {
            $old_filename = $SFile->_root_dir . "/" . $directory . "/" . $old_filename;
            $new_filename = $SFile->_root_dir . "/" . $directory . "/" . $new_filename;
        } else {
            $old_filename = $SFile->_root_dir . "/" . $old_filename;
            $new_filename = $SFile->_root_dir . "/" . $new_filename;
        }
        rename($old_filename, $new_filename);
    }

}

?>