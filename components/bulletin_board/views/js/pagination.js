(function($){
	$(document).ready(function(){
		
		var min_text = 1;
		var block_class_prefix = "page";
		var bullet_id_prefix = "page-change";
		var bullet_class = "pages-changer";
		var bullet_list_id = "pages-changer-block";
		var active_class = "opened";
		var separator = "--";
		
		
		function showOnly(current_text) {
			if (!current_text) { current_text = min_text; }
			
			for (i=min_text; i<=max_text; i++) {
				$('#' + bullet_id_prefix + separator + i).removeClass(active_class);
				
				if (i == current_text) {
					$('.' + block_class_prefix + separator + i).show();
					$('#' + bullet_id_prefix + separator + i).addClass(active_class);
				}
				else {
					$('.' + block_class_prefix + separator + i).hide();
				}
			}
		}
				
		// Show first text by default
		showOnly(min_text);
		
		// Handler for bullet clicks
		$('.' + bullet_class).on("click", function(){			
			var number_text = $(this).attr('id').split(separator)[1];
			
			// clearInterval(interval);
			showOnly(number_text);
		});
	})
})(jQuery); 
