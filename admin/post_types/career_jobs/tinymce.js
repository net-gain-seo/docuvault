jQuery(document).ready(function($) {
    //student_success SHORTCODE BUTTON
    tinymce.create('tinymce.plugins.student_success_plugin', {
        init : function(ed, url) {
            // Register buttons - trigger above command when clicked
            ed.addButton('student_success_button', {
                title : 'Insert Student Success Shortcode',
                image: url + '/images/testimonial-icon.png',
                onclick : function() {
                    // triggers the thickbox
                    var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                    W = W - 80;
                    H = H - 84;
                    tb_show( 'student_success', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=student_success-form' );
                }
            });
        }
    });

    // Register our TinyMCE plugin
    // first parameter is the button ID1
    // second parameter must match the first parameter of the tinymce.create() function above
    tinymce.PluginManager.add('student_success_button', tinymce.plugins.student_success_plugin);

    var student_successItemsHTML = '<input name="student_success_items[]" type="text" value="Item Heading" style="margin-bottom: 10px" />';


    // executes this when the DOM is ready
    jQuery(function(){
        // creates a form to be displayed everytime the button is clicked
        // you should achieve this using AJAX instead of direct html code like this

        var formContent = '<div id="student-success-form"><table id="student-success-table" class="form-table">';

        if(typeof student_success_styles != 'undefined'){
            formContent += '<tr>';
                formContent += '<th><label for="student_success_style">Style</label></th>';
                formContent += '<td>';
                    formContent += '<select name="student_success_style" id="student_success_style">';
                        $.each(student_success_styles, function(i, item) {
                            formContent += '<option value="'+item+'">'+item+'</option>';
                        });

                    formContent += '</select>';
                    formContent += '<br />';
                formContent += '</td>';
            formContent += '</tr>';
        }

        formContent += '<tr>\
				<th><label for="student_success_title">Title</label></th>\
				<td><input type="text" id="student_success_title" name="student_success_title" value="" /><br />\
				</td>\
			</tr>\
            <tr>\
				<th><label for="student_success_type">Type</label></th>\
				<td><select id="student_success_type" name="student_success_type"><option value="standard">Standard</option><option value="carousel">Carousel</option></select><br />\
				</td>\
			</tr>\
			<tr>\
				<th><label for="student_success_scrollDirection">Scroll Direction</label></th>\
				<td>\
				    <select id="student_success_scrollDirection" name="student_success_scrollDirection">\
				        <option value="left">Left</option>\
				        <option value="up">Up</option>\
				    </select><br />\
				</td>\
			</tr>\
            <tr class="full_width_only">\
			    <th><h3>Other Options</h3></th>\
			    <th></th>\
			</tr>\
            <tr>\
				<th><label for="student_success_id">ID</label></th>\
				<td><input type="text" id="student_success_id" name="student_success_id" value="" /><br />\
				</td>\
			</tr>\
			<tr>\
				<th><label for="student_success_class">Class</label></th>\
				<td><input type="text" id="student_success_class" name="student_success_class" value="" /><br />\
				</td>\
			</tr>\
			<tr>\
				<th><label for="student_success_offset">Offset</label></th>\
				<td><input type="text" id="student_success_offset" name="student_success_offset" value="0" /><br />\
				</td>\
			</tr>\
			<tr>\
				<th><label for="student_success_posts_per_page">Posts Per Page</label></th>\
				<td><input type="text" id="student_success_posts_per_page" name="student_success_posts_per_page" value="-1" /><br />\
				</td>\
			</tr>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="student_success-submit" class="button-primary" value="Insert student_success" name="submit" />\
		</p>\
		</div>';

        var form = jQuery(formContent);

        var table = form.find('table');
        form.appendTo('body').hide();

        // handles the click event of the submit button
        form.find('#student_success-submit').click(function(){
            var shortcode = '';
            var student_success_style = table.find('#student_success_style').val();
            var student_success_type = table.find('#student_success_type').val();
            var student_success_id = table.find('#student_success_id').val();
            var student_success_class = table.find('#student_success_class').val();
            var student_success_offset = table.find('#student_success_offset').val();
            var student_success_scrollDirection = table.find('#student_success_scrollDirection').val();
            var student_success_posts_per_page = table.find('#student_success_posts_per_page').val();
            var student_success_title = table.find('#student_success_title').val();

                shortcode += '<p>[student_success '+(student_success_type == "carousel" ? 'carousel=\"yes"':"")+' \
                '+(student_success_id != "" ? 'id=\"'+student_success_id+'\"':"")+' \
                '+(student_success_class != "" || student_success_style != undefined || student_success_type != undefined ? 'class=\"'+student_success_class+ ' '+(student_success_type != undefined ? student_success_type:"")+' '+(student_success_style != undefined ? student_success_style:"")+'\"':"")+'\
                '+(student_success_offset != "" ? 'offset=\"'+student_success_offset+'\"':"")+' \
                '+(student_success_posts_per_page != "" ? 'posts_per_page=\"'+student_success_posts_per_page+'\"':"")+' \
                '+(student_success_title != "" ? 'title=\"'+student_success_title+'\"':"")+' \
                '+(student_success_scrollDirection != "" ? 'direction=\"'+student_success_scrollDirection+'\"':"")+' \
                ]</p>';

            jQuery('input[name="student_success_items[]"]').each(function() {
                var heading = $(this).val();
                shortcode += '<p>[student_success_item title="'+heading+'"]</p><p>Content Goes Here...</p><p>[/student_success_item]</p>';
            });

            tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);

            tb_remove();
        });

        form.find('#addstudent_successItem').click(function(){
            jQuery('#additionalstudent_successItems').append('<div>'+student_successItemsHTML+' - <a class="removeItem" href="#">Remove</a></div>');
            return false;
        });

        jQuery(document).on('click','.removeItem',function(){
            jQuery(this).parent('div').remove();
            return false;
        });
    });
});
