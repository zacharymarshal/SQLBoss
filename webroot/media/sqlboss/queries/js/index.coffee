$ =>
  query_editor = ace.edit 'query_sql_editor'
  query_editor.setTheme 'ace/theme/tomorrow_night'
  query_editor.setFontSize '14px'
  query_editor.setShowInvisibles true
  query_editor.setDisplayIndentGuides true
  query_editor.setHighlightActiveLine false
  query_editor.getSession().setUseWrapMode true
  query_editor.getSession().setUseSoftTabs false
  query_editor.getSession().setMode 'ace/mode/pgsql'
  query_editor.getSession().setTabSize 2
  query_editor.moveCursorToPosition cursor if localStorage? and cursor = JSON.parse localStorage.getItem('cursor')
  query_editor.focus()

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