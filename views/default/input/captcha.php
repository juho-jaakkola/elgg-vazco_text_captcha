<?php
/**
 * Add captcha id and question
 */

elgg_load_library('vazco_text_captcha');

$challenge = vazco_text_captcha::getCaptchaChallenge();
list($challenge_id, $challenge_question, $challenge_answer) = $challenge;  
?>

<input type="hidden" name="captcha_id" value="<?php echo $challenge_id; ?>" />

<div>
	<label><?php echo elgg_echo('vazco_text_captcha:entercaptcha'); ?></label>
	<span><?php echo $challenge_question; ?></span>
	<?php echo elgg_view('input/text', array('name' => 'captcha_input')); ?>
</div>