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

namespace Assetserver\test;

use \Assetserver\test\helpers\Helper;

/**
 * module main class
 * 
 * @package     assetserver
 * @author      Eric VILLARD <dev@eviweb.fr>
 * @copyright	(c) 2012 Eric VILLARD <dev@eviweb.fr>
 * @license     http://opensource.org/licenses/MIT MIT License
 * @group	assetserver
 */
class Assetserver extends \Fuel\Core\TestCase
{

	/**
	 * set up the test environment
	 */
	public function setUp()
	{
		Helper::init();
	}

	/**
	 * revert to initial state
	 */
	public function tearDown()
	{
		Helper::restore();
	}

	/**
	 * @covers Assetserver\Assetserver::_init
	 */
	public function test_init()
	{
		// check routes
		$module_routes = Helper::get_routes();
		$config_routes = \Config::get('routes');
		foreach ($module_routes as $pattern => $route)
		{
			$this->assertNotNull($config_routes[$pattern]);
			$this->assertEquals($route, $config_routes[$pattern]);
		}

		// check paths
		$module_config = Helper::get_config();
		$module_paths = array_merge(
		    $module_config['paths'], \Config::get('theme.paths', array())
		);
		$paths = \Config::get('assetserver.paths');
		foreach ($module_paths as $path)
		{
			$this->assertContains($path, $paths);
		}
	}

	/**
	 * @covers Assetserver\Assetserver::add_path
	 */
	public function testAdd_path()
	{
		$path_1 = __DIR__;
		$path_2 = dirname(__DIR__);
		$path_3 = dirname(dirname(__DIR__));
		$path_4 = __DIR__;
		$backup = \Config::get('assetserver.paths');
		//
		$this->assertNotContains($path_1, \Config::get('assetserver.paths'));
		\Assetserver\Assetserver::add_path($path_1);
		$this->assertContains($path_1, \Config::get('assetserver.paths'));
		\Assetserver\Assetserver::add_path(array($path_1, $path_2, $path_3, $path_4));
		$this->assertContains($path_1, \Config::get('assetserver.paths'));
		$this->assertContains($path_2, \Config::get('assetserver.paths'));
		$this->assertContains($path_3, \Config::get('assetserver.paths'));
		$this->assertContains($path_4, \Config::get('assetserver.paths'));

		$values = array_count_values(\Config::get('assetserver.paths'));
		foreach ($values as $num)
		{
			$this->assertEquals(1, $num);
		}

		\Config::set('assetserver.paths', $backup);
		$this->assertSame($backup, \Config::get('assetserver.paths'));
	}

	/**
	 * @covers Assetserver\Assetserver::remove_path
	 */
	public function testRemove_path()
	{
		$path_1 = __DIR__;
		$path_2 = dirname(__DIR__);
		$path_3 = dirname(dirname(__DIR__));
		$path_4 = __DIR__;
		$backup = \Config::get('assetserver.paths');
		//
		\Assetserver\Assetserver::add_path(array($path_1, $path_2, $path_3, $path_4));
		$this->assertContains($path_1, \Config::get('assetserver.paths'));
		$this->assertContains($path_2, \Config::get('assetserver.paths'));
		$this->assertContains($path_3, \Config::get('assetserver.paths'));
		$this->assertContains($path_4, \Config::get('assetserver.paths'));

		\Assetserver\Assetserver::remove_path($path_1);
		$this->assertNotContains($path_1, \Config::get('assetserver.paths'));
		$this->assertContains($path_2, \Config::get('assetserver.paths'));
		$this->assertContains($path_3, \Config::get('assetserver.paths'));
		$this->assertNotContains($path_4, \Config::get('assetserver.paths'));

		\Assetserver\Assetserver::remove_path(array($path_1, $path_2, $path_3, $path_4));
		$this->assertNotContains($path_1, \Config::get('assetserver.paths'));
		$this->assertNotContains($path_2, \Config::get('assetserver.paths'));
		$this->assertNotContains($path_3, \Config::get('assetserver.paths'));
		$this->assertNotContains($path_4, \Config::get('assetserver.paths'));

		$this->assertSame($backup, \Config::get('assetserver.paths'));
	}

}