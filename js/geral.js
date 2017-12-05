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
			         };

function exibeFoto(){
    $('input[type=file]').each(function(index){
        if ($('input[type=file]').eq(index).val() != "")
        {
            readURL(this);
        }
    });
};	

