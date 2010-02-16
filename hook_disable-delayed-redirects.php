<?php
/**
 * @package phpBB
 * @copyright (c) 2010 Chris Smith
 * @license http://sam.zoy.org/wtfpl/COPYING

 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://sam.zoy.org/wtfpl/COPYING for more details.
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
		if (stripos(generate_board_url() . '/' . $user->page['page'], $url) === false)
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