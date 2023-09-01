(window.webpackJsonpGatoGraphQLSchemaConfigurationAdditionalDocumentation=window.webpackJsonpGatoGraphQLSchemaConfigurationAdditionalDocumentation||[]).push([[3],{53:function(s,a){s.exports='<h1 id="dynamic-variables">Dynamic Variables</h1> <p>Read the value of a variable that was created and had its value assigned dynamically, when resolving the GraphQL query</p> <h2 id="description">Description</h2> <p>The behavior of variables in GraphQL (as <a href="https://spec.graphql.org/draft/#sec-Language.Variables">defined in the spec</a>) is &quot;static&quot;: the variable name and type must be declared in the declaration of the operation, and its value is provided via a &quot;variables dictionary&quot; in the payload of the GraphQL request.</p> <p>For instance, in this query, we define variable <code>$postID</code> with type <code>ID</code>:</p> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-keyword">query</span> GetPost<span class="hljs-punctuation">(</span><span class="hljs-variable">$postID</span>: ID<span class="hljs-punctuation">!</span><span class="hljs-punctuation">)</span> <span class="hljs-punctuation">{</span>\n  post<span class="hljs-punctuation">(</span><span class="hljs-symbol">id</span><span class="hljs-punctuation">:</span> <span class="hljs-variable">$postID</span>) <span class="hljs-punctuation">{</span>\n    title\n    content\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <p>When sending the GraphQL request to the server, we must also provide the variable&#39;s value:</p> <pre><code class="hljs language-json"><span class="hljs"><span class="hljs-punctuation">{</span>\n  <span class="hljs-attr">&quot;postID&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-number">1</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <p>&quot;Dynamic&quot; variables are different than &quot;static&quot; variables in that they do not need be defined in advance, but can be created on runtime, assigning a value from some resolved field in the same GraphQL query.</p> <p>For instance, in the query below, every users has a meta value <code>&quot;preferred-date-format&quot;</code>. We can retrieve this value for the logged in user, export it under dynamic variable <code>$userPreferredDateFormat</code>, and then inject this variable into another field, <code>Post.dateStr</code>. Please notice how variable <code>$userPreferredDateFormat</code> does not need be defined in the operation <code>GetCustomizedPosts</code>, and its value is not provided in advance:</p> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-keyword">query</span> ExportLoggedInUserPreferredDateFormat <span class="hljs-punctuation">{</span>\n  me <span class="hljs-punctuation">{</span>\n    metaValue<span class="hljs-punctuation">(</span><span class="hljs-symbol">key</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;preferred-date-format&quot;</span><span class="hljs-punctuation">)</span>\n      <span class="hljs-meta">@export</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">as</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;userPreferredDateFormat&quot;</span><span class="hljs-punctuation">)</span>\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span>\n\n<span class="hljs-keyword">query</span> GetCustomizedPosts <span class="hljs-punctuation">{</span>\n  posts <span class="hljs-punctuation">{</span>\n    id\n    title\n    dateStr<span class="hljs-punctuation">(</span><span class="hljs-symbol">format</span><span class="hljs-punctuation">:</span> <span class="hljs-variable">$userPreferredDateFormat</span>)\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <p>Having support for dynamc variables gives us several benefits, including:</p> <ul> <li>Increased performance via the <strong>Multiple Query Execution</strong> extension: Execute a first query, export its field value(s) via some dynamic variables, and input these into a second query which will be executed immediately, already on the same request</li> <li>Field value manipulation: By exporting the value from a field as a dynamic variable, it can be input into a &quot;function field&quot; (<code>_sprintf</code>, <code>_strSubstr</code>, <code>_not</code>, and many others; check the <strong>PHP Functions via Schema</strong> extension), thus manipulating the field in the server before sending it back in the reponse</li> </ul> <h2 id="further-examples">Further examples</h2> <p>In the query below, dynamic variables are created on the first and second operations, and consumed in a third operation, thanks to <strong>Multiple Query Execution</strong>.</p> <p>We first export the admin&#39;s name and email as stored in <code>wp_options</code>, then export the logged-in user&#39;s email, and finally consume these dynamic variables to compose and send an email:</p> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-keyword">query</span> ExportAdminNameAndEmail <span class="hljs-punctuation">{</span>\n  <span class="hljs-symbol">adminName</span><span class="hljs-punctuation">:</span> optionValue<span class="hljs-punctuation">(</span><span class="hljs-symbol">name</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;admin_name&quot;</span><span class="hljs-punctuation">)</span>\n    <span class="hljs-meta">@export</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">as</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;adminName&quot;</span><span class="hljs-punctuation">)</span>\n\n  <span class="hljs-symbol">adminEmail</span><span class="hljs-punctuation">:</span> optionValue<span class="hljs-punctuation">(</span><span class="hljs-symbol">name</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;admin_email&quot;</span><span class="hljs-punctuation">)</span>\n    <span class="hljs-meta">@export</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">as</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;adminEmail&quot;</span><span class="hljs-punctuation">)</span>\n<span class="hljs-punctuation">}</span>\n\n<span class="hljs-keyword">query</span> ExportLoggedInUserEmail <span class="hljs-punctuation">{</span>\n  me <span class="hljs-punctuation">{</span>\n    email\n      <span class="hljs-meta">@export</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">as</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;userEmail&quot;</span><span class="hljs-punctuation">)</span>\n  <span class="hljs-punctuation">}</span>    \n<span class="hljs-punctuation">}</span>\n\n<span class="hljs-keyword">mutation</span> SendWelcomeEmailToLoggedInUser <span class="hljs-punctuation">{</span>\n  _sendEmail<span class="hljs-punctuation">(</span>\n    <span class="hljs-symbol">from</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n      <span class="hljs-symbol">name</span><span class="hljs-punctuation">:</span> <span class="hljs-variable">$adminName</span>\n      <span class="hljs-symbol">email</span><span class="hljs-punctuation">:</span> <span class="hljs-variable">$adminEmail</span>\n    <span class="hljs-punctuation">}</span>\n    <span class="hljs-symbol">to</span><span class="hljs-punctuation">:</span> <span class="hljs-variable">$userEmail</span>\n    <span class="hljs-symbol">messageAs</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n      <span class="hljs-symbol">text</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;Thanks for creating an account on our site!&quot;</span>\n    <span class="hljs-punctuation">}</span>\n  <span class="hljs-punctuation">)</span> <span class="hljs-punctuation">{</span>\n    status\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <p>In the query below, the dynamic variable is created and consumed in the same operation (and also within the resolution of a single field) to have the posts&#39; titles shortened to not more than 150 chars.</p> <p>To achieve this, the value of the field is exported to dynamic variable <code>$postTitle</code> (thanks to the <strong>Pass Onwards Directive</strong>), and this value is input to the <strong>Function Field</strong> <code>_strSubstr</code> (thanks to the <strong>Apply Field Directive</strong>):</p> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-punctuation">{</span>\n  posts <span class="hljs-punctuation">{</span>\n    id\n    <span class="hljs-symbol">shortenedTitle</span><span class="hljs-punctuation">:</span> title\n      <span class="hljs-meta">@passOnwards</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">as</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;postTitle&quot;</span><span class="hljs-punctuation">)</span>\n      <span class="hljs-meta">@applyField</span><span class="hljs-punctuation">(</span>\n        <span class="hljs-symbol">name</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;_strSubstr&quot;</span>\n        <span class="hljs-symbol">arguments</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n          <span class="hljs-symbol">string</span><span class="hljs-punctuation">:</span> <span class="hljs-variable">$postTitle</span>\n          <span class="hljs-symbol">offset</span><span class="hljs-punctuation">:</span> <span class="hljs-number">0</span>\n          <span class="hljs-symbol">length</span><span class="hljs-punctuation">:</span> <span class="hljs-number">150</span>\n        <span class="hljs-punctuation">}</span>,\n        <span class="hljs-symbol">setResultInResponse</span><span class="hljs-punctuation">:</span> <span class="hljs-literal">true</span>\n      <span class="hljs-punctuation">)</span>\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <h2 id="graphql-spec">GraphQL spec</h2> <p>This functionality is currently not part of the GraphQL spec, but it has been requested:</p> <ul> <li><a href="https://github.com/graphql/graphql-spec/issues/583">Issue #583 - [RFC] Dynamic variable declaration</a></li> </ul> '}}]);