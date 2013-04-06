search = (keyword, connection_id) ->
	$('.database').each ->
		database = $(@)
		if database.data('database_name').toLowerCase().indexOf(keyword) >= 0 && (connection_id == 'all' || parseInt(connection_id) == parseInt(database.data('connection_id')))
			database.show()
		else
			database.hide()

activate_connection = (connection_id) ->
	$('.connection').removeClass('active')
	$(".connection[data-connection_id=#{connection_id}]").addClass('active')
	search $('#databases-search').val(), connection_id

activate_connection_using_hash = () ->
	if window.location.hash
		connection_id = window.location.hash.slice(1)
		activate_connection connection_id

$ ->
	window.onhashchange = activate_connection_using_hash
	activate_connection_using_hash()
	
	$('.connection a').click ->
		$('.connection').removeClass('active')
		connection = $(@)
		connection.parent('li').addClass('active')
		connection_id = connection.attr('href').slice(1)
		search $('#databases-search').val(), connection_id

	$('#databases-search').keyup ->
		keyword = @.value.toLowerCase()
		connection_id = $('.connection.active a').attr('href').slice(1)
		search keyword, connection_id