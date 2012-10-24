<?php
/**
 * Copyright (C) 2012 by Chris Smith
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
*/

/**
 * @ignore
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
 * This hook adds your own copyright information to the footer.
 *
 * Usage:
 *
 * Prepend a custom line of text before the credit line:
 * > phpbb_hook_copyright::factory('Content © Chris Smith<br />%s')->register($phpbb_hook);
 *
 * Append a custom line of text before the credit line:
 * > phpbb_hook_copyright::factory('%s<br />phpBB Groupie &lt;3')->register($phpbb_hook);
 *
 * Replace the credit line with your own [not so cool :(]:
 * > phpbb_hook_copyright::factory('I stole this.', true)->register($phpbb_hook);
 *
 * @author Chris Smith <chris@cs278.org>
 * @param phpbb_hook $hook
 * @return void
 */
class phpbb_hook_copyright
{
	private $copyright;
	private $replace;

	public static function factory($copyright, $replace = false)
	{
		return new static($copyright, $replace);
	}

	/**
	 * Constructor.
	 *
	 * @param string $copyright Your text you wish to meld into the default credit line.
	 * @param bool   $replace   When false the supplied text will be run through
	 *                          sprintf() with the supplied argument being the default
	 *                          phpBB powered by message. When true the supplied text
	 *                          will replace the default message.
	 */
	public function __construct($copyright, $replace = false)
	{
		$this->copyright = $copyright;
		$this->replace = $replace;
	}

	public function register(phpbb_hook $hook)
	{
		$hook->register(array('template', 'display'), array($this, 'execute'));

		return $this;
	}

	public function execute(phpbb_hook $hook, $handle, $include_once, template $template)
	{
		if (!isset($template->_rootref['CREDIT_LINE']))
		{
			return;
		}

		if ($this->replace)
		{
			$template->_rootref['CREDIT_LINE'] = $this->copyright;
		}
		else
		{
			$template->_rootref['CREDIT_LINE'] = sprintf($this->copyright, $template->_rootref['CREDIT_LINE']);
		}
	}
}
