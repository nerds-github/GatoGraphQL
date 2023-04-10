(window.webpackJsonpGraphQLAPISchemaConfigurationAdditionalDocumentation=window.webpackJsonpGraphQLAPISchemaConfigurationAdditionalDocumentation||[]).push([[18],{64:function(s,n){s.exports='<h1 id="environment-fields">Environment Fields</h1> <p>Query the value from an environment variable or PHP constant.</p> <h2 id="description">Description</h2> <p>This module adds global field <code>_env</code> to the GraphQL schema, which allows to obtain a value from an environment variable, or from a PHP constant (most commonly defined in <code>wp-config.php</code>, but can also be defined elsewhere).</p> <p>Due to security reasons, the name of the environment variable and constants that can be accessed must be explicitly configured (explained in the next section).</p> <p>Field <code>_env</code> receives the name of the environment variable or constant under parameter <code>&quot;name&quot;</code>, and is resolved like this:</p> <ul> <li>If there is an environment variable with that name, it returns it</li> <li>Otherwise, if there is a constant with that name, it returns it</li> <li>Otherwise, it returns <code>null</code> and adds an error to the GraphQL output.</li> </ul> <p>For instance, this query retrieves the environment constant <code>GITHUB_ACCESS_TOKEN</code> which we might set-up to access a private repository in GitHub:</p> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-punctuation">{</span>\n  <span class="hljs-symbol">githubAccessToken</span><span class="hljs-punctuation">:</span> _env<span class="hljs-punctuation">(</span><span class="hljs-symbol">name</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;GITHUB_ACCESS_TOKEN&quot;</span><span class="hljs-punctuation">)</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <h2 id="configuring-access-to-the-environment-constants">Configuring access to the environment constants</h2> <p>We must configure the list of allowed environment variables and constants that can be queried. By default, this list is initially empty. (Unless the unsafe default settings to <a href="https://graphql-api.com/guides/config/building-static-sites" target="_blank">build static sites</a> are enabled, in which case any name is allowed by default.)</p> <p>Each entry can either be:</p> <ul> <li>A regex (regular expression), if it&#39;s surrounded by <code>/</code> or <code>#</code>, or</li> <li>The full variable or constant name, otherwise</li> </ul> <p>For instance, any of these entries match environment variable <code>&quot;GITHUB_ACCESS_TOKEN&quot;</code>:</p> <ul> <li><code>GITHUB_ACCESS_TOKEN</code></li> <li><code>#^([A-Z]*)_ACCESS_TOKEN$#</code></li> <li><code>/GITHUB_(\\S+)/</code></li> </ul> <p>There are 2 places where this configuration can take place, in order of priority:</p> <ol> <li>Custom: In the corresponding Schema Configuration</li> <li>General: In the Settings page</li> </ol> <p>In the Schema Configuration applied to the endpoint, select option <code>&quot;Use custom configuration&quot;</code> and then input the desired entries:</p> <p><img src="https://raw.githubusercontent.com/leoloso/PoP/master/layers/GraphQLAPIForWP/plugins/graphql-api-for-wp/docs/implicit-features//../../images/environment-fields-schema-configuration-entries.png" alt="Defining the entries on the Schema Configuration" title="Defining the entries on the Schema Configuration"></p> <p>Otherwise, the entries defined in the &quot;Environment Fields&quot; tab from the Settings will be used:</p> <p><img src="https://raw.githubusercontent.com/leoloso/PoP/master/layers/GraphQLAPIForWP/plugins/graphql-api-for-wp/docs/implicit-features//../../images/environment-fields-settings-entries.png" alt="Defining the entries on the Settings" title="Defining the entries on the Settings"></p> <p>There are 2 behaviors, &quot;Allow access&quot; and &quot;Deny access&quot;:</p> <ul> <li><strong>Allow access:</strong> only the configured entries can be accessed, and no other can</li> <li><strong>Deny access:</strong> the configured entries cannot be accessed, all other entries can</li> </ul> <p><img src="https://raw.githubusercontent.com/leoloso/PoP/master/layers/GraphQLAPIForWP/plugins/graphql-api-for-wp/docs/implicit-features//../../images/environment-fields-settings-behavior.png" alt="Defining the access behavior" title="Defining the access behavior"></p> <h2 id="security-not-exposing-credentials">Security: Not exposing credentials</h2> <p>Unless our GraphQL API is not publicly exposed (such as when building a static site), we must be careful for the GraphQL query to not expose private data:</p> <ul> <li>In the response of the query</li> <li>In the output when an error happens</li> <li>In the logs</li> </ul> <p>For instance, the following query:</p> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-punctuation">{</span>\n  <span class="hljs-symbol">githubAccessToken</span><span class="hljs-punctuation">:</span> _env<span class="hljs-punctuation">(</span><span class="hljs-symbol">name</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;GITHUB_ACCESS_TOKEN&quot;</span><span class="hljs-punctuation">)</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <p>...will directly print the credentials in the response:</p> <pre><code class="hljs language-json"><span class="hljs"><span class="hljs-punctuation">{</span>\n  <span class="hljs-attr">&quot;data&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n    <span class="hljs-attr">&quot;githubAccessToken&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;{some access token}&quot;</span>\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <p>We can use several of the other features in the plugin to make the GraphQL query secure:</p> <ul> <li><strong>Field to Input</strong> to inject the environment value into another field via a dynamic variable</li> <li><strong>@remove Directive</strong> to avoid printing the environment variable&#39;s value on the output</li> <li><strong>Send HTTP Request Fields</strong> to directly connect to an external service already from within the GraphQL query</li> </ul> <p>For instance, the following query connects to the GitHub REST API using a private access token:</p> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-punctuation">{</span>\n  <span class="hljs-symbol">githubAccessToken</span><span class="hljs-punctuation">:</span> _env<span class="hljs-punctuation">(</span><span class="hljs-symbol">name</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;GITHUB_ACCESS_TOKEN&quot;</span><span class="hljs-punctuation">)</span>\n    <span class="hljs-comment"># This directive will remove this entry from the output</span>\n    <span class="hljs-meta">@remove</span>\n\n  <span class="hljs-comment"># Create the authorization header to send to GitHub</span>\n  <span class="hljs-symbol">authorizationHeader</span><span class="hljs-punctuation">:</span> _sprintf<span class="hljs-punctuation">(</span>\n    <span class="hljs-symbol">string</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;Bearer %s&quot;</span>,\n    <span class="hljs-comment"># &quot;Field to Input&quot; feature to access value from the field above</span>\n    <span class="hljs-symbol">values</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">[</span><span class="hljs-variable">$__githubAccessToken</span>]\n  <span class="hljs-punctuation">)</span>\n    <span class="hljs-comment"># Do not print in output</span>\n    <span class="hljs-meta">@remove</span>\n\n  <span class="hljs-comment"># Use the field from &quot;Send HTTP Request Fields&quot; to connect to GitHub</span>\n  <span class="hljs-symbol">gitHubArtifactData</span><span class="hljs-punctuation">:</span> _sendJSONObjectCollectionHTTPRequest<span class="hljs-punctuation">(</span>\n    <span class="hljs-symbol">input</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n      <span class="hljs-symbol">url</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;https://api.github.com/repos/leoloso/PoP/actions/artifacts&quot;</span>,\n      <span class="hljs-symbol">options</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n        <span class="hljs-symbol">headers</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">[</span>\n          <span class="hljs-punctuation">{</span>\n            <span class="hljs-symbol">name</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;Accept&quot;</span>\n            <span class="hljs-symbol">value</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;application/vnd.github+json&quot;</span>\n          <span class="hljs-punctuation">}</span>,\n          <span class="hljs-punctuation">{</span>\n            <span class="hljs-symbol">name</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;Authorization&quot;</span>\n            <span class="hljs-comment"># &quot;Field to Input&quot; feature to access value from the field above</span>\n            <span class="hljs-symbol">value</span><span class="hljs-punctuation">:</span> <span class="hljs-variable">$__authorizationHeader</span>\n          <span class="hljs-punctuation">}</span>,\n        <span class="hljs-punctuation">]</span>\n      <span class="hljs-punctuation">}</span>\n    <span class="hljs-punctuation">}</span>\n  <span class="hljs-punctuation">)</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <p>In this query, fields <code>githubAccessToken</code> and <code>authorizationHeader</code> (which contain sensitive data) are both removed from the output, and field <code>gitHubArtifactData</code> will already print the results of the API call, without leaking any of its inputs (eg: an error will print the string <code>&quot;$__authorizationHeader&quot;</code> instead of the variable&#39;s value).</p> <h2 id="further-examples">Further examples</h2> <p>This query retrieves the DB configuration defined in the <code>wp-config.php</code> file:</p> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-punctuation">{</span>\n  <span class="hljs-symbol">dbName</span><span class="hljs-punctuation">:</span> _env<span class="hljs-punctuation">(</span><span class="hljs-symbol">name</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;DB_NAME&quot;</span><span class="hljs-punctuation">)</span>\n  <span class="hljs-symbol">dbUser</span><span class="hljs-punctuation">:</span> _env<span class="hljs-punctuation">(</span><span class="hljs-symbol">name</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;DB_USER&quot;</span><span class="hljs-punctuation">)</span>\n  <span class="hljs-symbol">dbPassword</span><span class="hljs-punctuation">:</span> _env<span class="hljs-punctuation">(</span><span class="hljs-symbol">name</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;DB_PASSWORD&quot;</span><span class="hljs-punctuation">)</span>\n  <span class="hljs-symbol">dbHost</span><span class="hljs-punctuation">:</span> _env<span class="hljs-punctuation">(</span><span class="hljs-symbol">name</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;DB_HOST&quot;</span><span class="hljs-punctuation">)</span>\n<span class="hljs-punctuation">}</span></span></code></pre> '}}]);