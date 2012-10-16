jQuery(document).ready(function($) {
	var i = 2;
	$('#ingredients-meta .add-ingredient').click(function(e) {
		
		if($('#ingredient-1').length < 1) {
			$('<input type="submit" class="secondary delete-ingredient" id="ingredient-1" value="Delete Ingredient" />').insertAfter('.ingredients-span');
		}
		
		var output = '<div><span>';
		
		output += '<label for="ingredient-' + i + '">Ingredient Name: </label>';
		output += '<input type="text" name="ingredient-' + i + '" class="ingredient-' + i + '" width="55" />';
		
		output += '<label for="qty-' + i + '"> QTY: </label>';
		output += '<input type="text" name="qty-' + i + '" class="qty-' + i + '" width="25" /></span>';
		
		output += '<input type="submit" class="secondary delete-ingredient" id="ingredient-' + i + '" value="Delete Ingredient" /></div>';
		
		i++;
		
		$(output).appendTo('#ingredients-meta .inside');
		e.preventDefault();
		e.stopPropagation();
	});
	
	
	$('#ingredients-meta').on('click', '.delete-ingredient', function(e) {
		
		$(this).prev().find('input').attr('value', 'empty').parent().add(this).hide();

		e.preventDefault();
	});
});

