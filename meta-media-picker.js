jQuery(document).ready(function($){

    // Instantiates the variable that holds the media library frame.
    var meta_image_frame;

    // Runs when the image button is clicked.
    $('.meta-image-button').click(function(e){

        // Prevents the default action from occuring.
        e.preventDefault();
        
        var meta_image = $(this).attr("meta-image");

        // If the frame already exists, re-open it.
        if ( meta_image_frame ) {
            //meta_image_frame.open();
            //return;
        }

        // Sets up the media library frame
        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
            title: "Select file to use",
            button: { text:  "Use this file" }
        });
        
        // Runs when an image is selected.
        meta_image_frame.on('select', function(){

            // Grabs the attachment selection and creates a JSON representation of the model.
            var media_attachment = meta_image_frame.state().get('selection').first().toJSON();
            
            console.log(media_attachment);
            console.log(meta_image);

            // Sends the attachment URL to our custom image input field.
            $('.meta-image[meta-image="'+meta_image+'"]').val(media_attachment.url);
            $(".meta-image-button[meta-image='"+meta_image+"']").val(media_attachment.name + "." + media_attachment.subtype + " (Click to change)");
            $('.meta-image-clear[meta-image="'+meta_image+'"]').show();
        });

        // Opens the media library frame.
        meta_image_frame.open();
    });
    $('.meta-image-clear').click(function(e){
        $('.meta-image[meta-image="'+$(this).attr("meta-image")+'"]').val("");  
        $(".meta-image-button[meta-image='"+$(this).attr("meta-image")+"']").val("Choose or Upload a file");
        $('.meta-image-clear[meta-image="'+$(this).attr("meta-image")+'"]').hide();
    });
});