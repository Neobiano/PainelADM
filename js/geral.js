function readURL(input) 
					{
			            if (input.files && input.files[0]) {
			                var reader = new FileReader();
			                reader.onload = function (e) {
			                    $(input).next()
			                    .attr('src', e.target.result)
			                };
			                reader.readAsDataURL(input.files[0]);
			            }
			            else {
			                var img = input.value;
			                $(input).next().attr('src',img);
			            }
			         }

function exibeFoto(){
    $('input[type=file]').each(function(index){
        if ($('input[type=file]').eq(index).val() != "")
        {
            readURL(this);
        }
    });
}	

$(document).ready(function(){
	$("input").addClass('radius5');
	$("textarea").addClass('radius5');
	$("fieldset").addClass('radius5');
	$("sidebar li").addClass('radius5');
	//accordion
	$('#accordion a.itesm').click(function() {
		$('#accordion li').children('ul').slideUp('fast');
		$('#accordion li').each(function(){
			$(this).removeClass('active');
		});
		$(this).siblings('ul').slideDown('fast');
		$(this).parent().addClass('active');
		return false;
	});
});
