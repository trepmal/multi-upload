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

	function __construct() {
		add_action( 'admin_menu', array( &$this, 'menu' ) );
		add_action( 'admin_enqueue_scripts', array( &$this, 'admin_enqueue_scripts' ) );
	}

	function menu() {
		add_options_page( __( 'Multi Upload', 'multi-upload' ), __( 'Multi Upload', 'multi-upload' ), 'edit_posts', __CLASS__, array( &$this, 'page' ) );
	}

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

			echo '<p>';
			submit_button( __( 'Save', 'multi-upload' ), 'primary', 'save', false );
			// submit_button( 'Add', 'small', 'add', false );
			echo '</p>';
		?>
		</form>
		</div><?php
	}


	function _upload( $id ) {
		echo '<div class="upload">';

			$value = get_option( $id, '' );

			echo "<input name='image[$id]' type='number' class='small-text' value='$value' />";
			$button_text = __( 'Upload', 'multi-upload' );
			$uploader_title_text = __( 'Select an Image', 'multi-upload' );
			$uploader_button_text = __( 'Select', 'multi-upload' );
			echo "<input type='button' class='button upload-image' id='$id' value='$button_text' data-uploader_title='$uploader_title_text' data-uploader_button_text='$uploader_button_text' /><br />";
			if ( ! empty( $value ) ) {
				$img = wp_get_attachment_image_src( $value );
				echo "<img src='$img[0]' />";
			}

		echo '</div>';

	}

	function admin_enqueue_scripts( $hook ) {
		if ( 'settings_page_Multi_Upload' != $hook ) return;

		wp_enqueue_media( );
		wp_enqueue_script( 'multi-upload', plugins_url( 'multi-upload.js', __FILE__ ), array('jquery') );

	}

}