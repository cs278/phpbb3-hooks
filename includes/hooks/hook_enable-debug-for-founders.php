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
 * This hook enables the debug mode for founders
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