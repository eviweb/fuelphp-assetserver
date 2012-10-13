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

namespace Assetserver\test\Controller;

use \Assetserver\test\helpers\Helper;

/**
 * asset manager
 * 
 * @package     assetserver
 * @author      Eric VILLARD <dev@eviweb.fr>
 * @copyright	(c) 2012 Eric VILLARD <dev@eviweb.fr>
 * @license     http://opensource.org/licenses/MIT MIT License
 * @group	assetserver
 */
class AssetManager extends \Fuel\Core\TestCase
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
	 * @covers Assetserver\Controller\AssetManager::action_get
	 */
	public function testAction_get()
	{
		// look for assets/css/example.css
		$this->assertEquals(
			file_get_contents(Helper::get_path('assets/css/example.css')),
			\Request::forge('assetserver/assetmanager/get/default_test/example', true)
				->execute()
				->response()
				->body()				
		);
		// look for assets/js/example.js
		$this->assertEquals(
			file_get_contents(Helper::get_path('assets/js/example.js')),
			\Request::forge('assetserver/assetmanager/get/default_test/example/js', true)
				->execute()
				->response()
				->body()				
		);
		// look for assets/img/fuelphp.png
		$this->assertEquals(
			file_get_contents(Helper::get_path('assets/img/fuelphp.png')),
			\Request::forge('assetserver/assetmanager/get/default_test/fuelphp/png', true)
				->execute()
				->response()
				->body()				
		);
		// look for outside/example.php
		$this->assertEquals(
			403,
			\Request::forge('assetserver/assetmanager/get/default_test/example/php', true)
				->execute()
				->response()
				->status				
		);
		// look for a non existing file
		$this->assertEquals(
			404,
			\Request::forge('assetserver/assetmanager/get/default_test/noexisting', true)
				->execute()
				->response()
				->status				
		);
	}
}