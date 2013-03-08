$ ->
   $('.connection a').click ->
    $('.connection').removeClass('active')
    connection = $(@)
    connection.parent('li').addClass('active')
    connection_id = connection.attr('href').substring(1)
    if connection_id == 'all'
      $('.database').show()
    else
      $('.database').hide()
      $(".database[data-connection_id=#{connection_id}]").show()