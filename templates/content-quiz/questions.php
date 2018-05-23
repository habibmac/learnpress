<?php
/**
 * Template for displaying list question in quiz.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/content-quiz/questions.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  3.1
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$quiz = LP_Global::course_item_quiz();

if ( ! $questions = $quiz->get_questions() ) {
	return;
}

foreach ( $questions as $question ) {
	learn_press_get_template( 'content-question/content.php', array( 'question' => LP_Question::get_question( $question ) ) );
}
