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