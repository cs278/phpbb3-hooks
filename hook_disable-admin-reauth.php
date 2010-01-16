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
 * This hook disables the ACPs re-authentication
 * The intended use for this hook is development environments,
 * use in a live scenario is reckless.
 */
function hook_disable_admin_reauth(&$hook)
{
	global $user, $auth;

	if (empty($user->data['session_admin']) && $auth->acl_get('a_'))
	{
		$user->data['session_admin'] = 1;
	}
}

$phpbb_hook->register('phpbb_user_session_handler', 'hook_disable_admin_reauth');
