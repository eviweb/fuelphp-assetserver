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

namespace Assetserver\test\helpers;

/**
 * add some features to facilitate the testing process
 * 
 * @package     assetserver
 * @author      Eric VILLARD <dev@eviweb.fr>
 * @copyright	(c) 2012 Eric VILLARD <dev@eviweb.fr>
 * @license     http://opensource.org/licenses/MIT MIT License
 */
final class Helper
{
	/**
	 * initial config backup
	 * 
	 * @var array
	 */
	private static $_backup;
	
	/**
	 * module routes
	 * 
	 * @var array
	 */
	private static $_routes;
	
	/**
	 * module config
	 * 
	 * @var array
	 */
	private static $_config;
	
	/**
	 * module path
	 * 
	 * @var string 
	 */
	private static $_modulepath;
	
	/**
	 * var initialization
	 */
	public static function init()
	{
		static::$_backup = array(
		    'assetserver' => \Config::get('assetserver'),
		    'routes'      => \Config::get('routes'),
		    'theme'       => \Config::get('theme'),
		);
		static::$_modulepath = dirname(dirname(__DIR__));
		static::$_routes = include(static::$_modulepath.'/config/routes.php');
		static::$_config = include(static::$_modulepath.'/config/config.php');
		\Config::load(static::$_modulepath.'/tests/resources/config/theme.php', 'theme', true, true);
		\Assetserver\Assetserver::_init();
	}

	/**
	 * restore the configuration initial state
	 */
	public static function restore()
	{
		\Config::set('assetserver', static::$_backup['assetserver']);
		\Config::set('routes', static::$_backup['routes']);
		\Config::set('theme', static::$_backup['theme']);
	}
	
	/**
	 * read accessor 
	 * 
	 * @see Helper::$_routes
	 * @return array
	 */
	public static function get_routes()
	{
		return static::$_routes;
	}
	
	/**
	 * read accessor 
	 * 
	 * @see Helper::$_config
	 * @return array
	 */
	public static function get_config()
	{
		return static::$_config;
	}


	/**
	 * construct a local path for testing
	 * 
	 * @param string $file	the file to append to the path
	 * @return string	returns the local path for testing
	 */
	public static function get_path($file)
	{
		return static::$_modulepath.'/tests/resources/themes/default_test/'.$file;
	}
}