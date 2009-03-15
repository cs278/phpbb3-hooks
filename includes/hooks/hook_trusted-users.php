<?php

/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://sam.zoy.org/wtfpl/COPYING for more details.
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

/**
 * This hook disables the post queue for accounts registered with a trusted
 * e-mail address.
 */
function hook_trusted_users(&$hook)
{
	global $config, $user;

	if ($config['enable_queue_trigger'] && !$user->data['session_admin'] && preg_match('#@example\.com$#i', $user->data['user_email']))
	{
		$config['enable_queue_trigger'] = 0; // Disable the post queue for our trusted users
	}
}

$phpbb_hook->register('phpbb_user_session_handler', 'hook_trusted_users');