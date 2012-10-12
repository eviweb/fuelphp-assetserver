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
 * mime types helper
 * 
 * @package     assetserver
 * @author      Eric VILLARD <dev@eviweb.fr>
 * @copyright	(c) 2012 Eric VILLARD <dev@eviweb.fr>
 * @license     http://opensource.org/licenses/MIT MIT License
 * @group	assetserver
 */
class MimeTypes extends \Fuel\Core\TestCase
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
	 * @covers Assetserver\MimeTypes::get_type
	 */
	public function testGet_type()
	{	
		$this->assertEquals(
			'text/css',
			\Assetserver\MimeTypes::get_type(Helper::get_path('assets/css/example.css'))
		);		
		$this->assertEquals(
			'application/x-javascript',
			\Assetserver\MimeTypes::get_type(Helper::get_path('assets/js/example.js'))
		);
		$this->assertEquals(
			'image/png',
			\Assetserver\MimeTypes::get_type(Helper::get_path('assets/img/fuelphp.png'))
		);
		$this->assertEquals(
			'text/x-php',
			\Assetserver\MimeTypes::get_type(Helper::get_path('outside/example.php'))
		);
		$this->assertEquals(
			'text/x-php',
			\Assetserver\MimeTypes::get_type(Helper::get_path('outside/example2.php'))
		);
		$this->assertFalse(
			\Assetserver\MimeTypes::get_type(Helper::get_path('no_existing_file.png'))
		);
	}	
}
