# Syntax Highlighting
#= require /bower_components/rainbow/js/rainbow.min.js
#= require /bower_components/rainbow/js/language/generic.js
#
#= require /bower_components/floatThead/dist/jquery.floatThead.min.js
#
# Highlight.js https://github.com/isagalaev/highlight.js
#= require /bower_components/highlightjs/highlight.pack.js
#= require /sqlboss/queries/js/highlighter.js

Rainbow.extend [
  matches:
    1: 'keyword'
  pattern: /\b(numeric|after|insert|each|row|execute|procedure|time|character varying|timestamp|date|character|text|real|primary|key|unique|constraint|check|foreign|references|on|update|cascade|restrict|set)\b/gi
,
  name: 'constant.language'
  pattern: /true|false|null|not null/ig
]

$ ->
  $("table.table-float").floatThead()