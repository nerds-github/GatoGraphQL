(window.webpackJsonpGraphQLAPIPersistedQueryEndpointOptions=window.webpackJsonpGraphQLAPIPersistedQueryEndpointOptions||[]).push([[2],{47:function(e,t){e.exports='<h1 id="persisted-queries">Persisted Queries</h1> <p>Use GraphQL queries to create pre-defined enpoints as in REST, obtaining the benefits from both APIs.</p> <h2 id="description">Description</h2> <p>With <strong>REST</strong>, you create multiple endpoints, each returning a pre-defined set of data.</p> <table> <thead> <tr> <th>Advantages</th> <th>Disadvantages</th> </tr> </thead> <tbody><tr> <td>✅ It&#39;s simple</td> <td>❌ It&#39;s tedious to create all the endpoints</td> </tr> <tr> <td>✅ Accessed via <code>GET</code> or <code>POST</code></td> <td>❌ A project may face bottlenecks waiting for endpoints to be ready</td> </tr> <tr> <td>✅ Can be cached on the server or CDN</td> <td>❌ Producing documentation is mandatory</td> </tr> <tr> <td>✅ It&#39;s secure: only intended data is exposed</td> <td>❌ It can be slow (mainly for mobile apps), since the application may need several requests to retrieve all the data</td> </tr> </tbody></table> <p>With <strong>GraphQL</strong>, you provide any query to a single endpoint, which returns exactly the requested data.</p> <table> <thead> <tr> <th>Advantages</th> <th>Disadvantages</th> </tr> </thead> <tbody><tr> <td>✅ No under/over fetching of data</td> <td>❌ Accessed only via <code>POST</code></td> </tr> <tr> <td>✅ It can be fast, since all data is retrieved in a single request</td> <td>❌ It can&#39;t be cached on the server or CDN, making it slower and more expensive than it could be</td> </tr> <tr> <td>✅ It enables rapid iteration of the project</td> <td>❌ It may require to reinvent the wheel, such as uploading files or caching</td> </tr> <tr> <td>✅ It can be self-documented</td> <td>❌ Must deal with additional complexities, such as the N+1 problem</td> </tr> <tr> <td>✅ It provides an editor for the query (GraphiQL) that simplifies the task</td> <td>&nbsp;</td> </tr> </tbody></table> <p><strong>Persisted queries</strong> combine these 2 approaches together:</p> <ul> <li>It uses GraphQL to create and resolve queries</li> <li>But instead of exposing a single endpoint, it exposes every pre-defined query under its own endpoint</li> </ul> <p>Hence, we obtain multiple endpoints with predefined data, as in REST, but these are created using GraphQL, obtaining the advantages from each and avoiding their disadvantages:</p> <table> <thead> <tr> <th>Advantages</th> <th>Disadvantages</th> </tr> </thead> <tbody> <tr> <td>✅ Accessed via <code>GET</code> or <code>POST</code></td> <td><s>❌ It\'s tedious to create all the endpoints</s></td> </tr> <tr> <td>✅ Can be cached on the server or CDN</td> <td><s>❌ A project may face bottlenecks waiting for endpoints to be ready</s></td> </tr> <tr> <td>✅ It\'s secure: only intended data is exposed</td> <td><s>❌ Producing documentation is mandatory</s></td> </tr> <tr> <td>✅ No under/over fetching of data</td> <td><s>❌ It can be slow (mainly for mobile apps), since the application may need several requests to retrieve all the data</s></td> </tr> <tr> <td>✅ It can be fast, since all data is retrieved in a single request</td> <td><s>❌ Accessed only via <code>POST</code></s></td> </tr> <tr> <td>✅ It enables rapid iteration of the project</td> <td><s>❌ It can\'t be cached on the server or CDN, making it slower and more expensive than it could be</s></td> </tr> <tr> <td>✅ It can be self-documented</td> <td><s>❌ It may require to reinvent the wheel , such asuploading files or caching</s></td> </tr> <tr> <td>✅ It provides an editor for the query (GraphiQL) that simplifies the task</td> <td><s>❌ Must deal with additional complexities, such as the N+1 problem</s> 👈🏻 this issue is [resolved by the underlying engine](https://graphql-by-pop.com/docs/architecture/suppressing-n-plus-one-problem.html)</td> </tr> </tbody> </table> <h2 id="how-to-use">How to use</h2> <p>Clicking on the Persisted Queries link in the menu, it displays the list of all the created persisted queries:</p> <p><img src="https://raw.githubusercontent.com/GraphQLAPI/graphql-api-for-wp/master/docs/modules/persisted-queries/../../images/persisted-queries-page.png" alt="Persisted Queries in the admin"></p> <p>A persisted query is a custom post type (CPT). To create a new persisted query, click on button &quot;Add New GraphQL persisted query&quot;, which will open the WordPress editor:</p> <p><img src="https://raw.githubusercontent.com/GraphQLAPI/graphql-api-for-wp/master/docs/modules/persisted-queries/../../images/new-persisted-query.png" alt="Creating a new Persisted Query"></p> <p>The main input is the GraphiQL client, which comes with the Explorer by default. Clicking on the fields on the left side panel adds them to the query, and clicking on the &quot;Run&quot; button executes the query:</p> <p><img src="https://raw.githubusercontent.com/GraphQLAPI/graphql-api-for-wp/master/docs/modules/persisted-queries/../../images/graphiql-explorer.gif" alt="Writing and executing a persisted query"></p> <p>When the query is ready, publish it, and its permalink becomes its endpoint:</p> <p><img src="https://raw.githubusercontent.com/GraphQLAPI/graphql-api-for-wp/master/docs/modules/persisted-queries/../../images/publishing-persisted-query.gif" alt="Publishing the persisted query"></p> <p>Appending <code>?view=source</code> to the permalink, it will show the persisted query and its configuration (as long as the user has access to it):</p> <p><img src="https://raw.githubusercontent.com/GraphQLAPI/graphql-api-for-wp/master/docs/modules/persisted-queries/../../images/persisted-query-source.png" alt="Persisted query source"></p> <p>By default, the persisted query&#39;s endpoint has path <code>/graphql-query/</code>, and this value is configurable through the Settings:</p> <p><img src="https://raw.githubusercontent.com/GraphQLAPI/graphql-api-for-wp/master/docs/modules/persisted-queries/../../images/settings-persisted-queries.png" alt="Persisted query Settings"></p> <h2 id="editor-inputs">Editor Inputs</h2> <p>These inputs in the body of the editor are shipped with the plugin (more inputs can be added by extensions):</p> <table> <thead> <tr> <th>Input</th> <th>Description</th> </tr> </thead> <tbody> <tr> <td><strong>Title</strong></td> <td>Persisted query\'s title</td> </tr> <tr> <td><strong>GraphiQL client</strong></td> <td>Editor to write and execute the GraphQL query: <ul><li>Write the query on the textarea</li><li>Declare variables inside the query, and declare their values on the variables input at the bottom</li><li>Click on the "Run" button to execute the query</li><li>Obtain the results on the input on the right side</li><li>Click on "Docs" to inspect the schema information</li></ul>The Explorer (shown only if module <code>GraphiQL Explorer</code> is enabled) allows to click on the fields, and these are automatically added to the query</td> </tr> <tr> <td><strong>Schema configuration</strong></td> <td>From the dropdown, select the schema configuration that applies to the persisted query, or one of these options: <ul><li><code>"Default"</code>: the schema configuration is the one selected on the plugin\'s Settings</li><li><code>"None"</code>: the persisted query will be unconstrained</li><li><code>"Inherit from parent"</code>: Use the same schema configuration as the parent persisted query.<br/>This option is available when module <code>API Hierarchy</code> is enabled, and the persisted query has a parent query (selected on the Document settings)</li></ul></td> </tr> <tr> <td><strong>Options</strong></td> <td>Customize the behavior of the persisted query: <ul><li><strong>Enabled?:</strong> If the persisted query is enabled.<br/>It\'s useful to disable a persisted query it\'s a parent query in an API hierarchy</li><li><strong>Accept variables as URL params?:</strong> Allow URL params to override the values for variables defined in the GraphiQL client</li></ul></td> </tr> <tr> <td><strong>API Hierarchy:</strong></td> <td>Use the same query as the parent persisted query.<br/>This option is available when the persisted query has a parent query (selected on the Document settings)</td> </tr> </tbody> </table> <p>These are the inputs in the Document settings:</p> <table> <thead> <tr> <th>Input</th> <th>Description</th> </tr> </thead> <tbody><tr> <td><strong>Permalink</strong></td> <td>The endpoint under which the persisted query will be available</td> </tr> <tr> <td><strong>Categories</strong></td> <td>Can categorize the persisted query.<br/>Eg: <code>mobile</code>, <code>app</code>, etc</td> </tr> <tr> <td><strong>Excerpt</strong></td> <td>Provide a description for the persisted query.<br/>This input is available when module <code>Excerpt as Description</code> is enabled</td> </tr> <tr> <td><strong>Page attributes</strong></td> <td>Select a parent persisted query.<br/>This input is available when module <code>API Hierarchy</code> is enabled</td> </tr> </tbody></table> \x3c!-- ## Settings\n\n| Option | Description | \n| --- | --- |\n| **Base path** | The base path for the custom endpoint URL. It defaults to `graphql-query` | --\x3e <h2 id="resources">Resources</h2> <p>Video showing how to create a persisted query: <a href="https://vimeo.com/443790273" target="_blank">vimeo.com/443790273</a>.</p> '}}]);