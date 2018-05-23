<?php
/**
 * Template for displaying description of question.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/content-question/description.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  3.1
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$quiz     = LP_Global::course_item_quiz();
$question = $question ? $question : LP_Global::quiz_question();

if ( ! $question ) {
	return;
}

if ( ! $content = $question->get_content() ) {
	return;
}
?>

<div class="quiz-question-desc"><?php echo $content; ?></div>
