<?php
/****************************************************************/
/* ATutor														*/
/****************************************************************/
/* Copyright (c) 2002-2005 by Greg Gay & Joel Kronenberg        */
/* Adaptive Technology Resource Centre / University of Toronto  */
/* http://atutor.ca												*/
/*                                                              */
/* This program is free software. You can redistribute it and/or*/
/* modify it under the terms of the GNU General Public License  */
/* as published by the Free Software Foundation.				*/
/****************************************************************/
// $Id$

define('AT_INCLUDE_PATH', '../../include/');
require(AT_INCLUDE_PATH.'vitals.inc.php');

authenticate(AT_PRIV_TEST_CREATE);
require(AT_INCLUDE_PATH.'lib/test_result_functions.inc.php');

if (isset($_POST['cancel'])) {
	$msg->addFeedback('CANCELLED');
	header('Location: question_db.php');
	exit;
} else if ($_POST['submit']) {
	$_POST['required']     = 1; //intval($_POST['required']);
	$_POST['feedback']     = trim($_POST['feedback']);
	$_POST['question']     = trim($_POST['question']);
	$_POST['category_id']  = intval($_POST['category_id']);
	$_POST['answer']       = intval($_POST['answer']);
	$_POST['properties']   = intval($_POST['properties']);

	if ($_POST['question'] == ''){
		$msg->addError('QUESTION_EMPTY');
	}

	if (!$msg->containsErrors()) {
		$_POST['feedback'] = $addslashes($_POST['feedback']);
		$_POST['question'] = $addslashes($_POST['question']);

		/*
		$sql = 'SELECT content_id FROM '.TABLE_PREFIX."tests WHERE test_id=$_POST[tid]";
		$result = mysql_query($sql, $db);			
		$row = mysql_fetch_assoc($result);
		*/

		$sql = "INSERT INTO ".TABLE_PREFIX."tests_questions VALUES (	0,
			$_POST[category_id],
			$_SESSION[course_id],
			2,
			'$_POST[feedback]',
			'$_POST[question]',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			$_POST[answer],
			0,
			0,
			0,
			0,
			0,
			0,
			0,
			0,
			0,
			$_POST[properties],
			0)";
		$result	= mysql_query($sql, $db);
		
		$msg->addFeedback('QUESTION_ADDED');
		header('Location: question_db.php');
	}
}

require(AT_INCLUDE_PATH.'header.inc.php');

$msg->addHelp('QUESTION_TF');
$msg->printAll(); 

?>
<form action="tools/tests/create_question_tf.php" method="post" name="form">
<div class="input-form">

	<div class="row">
		<div class="required" title="<?php echo _AT('required_field'); ?>">*</div><label for="cats"><?php echo _AT('category'); ?></label><br />
		<select name="category_id" id="cats">
			<?php print_question_cats($_POST['category_id']); ?>
		</select>
	</div>

	<div class="row">
		<label for="feedback"><?php echo _AT('optional_feedback'); ?></label>		
		<a onclick="javascript:window.open('<?php echo $_base_href; ?>/tools/tests/form_editor.php?area=feedback','newWin1','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,copyhistory=0,width=640,height=480')" style="cursor: pointer" ><?php echo _AT('use_visual_editor'); ?></a>
		<br />
	
		<textarea id="feedback" cols="50" rows="3" name="feedback"><?php echo htmlspecialchars(stripslashes($_POST['feedback'])); ?></textarea>
	</div>
	
	<div class="row">
		<div class="required" title="<?php echo _AT('required_field'); ?>">*</div><label for="question"><?php echo _AT('statement'); ?></label>
		<a onclick="javascript:window.open('<?php echo $_base_href; ?>/tools/tests/form_editor.php?area=question','newWin1','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,copyhistory=0,width=640,height=480')" style="cursor: pointer" ><?php echo _AT('use_visual_editor'); ?></a>
		<br />

		<textarea id="question" cols="50" rows="6" name="question"><?php echo htmlspecialchars(stripslashes($_POST['question'])); ?></textarea>
	</div>
	
	<div class="row">
		<label for="properties"><?php echo _AT('option_alignment'); ?></label><br />
		<label for="prop_5"><input type="radio" name="properties" id="prop_5" value="5" checked="checked" /><?php echo _AT('vertical'); ?></label>
		<label for="prop_6"><input type="radio" name="properties" id="prop_6" value="6" /><?php echo _AT('horizontal'); ?></label>
	</div>

	<div class="row">
		<?php echo _AT('answer'); ?><br />
		<input type="radio" name="answer" value="1" id="answer1" /><label for="answer1"><?php echo _AT('true'); ?></label>, 
		<input type="radio" name="answer" value="2" id="answer2" checked="checked" /><label for="answer2"><?php echo _AT('false'); ?></label>
	</div>

	<div class="row buttons">
		<input type="submit" value="<?php echo _AT('save'); ?>"   name="submit" accesskey="s" />
		<input type="submit" value="<?php echo _AT('cancel'); ?>" name="cancel" />
	</div>
</div>
</form>

<?php require (AT_INCLUDE_PATH.'footer.inc.php'); ?>