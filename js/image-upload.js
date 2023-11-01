/*jQuery(document).ready(function(t){"use strict";var e;t(".meta-image-button").click(function(i){var a=t(this).parent().children("input.image-upload-field");return i.preventDefault(),e?void e.open():(e=wp.media.frames.meta_image_frame=wp.media({title:meta_image.title,button:{text:meta_image.button},library:{type:"image"}}),e.on("select",function(){var t=e.state().get("selection").first().toJSON();a.val(t.url)}),void e.open())})});*/
jQuery(function($){
	"use strict";
	// Set all variables to be used in scope
	var frame;
	
	// ADD IMAGE LINK
	$('body').on('click', '.meta-image-button', function(event) {
		event.preventDefault();
		
		var metaBox = $(this).parents('.image-upload-form'), // Your meta box id here
		addImgLink = metaBox.find('.meta-image-button'),
		delImgLink = metaBox.find('.meta-image-delete-button'),
		imgContainer = metaBox.find('.custom-img-wrap'),
		imgIdInput = metaBox.find('.image-upload-field');
		
		// If the media frame already exists, reopen it.
		if (frame) {
			frame.open();
			return;
		}
		
		// Create a new media frame
		frame = wp.media({
			title: 'Select or Upload Media Of Your Chosen Persuasion',
			button: {
				text: 'Use this media'
			},
			multiple: false  // Set to true to allow multiple files to be selected
		});
		
		// When an image is selected in the media frame...
		frame.on( 'select', function() {
			// Get media attachment details from the frame state
			var attachment = frame.state().get('selection').first().toJSON();
			
			// Send the attachment URL to our custom image input field.
			imgContainer.append('<img src="'+attachment.url+'" alt="" class="bg-preview" />');
			
			// Send the attachment id to our hidden input
			imgIdInput.val(attachment.id);
			
			// Hide the add image link
			addImgLink.addClass('hidden');
			
			// Unhide the remove image link
			delImgLink.removeClass('hidden');
		});
		
		// Finally, open the modal on click
		frame.open();
	});
	
	// DELETE IMAGE LINK
	$('body').on('click', '.meta-image-delete-button', function(event) {
		event.preventDefault();
		
		var metaBox = $(this).parents('.image-upload-form'), // Your meta box id here
			addImgLink = metaBox.find('.meta-image-button'),
			delImgLink = metaBox.find('.meta-image-delete-button'),
			imgContainer = metaBox.find('.custom-img-wrap'),
			imgIdInput = metaBox.find('.image-upload-field');
			
		// Clear out the preview image
		imgContainer.html('');
	
		// Un-hide the add image link
		addImgLink.removeClass('hidden');
	
		// Hide the delete image link
		delImgLink.addClass('hidden');
	
		// Delete the image id from the hidden input
		imgIdInput.val('');
	});
});