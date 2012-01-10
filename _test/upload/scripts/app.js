$(function () {

	$('#filedrag').show();

	$('input').uniform();

    $('#fileupload').fileupload({
		dataType: 'text',

	    dropZone: $('#filedrag'),

		add: function(e, data) {
			data.submit();
			$('#upload-form').hide();
			$('#result-form').show();
			$('#result-link-openbutton').click(function(){
				window.open($('#result-link-openbutton').attr('href'));
			});
		},

	    progress: function(e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
		    $('#bar').width(progress + '%');
		},
		
		done: function(e, data) {
			//$('#state').text('Complete!');
			$('#state').hide();
			$('#result-link').val(data.result);
			$('#result-link-openbutton').attr('href',data.result);
			$('#result-link-openbutton').show();
			$('#result-link').show();
		},

	    fail: function(e, data) {
		   $('#state').text('Error during image upload :(');
	    }
	});

   /*

    // Open download dialogs via iframes,
    // to prevent aborting current uploads:
    $('#fileupload .files a:not([target^=_blank])').live('click', function (e) {
        e.preventDefault();
        $('<iframe style="display:none;"></iframe>')
            .prop('src', this.href)
            .appendTo('body');
    });*/

});