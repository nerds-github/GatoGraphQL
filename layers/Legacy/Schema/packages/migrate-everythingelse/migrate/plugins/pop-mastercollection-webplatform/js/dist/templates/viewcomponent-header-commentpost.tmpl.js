!function(){var e=Handlebars.template;(Handlebars.templates=Handlebars.templates||{})["viewcomponent-header-commentpost"]=e({1:function(e,l,n,t,a,s,u){var o,d=e.lambda,r=e.escapeExpression;return"<div class='"+r(d(null!=u[1]?u[1].class:u[1],l))+"' style='"+r(d(null!=u[1]?u[1].style:u[1],l))+"'>"+r((n.enterModule||l&&l.enterModule||n.helperMissing).call(null!=l?l:e.nullContext||{},u[1],{name:"enterModule",hash:{objectID:null!=(o=null!=u[1]?u[1].dbObject:u[1])?o["post-id"]:o,dbKey:null!=(o=null!=(o=null!=u[1]?u[1].bs:u[1])?o.dbkeys:o)?o["post-id"]:o},data:a}))+"</div>"},compiler:[7,">= 4.0.0"],main:function(e,l,n,t,a,s,u){var o;return null!=(o=(n.withModule||l&&l.withModule||n.helperMissing).call(null!=l?l:e.nullContext||{},l,"header-post",{name:"withModule",hash:{},fn:e.program(1,a,0,s,u),inverse:e.noop,data:a}))?o:""},useData:!0,useDepths:!0})}();