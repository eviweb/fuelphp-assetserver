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
use \Assetserver\MimeTypes;
use \Assetserver\Security;

/**
 * asset manager
 * 
 * @package     assetserver
 * @author      Eric VILLARD <dev@eviweb.fr>
 * @copyright	(c) 2012 Eric VILLARD <dev@eviweb.fr>
 * @license     http://opensource.org/licenses/MIT MIT License
 */
class Controller_AssetManager extends \Controller
{
	/**
	 * serves the needed file
	 * 
	 * @return \Fuel\Core\Response
	 */
	public function action_get()
	{
		$headers = array();
		$body    = '';
		$type    = '';
		$code    = 202;
		$file    = AssetLocator::locate(
			$this->param('asset'), 
			$this->param('ext'), 
			$this->param('theme')
		);
		if (file_exists($file)) {
			$type = MimeTypes::get_type($file);
			if (Security::is_allowed($type))
			{
				$body = file_get_contents($file);
				$headers['Content-type'] = $type;
			} 
			else 
			{
				$code = 403;
			}
		} else {
			$code    = 404;
		}
		
		return \Response::forge($body, $code, $headers);
	}
}