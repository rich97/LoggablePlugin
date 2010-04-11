<?php
/* SVN FILE: $Id$ */
/**
 * Short description for file.
 *
 * Long description for file
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.webroot
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
if (!defined('CAKE_CORE_INCLUDE_PATH')) {
	header('HTTP/1.1 404 Not Found');
    die();
}
/**
 * Enter description here...
 */
if (!class_exists('File')) {
	uses('file');
}
/**
 * Enter description here...
 *
 * @param unknown_type $path
 * @param unknown_type $name
 * @return unknown
 */
	function make_clean_js($path, $name) {
		App::import('Vendor', 'JSMin');
		$data = file_get_contents($path);
//		$csspp = new csspp();
//		$output = $csspp->compress($data);
//		$ratio = 100 - (round(strlen($output) / strlen($data), 3) * 100);
//		$output = " /* file: $name, ratio: $ratio% */ " . $output;
        $output = $data;
		return $output;
	}
/**
 * Enter description here...
 *
 * @param unknown_type $path
 * @param unknown_type $content
 * @return unknown
 */
	function write_js_cache($path, $content) {
		if (!is_dir(dirname($path))) {
			mkdir(dirname($path));
		}
		$cache = new File($path);
		return $cache->write($content);
	}

	if (preg_match('|\.\.|', $url) || !preg_match('|^cjs/(.+)$|i', $url, $regs)) {
//		die('Wrong file name.');
        die();
	}

	$filename = 'js/' . $regs[1];
	$filepath = JS . $regs[1];
	$cachepath = CACHE . 'js' . DS . str_replace(array('/','\\'), '-', $regs[1]);

	if (!file_exists($filepath)) {
//		die('Wrong file name.');
        die();
    }

	if (file_exists($cachepath)) {
		$templateModified = filemtime($filepath);
		$cacheModified = filemtime($cachepath);

		if ($templateModified > $cacheModified) {
			$output = make_clean_js($filepath, $filename);
			write_js_cache($cachepath, $output);
		} else {
			$output = file_get_contents($cachepath);
		}
    } else {
		$output = make_clean_js($filepath, $filename);
		write_js_cache($cachepath, $output);
		$templateModified = time();
	}

	header("Date: " . date("D, j M Y G:i:s ", $templateModified) . 'GMT');
    header("Content-Type: text/javascript");
    if (($templateModified - $cacheModified) < DAY) {
    	header("Expires: " . gmdate("D, d M Y H:i:s", time() + MONTH) . " GMT");
	    header("Cache-Control: max-age=86400, must-revalidate"); // HTTP/1.1
    	header("Pragma: cache");        // HTTP/1.0
    }
	print $output;
?>
