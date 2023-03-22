(window.webpackJsonpGraphQLAPISchemaConfigurationAdditionalDocumentation=window.webpackJsonpGraphQLAPISchemaConfigurationAdditionalDocumentation||[]).push([[12],{58:function(e,t){e.exports='<h1 id="cache-control">Cache Control</h1> <p>When queries are executed against the GraphQL server using <code>GET</code> (instead of the more traditional <code>POST</code> method), the GraphQL response can be cached on the client-side or intermediate stages between the client and the server (such as a CDN), by relying on standard HTTP caching.</p> <p>This works naturally for persisted queries, and for the single endpoint and custom endpoints it can work by appending param <code>?query={ GraphQL query }</code> to the endpoint.</p> <h2 id="description">Description</h2> <p>HTTP caching works by sending a <code>Cache-Control</code> header with a <code>max-age</code> value in the response, indicating for how long the response must be cached.</p> <p>The GraphQL API PRO plugin offers Cache Control Lists, where custom <code>max-age</code> values are defined for fields and directives. Hence, different queries containing different combinations of fields and directives will produce a different <code>max-age</code> value.</p> <p>The response&#39;s <code>max-age</code> value is calculated as the lowest value from all the fields and directives in the requested query, or <code>no-store</code> if either:</p> <ul> <li>any mutation is executed</li> <li>any field or directive has <code>max-age</code> with value <code>0</code></li> <li>an Access Control rule must check the user state for any field or directive (in which case, the response is specific to the user, so it cannot be cached)</li> </ul> <p><img src="https://raw.githubusercontent.com/leoloso/PoP/master/layers/GraphQLAPIForWP/plugins/graphql-api-for-wp/docs/implicit-features//../../images/cache-control.gif" alt="Defining a cache control policy" title="Defining a cache control policy"></p> <h2 id="using-a-cache-control-list-ccl">Using a Cache Control List (CCL)</h2> <p>After creating the CCL (see next section), we can have the endpoint use it by editing the corresponding Schema Configuration, and selecting the CCL from the list under block &quot;Cache Control Lists&quot;.</p> <p><img src="https://raw.githubusercontent.com/leoloso/PoP/master/layers/GraphQLAPIForWP/plugins/graphql-api-for-wp/docs/implicit-features//../../images/schema-config-cache-control-lists.png" alt="Selecting a Cache Control List in the Schema Configuration" title="Selecting a Cache Control List in the Schema Configuration"></p> <h2 id="creating-a-cache-control-list">Creating a Cache Control List</h2> <p>Click on the &quot;Cache Control Lists&quot; page in the GraphQL API menu:</p> <p><img src="https://raw.githubusercontent.com/leoloso/PoP/master/layers/GraphQLAPIForWP/plugins/graphql-api-for-wp/docs/implicit-features//../../images/cache-control-lists.png" alt="Cache Control Lists" title="Cache Control Lists"></p> <p>Then click on &quot;Add New Cache Control List&quot; to go to the editor:</p> <p><img src="https://raw.githubusercontent.com/leoloso/PoP/master/layers/GraphQLAPIForWP/plugins/graphql-api-for-wp/docs/implicit-features//../../images/cache-control-list.png" alt="Creating a Cache Control List" title="Creating a Cache Control List"></p> <p>Every Cache Control List contains one or many entries, each of them with the following elements:</p> <ul> <li>The fields and directives which, if they appear on the GraphQL query, the selected max-age takes effect</li> <li>The max-age</li> </ul> <p><img src="https://raw.githubusercontent.com/leoloso/PoP/master/layers/GraphQLAPIForWP/plugins/graphql-api-for-wp/docs/implicit-features//../../images/cache-control-entry.png" alt="Cache Control entry" title="Cache Control entry"></p> <p>Caching for fields from an interface is carried on all types implementing the interface.</p> <p><img src="https://raw.githubusercontent.com/leoloso/PoP/master/layers/GraphQLAPIForWP/plugins/graphql-api-for-wp/docs/implicit-features//../../images/selecting-field-from-interface.png" alt="Selecting a field from an interface" title="Selecting a field from an interface"></p> <p>Fields which are not given any specific <code>max-age</code> will use the default value, defined in the Settings page under tab &quot;Cache Control&quot;:</p> <p><img src="https://raw.githubusercontent.com/leoloso/PoP/master/layers/GraphQLAPIForWP/plugins/graphql-api-for-wp/docs/implicit-features//../../images/settings-cache-control.png" alt="Default max-age value in the Settings page" title="Default max-age value in the Settings page"></p> <h2 id="executing-the-endpoint-via-get">Executing the endpoint via <code>GET</code></h2> <p>Persisted queries are already suitable to be executed via <code>GET</code>, as they store the GraphQL query in the server (i.e. it must not be provided in the body of the request).</p> <p>For the single endpoint and custom endpoints, though, the query must be provided under param <code>?query=...</code> attached to the endpoint URL.</p> <p>For instance, the following GraphQL query:</p> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-punctuation">{</span>\n  posts <span class="hljs-punctuation">{</span>\n    id\n    title\n    url\n    author <span class="hljs-punctuation">{</span>\n      id\n      name\n      url\n    <span class="hljs-punctuation">}</span>\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <p>...can be executed via <code>GET</code> against the single endpoint like this:</p> <p><code>https://mysite.com/graphql/?query={ posts { id title url author { id name url } } }</code></p> \x3c!-- ## Resources\n\nVideo showing how the response\'s `Cache-Control` header contains different `max-age` values depending on the Cache Control configuration for the fields in the query: <a href="https://vimeo.com/413503188" target="_blank">vimeo.com/413503188</a>. --\x3e '}}]);