<?php
/**
 * Copyright (C) 2009 by Chris Smith
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
 * This hook enables the debug mode for founders
 *
 * @author Chris Smith <toonarmy@phpbb.com>
 * @param phpbb_hook $hook
 * @return void
 */
function hook_enable_debug_for_founders(&$hook)
{
	global $user;

	if ($user->data['user_type'] == USER_FOUNDER)
	{
		// Be careful when defining the constants

		if (!defined('DEBUG'))
		{
			define('DEBUG', true);
		}

		if (!defined('DEBUG_EXTRA'))
		{
			define('DEBUG_EXTRA', true);
		}
	}
}

$phpbb_hook->register('phpbb_user_session_handler', 'hook_enable_debug_for_founders');
