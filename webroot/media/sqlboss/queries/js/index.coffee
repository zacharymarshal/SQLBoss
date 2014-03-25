$ =>

  public_checkbox = $('#query-public').prev()
  $('#query-public').addClass('btn-primary active') if public_checkbox.prop('checked')
  
  # Public checkbox
  $('#query-public').click ->
    $(@).toggleClass('btn-primary active')
    public_checkbox.prop 'checked', ! public_checkbox.prop('checked')

  query_editor = ace.edit 'query_sql_editor'
  query_editor.setTheme 'ace/theme/tomorrow'
  query_editor.setFontSize '14px'
  query_editor.setShowInvisibles true
  query_editor.setDisplayIndentGuides true
  query_editor.setHighlightActiveLine false
  query_editor.getSession().setUseWrapMode true
  query_editor.getSession().setUseSoftTabs false
  query_editor.getSession().setMode 'ace/mode/pgsql'
  query_editor.getSession().setTabSize 2
  query_editor.moveCursorToPosition cursor if localStorage? and cursor = JSON.parse localStorage.getItem('cursor')

  query_form = $('#QueryIndexForm')
  query_field = $('#QueryQuerySql')
  query_form.submit (e) ->
    query_field.val query_editor.getSession().getValue()
    localStorage.setItem 'cursor', JSON.stringify(query_editor.getCursorPosition())
    return true

  $(window).keydown (e) ->
    if e.keyCode == 116 || (e.keyCode == 13 && e.shiftKey)
      e.preventDefault()
      query_form.submit()

  $("table.table-float").floatThead()