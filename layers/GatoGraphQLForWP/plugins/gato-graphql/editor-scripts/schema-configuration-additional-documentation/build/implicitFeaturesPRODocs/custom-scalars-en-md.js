(window.webpackJsonpGatoGraphQLSchemaConfigurationAdditionalDocumentation=window.webpackJsonpGatoGraphQLSchemaConfigurationAdditionalDocumentation||[]).push([[5],{52:function(e,o){e.exports='<h1 id="custom-scalars-pack">Custom Scalars Pack</h1> <p>Collection of additional custom scalar types.</p> <h2 id="custom-scalars">Custom Scalars</h2> <p>The following custom scalar types are made available in the GraphQL schema:</p> <h3 id="domain"><code>Domain</code></h3> <p>Domain scalar, such as <code>https://mysite.com</code> or <code>http://www.mysite.org</code></p> <h3 id="ip"><code>IP</code></h3> <p>IP scalar, including both IPv4 (such as <code>192.168.0.1</code>) and IPv6 (such as <code>2001:0db8:85a3:08d3:1319:8a2e:0370:7334</code></p> <h3 id="ipv4"><code>IPv4</code></h3> <p>IPv4 scalar, such as <code>192.168.0.1</code></p> <h3 id="ipv6"><code>IPv6</code></h3> <p>IPv6 scalar, such as <code>2001:0db8:85a3:08d3:1319:8a2e:0370:7334</code></p> <h3 id="macaddress"><code>MACAddress</code></h3> <p>MAC (media access control) address scalar, such as <code>00:1A:C2:7B:00:47</code></p> <h3 id="positivefloat"><code>PositiveFloat</code></h3> <p>A positive float or 0</p> <h3 id="positiveint"><code>PositiveInt</code></h3> <p>A positive integer or 0</p> <h3 id="phonenumber"><code>PhoneNumber</code></h3> <p>Phone number scalar, such as <code>+1-212-555-0149</code></p> <h3 id="strictlypositivefloat"><code>StrictlyPositiveFloat</code></h3> <p>A positive float (&gt; 0)</p> <h3 id="strictlypositiveint"><code>StrictlyPositiveInt</code></h3> <p>A positive integer (&gt; 0)</p> <h3 id="stringvaluejsonobject"><code>StringValueJSONObject</code></h3> <p>A JSON Object where values are strings.</p> <h3 id="uuid"><code>UUID</code></h3> <p>UUID (universally unique identifier) scalar, such as <code>25770975-0c3d-4ff0-ba27-a0f98fe9b052</code></p> <h2 id="introspection">Introspection</h2> <p>When installing the Gato GraphQL PRO plugin, these custom scalars will always be available for your use to extend the GraphQL schema.</p> <p>However, please notice that only when a custom scalar type is referenced will it appear on the GraphQL schema, as <a href="https://spec.graphql.org/October2021/#sec-Scalars.Built-in-Scalars">defined by the spec for built-in scalars</a>:</p> <blockquote> <p>When returning the set of types from the <code>__Schema</code> introspection type, all referenced built-in scalars must be included. If a built-in scalar type is not referenced anywhere in a schema (there is no field, argument, or input field of that type) then it must not be included.</p> </blockquote> '}}]);