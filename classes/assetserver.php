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
 * module main class
 * 
 * @package     assetserver
 * @author      Eric VILLARD <dev@eviweb.fr>
 * @copyright	(c) 2012 Eric VILLARD <dev@eviweb.fr>
 * @license     http://opensource.org/licenses/MIT MIT License
 */
class Assetserver
{

	/**
	 * module initialization
	 */
	public static function _init()
	{
		\Config::load('assetserver::config', 'assetserver');
		\Config::load('assetserver::security', 'assetserver');
		\Config::load('assetserver::types', 'assetserver');
		\Config::load('assetserver::routes', 'routes');
		\Config::load('theme', true);
		// get module default paths
		$default_paths = \Config::get('assetserver.paths', array());
		// get app paths
		$theme_paths = \Config::get('theme.paths', array());
		// merge both
		$final_paths = array_unique(array_merge($default_paths, $theme_paths));
		// we need to reindex the final array because array_unique does not do it
		$indexes = range(0, count($final_paths) - 1);
		\Config::set('assetserver.paths', array_combine($indexes, $final_paths));
	}

	/**
	 * add a path to assetserver.paths
	 * 
	 * @param string $path	path to add to assetserver.paths
	 */
	public static function add_path($path)
	{
		$paths = \Config::get('assetserver.paths');

		if (!is_array($path))
		{
			$path = array($path);
		}

		foreach ($path as $item)
		{
			if (!in_array($item, $paths))
			{
				array_push($paths, $item);
			}
		}

		\Config::set('assetserver.paths', $paths);
	}

	/**
	 * remove a path from assetserver.paths
	 * 
	 * @param string $path	path to remove from assetserver.paths
	 */
	public static function remove_path($path)
	{
		$paths = \Config::get('assetserver.paths');

		if (!is_array($path))
		{
			$path = array($path);
		}

		foreach ($path as $item)
		{
			$i = array_search($item, $paths);
			if ($i !== false)
			{
				array_splice($paths, $i, 1);
			}
		}

		\Config::set('assetserver.paths', $paths);
	}

}