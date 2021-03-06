jQuery(document).ready( function($) {

	var file_frames = [],
		$button = $('.upload-image');

	$button.on( 'click', function( event ) {
		event.preventDefault();

		var $btn = $(this),
			btnid = $btn.attr('id'),
			$group = $btn.closest('.upload');

		/*
			With multiple uploads on each page, this only remembers the first one opened
		*/

		// If the media frame already exists, reopen it.
		if ( file_frames[ btnid ] ) {
			file_frames[ btnid ].open();
			return;
		}

		// Create the media frame.
		file_frames[ btnid ] = wp.media.frames.file_frame = wp.media({
			title: $( this ).data( 'uploader_title' ),
			button: {
				text: $( this ).data( 'uploader_button_text' ),
			},
			library: {
				type: 'image'
			},
			multiple: false  // Set to true to allow multiple files to be selected
		});

		// When an image is selected, run a callback.
		file_frames[ btnid ].on( 'select', function() {
			// We set multiple to false so only get one image from the uploader

			attachment = file_frames[ btnid ].state().get('selection').first().toJSON();

			if ( $group.find('.uploaded-image').length > 0 ) {
				$group.find('.uploaded-image').remove();
			}

			// set input
			$group.find('input[type="number"]').val( attachment.id );
			// set preview
			img = '<img class="uploaded-image" src="' + attachment.url + '" />';
			$group.append( img );

		});

		// Finally, open the modal
		file_frames[ btnid ].open();
	});

});