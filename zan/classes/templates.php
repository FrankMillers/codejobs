<?php
/**
 * ZanPHP
 *
 * An open source agile and rapid development framework for PHP 5
 *
 * @package		ZanPHP
 * @author		MilkZoft Developer Team
 * @copyright	Copyright (c) 2011, MilkZoft, Inc.
 * @license		http://www.zanphp.com/documentation/en/license/
 * @link		http://www.zanphp.com
 */
 
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

/**
 * ZanPHP Templates Class
 *
 * This class is responsible for controlling design templates
 *
 * @package		ZanPHP
 * @subpackage	core
 * @category	classes
 * @author		MilkZoft Developer Team
 * @link		http://www.zanphp.com/documentation/en/classes/templates_class
 */
class ZP_Templates extends ZP_Load {
	/**
	 * Contains the CSS style from an specific application
	 * 
	 * @var private $CSS = NULL
	 */
	private $CSS = NULL;

	private $topCSS    = array();
	private $bottomCSS = array();
	
	/**
	 * 
	 * 
	 * 
	 */
	private $js = NULL;
	
	/**
	 * Contains the name of the current theme
	 * 
	 * @var private $theme = NULL
	 */
	private $theme = NULL;
	
	/**
	 * Contains the path of the theme
	 * 
	 * @var public $themePath
	 */
	public $themePath;
	
	/**
	 * Contains the route of the theme
	 * 
	 * @var public $themeRoute
	 */
	public $themeRoute;
	
	/**
	 * Contains the title for the header template
	 * 
	 * @var private $title = _get("webNam"]e
	 */
	private $title;
        
        /**
	 * Contains the meta tags for the header template
	 * 
	 * @var private $meta = _get("tagsMeta"]
	 */
	private $meta;
	
	/**
	 * Contains the array of vars
	 * 
	 * @var public $vars = array()
	 */
	private $vars = array();
	
	/**
	 * Contains the ignored segments
	 * 
	 * @var private $ignoredSegments = array()
	 */
	private $ignoredSegments = array();
	
    /**
     * Load helpers: array, browser, debugging, forms, html and web
     *
     * @return void
     */
	public function __construct() {

	}
	
    /**
     * Set the CSS style
     *
     * @return void
     */	
	public function CSS($CSS = NULL, $application = NULL, $print = FALSE, $top = FALSE) {
		if($top) {
			$arrayCSS = &$this->topCSS;
		} else {
			$arrayCSS = &$this->bottomCSS;
		}

		if(file_exists($CSS)) { 
			if($print) {
				print '<link rel="stylesheet" href="'. _get("webURL") . _sh . $this->getScript($CSS, 'css') .'" type="text/css" />';
			} else { 
				array_push($arrayCSS, $CSS);
			}
			// $this->CSS .= '<link rel="stylesheet" href="'. _get("webURL") . _sh . $this->getScript($CSS, 'css') .'" type="text/css" />';
		} 

		if($CSS === "bootstrap") {
			if($print) {
				print '<link rel="stylesheet" href="'. _get("webURL") .'/zan/vendors/css/frameworks/bootstrap/css/bootstrap.min.css" type="text/css" />';
			} else {
				array_push($arrayCSS, _corePath ."/vendors/css/frameworks/bootstrap/css/bootstrap.min.css");
			}
			// $this->CSS .= '<link rel="stylesheet" href="'. _get("webURL") .'/zan/vendors/css/frameworks/bootstrap/css/bootstrap.min.css" type="text/css" />';

			$this->js("bootstrap");
		} elseif($CSS === "prettyphoto") {
			if($print) {
				print '<link rel="stylesheet" href="'. path("vendors/js/lightbox/prettyphoto/css/prettyPhoto.css", "zan") .'" type="text/css" />';
			} else {
				array_push($arrayCSS, _corePath ."/vendors/js/lightbox/prettyphoto/css/prettyPhoto.css");
			}
			//$this->CSS .= '<link rel="stylesheet" href="'. path("vendors/js/lightbox/prettyphoto/css/prettyPhoto.css", "zan") .'" type="text/css" />';	
		} elseif($CSS === "codemirror") {
            if ($print) {
                print '<link rel="stylesheet" href="'. path("vendors/js/codemirror/codemirror.css", "zan") .'" type="text/css" />';
            } else {
				array_push($arrayCSS, _corePath ."/vendors/js/codemirror/codemirror.css");
                //$this->CSS .= '<link rel="stylesheet" href="'. path("vendors/js/codemirror/codemirror.css", "zan") .'" type="text/css" />';
            }
		} elseif($CSS === "redactorjs") {
            if ($print) {
                print '<link rel="stylesheet" href="'. path("vendors/js/editors/redactorjs/css/redactor.css", "zan") .'" type="text/css" />';
            } else {
				array_push($arrayCSS, _corePath ."/vendors/js/editors/redactorjs/css/redactor.css");
                //$this->CSS .= '<link rel="stylesheet" href="'. path("vendors/js/editors/redactorjs/css/redactor.css", "zan") .'" type="text/css" />';
            }			
		} elseif($CSS === "markitup") {
            if ($print) {
                print '<link rel="stylesheet" href="'. path("vendors/js/editors/markitup/skins/markitup/style.min.css", "zan") .'" type="text/css" />';
                print '<link rel="stylesheet" href="'. path("vendors/js/editors/markitup/sets/html/style.css", "zan") .'" type="text/css" />';
            } else {
				array_push($arrayCSS, _corePath ."/vendors/js/editors/markitup/skins/markitup/style.min.css", _corePath ."/vendors/js/editors/markitup/sets/html/style.css");
                //$this->CSS .= '<link rel="stylesheet" href="'. path("vendors/js/editors/markitup/skins/markitup/style.min.css", "zan") .'" type="text/css" />';
                //$this->CSS .= '<link rel="stylesheet" href="'. path("vendors/js/editors/markitup/sets/html/style.css", "zan") .'" type="text/css" />';
            }			
		}

		if(!_get("optimization")) {
			$file = is_null($application) ? "www/lib/css/$CSS.css" : "www/applications/$application/views/css/$CSS.css";
		} else {
			$file = NULL;
		}
		
		if(file_exists($file)) {
			//$file = $this->getScript($file, 'css');

			if($print) {
				print '<link rel="stylesheet" href="'. _get("webURL") .'/'. $file .'" type="text/css" />';
			} else {
				array_push($arrayCSS, $file);
				//$this->CSS .= '<link rel="stylesheet" href="'. _get("webURL") .'/'. $file .'" type="text/css" />';
			}
		}
	}
	
	/*
	* Gets the filename according to current environment
	*/
	private function getScript($filename, $ext) {
		if(_get('environment') > 2) {
			if(!preg_match("/(.+)\.min\.$ext$/", $filename)) {
				return preg_replace("/.$ext$/", ".min.$ext", $filename);
			} else {
				return $filename;
			}
		} else {
			if(preg_match("/(.+)\.min\.$ext$/", $filename, $name)) {
				unset($name[0]);
				return current($name) . ".$ext";
			} else {
				return $filename;
			}
		}
	}

    /**
     * Verify if a template exists
     *
     * @return boolean value
     */
	public function exists($template, $view = FALSE) {
		if(!$view) {
			if(file_exists("www/lib/themes/$this->theme/$template.php")) {
				return TRUE; 
			} 
		} elseif(file_exists("www/applications/$view/views/$template.php")) {
			return TRUE; 
		} 
		
		return FALSE;
	}
	
    /**
     * Get the CSS style
     *
     * @return void
     */
	public function getCSS() {
		$CSS = array_merge($this->topCSS, $this->bottomCSS);
		array_walk($CSS, create_function('&$val', '$val = "'. _get("webURL") .'/$val";'));
		return '<link rel="stylesheet" href="'. implode('" type="text/css" /><link rel="stylesheet" href="', $CSS) .'" type="text/css" />';
	}
	
    /**
     * Get the Js
     *
     * @return void
     */
	public function getJs() {
		return $this->js;
	}
	
    /**
     * Gets the list of available designs
     *
     * @return array value
     */	
	public function getThemes($theme) {
		$path    = "www/lib/themes/";
		$dir	 = dir($path);
		$options = FALSE;
		
		$i = 0;
		
		while($element = $dir->read()) {
			$directory = $path . $element . _sh;						
			
			if($element !== ".." and $element !== "." and is_dir($directory) and $element !== "cpanel") {
				if($element === $theme) {
					$options[$i]["value"]    = $element;
					$options[$i]["option"]   = $element;
					$options[$i]["selected"] = TRUE;
				} else {
					$options[$i]["value"]    = $element;
					$options[$i]["option"]   = $element;
					$options[$i]["selected"] = FALSE;
				}
								
				$i++;
			}
		}	
			
		$dir->close();		
		
		return $options;
	}
	
    /**
     * Get the header title
     *
     * @return void
     */
	public function getTitle() {
		return (is_null($this->title)) ? _get("webName") ." - ". _get("webSlogan") : encode($this->title);
	}
        
     /**
     * Get the meta tags
     *
     * @return void
     */
	public function getMeta() {
		return (is_null($this->meta) ? "" : ltrim($this->meta));
	}
        
    /**
     * Verify if a theme exists
     *
     * @return boolean value
     */
	public function isTheme() {
		$this->path = (!is_null($this->theme)) ? "www/lib/themes/$this->theme" : FALSE;
		
		$this->directory = @dir($this->path);
		
		return ($this->directory) ? TRUE : FALSE;
	}
	
    /**
     * 
     *
     * 
     */
	public function js($js, $application = NULL, $getJs = FALSE) {
		if($js == "prettyphoto") {
			$js = '<script type="text/javascript" src="'. path("vendors/js/lightbox/prettyphoto/js/jquery.prettyphoto.js", "zan") .'"></script>';

			$this->CSS("prettyphoto");
		} elseif($js === "jquery") {
			$js = '<script type="text/javascript" src="'. path("vendors/js/jquery/jquery.js", "zan") .'"></script>';
		} elseif (preg_match('/^jquery\.(.+)\.js$/i', $js, $matches)){ # Plugin jQuery
			$plugin_name = trim($matches[1]);
			
			if(file_exists(_corePath . "/vendors/js/jquery/$plugin_name/")) {
				$js = '<script type="text/javascript" src="'. path("vendors/js/jquery/$plugin_name/$js", "zan") .'"></script>';
				$this->css(_corePath . "/vendors/js/jquery/$plugin_name/$plugin_name.css");
			} else {
				$js = '<script type="text/javascript" src="'. path("vendors/js/jquery/$js", "zan") .'"></script>';
			}
        } elseif($js === "redactorjs") {
			$js = '<script type="text/javascript" src="'. path("vendors/js/editors/redactorjs/redactor.js", "zan") .'"></script>';
			$js .= '<script type="text/javascript" src="'. path("vendors/js/editors/redactorjs/scripts/set.js", "zan") .'"></script>';
			if(_get("webLang") !== "en") {
				$js .= '<script type="text/javascript" src="'. path("vendors/js/editors/redactorjs/langs/". _get("webLang") .".js", "zan") .'"></script>';
			}
			$this->CSS("redactorjs");
		} elseif($js === "markitup") {
			$js = '<script type="text/javascript" src="'. path("vendors/js/editors/markitup/jquery.markitup.js", "zan") .'"></script>';
			$js .= '<script type="text/javascript" src="'. path("vendors/js/editors/markitup/sets/html/set.js", "zan") .'"></script>';
			$this->CSS("markitup");
		} elseif($js === "tinymce") {
			$js = '<script type="text/javascript" src="'. path("vendors/js/editors/tinymce/tiny_mce.js", "zan") .'"></script>';
		} elseif($js === "switch-editor") {
			$js = '<script type="text/javascript" src="'. path("vendors/js/editors/switch.js", "zan") .'"></script>';
		} elseif($js === "lesscss") {
			$js = '<script type="text/javascript" src="'. path("vendors/js/less/less.js", "zan") .'"></script>';
		} elseif($js === "angular") {
			$js = '<script type="text/javascript" src="'. path("vendors/js/angular/angular-1.0.1.min.js", "zan") .'"></script>';
		} elseif($js === "bootstrap") {
			$js = '<script type="text/javascript" src="'. path("vendors/css/frameworks/bootstrap/js/bootstrap.min.js", "zan") .'"></script>';
		} elseif($js === "codemirror") {
			$js = '<script type="text/javascript" src="'. path("vendors/js/codemirror/codemirror.js", "zan") .'"></script>';
			$js .= '<script type="text/javascript" src="'. path("vendors/js/codemirror/util/loadmode.js", "zan") .'"></script>';
		} elseif(file_exists($js)) {
			$js = '<script type="text/javascript" src="'. _get("webURL") .'/'. $this->getScript($js, 'js') .'"></script>';
		} elseif(file_exists(path($js, "zan"))) {
			$js = '<script type="text/javascript" src="'. path($js, "zan") .'"></script>';
		} elseif(file_exists("www/applications/$application/views/js/$js")) {
			$filename = $this->getScript("www/applications/$application/views/js/$js", 'js');
			$js = '<script type="text/javascript" src="'. _get("webURL") .'/'. $filename .'"></script>';
		} elseif(file_exists("www/applications/$application/views/js/$js.js")) {
			$filename = $this->getScript("www/applications/$application/views/js/$js.js", 'js');
			$js = '<script type="text/javascript" src="'. _get("webURL") .'/'. $filename .'"></script>';
		} else {
			return FALSE;
		}

		if($getJs) {
			return $js;
		} else {
			$this->js .= $js;
		}
	}

    /**
     * Load template
     *
     * @return void
     */
	public function load($template, $direct = FALSE) {	
		if(is_array($this->vars)) {
			$key  = array_keys($this->vars);
			$size = sizeof($key);			
		
			for($i = 0; $i < $size; $i++) {
				$$key[$i] = $this->vars[$key[$i]];
			}
		}
		
		if($direct) { 
			if(is_array($template)) {
				$count = count($template);

				if($count === 1) {
					include $template[0];
				} elseif($count === 2) {
					include $template[0];
					include $template[1];
				} elseif($count === 3) {
					include $template[0];
					include $template[1];
					include $template[2];
				} else {
					include $template[0];
					include $template[1];
					include $template[2];
					include $template[3];
				}
			} else {
				if(!file_exists($template)) {
					getException("Error 404: Theme Not Found: ". $template);
				}		
				
				include $template;
			}
		} else { 
			$_name = $template;		

			$template    = "www/lib/themes/$this->theme/$_name.php"; 
			$minTemplate = "www/lib/themes/$this->theme/min/$_name.php";

			if(_get("environment") > 2 and file_exists($minTemplate)) {
				$template = $minTemplate;
			}

			if(!file_exists($template)) {
				getException("Error 404: Theme Not Found: ". $template);									
			}
			
			include $template;	
		}						
	}
	
    /**
     * Set the current theme
     *
     * @return void
     */
	public function theme($theme = NULL) {
		$this->theme = (is_null($theme)) ? _get("webTheme") : $theme;

		$this->themeRoute = "www/lib/themes/$this->theme";
		
		$this->themePath = _get("webURL") . "/$this->themeRoute";
		
		if(!$this->isTheme()) {
			die("You need to create a valid theme");
		}
	}
	
    /**
     * 
     *
     * 
     */
	public function themeCSS($theme = NULL, $min = TRUE) {
		$style = ($min) ? "style.min.css" : "style.css";
		
		return '<link rel="stylesheet" href="'. $this->themePath .'/css/'. $style .'" type="text/css">';					
	}
	
    /**
     * Set header title
     *
     * @return void
     */
	public function title($title = NULL) {
		$this->helper("string");

		if(!is_null($title)) {
			$title = stripslashes($title) ." - ". _get("webName");
		}

		$this->title = is_null($title) ? _get("webName") ." - ". _get("webSlogan") : $title;
        
        $this->meta("title", $this->title);
	}
        
    /**
     * Set header meta tag
     *
     * @return void
     */           
    public function meta($tag, $value) {
        switch($tag) {
            case "title":
                $value = stripslashes($value);

                $this->meta .= "<meta name=\"$tag\" content=\"$value\" />";
            break;
            
            case "language":
                $this->meta .= "<meta http-equiv=\"content-language\" content=\"$value\" />";
            break;
            
            case "description":
                $value = preg_replace("/\r\n+/", " ", strip_tags($value));
                $value = str_replace('"', "", $value);

                if(strlen($value) > 250) {
                    $abstract = stripslashes(substr($value, 0, strrpos(substr($value, 0, 100), " ")));
                    $value    = stripslashes(substr($value, 0, strrpos(substr($value, 0, 250), " ")));
                } else {
                	$abstract = $value;
                }
                
                $this->meta .= "<meta name=\"abstract\" content=\"". $abstract ."\" />";
            
            default:
                $this->meta .= "<meta name=\"$tag\" content=\"$value\" />";
            break;   
        }
    }
	
    /**
     * Set vars
     *
     * @return void
     */
	public function vars($vars) {
		$this->vars = $vars;
	}
	
	/**
     * Set ignored segments
     *
     * @return void
     */
	public function ignoreSegments($segments = array()) {
		$this->ignoredSegments = $segments;
	}

	/**
     * Verifies if exists a minified file
     *
     * @return boolean value
     */
	public function isMinified($ext, $print) {
		if(_get("environment") < 3) {
			return FALSE;
		} else {
			$exists = is_file($this->getMinFile() .".". $ext);

			if($exists and $print) {
				echo '<link rel="stylesheet" href="'. $this->getMinFile(TRUE) .'.'. $ext .'" type="text/css" />';
			}

			return $exists;
		}
	}

	/**
     * Gets the path/URL of minified file without extension
     *
     * @return string value
     */
	private function getMinFile($URL = FALSE) {
		$filename = sha1($this->filterURL());

		if(!$URL) {
			return _cacheDir . _sh . $filename;
		} else {
			return path(_cacheDir ."/$filename", TRUE);
		}
	}

	private function filterURL() {
		$parts 	  = route();
		$segments = "/";

		if(isLang()) array_shift($parts);

		if(count($parts) > 0 and count($this->ignoredSegments) > 0) foreach ($this->ignoredSegments as $segment) array_splice($parts, $segment, 1, "-");
		
		return path(TRUE) ."/". implode("/", $parts);
	}
}