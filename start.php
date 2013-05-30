<?php

function vazco_text_captcha_init() {
	$path = elgg_get_plugins_path();
	elgg_register_library('vazco_text_captcha', $path . 'vazco_text_captcha/models/model.php');

	// Provide a hook handler that adds default actions that the captcha is added to
	elgg_register_plugin_hook_handler('actionlist', 'captcha', 'vazco_text_captcha_actionlist_hook');

	$actions = elgg_trigger_plugin_hook('actionlist', 'captcha', array(), $actions);

	// Register actions to intercept
	foreach ($actions as $action) {
		elgg_register_plugin_hook_handler("action", $action, "vazco_text_captcha_verify", 999);
	}
}

/**
 * Listen to the action plugin hook and check the vazco_text_captcha.
 *
 * @param  string  $hook   'action'
 * @param  string  $type   The action being processed
 * @param  boolean $return Defaults to true
 * @param  null    $params
 * @return boolean
 */
function vazco_text_captcha_verify($hook, $type, $return, $params) {
	elgg_make_sticky_form('register');

	elgg_load_library('vazco_text_captcha');

	$token = get_input('captcha_id');
	$input = get_input('captcha_input');

	$challenge = vazco_text_captcha::getCaptchaChallengeById($token);

	list($challenge_id, $challenge_question, $challenge_answer) = $challenge;

	if (trim(strtolower($challenge_answer)) == trim(strtolower($input))) {
		return $return;
	}

	register_error(elgg_echo('vazco_text_captcha:captchafail'));
	forward(REFERER);
}

/**
 * Return an array of actions the that captcha will be used for.
 *
 * @param string $hook   'action'
 * @param string $type   Name of the action
 * @param array  $return Array of actions
 * @param array  $params Modified array of actions
 */
function vazco_text_captcha_actionlist_hook($hook, $type, $return, $params) {
	$return[] = 'register';
	$return[] = 'user/requestnewpassword';
	return $return;
}

elgg_register_event_handler('init', 'system', 'vazco_text_captcha_init');