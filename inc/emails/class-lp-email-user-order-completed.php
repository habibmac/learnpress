<?php

/**
 * Class LP_Email_User_Order_Completed
 *
 * @author  ThimPress
 * @package LearnPress/Classes
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit();

class LP_Email_User_Order_Completed extends LP_Email {
	/**
	 * LP_Email_User_Order_Completed constructor.
	 */
	public function __construct() {
		$this->id    = 'user_order_completed';
		$this->title = __( 'User order completed', 'learnpress' );

		$this->template_html  = 'emails/user-order-completed.php';
		$this->template_plain = 'emails/plain/user-order-completed.php';

		$this->default_subject = __( 'Your order on {order_date} is completed', 'learnpress' );
		$this->default_heading = __( 'Your order {order_number} is completed', 'learnpress' );

		add_action( 'learn_press_order_status_completed_notification', array( $this, 'trigger' ) );

		parent::__construct();
	}

	public function admin_options( $settings_class ) {
		$view = learn_press_get_admin_view( 'settings/emails/user-order-completed.php' );
		include_once $view;
	}

	public function trigger( $order_id ) {

		if ( !$this->enable ) {
			return;
		}
		$this->object               = array(
			'order' => learn_press_get_order( $order_id )
		);
		$this->find['site_title']   = '{site_title}';
		$this->find['order_date']   = '{order_date}';
		$this->find['order_number'] = '{order_number}';

		$this->replace['site_title']   = $this->get_blogname();
		$this->replace['order_date']   = date_i18n( get_option( 'date_format' ), strtotime( $this->object['order']->order_date ) );
		$this->replace['order_number'] = $this->object['order']->get_order_number();


		$return = $this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );

		return $return;
	}

	public function get_recipient() {
		$user            = learn_press_get_user( $this->object['order']->user_id );
		$this->recipient = $user->user_email;
		return parent::get_recipient(); // TODO: Change the autogenerated stub
	}

	public function get_content_html() {
		ob_start();
		learn_press_get_template( $this->template_html, $this->get_template_data( 'html' ) );
		return ob_get_clean();
	}

	public function get_content_plain() {
		ob_start();
		learn_press_get_template( $this->template_plain, $this->get_template_data( 'plain' ) );
		return ob_get_clean();
	}

	/**
	 * @param string $format
	 *
	 * @return array|void
	 */
	public function get_template_data( $format = 'plain' ) {
		return array(
			'email_heading' => $this->get_heading(),
			'footer_text'   => $this->get_footer_text(),
			'site_title'    => $this->get_blogname(),
			'plain_text'    => $format == 'plain',
			'order'         => $this->object['order']
		);
	}
}

return new LP_Email_User_Order_Completed();
