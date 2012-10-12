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
class AssetLocator extends \Fuel\Core\TestCase
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
	 * @covers Assetserver\AssetLocator::locate
	 */
	public function testLocate()
	{	
		// all of the following should give the same result
		$this->assertEquals(
			Helper::get_path('assets/css/example.css'),
			\Assetserver\AssetLocator::locate('example')
		);		
		$this->assertEquals(
			Helper::get_path('assets/css/example.css'),
			\Assetserver\AssetLocator::locate('example', 'css')
		);
		$this->assertEquals(
			Helper::get_path('assets/css/example.css'),
			\Assetserver\AssetLocator::locate('example', '.css')
		);
		$this->assertEquals(
			Helper::get_path('assets/css/example.css'),
			\Assetserver\AssetLocator::locate('example', '.css', 'default_test')
		);
		
		// test with a different extension
		$this->assertEquals(
			Helper::get_path('assets/js/example.js'),
			\Assetserver\AssetLocator::locate('example', 'js')
		);
		
		// another recursive search
		$this->assertEquals(
			Helper::get_path('outside/example2.css'),
			\Assetserver\AssetLocator::locate('example2')
		);
		
		// force the sub path base
		$this->assertEquals(
			Helper::get_path('outside/fuelphp.png'),
			\Assetserver\AssetLocator::locate('fuelphp', 'png', 'default_test/outside')
		);
	}	
}
