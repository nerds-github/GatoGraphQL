!function(){var l=Handlebars.template;(Handlebars.templates=Handlebars.templates||{})["em-map-staticimage"]=l({1:function(l,e,a,n,t,s,u){var r;return null!=(r=(a.withModule||e&&e.withModule||a.helperMissing).call(null!=e?e:l.nullContext||{},u[1],"urlparam",{name:"withModule",hash:{},fn:l.program(2,t,0,s,u),inverse:l.noop,data:t}))?r:""},2:function(l,e,a,n,t,s,u){return l.escapeExpression((a.enterModule||e&&e.enterModule||a.helperMissing).call(null!=e?e:l.nullContext||{},u[2],{name:"enterModule",hash:{objectID:u[1],dbKey:null!=u[2]?u[2].dbKey:u[2]},data:t}))},compiler:[7,">= 4.0.0"],main:function(l,e,a,n,t,s,u){var r,o,c=null!=e?e:l.nullContext||{},i=a.helperMissing,h=l.escapeExpression;return'<img class="'+h((o=null!=(o=a.class||(null!=e?e.class:e))?o:i,"function"==typeof o?o.call(c,{name:"class",hash:{},data:t}):o))+'" style="'+h((o=null!=(o=a.style||(null!=e?e.style:e))?o:i,"function"==typeof o?o.call(c,{name:"style",hash:{},data:t}):o))+'" src="'+h((o=null!=(o=a.url||(null!=e?e.url:e))?o:i,"function"==typeof o?o.call(c,{name:"url",hash:{},data:t}):o))+(null!=(r=a.each.call(c,null!=e?e.dbObjectIDs:e,{name:"each",hash:{},fn:l.program(1,t,0,s,u),inverse:l.noop,data:t}))?r:"")+'">'},useData:!0,useDepths:!0})}();