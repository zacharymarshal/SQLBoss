// Generated by CoffeeScript 1.7.1
(function() {
  $(function() {
    return $('.query-sql_box').hover(function() {
      $('.query-link_overlay', this).css('visibility', 'visible');
      return $(this).addClass('query-sql_box_highlight');
    }, function() {
      $('.query-link_overlay', this).css('visibility', 'hidden');
      return $(this).removeClass('query-sql_box_highlight');
    });
  });

}).call(this);
