(window.webpackJsonpGraphQLAPISchemaConfigurationAdditionalDocumentation=window.webpackJsonpGraphQLAPISchemaConfigurationAdditionalDocumentation||[]).push([[30],{76:function(s,a){s.exports='<h1 id="pass-onwards-directive">Pass Onwards Directive</h1> <p>Add directive <code>@passOnwards</code> to make the field&#39;s resolved value available to subsequent directives via a dynamic variable. It is the equivalent of the <strong>Field to Input</strong> feature, but allowing to reference the field value within a directive argument.</p> <p>Directive <code>@passOnwards</code> allows us to manipulate the value of the field, by applying any needed directive, which can now receive the value of the field as an input.</p> <h2 id="description">Description</h2> <p>In the query below, field <code>notHasComments</code> is composed by obtaining the value from field <code>hasComments</code> and calculating its opposite value. This works by:</p> <ul> <li>Making the field&#39;s value available via <code>@passOnwards</code>; the field&#39;s value can then be input into any subsequent directive</li> <li><code>@applyField</code> takes the input (exported under dynamic variable <code>$postHasComments</code>), applies the global field <code>not</code> into it, and stores the result back into the field</li> </ul> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-punctuation">{</span>\n  posts <span class="hljs-punctuation">{</span>\n    id\n    hasComments\n    <span class="hljs-symbol">notHasComments</span><span class="hljs-punctuation">:</span> hasComments\n      <span class="hljs-meta">@passOnwards</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">as</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;postHasComments&quot;</span><span class="hljs-punctuation">)</span>\n      <span class="hljs-meta">@applyField</span><span class="hljs-punctuation">(</span>\n        <span class="hljs-symbol">name</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;_not&quot;</span>\n        <span class="hljs-symbol">arguments</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n          <span class="hljs-symbol">value</span><span class="hljs-punctuation">:</span> <span class="hljs-variable">$postHasComments</span>\n        <span class="hljs-punctuation">}</span>,\n        <span class="hljs-symbol">setResultInResponse</span><span class="hljs-punctuation">:</span> <span class="hljs-literal">true</span>\n      <span class="hljs-punctuation">)</span>\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <p>This will produce:</p> <pre><code class="hljs language-json"><span class="hljs"><span class="hljs-punctuation">{</span>\n  <span class="hljs-attr">&quot;data&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n    <span class="hljs-attr">&quot;posts&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">[</span>\n      <span class="hljs-punctuation">{</span>\n        <span class="hljs-attr">&quot;id&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-number">1724</span><span class="hljs-punctuation">,</span>\n        <span class="hljs-attr">&quot;hasComments&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-literal"><span class="hljs-keyword">true</span></span><span class="hljs-punctuation">,</span>\n        <span class="hljs-attr">&quot;notHasComments&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-literal"><span class="hljs-keyword">false</span></span>\n      <span class="hljs-punctuation">}</span><span class="hljs-punctuation">,</span>\n      <span class="hljs-punctuation">{</span>\n        <span class="hljs-attr">&quot;id&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-number">358</span><span class="hljs-punctuation">,</span>\n        <span class="hljs-attr">&quot;hasComments&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-literal"><span class="hljs-keyword">false</span></span><span class="hljs-punctuation">,</span>\n        <span class="hljs-attr">&quot;notHasComments&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-literal"><span class="hljs-keyword">true</span></span>\n      <span class="hljs-punctuation">}</span><span class="hljs-punctuation">,</span>\n      <span class="hljs-punctuation">{</span>\n        <span class="hljs-attr">&quot;id&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-number">555</span><span class="hljs-punctuation">,</span>\n        <span class="hljs-attr">&quot;hasComments&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-literal"><span class="hljs-keyword">false</span></span><span class="hljs-punctuation">,</span>\n        <span class="hljs-attr">&quot;notHasComments&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-literal"><span class="hljs-keyword">true</span></span>\n      <span class="hljs-punctuation">}</span>\n    <span class="hljs-punctuation">]</span>\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> '}}]);