<?php

define('AUTOLOAD_CSS', 'css');
define('AUTOLOAD_JS', 'js');

/**
 * This class loads the specified CSS or JS
 */
class Autoload {

    /**
     * Chech if the given dir and files exist and are valids
     * @param String $dir The directory we want to check
     * @param array() $files array of files that we want to autoload if null checks all the files in dir
     * @param string $type Type of load we want to make, accepted values 'css' y 'js'
     * @return boolean wheather or not the file is valid
     * @throws AutoloadException
     */
    function check($dir, $files = null, $type = AUTOLOAD_CSS) {
        if (!($type == AUTOLOAD_CSS || $type == AUTOLOAD_JS)) {
            throw new AutoloadException("The given type '$type' is not valid");
        }
        if (is_dir($dir)) {
            $directory = dir($dir);
            while ((false !== ($item = $directory -> read())) && (!isset($directory_not_empty))) {
                if ($item != '.' && $item != '..') {
                    $info = pathinfo($dir . "/" . $item);
                    if (isset($info['extension']) && strtolower($info['extension']) == $type) {
                        $directory_not_empty = true;
                    }
                }
            }
            if (!isset($directory_not_empty) || $directory_not_empty != true) {
                throw new AutoloadException("The given dir '$dir' doesn't have valid files");
            }
            if (substr($dir, -1) == '/' || substr($dir, -1) == '\\') {
                $dir = substr($dir, 0, -1);
            }
            if ($files != null) {
                foreach ($files as $file) {
                    if (!file_exists($dir . "/" . $file)) {
                        throw new AutoloadException("File '" . $file . "' don't exist");
                    } else {
                        $info = pathinfo($dir . "/" . $file);
                        if (!isset($info['extension']) || strtolower($info['extension']) != $type) {
                            throw new AutoloadException("The given file '$file' is invalid");
                        }
                    }
                }
            }
            return true;
        } else {
            throw new AutoloadException("The given dir '$dir' is not a directory");
        }
    }

    /**
     * Get the array of the files to be imported
     * @param String $dir The directory we want to auto load
     * @param array() $include array of files that we want to autoload if null loads all the files in dir
     * @param array() $exclude the array of files we DON'T want to include in our load
     * @param string $type Type of load we want to make, accepted values 'css' y 'js'
     * @param return array() Array with the files that are going to be loaded
     * @throws AutoloadException
     */
    function getFiles($dir, $include = null, $exclude = null, $type = AUTOLOAD_CSS) {
        if ($this->check($dir, $include, $type)) {

            if ($include == null || !is_array($include)) {
                $include = array();
                $directory = dir($dir);
                while (false !== ($item = $directory -> read())) {
                    if ($item != '.' && $item != '..') {
                        $info = pathinfo($dir . "/" . $item);
                        if (isset($info['extension']) && strtolower($info['extension']) == $type) {
                            $include[] = $item;
                        }
                    }
                }
            }
            if ($exclude != null && is_array($exclude)) {
                $include = array_diff($include, $exclude);
            }

            return $include;
        }
    }
    
    /**
     * Get the string containing the css tags we want to load
     * @param String $dir The directory we want to auto load
     * @param array() $include array of files that we want to autoload if null loads all the files in dir
     * @param array() $exclude the array of files we DON'T want to include in our load
     * @param return array() Array with the files that are going to be loaded
     * @param array() extras extra atributes for the tags
     * @return String
     * @throws AutoloadException
     */
    function loadCss($dir, $include = null, $exclude = null,$extras=null){
        $files = $this->getFiles($dir,$include,$exclude,AUTOLOAD_CSS);
        $tags="";
        foreach($files as $file){
            $tags.="<link rel=\"stylesheet\" type=\"text/css\" ";
            if($extras!= null && is_array($extras)){
                foreach ($extras as $key => $value) {
                    $tags.="$key=\"$value\" ";
                }
            }
            $tags.="href=\"$dir/$file\" />\n";
        }
        return $tags;
    }
    
    /**
     * Get the string containing the js tags we want to load
     * @param String $dir The directory we want to auto load
     * @param array() $include array of files that we want to autoload if null loads all the files in dir
     * @param array() $exclude the array of files we DON'T want to include in our load
     * @param return array() Array with the files that are going to be loaded
     * @param array() extras extra atributes for the tags
     * @throws AutoloadException
     */
    function loadJs($dir, $include = null, $exclude = null,$extras=null){
        $files = $this->getFiles($dir,$include,$exclude,AUTOLOAD_JS);
        $tags="";
        foreach($files as $file){
            $tags.="<script type=\"text/javascript\" ";
            if($extras!= null && is_array($extras)){
                foreach ($extras as $key => $value) {
                    $tags.="$key=\"$value\" ";
                }
            }
            $tags.="src=\"$dir/$file\"></script>\n";
        }
        return $tags;
    }
    
    
    /**
     * Loads a single css file
     * @param String $file The path to the file we want to load
     * @param array $extras extra atributes to our tag
     * @return String The thag of our autoload
     * @throws AutoloadException
     */
    function loadSingleJs($file,$extras=null){
        if(file_exists ( $file )){
            $info = pathinfo($file);
            $tags="";
            if (isset($info['extension']) && strtolower($info['extension']) == AUTOLOAD_JS) {
                $tags.="<script type=\"text/javascript\" ";
                if($extras!= null && is_array($extras)){
                    foreach ($extras as $key => $value) {
                        $tags.="$key=\"$value\" ";
                    }
                }
                $tags.="src=\"$file\"></script>\n";
                return $tags;
            }else{
                throw new AutoloadException("File '" . $file . "' is not valid");
            }
        }else{
            throw new AutoloadException("File '" . $file . "' don't exist");
        }
    }
    
    /**
     * Loads a single js file
     * @param String $file The path to the file we want to load
     * @param array $extras extra atributes to our tag
     * @return String The thag of our autoload
     * @throws AutoloadException
     */
    function loadSingleCss($file,$extras=null){
        if(file_exists ( $file )){
            $info = pathinfo($file);
            $tags="";
            if (isset($info['extension']) && strtolower($info['extension']) == AUTOLOAD_CSS) {
                $tags.= "<link rel=\"stylesheet\" type=\"text/css\" ";
                if($extras!= null && is_array($extras)){
                    foreach ($extras as $key => $value) {
                        $tags.="$key=\"$value\" ";
                    }
                }
                $tags.="href=\"$file\" />\n";
                return $tags;
            }else{
                throw new AutoloadException("File '" . $file . "' is not valid");
            }
        }else{
            throw new AutoloadException("File '" . $file . "' don't exist");
        }
    }

}

class AutoloadException extends Exception {
    public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

}
