jQuery(document).ready( function($) {

	var file_frames = [],
		$button = $('.upload-image');

	$button.click( function( event ){
		event.preventDefault();

		var btn = $(this),
			btnid = btn.attr('id'),
			group = btn.closest('.upload');


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
				text: $( this ).css('background', '1px soild red').data( 'uploader_button_text' ),
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

			if ( group.find('br').next('img').length > 0 ) {
				group.find('br').next('img').remove();
			}

			// set input
			group.find('input[type="number"]').val( attachment.id );
			// set preview
			img = '<img src="'+ attachment.url +'" />';
			btn.next('br').after( img );

		});

		// Finally, open the modal
		file_frames[ btnid ].open();
	});

	/*
	$('#add').click( function( event ) {
		event.preventDefault();
		// $(this).css('background', 'green');
		$last = $('.upload:last');
		// $last.css('background', 'red');
		html = $last.html();
		html = html.replace( /id=".*?"/gm, 'id="test"' );
		// html = html.replace( /id="upload-image/gm, 'id="test"' );
		$last.after( '<div class="upload">'+ html +'</div>');
	});
	*/

});