<?php
	/**
	 * Action for saving a new email address for a user and triggering a confirmation.
	 * 
	 * @package Elgg
	 * @subpackage Core
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author 
	 * @copyright Curverider Ltd 2008
	 * @link http://elgg.org/
	 */

	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
	global $CONFIG;

	gatekeeper();
	
	$email = get_input('email');
	$user_id = get_input('guid');
	$user = "";
	
	if (!$user_id)
		$user = $_SESSION['user'];
	else
		$user = get_entity($user_guid);
		
	if ($user)
	{
		$user->email = $email;
		if ($user->save())
		{
			request_email_validation($user->getGUID());
			system_message(elgg_echo('email:save:success'));
		}
		else
			system_message(elgg_echo('email:save:fail'));
	}
	else
		system_message(elgg_echo('email:save:fail'));
	
	forward($_SERVER['HTTP_REFERER']);
	exit;
?>