!function(){var e=Handlebars.template;(Handlebars.templates=Handlebars.templates||{})["em-map-staticimage-url"]=e({1:function(e,a,l,n,t,r,s){var i;return null!=(i=(l.withModule||a&&a.withModule||l.helperMissing).call(null!=a?a:e.nullContext||{},s[1],null!=(i=null!=s[1]?s[1]["template-ids"]:s[1])?i.param:i,{name:"withModule",hash:{},fn:e.program(2,t,0,r,s),inverse:e.noop,data:t}))?i:""},2:function(e,a,l,n,t,r,s){return e.escapeExpression((l.enterModule||a&&a.enterModule||l.helperMissing).call(null!=a?a:e.nullContext||{},s[2],{name:"enterModule",hash:{itemObjectId:s[1],itemDBKey:null!=s[2]?s[2].itemDBKey:s[2]},data:t}))},compiler:[7,">= 4.0.0"],main:function(e,a,l,n,t,r,s){var i;return"https://maps.googleapis.com/maps/api/staticmap?size=600x400&maptype=roadmap&key=AIzaSyA9pdYHZ9jZdcdiqM9ttPdWqqnQrxHBWkM"+(null!=(i=l.each.call(null!=a?a:e.nullContext||{},null!=a?a.items:a,{name:"each",hash:{},fn:e.program(1,t,0,r,s),inverse:e.noop,data:t}))?i:"")},useData:!0,useDepths:!0})}();