<?php
/*
 * Plugin Name: Multi-Upload
 * Plugin URI: trepmal.com
 * Description:
 * Version:
 * Author: Kailey Lampert
 * Author URI: kaileylampert.com
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * TextDomain: multi-upload
 * DomainPath:
 * Network:
 */

$multi_upload = new Multi_Upload();

class Multi_Upload {

	/**
	 * Hook in
	 *
	 * @return void
	 */
	function __construct() {
		add_action( 'admin_menu', array( $this, 'menu' ) );
	}

	/**
	 * Create menu page
	 *
	 * @return void
	 */
	function menu() {
		add_options_page( __( 'Multi Upload', 'multi-upload' ), __( 'Multi Upload', 'multi-upload' ), 'edit_posts', __CLASS__, array( $this, 'page' ) );
	}

	/**
	 * Output page
	 *
	 * @return void
	 */
	function page() {
		?><div class="wrap">
		<h2><?php _e( 'Multi Upload', 'multi-upload' ); ?></h2>
		<?php
			if ( isset( $_POST['image'] ) ) {
				foreach( $_POST['image'] as $name => $value )
					update_option( $name, intval( $value ) );
			}
		?>
		<form method="post">
		<?php
			$this->_upload( 'upload-image-1' );
			$this->_upload( 'upload-image-2' );
			$this->_upload( 'upload-image-3' );

			submit_button( __( 'Save', 'multi-upload' ), 'primary', 'save' );
		?>
		</form>
		</div><?php
	}


	/**
	 * Output upload form
	 *
	 * @param string $id Upload instance id
	 * @return void
	 */
	function _upload( $id ) {

		wp_enqueue_media( );
		wp_enqueue_script( 'multi-upload', plugins_url( 'multi-upload.js', __FILE__ ), array('jquery'), '0.1.0', false );

		echo '<p class="upload">';

			$value = get_option( $id, '' );

			echo '<input name="image['. esc_attr( $id ) .']" type="number" class="small-text" value="'. esc_attr( $value ) .'" />';

			$button_text          = __( 'Upload', 'multi-upload' );
			$uploader_title_text  = __( 'Select an Image', 'multi-upload' );
			$uploader_button_text = __( 'Select', 'multi-upload' );

			submit_button( $button_text, 'secondary small upload-image', 'submit', false, array(
				'data-uploader_title'       => esc_attr( $uploader_title_text ),
				'data-uploader_button_text' => esc_attr( $uploader_button_text ),
				'id'                        => esc_attr( $id )
			) );

			if ( ! empty( $value ) ) {
				$img = wp_get_attachment_image_src( $value );
				echo "<br /><img src='$img[0]' />";
			}

		echo '</p>';

	}

}
