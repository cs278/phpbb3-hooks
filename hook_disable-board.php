<?php
/**
 * Copyright (C) 2011 by Chris Smith
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
 * This hook disables the board if a file is present on the file system.
 *
 * @author Chris Smith <toonarmy@phpbb.com>
 */
class phpbb_hook_disable_board
{
	protected $file;

	static public function factory($file)
	{
		return new self($file);
	}

	public function __construct($file)
	{
		$this->file = $file;
	}

	public function getFile()
	{
		if (!is_absolute($this->file))
		{
			global $phpbb_root_path;

			return $phpbb_root_path . '/' . $this->file;
		}
		else
		{
			return $this->file;
		}
	}

	public function register($hook)
	{
		$hook->register('phpbb_user_session_handler', array($this, 'execute'));

		return $this;
	}

	public function execute($hook)
	{
		global $config;

		$file = $this->getFile();

		if (file_exists($file))
		{
			if (filesize($file) > 0)
			{
				$message = trim(file_get_contents($file));
			}
			else
			{
				$message = '';
			}

			$config['board_disable'] = 1;
			$config['board_disable_msg'] = $message;
		}
	}
}

//phpbb_hook_disable_board::factory('.board-disable')
//	->register($phpbb_hook);
