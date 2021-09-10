/**
 * Based on arcade theme's header image picker
 * @param {type} $
 * @returns {undefined}
 */
( function($) {
	var file_frame;
    var $container = $('#cb-header-image');
    var $image_holder = $container.find( '#cb-header-image-container' );
    var $input = $container.find('#cb-header-image-url');
    var $del_button = $container.find('.delete-image');

    if ( $input.val().length <= 0 ) {
        $del_button.hide();
    }

	$( '#cb-header-image' )
        .on('click', '.select-image', function(e) {
            e.preventDefault();
            if ( file_frame ) {
                file_frame.open();
            return;
        }

        file_frame = wp.media.frames.file_frame = wp.media( {
            title: $(this).data( 'uploader_title' ),
            button: {
                text: $(this).data( 'uploader_button_text' )
            },
            multiple: false
        } );

        file_frame.on( 'select', function() {
            var attachment = file_frame.state().get( 'selection' ).first().toJSON();
            $input.val( attachment.url );
            $image_holder.html( '<img src="' + attachment.url + '" alt="" style="max-width:100%;" />' );
           $del_button.show();
        } );

        file_frame.open();
    } )
    .on('click', '.delete-image', function(e) {
        e.preventDefault();
        $input.val( '' );
        $image_holder.html( '' );
        $del_button.hide();
    } );
} )(jQuery);