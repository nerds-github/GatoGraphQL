(window.webpackJsonpGraphQLAPISchemaConfigurationAdditionalDocumentation=window.webpackJsonpGraphQLAPISchemaConfigurationAdditionalDocumentation||[]).push([[3],{50:function(s,n){s.exports='<h1 id="query-schema-extensions-via-introspection">Query schema extensions via introspection</h1> <p>Custom metadata attached to schema elements can be queried via field <code>extensions</code>, and every element in the schema can define its own set of properties to query.</p> <h2 id="description">Description</h2> <p>All introspection elements of the schema have an <code>extensions</code> field available, each of them returning an object of a corresponding &quot;<code>_Extensions</code>&quot; type, which exposes the custom properties for that element.</p> <p>Using SDL (Schema Definition Language) to visualize it, the schema offers these extra fields (and additional custom fields can be further added):</p> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-comment">########################################################</span>\n<span class="hljs-comment"># Using &quot;_&quot; instead of &quot;__&quot; in introspection type name</span>\n<span class="hljs-comment"># to avoid errors in graphql-js</span>\n<span class="hljs-comment">########################################################</span>\n\n<span class="hljs-keyword">type</span> _SchemaExtensions <span class="hljs-punctuation">{</span>\n  <span class="hljs-comment"># Is the schema being namespaced?</span>\n  <span class="hljs-symbol">isNamespaced</span><span class="hljs-punctuation">:</span> Boolean<span class="hljs-punctuation">!</span>\n<span class="hljs-punctuation">}</span>\n\nextend <span class="hljs-keyword">type</span> __Schema <span class="hljs-punctuation">{</span>\n  <span class="hljs-symbol">extensions</span><span class="hljs-punctuation">:</span> _SchemaExtensions<span class="hljs-punctuation">!</span>\n<span class="hljs-punctuation">}</span>\n\n<span class="hljs-keyword">type</span> _NamedTypeExtensions <span class="hljs-punctuation">{</span>\n  <span class="hljs-comment"># The type name</span>\n  <span class="hljs-symbol">elementName</span><span class="hljs-punctuation">:</span> String<span class="hljs-punctuation">!</span>\n\n  <span class="hljs-comment"># The &quot;namespaced&quot; type name</span>\n  <span class="hljs-symbol">namespacedName</span><span class="hljs-punctuation">:</span> String<span class="hljs-punctuation">!</span>\n\n  <span class="hljs-comment"># Enum-like &quot;possible values&quot; for EnumString type resolvers, `null` otherwise</span>\n  <span class="hljs-symbol">possibleValues</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">[</span>String<span class="hljs-punctuation">!</span><span class="hljs-punctuation">]</span>\n\n  <span class="hljs-comment"># OneOf Input Objects are a special variant of Input Objects where the type system asserts that exactly one of the fields must be set and non-null, all others being omitted.</span>\n  <span class="hljs-symbol">isOneOf</span><span class="hljs-punctuation">:</span> Boolean<span class="hljs-punctuation">!</span>\n<span class="hljs-punctuation">}</span>\n\nextend <span class="hljs-keyword">type</span> __Type <span class="hljs-punctuation">{</span>\n  <span class="hljs-comment"># Non-null for named types, null for wrapping types (Non-Null and List)</span>\n  <span class="hljs-symbol">extensions</span><span class="hljs-punctuation">:</span> _NamedTypeExtensions\n<span class="hljs-punctuation">}</span>\n\n<span class="hljs-keyword">type</span> _DirectiveExtensions <span class="hljs-punctuation">{</span>\n  <span class="hljs-comment"># If no objects are returned in the field (eg: because they failed validation), does the directive still need to be executed?</span>\n  <span class="hljs-symbol">needsDataToExecute</span><span class="hljs-punctuation">:</span> Boolean<span class="hljs-punctuation">!</span>\n\n  <span class="hljs-comment"># Names or descriptions of the types the field directives is restricted to, or `null` if it supports any type (i.e. it defines no restrictions)</span>\n  <span class="hljs-symbol">fieldDirectiveSupportedTypeNamesOrDescriptions</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">[</span>String<span class="hljs-punctuation">!</span><span class="hljs-punctuation">]</span>\n<span class="hljs-punctuation">}</span>\n\nextend <span class="hljs-keyword">type</span> __Directive <span class="hljs-punctuation">{</span>\n  <span class="hljs-symbol">extensions</span><span class="hljs-punctuation">:</span> _DirectiveExtensions<span class="hljs-punctuation">!</span>\n<span class="hljs-punctuation">}</span>\n\n<span class="hljs-keyword">type</span> _FieldExtensions <span class="hljs-punctuation">{</span>\n  <span class="hljs-symbol">isGlobal</span><span class="hljs-punctuation">:</span> Boolean<span class="hljs-punctuation">!</span>\n\n  <span class="hljs-comment"># Useful for nested mutations</span>\n  <span class="hljs-symbol">isMutation</span><span class="hljs-punctuation">:</span> Boolean<span class="hljs-punctuation">!</span>\n\n  <span class="hljs-comment"># `true` =&gt; Only exposed when &quot;Expose “sensitive” data elements&quot; is enabled</span>\n  <span class="hljs-symbol">isSensitiveDataElement</span><span class="hljs-punctuation">:</span> Boolean<span class="hljs-punctuation">!</span>\n<span class="hljs-punctuation">}</span>\n\nextend <span class="hljs-keyword">type</span> __Field <span class="hljs-punctuation">{</span>\n  <span class="hljs-symbol">extensions</span><span class="hljs-punctuation">:</span> _FieldExtensions<span class="hljs-punctuation">!</span>\n<span class="hljs-punctuation">}</span>\n\n<span class="hljs-keyword">type</span> _InputValueExtensions <span class="hljs-punctuation">{</span>\n  <span class="hljs-symbol">isSensitiveDataElement</span><span class="hljs-punctuation">:</span> Boolean<span class="hljs-punctuation">!</span>\n<span class="hljs-punctuation">}</span>\n\nextend <span class="hljs-keyword">type</span> __InputValue <span class="hljs-punctuation">{</span>\n  <span class="hljs-symbol">extensions</span><span class="hljs-punctuation">:</span> _InputValueExtensions<span class="hljs-punctuation">!</span>\n<span class="hljs-punctuation">}</span>\n\n<span class="hljs-keyword">type</span> _EnumValueExtensions <span class="hljs-punctuation">{</span>\n  <span class="hljs-symbol">isSensitiveDataElement</span><span class="hljs-punctuation">:</span> Boolean<span class="hljs-punctuation">!</span>\n<span class="hljs-punctuation">}</span>\n\nextend <span class="hljs-keyword">type</span> __EnumValue <span class="hljs-punctuation">{</span>\n  <span class="hljs-symbol">extensions</span><span class="hljs-punctuation">:</span> _EnumValueExtensions<span class="hljs-punctuation">!</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <p>For instance, we can query the name and namespaced name of each type:</p> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-keyword">query</span> TypeQualifiedNames <span class="hljs-punctuation">{</span>\n  __schema <span class="hljs-punctuation">{</span>\n    types <span class="hljs-punctuation">{</span>\n      name\n      extensions <span class="hljs-punctuation">{</span>\n        elementName\n        namespacedName\n      <span class="hljs-punctuation">}</span>\n    <span class="hljs-punctuation">}</span>\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <h2 id="graphql-spec">GraphQL spec</h2> <p>This functionality is not yet part of the GraphQL spec, but has been requested:</p> <ul> <li><a href="https://github.com/graphql/graphql-spec/issues/300" target="_blank">Issue #300 - Expose user-defined meta-information via introspection API in form of directives</a></li> <li><a href="https://github.com/graphql/graphql-wg/discussions/1096" target="_blank">Discussion #1096 - &quot;Metadata Directives&quot; Proposal</a></li> </ul> '}}]);