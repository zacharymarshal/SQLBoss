$ ->
	$('.query-sql_box').hover ->
		$('.query-link_overlay', @).css('visibility', 'visible')
		$(@).addClass('query-sql_box_highlight')
	, ->
		$('.query-link_overlay', @).css('visibility', 'hidden')
		$(@).removeClass('query-sql_box_highlight')