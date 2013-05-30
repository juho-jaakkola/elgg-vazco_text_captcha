<?php 

$param = $vars['entity']->tasks;

// Set default value if user hasn't set it
if (!isset($param))	{
	$param = "2 * 2 = ?|4\n2 * 3 = ?|6";
	$vars['entity']->tasks = $param;
}

$tasks_label = elgg_echo('vazco_text_captcha:tasks'); 
$tasks_desc = elgg_echo('vazco_text_captcha:tasks:description'); 
$tasks_input = elgg_view('input/plaintext', array(
	'name' => 'params[tasks]',
	'value' => $param
));

echo <<<HTML
	<div>
		<label>$tasks_label</label>
		$tasks_input
		<p class="elgg-text-help">$tasks_desc</p>
	</div>
HTML;
