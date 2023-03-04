(window.webpackJsonpGraphQLAPISchemaConfigurationAdditionalDocumentation=window.webpackJsonpGraphQLAPISchemaConfigurationAdditionalDocumentation||[]).push([[27],{73:function(s,a){s.exports='<h1 id="multiple-query-execution">Multiple Query Execution</h1> <p>Multiple queries are combined together, and executed as a single operation, reusing their state and their data. For instance, if a first query fetches some data, and a second query also accesses the same data, this data is retrieved only once, not twice.</p> <p>This feature improves performance, for whenever we need to execute an operation against the GraphQL server, then wait for its response, and then use that result to perform another operation. By combining them together, we are avoiding the latency from the extra request(s).</p> <h2 id="description">Description</h2> <p>Multiple query execution combines the multiple queries into a single query, making sure they are executed in the same requested order.</p> <p><img src="https://raw.githubusercontent.com/leoloso/PoP/master/layers/GraphQLAPIForWP/plugins/graphql-api-for-wp/docs/implicit-features//../../images/executing-multiple-queries.gif" alt="Executing queries independently, and then all together as a single operation" title="Executing queries independently, and then all together as a single operation"></p> <p>This is different from query batching, in which the GraphQL server also executes multiple queries in a single request, but those queries are merely executed one after the other, independently from each other.</p> <p>When this feature is enabled, two directives are made available in the GraphQL schema:</p> <ul> <li><code>@depends</code> operation directive, to have an operation (whether a <code>query</code> or <code>mutation</code>) indicate what other operations must be executed before</li> <li><code>@export</code> field directive, to export some field value from one query, to inject it as an input to some field in another query</li> </ul> \x3c!-- ## When to use\n\nLet\'s suppose we want to search all posts which mention the name of the logged-in user. Normally, we would need 2 queries to accomplish this:\n\nWe first retrieve the user\'s `name`:\n\n```graphql\nquery GetLoggedInUserName {\n  me {\n    name\n  }\n}\n```\n\n...and then, having executed the first query, we can pass the retrieved user\'s `name` as variable `$search` to perform the search in a second query:\n\n```graphql\nquery GetPostsContainingString($search: String = "") {\n  posts(filter: { search: $search }) {\n    id\n    title\n  }\n}\n```\n\nThe `@export` directive exports the value from a field, and inject this value into a second field through a dynamic variable (whose name is defined under argument `as`), thus combining the 2 queries into 1:\n\n```graphql\nquery GetLoggedInUserName {\n  me {\n    name @export(as: "search")\n  }\n}\n\nquery GetPostsContainingString @depends(on: "GetLoggedInUserName") {\n  posts(filter: { search: $search }) {\n    id\n    title\n  }\n}\n``` --\x3e <h2 id="depends"><code>@depends</code></h2> <p>When the GraphQL Document contains multiple operations, we must provide URL param <code>?operationName=</code> to indicate the server which one to execute.</p> <p>Starting from this initial operation, the server will collect all operations to execute, which are defined by adding directive <code>depends(on: [...])</code>, and execute them in the corresponding order respecting the dependencies.</p> <p>Directive arg <code>operations</code> receives an array of operation names (<code>[String]</code>), or we can also provide a single operation name (<code>String</code>).</p> <p>In this query, we pass <code>?operationName=Four</code>, and the executed operations (whether <code>query</code> or <code>mutation</code>) will be <code>[&quot;One&quot;, &quot;Two&quot;, &quot;Three&quot;, &quot;Four&quot;]</code>:</p> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-keyword">mutation</span> One <span class="hljs-punctuation">{</span>\n  <span class="hljs-comment"># Do something ...</span>\n<span class="hljs-punctuation">}</span>\n\n<span class="hljs-keyword">mutation</span> Two <span class="hljs-punctuation">{</span>\n  <span class="hljs-comment"># Do something ...</span>\n<span class="hljs-punctuation">}</span>\n\n<span class="hljs-keyword">query</span> Three <span class="hljs-meta">@depends</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">on</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">[</span><span class="hljs-string">&quot;One&quot;</span>, <span class="hljs-string">&quot;Two&quot;</span><span class="hljs-punctuation">]</span><span class="hljs-punctuation">)</span> <span class="hljs-punctuation">{</span>\n  <span class="hljs-comment"># Do something ...</span>\n<span class="hljs-punctuation">}</span>\n\n<span class="hljs-keyword">query</span> Four <span class="hljs-meta">@depends</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">on</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;Three&quot;</span><span class="hljs-punctuation">)</span> <span class="hljs-punctuation">{</span>\n  <span class="hljs-comment"># Do something ...</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <h2 id="export"><code>@export</code></h2> <p>Directive <code>@export</code> exports the value of a field (or set of fields) into a dynamic variable, to be used as input in some field from another query.</p> <p>For instance, in this query we export the logged-in user&#39;s name, and use this value to search for posts containing this string (please notice that variable <code>$loggedInUserName</code>, because it is dynamic, does not need be defined in operation <code>FindPosts</code>):</p> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-keyword">query</span> GetLoggedInUserName <span class="hljs-punctuation">{</span>\n  loggedInUser <span class="hljs-punctuation">{</span>\n    name <span class="hljs-meta">@export</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">as</span><span class="hljs-punctuation">:</span> <span class="hljs-variable">$loggedInUserName</span>)\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span>\n\n<span class="hljs-keyword">query</span> FindPosts <span class="hljs-meta">@depends</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">on</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;GetLoggedInUserName&quot;</span><span class="hljs-punctuation">)</span> <span class="hljs-punctuation">{</span>\n  posts<span class="hljs-punctuation">(</span><span class="hljs-symbol">filter</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span> <span class="hljs-symbol">search</span><span class="hljs-punctuation">:</span> <span class="hljs-variable">$loggedInUserName</span> <span class="hljs-punctuation">}</span><span class="hljs-punctuation">)</span> <span class="hljs-punctuation">{</span>\n    id\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <h3 id="exportable-data">Exportable data</h3> <p><code>@export</code> handles these 2 cases:</p> <ol> <li>Exporting a single value from a single field</li> <li>Exporting a list of values from a single field</li> </ol> <p>In addition, when the <strong>Multi-Field Directives</strong> feature is enabled, <code>@export</code> handles 2 additional cases:</p> <ol start="3"> <li>Exporting a dictionary of values, containing several fields from the same object</li> <li>Exporting a list of a dictionary of values, with each dictionary containing several fields from the same object</li> </ol> <h4 id="1-exporting-a-single-value-from-a-single-field">1. Exporting a single value from a single field</h4> <p><code>@export</code> must handle exporting a single value from a single field, such as the user&#39;s <code>name</code> in this query:</p> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-keyword">query</span> GetLoggedInUserName <span class="hljs-punctuation">{</span>\n  me <span class="hljs-punctuation">{</span>\n    name <span class="hljs-meta">@export</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">as</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;search&quot;</span><span class="hljs-punctuation">)</span>\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span>\n\n<span class="hljs-keyword">query</span> GetPostsContainingString <span class="hljs-meta">@depends</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">on</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;GetLoggedInUserName&quot;</span><span class="hljs-punctuation">)</span> <span class="hljs-punctuation">{</span>\n  posts<span class="hljs-punctuation">(</span><span class="hljs-symbol">filter</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span> <span class="hljs-symbol">search</span><span class="hljs-punctuation">:</span> <span class="hljs-variable">$search</span> <span class="hljs-punctuation">}</span><span class="hljs-punctuation">)</span> <span class="hljs-punctuation">{</span>\n    id\n    title\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <h4 id="2-exporting-a-list-of-values-from-a-single-field">2. Exporting a list of values from a single field</h4> <p>Fields returning lists should also be exportable. For instance, in the query below, the exported value is the list of names from the logged-in user&#39;s friends (hence the type of the <code>$search</code> variable went from <code>String</code> to <code>[String]</code>):</p> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-keyword">query</span> GetLoggedInUserFriendNames <span class="hljs-punctuation">{</span>\n  me <span class="hljs-punctuation">{</span>\n    friends <span class="hljs-punctuation">{</span>\n      name <span class="hljs-meta">@export</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">as</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;search&quot;</span><span class="hljs-punctuation">)</span>\n    <span class="hljs-punctuation">}</span>\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span>\n\n<span class="hljs-keyword">query</span> GetPostsContainingLoggedInUserFriendNames <span class="hljs-meta">@depends</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">on</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;GetLoggedInUserFriendNames&quot;</span><span class="hljs-punctuation">)</span> <span class="hljs-punctuation">{</span>\n  posts<span class="hljs-punctuation">(</span><span class="hljs-symbol">filter</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span> <span class="hljs-symbol">searchAny</span><span class="hljs-punctuation">:</span> <span class="hljs-variable">$search</span> <span class="hljs-punctuation">}</span><span class="hljs-punctuation">)</span> <span class="hljs-punctuation">{</span>\n    id\n    title\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <h4 id="3-exporting-a-dictionary-of-values-containing-several-fields-from-the-same-object">3. Exporting a dictionary of values, containing several fields from the same object</h4> <p>We may also need to export several properties from a same object. Then, <code>@export</code> also allows to export these properties to the same variable, as a dictionary of values.</p> <p>For instance, the query could export both the <code>name</code> and <code>surname</code> fields from the user, and have a <code>searchByAnyProperty</code> input that receives a dictionary. This is done by appending the <code>affectAdditionalFieldsUnderPos</code> directive argument (see the documentation for <strong>Multi-Field Directives</strong>) pointing to the extra field(s):</p> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-keyword">query</span> GetLoggedInUserNameAndSurname <span class="hljs-punctuation">{</span>\n  me <span class="hljs-punctuation">{</span>\n    name\n    surname\n      <span class="hljs-meta">@export</span><span class="hljs-punctuation">(</span>\n        <span class="hljs-symbol">as</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;search&quot;</span>\n        <span class="hljs-symbol">affectAdditionalFieldsUnderPos</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">[</span><span class="hljs-number">1</span><span class="hljs-punctuation">]</span>\n      <span class="hljs-punctuation">)</span>\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span>\n\n<span class="hljs-keyword">query</span> GetPostsContainingLoggedInUserNameAndSurname <span class="hljs-meta">@depends</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">on</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;GetLoggedInUserNameAndSurname&quot;</span><span class="hljs-punctuation">)</span> <span class="hljs-punctuation">{</span>\n  posts<span class="hljs-punctuation">(</span><span class="hljs-symbol">filter</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span> <span class="hljs-symbol">searchByAnyProperty</span><span class="hljs-punctuation">:</span> <span class="hljs-variable">$search</span> <span class="hljs-punctuation">}</span><span class="hljs-punctuation">)</span> <span class="hljs-punctuation">{</span>\n    id\n    title\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <h4 id="4-exporting-a-list-of-a-dictionary-of-values-with-each-dictionary-containing-several-fields-from-the-same-object">4. Exporting a list of a dictionary of values, with each dictionary containing several fields from the same object</h4> <p>Similar to upgrading from a single value to a list of values, we can upgrade from a single dictionary to a list of dictionaries.</p> <p>For instance, we could export fields <code>name</code> and <code>surname</code> from the list of the logged-in user&#39;s friends:</p> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-keyword">query</span> GetLoggedInUserFriendNamesAndSurnames <span class="hljs-punctuation">{</span>\n  me <span class="hljs-punctuation">{</span>\n    friends <span class="hljs-punctuation">{</span>\n      name\n      surname\n        <span class="hljs-meta">@export</span><span class="hljs-punctuation">(</span>\n          <span class="hljs-symbol">as</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;search&quot;</span>\n          <span class="hljs-symbol">affectAdditionalFieldsUnderPos</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">[</span><span class="hljs-number">1</span><span class="hljs-punctuation">]</span>\n        <span class="hljs-punctuation">)</span>\n    <span class="hljs-punctuation">}</span>\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span>\n\n<span class="hljs-keyword">query</span> GetPostsContainingLoggedInUserFriendNamesAndSurnames <span class="hljs-meta">@depends</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">on</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;GetLoggedInUserFriendNamesAndSurnames&quot;</span><span class="hljs-punctuation">)</span> <span class="hljs-punctuation">{</span>\n  posts<span class="hljs-punctuation">(</span><span class="hljs-symbol">filter</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span> <span class="hljs-symbol">searchAnyByAnyProperty</span><span class="hljs-punctuation">:</span> <span class="hljs-variable">$search</span> <span class="hljs-punctuation">}</span><span class="hljs-punctuation">)</span> <span class="hljs-punctuation">{</span>\n    id\n    title\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <h2 id="conditional-execution-of-operations">Conditional execution of operations</h2> <p>When Multiple Query Execution is enabled, directives <code>@include</code> and <code>@skip</code> are also available as operation directives, and these can be use to conditionally execute an operation if it satisfies some condition.</p> <p>For instance, in this query, operation <code>CheckIfPostExists</code> exports a dynamic variable <code>$postExists</code> and, only if its value is <code>true</code>, will mutation <code>ExecuteOnlyIfPostExists</code> be executed:</p> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-keyword">query</span> CheckIfPostExists<span class="hljs-punctuation">(</span><span class="hljs-variable">$id</span>: ID<span class="hljs-punctuation">!</span><span class="hljs-punctuation">)</span> <span class="hljs-punctuation">{</span>\n  <span class="hljs-comment"># Initialize the dynamic variable to `false`</span>\n  <span class="hljs-symbol">postExists</span><span class="hljs-punctuation">:</span> _echo<span class="hljs-punctuation">(</span><span class="hljs-symbol">value</span><span class="hljs-punctuation">:</span> <span class="hljs-literal">false</span><span class="hljs-punctuation">)</span> <span class="hljs-meta">@export</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">as</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;postExists&quot;</span><span class="hljs-punctuation">)</span>\n\n  post<span class="hljs-punctuation">(</span><span class="hljs-symbol">by</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span> <span class="hljs-symbol">id</span><span class="hljs-punctuation">:</span> <span class="hljs-variable">$id</span> <span class="hljs-punctuation">}</span><span class="hljs-punctuation">)</span> <span class="hljs-punctuation">{</span>\n    <span class="hljs-comment"># Found the Post =&gt; Set dynamic variable to `true`</span>\n    <span class="hljs-symbol">postExists</span><span class="hljs-punctuation">:</span> _echo<span class="hljs-punctuation">(</span><span class="hljs-symbol">value</span><span class="hljs-punctuation">:</span> <span class="hljs-literal">true</span><span class="hljs-punctuation">)</span> <span class="hljs-meta">@export</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">as</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;postExists&quot;</span><span class="hljs-punctuation">)</span>\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span>\n\n<span class="hljs-keyword">mutation</span> ExecuteOnlyIfPostExists\n  <span class="hljs-meta">@depends</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">on</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;CheckIfPostExists&quot;</span><span class="hljs-punctuation">)</span>\n  <span class="hljs-meta">@include</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">if</span><span class="hljs-punctuation">:</span> <span class="hljs-variable">$postExists</span>)\n<span class="hljs-punctuation">{</span>\n  <span class="hljs-comment"># Do something...</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <h2 id="directive-execution-order">Directive execution order</h2> <p>If there are other directives before <code>@export</code>, the exported value will reflect the modifications by those previous directives.</p> <p>For instance, in this query, depending on <code>@export</code> taking place before or after <code>@strUpperCase</code>, the result will be different:</p> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-keyword">query</span> One <span class="hljs-punctuation">{</span>\n  id\n    <span class="hljs-comment"># First export &quot;root&quot;, only then will be converted to &quot;ROOT&quot;</span>\n    <span class="hljs-meta">@export</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">as</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;id&quot;</span><span class="hljs-punctuation">)</span>\n    <span class="hljs-meta">@strUpperCase</span>\n\n  <span class="hljs-symbol">again</span><span class="hljs-punctuation">:</span> id\n    <span class="hljs-comment"># First convert to &quot;ROOT&quot; and then export this value</span>\n    <span class="hljs-meta">@strUpperCase</span>\n    <span class="hljs-meta">@export</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">as</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;again&quot;</span><span class="hljs-punctuation">)</span>\n<span class="hljs-punctuation">}</span>\n\n<span class="hljs-keyword">query</span> Two <span class="hljs-meta">@depends</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">on</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;One&quot;</span><span class="hljs-punctuation">)</span> <span class="hljs-punctuation">{</span>\n  <span class="hljs-symbol">mirrorID</span><span class="hljs-punctuation">:</span> _echo<span class="hljs-punctuation">(</span><span class="hljs-symbol">value</span><span class="hljs-punctuation">:</span> <span class="hljs-variable">$id</span>)\n  <span class="hljs-symbol">mirrorAgain</span><span class="hljs-punctuation">:</span> _echo<span class="hljs-punctuation">(</span><span class="hljs-symbol">value</span><span class="hljs-punctuation">:</span> <span class="hljs-variable">$again</span>)\n<span class="hljs-punctuation">}</span></span></code></pre> <p>Producing:</p> <pre><code class="hljs language-json"><span class="hljs"><span class="hljs-punctuation">{</span>\n  <span class="hljs-attr">&quot;data&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n    <span class="hljs-attr">&quot;id&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;ROOT&quot;</span><span class="hljs-punctuation">,</span>\n    <span class="hljs-attr">&quot;again&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;ROOT&quot;</span><span class="hljs-punctuation">,</span>\n    <span class="hljs-attr">&quot;mirrorID&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;root&quot;</span><span class="hljs-punctuation">,</span>\n    <span class="hljs-attr">&quot;mirrorAgain&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;ROOT&quot;</span>\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <h2 id="multi-field-directives">Multi-Field Directives</h2> <p>When the <strong>Multi-Field Directives</strong> feature is enabled and we export the value of multiple fields into a dictionary, use <code>@deferredExport</code> instead of <code>@export</code> to guarantee that all directives from each involved field have been executed before exporting the field&#39;s value.</p> <p>For instance, in this query, the first field has directive <code>@strUpperCase</code> applied to it, and the second has <code>@strTitleCase</code>. When executing <code>@deferredExport</code>, the exported value will have these directives applied:</p> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-keyword">query</span> One <span class="hljs-punctuation">{</span>\n  id <span class="hljs-meta">@strUpperCase</span> <span class="hljs-comment"># Will be exported as &quot;ROOT&quot;</span>\n  <span class="hljs-symbol">again</span><span class="hljs-punctuation">:</span> id <span class="hljs-meta">@strTitleCase</span> <span class="hljs-comment"># Will be exported as &quot;Root&quot;</span>\n    <span class="hljs-meta">@deferredExport</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">as</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;props&quot;</span>, <span class="hljs-symbol">affectAdditionalFieldsUnderPos</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">[</span><span class="hljs-number">1</span><span class="hljs-punctuation">]</span><span class="hljs-punctuation">)</span>\n<span class="hljs-punctuation">}</span>\n\n<span class="hljs-keyword">query</span> Two <span class="hljs-meta">@depends</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">on</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;One&quot;</span><span class="hljs-punctuation">)</span> <span class="hljs-punctuation">{</span>\n  <span class="hljs-symbol">mirrorProps</span><span class="hljs-punctuation">:</span> _echo<span class="hljs-punctuation">(</span><span class="hljs-symbol">value</span><span class="hljs-punctuation">:</span> <span class="hljs-variable">$props</span>)\n<span class="hljs-punctuation">}</span></span></code></pre> <p>Producing:</p> <pre><code class="hljs language-json"><span class="hljs"><span class="hljs-punctuation">{</span>\n  <span class="hljs-attr">&quot;data&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n    <span class="hljs-attr">&quot;id&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;ROOT&quot;</span><span class="hljs-punctuation">,</span>\n    <span class="hljs-attr">&quot;again&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;Root&quot;</span><span class="hljs-punctuation">,</span>\n    <span class="hljs-attr">&quot;mirrorProps&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n      <span class="hljs-attr">&quot;id&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;ROOT&quot;</span><span class="hljs-punctuation">,</span>\n      <span class="hljs-attr">&quot;again&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;Root&quot;</span>\n    <span class="hljs-punctuation">}</span>\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <h2 id="execution-in-persisted-queries">Execution in Persisted Queries</h2> <p>When a GraphQL query contains multiple operations in a Persisted Query, we must invoke the corresponding endpoint passing URL param <code>?operationName=...</code> with the name of the first operation to execute.</p> <p>For instance, to execute operation <code>GetPostsContainingString</code> in a Persisted Query with endpoint <code>/graphql-query/posts-with-user-name/</code>, we must invoke: <code>https://www.mysite.com/graphql-query/posts-with-user-name/?operationName=GetPostsContainingString</code>.</p> <h2 id="examples">Examples</h2> <p>Import content from an external API endpoint:</p> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-keyword">query</span> FetchDataFromExternalEndpoint\n<span class="hljs-punctuation">{</span>\n  _requestJSONObjectItem<span class="hljs-punctuation">(</span><span class="hljs-symbol">input</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span> <span class="hljs-symbol">url</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;https://site.com/wp-json/wp/posts/1&quot;</span> <span class="hljs-punctuation">}</span> <span class="hljs-punctuation">)</span>\n    <span class="hljs-meta">@export</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">as</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;externalData&quot;</span><span class="hljs-punctuation">)</span>\n    <span class="hljs-meta">@remove</span>\n<span class="hljs-punctuation">}</span>\n\n<span class="hljs-keyword">query</span> ManipulateDataIntoInput <span class="hljs-meta">@depends</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">on</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;FetchDataFromExternalEndpoint&quot;</span><span class="hljs-punctuation">)</span>\n<span class="hljs-punctuation">{</span>\n  <span class="hljs-symbol">title</span><span class="hljs-punctuation">:</span> _objectProperty<span class="hljs-punctuation">(</span>\n    <span class="hljs-symbol">object</span><span class="hljs-punctuation">:</span> <span class="hljs-variable">$externalData</span>,\n    <span class="hljs-symbol">by</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n      <span class="hljs-symbol">path</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;title.rendered&quot;</span>\n    <span class="hljs-punctuation">}</span>\n  <span class="hljs-punctuation">)</span> <span class="hljs-meta">@export</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">as</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;postTitle&quot;</span><span class="hljs-punctuation">)</span>\n\n  <span class="hljs-symbol">excerpt</span><span class="hljs-punctuation">:</span> _objectProperty<span class="hljs-punctuation">(</span>\n    <span class="hljs-symbol">object</span><span class="hljs-punctuation">:</span> <span class="hljs-variable">$externalData</span>,\n    <span class="hljs-symbol">by</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n      <span class="hljs-symbol">key</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;excerpt&quot;</span>\n    <span class="hljs-punctuation">}</span>\n  <span class="hljs-punctuation">)</span> <span class="hljs-meta">@export</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">as</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;postExcerpt&quot;</span><span class="hljs-punctuation">)</span>\n<span class="hljs-punctuation">}</span>\n\n<span class="hljs-keyword">mutation</span> CreatePost <span class="hljs-meta">@depends</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">on</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;ManipulateDataIntoInput&quot;</span><span class="hljs-punctuation">)</span>\n<span class="hljs-punctuation">{</span>\n  createPost<span class="hljs-punctuation">(</span><span class="hljs-symbol">input</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n    <span class="hljs-symbol">title</span><span class="hljs-punctuation">:</span> <span class="hljs-variable">$postTitle</span>\n    <span class="hljs-symbol">excerpt</span><span class="hljs-punctuation">:</span> <span class="hljs-variable">$postExcerpt</span>\n  <span class="hljs-punctuation">}</span><span class="hljs-punctuation">)</span> <span class="hljs-punctuation">{</span>\n    id\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <h2 id="graphql-spec">GraphQL spec</h2> <p>This functionality is currently not part of the GraphQL spec, but it has been requested:</p> <ul> <li><a href="https://github.com/graphql/graphql-spec/issues/375" target="_blank">Issue #375 - [RFC] Executing multiple operations in a query</a></li> <li><a href="https://github.com/graphql/graphql-spec/issues/377" target="_blank">Issue #377 - [RFC] exporting variables between queries</a></li> </ul> '}}]);