(window.webpackJsonpGraphQLAPICustomEndpointOverview=window.webpackJsonpGraphQLAPICustomEndpointOverview||[]).push([[1],{9:function(e,t,n){}}]),function(e){function t(t){for(var a,i,s=t[0],o=t[1],c=t[2],u=0,m=[];u<s.length;u++)i=s[u],Object.prototype.hasOwnProperty.call(r,i)&&r[i]&&m.push(r[i][0]),r[i]=0;for(a in o)Object.prototype.hasOwnProperty.call(o,a)&&(e[a]=o[a]);for(p&&p(t);m.length;)m.shift()();return l.push.apply(l,c||[]),n()}function n(){for(var e,t=0;t<l.length;t++){for(var n=l[t],a=!0,s=1;s<n.length;s++){var o=n[s];0!==r[o]&&(a=!1)}a&&(l.splice(t--,1),e=i(i.s=n[0]))}return e}var a={},r={0:0},l=[];function i(t){if(a[t])return a[t].exports;var n=a[t]={i:t,l:!1,exports:{}};return e[t].call(n.exports,n,n.exports,i),n.l=!0,n.exports}i.m=e,i.c=a,i.d=function(e,t,n){i.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},i.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},i.t=function(e,t){if(1&t&&(e=i(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var n=Object.create(null);if(i.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var a in e)i.d(n,a,function(t){return e[t]}.bind(null,a));return n},i.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return i.d(t,"a",t),t},i.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},i.p="";var s=window.webpackJsonpGraphQLAPICustomEndpointOverview=window.webpackJsonpGraphQLAPICustomEndpointOverview||[],o=s.push.bind(s);s.push=t,s=s.slice();for(var c=0;c<s.length;c++)t(s[c]);var p=o;l.push([10,1]),n()}([function(e,t){e.exports=window.wp.element},function(e,t){e.exports=window.wp.i18n},function(e,t){e.exports=window.wp.components},function(e,t){e.exports=window.wp.editor},function(e,t){e.exports=window.wp.plugins},function(e,t){e.exports=window.wp.editPost},function(e,t){e.exports=window.wp.data},function(e,t){e.exports=window.wp.url},function(e,t){e.exports=window.wp.blockEditor},,function(e,t,n){"use strict";n.r(t);var a=n(4),r=n(0),l=n(1),i=n(5),s=n(6),o=n(7),c=n(2),p=n(3),u=n(8);function m(){var e=Object(s.useSelect)((function(e){var t=e(p.store).getCurrentPost(),n=e(p.store).getPermalinkParts(),a=e(u.store).getBlocks(),r=a.filter((function(e){return"graphql-api/custom-endpoint-options"===e.name})).shift(),l=a.filter((function(e){return"graphql-api/endpoint-graphiql"===e.name})).shift(),i=a.filter((function(e){return"graphql-api/endpoint-voyager"===e.name})).shift();return{postSlug:Object(o.safeDecodeURIComponent)(e(p.store).getEditedPostSlug()),postLink:t.link,postLinkHasParams:t.link.indexOf("?")>=0,postStatus:t.status,isPostPublished:"publish"===t.status,isPostDraftOrPending:"draft"===t.status||"pending"===t.status,isPostPrivate:"private"===t.status,isPostPasswordProtected:!!t.password,permalinkPrefix:null==n?void 0:n.prefix,permalinkSuffix:null==n?void 0:n.suffix,isCustomEndpointEnabled:r.attributes.isEnabled,isGraphiQLClientEnabled:l.attributes.isEnabled,isVoyagerClientEnabled:i.attributes.isEnabled}}),[]),t=e.postSlug,n=e.postLink,a=e.postLinkHasParams,i=e.postStatus,m=e.isPostPublished,d=e.isPostDraftOrPending,b=e.isPostPrivate,_=e.isPostPasswordProtected,O=e.permalinkPrefix,f=e.permalinkSuffix,j=e.isCustomEndpointEnabled,E=e.isGraphiQLClientEnabled,w=e.isVoyagerClientEnabled,h=a?"&":"?",g=m&&!_?"🟢":d||b||_?"🟡":"🔴",v=m||d||b;return Object(r.createElement)(r.Fragment,null,j&&Object(r.createElement)("p",{className:"notice-message"},Object(r.createElement)(c.Notice,{status:m&&!_?"success":d||b||_?"warning":"error",isDismissible:!1},Object(r.createElement)("strong",null,Object(l.__)("Status ","graphql-api"),Object(r.createElement)("code",null,i),_&&Object(l.__)(" (protected by password)","graphql-api"),Object(l.__)(": ","graphql-api")),Object(r.createElement)("br",null),Object(r.createElement)("span",{className:"notice-inner-message"},m&&!_&&Object(l.__)("Custom endpoint is public, available to everyone.","graphql-api"),m&&_&&Object(l.__)("Custom endpoint is public, available to anyone with the required password.","graphql-api"),d&&!_&&Object(l.__)("Custom endpoint is not yet public, only available to the Schema editors.","graphql-api"),d&&_&&Object(l.__)("Custom endpoint is not yet public, only available to the Schema editors with the required password.","graphql-api"),b&&Object(l.__)("Custom endpoint is private, only available to the Schema editors.","graphql-api"),!v&&Object(l.__)("Custom endpoint is not yet available.","graphql-api")))),v&&Object(r.createElement)(r.Fragment,null,Object(r.createElement)("div",{className:"editor-post-url"},Object(r.createElement)("h3",{className:"editor-post-url__link-label"},j?g:"🔴"," ",Object(l.__)("Custom Endpoint URL")),Object(r.createElement)("p",null,j&&Object(r.createElement)(c.ExternalLink,{className:"editor-post-url__link",href:n,target:"_blank"},Object(r.createElement)(r.Fragment,null,Object(r.createElement)("span",{className:"editor-post-url__link-prefix"},O),Object(r.createElement)("span",{className:"editor-post-url__link-slug"},t),Object(r.createElement)("span",{className:"editor-post-url__link-suffix"},f))),!j&&Object(r.createElement)("span",{className:"disabled-text"},Object(l.__)("Disabled","graphql-api")))),Object(r.createElement)("hr",null),Object(r.createElement)("div",{className:"editor-post-url"},Object(r.createElement)("h3",{className:"editor-post-url__link-label"},v?"🟡":"🔴"," ",Object(l.__)("View Endpoint Source")),Object(r.createElement)("p",null,Object(r.createElement)(c.ExternalLink,{className:"editor-post-url__link",href:n+h+"view=source",target:"_blank"},Object(r.createElement)(r.Fragment,null,Object(r.createElement)("span",{className:"editor-post-url__link-prefix"},O),Object(r.createElement)("span",{className:"editor-post-url__link-slug"},t),Object(r.createElement)("span",{className:"editor-post-url__link-suffix"},f),Object(r.createElement)("span",{className:"editor-endoint-custom-post-url__link-view"},"?view="),Object(r.createElement)("span",{className:"editor-endoint-custom-post-url__link-view-item"},"source"))))),Object(r.createElement)("hr",null),Object(r.createElement)("div",{className:"editor-post-url"},Object(r.createElement)("h3",{className:"editor-post-url__link-label"},E?g:"🔴"," ",Object(l.__)("GraphiQL client")),Object(r.createElement)("p",null,E&&Object(r.createElement)(c.ExternalLink,{className:"editor-post-url__link",href:n+h+"view=graphiql",target:"_blank"},Object(r.createElement)(r.Fragment,null,Object(r.createElement)("span",{className:"editor-post-url__link-prefix"},O),Object(r.createElement)("span",{className:"editor-post-url__link-slug"},t),Object(r.createElement)("span",{className:"editor-post-url__link-suffix"},f),Object(r.createElement)("span",{className:"editor-endoint-custom-post-url__link-view"},"?view="),Object(r.createElement)("span",{className:"editor-endoint-custom-post-url__link-view-item"},"graphiql"))),!E&&Object(r.createElement)("span",{className:"disabled-text"},Object(l.__)("Disabled","graphql-api")))),Object(r.createElement)("hr",null),Object(r.createElement)("div",{className:"editor-post-url"},Object(r.createElement)("h3",{className:"editor-post-url__link-label"},w?g:"🔴"," ",Object(l.__)("Interactive Schema Client")),Object(r.createElement)("p",null,w&&Object(r.createElement)(c.ExternalLink,{className:"editor-post-url__link",href:n+h+"view=schema",target:"_blank"},Object(r.createElement)(r.Fragment,null,Object(r.createElement)("span",{className:"editor-post-url__link-prefix"},O),Object(r.createElement)("span",{className:"editor-post-url__link-slug"},t),Object(r.createElement)("span",{className:"editor-post-url__link-suffix"},f),Object(r.createElement)("span",{className:"editor-endoint-custom-post-url__link-view"},"?view="),Object(r.createElement)("span",{className:"editor-endoint-custom-post-url__link-view-item"},"schema"))),!w&&Object(r.createElement)("span",{className:"disabled-text"},Object(l.__)("Disabled","graphql-api"))))))}n(9);Object(a.registerPlugin)("custom-endpoint-overview-panel",{render:function(){return Object(r.createElement)(i.PluginDocumentSettingPanel,{name:"custom-endpoint-overview-panel",title:Object(l.__)("Custom Endpoint Overview","graphql-api")},Object(r.createElement)(m,null))},icon:"welcome-view-site"})}]);