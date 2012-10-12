<?php

/* vim: set noexpandtab tabstop=8 shiftwidth=8 softtabstop=8: */
/**
 * The MIT License
 *
 * Copyright 2012 Eric VILLARD <dev@eviweb.fr>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 * 
 * @package     assetserver
 * @author      Eric VILLARD <dev@eviweb.fr>
 * @copyright	(c) 2012 Eric VILLARD <dev@eviweb.fr>
 * @license     http://opensource.org/licenses/MIT MIT License
 */

namespace Assetserver;

/**
 * asset locator
 * 
 * @package     assetserver
 * @author      Eric VILLARD <dev@eviweb.fr>
 * @copyright	(c) 2012 Eric VILLARD <dev@eviweb.fr>
 * @license     http://opensource.org/licenses/MIT MIT License
 */
class AssetLocator
{
	/**
	 * look for an asset
	 * 
	 * @param string $searched	file name of the asset to search
	 * @param string $ext		file extension
	 * @param string $folder	base folder name, should be the name of the active theme
	 * @return string		returns the path of the file if found, or an empty string
	 */
	public static function locate($searched, $ext = '', $folder = '')
	{
		$paths = \Config::get('assetserver.paths');
		$ext   = !empty($ext) 
			 && !preg_match('/^\./', $ext) ? '.'.$ext : $ext;
		$file  = '';
		$i     = 0;
		$l     = count($paths);
		while ($i < $l && empty($file))
		{
			$path = $paths[$i]
				.(preg_match('/\\'.DS.'$/', $paths[$i]) ? '' : DS)
				.(empty($folder) ? '' : $folder.DS);
			$file = static::_search($searched.$ext, $path);
			$i++;
		}
		return $file;
	}

	/**
	 * recursive search method
	 * 
	 * @param string $searched	file name of the asset to search, with or without its extension
	 *				if the extension is not provided, the search stops at the first
	 *				occurence of a file named as the $searched pattern
	 * @param string $path		base path to start looking for the file
	 * @return string		returns the path of the file if found, or an empty string
	 */
	protected static function _search($searched, $path)
	{	
		if (!is_dir($path)) return '';
		$dirs = array_slice(scandir($path), 2);
		$file = '';
		$i = 0;
		$l = count($dirs);
		while ($i < $l && empty($file))
		{
			$dir  = $dirs[$i];
			$file = $dir == $searched 
				|| preg_match('/^'.$searched.'\.\w+$/', $dir) 
					? $path.$dir : '';
			if ($dir != '.' && $dir != '..' && is_dir($path.$dir))
			{
				$file = static::_search($searched, $path.$dir.DS);
			}
			$i++;
		}
		return $file;
	}
}