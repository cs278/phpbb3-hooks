<?php
/**
 * Copyright (C) 2010 by Chris Smith
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
 * This hook disables the delayed redirects used by phpBB.
 *
 * @author Chris Smith <toonarmy@phpbb.com>
 * @param phpbb_hook $hook
 * @return void
 */
function hook_disable_delayed_redirects(&$hook)
{
	global $template, $user;

	if (!isset($template->_rootref['MESSAGE_TEXT']) || !isset($template->_rootref['META']))
	{
		return;
	}

	//'<meta http-equiv="refresh" content="' . $time . ';url=' . $url . '" />')
	if (preg_match('#<meta http-equiv="refresh" content="[0-9]+;url=(.+?)" />#', $template->_rootref['META'], $match))
	{
		// HTML entitied
		$url = str_replace('&amp;', '&', $match[1]);

		// Show messages from pages that return to the same page,
		// otherwise there is no feedback that anything changed
		// which makes the UCP preferences and other places seem
		// to be broken.
		if (generate_board_url() . '/' . $user->page['page'] !== $url)
		{
			redirect($url);
			exit; // Implicit
		}
	}
}

/**
 * Only register the hook for normal pages, not administration pages.
 */
if (!defined('ADMIN_START'))
{
	$phpbb_hook->register(array('template', 'display'), 'hook_disable_delayed_redirects');
}
