![PoP](https://assets.getpop.org/wp-content/themes/getpop/img/pop-logo-horizontal.png)

# PoP

This repo contains only documentation concerning the component-model architecture. All actual code (and corresponding documentation) is found on different repositories under the [PoP organization account](https://github.com/getpop/).

## Description
 
PoP describes an architecture based on a server-side component model. It is intended to become a specification, so that it can be implemented in different languages. 

PoP is components all the way down. Each component is implemented partly in the back-end, and partly in the front-end. The component-based architecture provides the mechanism to build the application, and guides how it can be deployed (eg: it supports the serverless paradigm). 

![In PoP, everything is a module](https://uploads.getpop.org/wp-content/uploads/2018/12/everything-is-a-module.jpg)

Native applications to PoP are [APIs](https://github.com/getpop/api) (WIP, almost finished), [websites](https://github.com/getpop/site-builder) and [static sites](https://github.com/getpop/static-site-generator) (coming soon).

## Implementations

Currently, PoP has been implemented in the following languages:

- [PoP in PHP](https://github.com/leoloso/PoP-PHP)

## Install

Follow the instructions for the corresponding platform:

- [PoP API for WordPress](https://github.com/leoloso/PoP-API-WP)
- Others coming soon...
<!--
- PoP API for Laravel + WordPress (coming soon)
- PoP site for WordPress (coming soon)
-->

## Architecture foundations

The architecture establishes the following foundations:

1. Everything is a module (or component)
2. The module is its own API
3. The API and the application share the same foundations

### 1. Everything is a module

A PoP application contains a top-most module (also called a component) which wraps other modules, which themselves wrap other modules, and so on until reaching the last level:

![Sequence of modules wrapping modules wrapping modules, from an avatar all the way up to the webpage](https://uploads.getpop.org/wp-content/uploads/2018/12/module-sequence.gif)

Hence, in PoP everything is a module, and the top-most module represents the page.

### 2. The module is its own API

Every module, at whichever level inside the component hierarchy (i.e. the composition of modules starting from the top-most, all the way down to the last level), is independently accessible through the API simply by passing along its module path in the URL: `/page-url/?output=json&modulefilter=modulepaths&modulepaths[]=path-to-the-module`

### 3. The API and the application share the same foundations

In PoP, the application consumes its data from itself. Indeed, the application and the API are the same entity, so there is no code duplication whatsoever (eg: for user authentication). Moreover, the application can consume the data already on the server-side, avoiding the extra latency from consuming data on the client-side.

## Progressive/Resilient components

In most libraries/frameworks in the market, the implementation of the concept of components is based on JavaScript. In PoP, a component has a progressive approach, and its implementation spans from back to front-end:

<table>
<thead>
<tr><th>Back-end</th><th>Front-end</th></tr>
</thead>
<tbody>
<tr valign="top"><td>
<ul>
<li>Component hierarchy</li>
<li>Data loading</li>
<li>Configuration</li>
<li>Props</li>
</ul>
</td><td>
<ul>
<li>Styles</li>
<li>View</li>
<li>Reactivity</li>
</ul>
</td></tr>
</tbody>
</table>

## Design goals

PoP's architecture attempts to achieve the following goals:

✅ The API and the application share the same architecture/foundations

✅ Support for creating all-purpose APIs, compatible with industry standards (such as REST and GraphQL), and incorporating the advantages from other APIs

✅ High level of modularity:

- Strict top-down module hierarchy: ancestor modules know their descendants, but not the other way around
- One-way setting of props across modules, from ancestors to descendants
- Configuration values through API, allowing to decouple modules from each other

✅ Minimal effort to produced a maximum output:

- Isomorphism to produce HTML code client and server-side and to be sent as transactional email
- API output easily customized for different applications (website, mobile app, integration with 3rd party apps, etc)
- Native code splitting, A/B testing, client-side state management and layout cache

✅ Clearly decoupled responsibilities in the stack, which defines clear responsibilities across team members. Eg:

- JavaScript templates for markup
- JavaScript for user interactivity/dynamic functionality
- CSS for styles
- PHP for creating the modules

✅ JavaScript as progressive enhancement (the application works always, even if JavaScript is disabled)

✅ Aggressive caching, implemented across several layers: 

- Pages and configuration in server
- Content and assets through CDN
- Content and assets through service workers and local storage in client

✅ Self documentation: 

- The website is already the documentation for the API
- Component pattern libraries are automatically generated by rendering each module on their own (through `modulefilter=modulepaths&modulepaths[]=path-to-the-module`)

<!--
## Open specification

PoP is in the process of decoupling the API specification from the implementation, resulting in the following parts:

1. The API (JSON response) specification
2. PoP Server, to serve content based on the API specification (originally implemented in PHP)
3. PoP.js, to consume the native PoP API in the client

Through the open specification, we hope this architecture can be migrated to other technologies (eg: Node.js, Java, .NET, etc), enabling any site implementing the specification to be able to interact with any other such site. 
-->
<!--
### CMS-agnostic

Because it was originally conceived for WordPress, PoP's current implementation is in PHP, which can be perfectly used for other PHP-based CMSs (such as Joomla or Drupal). For this reason, we are transforming the codebase to make PoP become CMS-agnostic, splitting plugins into 2 entities: a generic implementation that should work for every CMS (eg: "pop-engine") and a specific one for WordPress (eg: "pop-engine-wp"), so that only the latter one should be re-implemented for other CMSs. 

> Note: This task is a work in progress and nowhere near completion: plenty of code has been implemented following the WordPress architecture (eg: basing the object model on posts, pages and custom post types), and must be assessed if it is compatible for other CMSs.
-->

## Response specification

The output from requesting a URL can contain several layers. At its core it is a data layer (useful for implementing an API). This layer can be extended to add a configuration layer.

### 1. Data layer

The data layer supports the creation of an API. It represents data in the following way:

- Database data is retrieved through a relational structure under section `databases`
- The IDs which are the results for each component are indicated through entry `dbobjectids` (under section `datasetmoduledata`)
- Where to find those results in the database is indicated through entry `dbkeys` (under section `modulesettings`)
- All database data is normalized (i.e. not repeated)

The API response looks like this:

```javascript
{
  databases: {
    primary: {
      posts: {
        1: {
          author: 7, 
          comments: [88]
        },
        2: {
          recommendedby: [5], 
          comments: [23]
        },
      },
      users: {
        5: {
          name: "Leo"
        },
        7: {
          name: "Pedro"
        },
        18: {
          name: "Romualdo"
        }
      },
      comments: {
        23: {
          author: 7, 
          post_id: 2, 
          content: "Great stuff!"
        },
        88: {
          author: 18, 
          post_id: 1, 
          content: "I love this!"
        }
      }
    }
  },
  datasetmoduledata: {
    "topmodule": {
      modules: {
        "datamodule1": {
          dbobjectids: [1], 
        },
        "datamodule2": {
          dbobjectids: [2], 
        }
      }
    }
  },
  modulesettings: {
    "topmodule": {
      modules: {
        "datamodule1": {
          dbkeys: {
            id: "posts",
            author: "users",
            comments: "comments"
          }
        },
        "datamodule2": {
          dbkeys: {
            id: "posts",
            recommendedby: "users",
            comments: "comments"
          }
        }
      }
    }
  }
}
```

### 2. Configuration layer

The configuration layer can provide those properties and values required to build any kind of application:

```javascript
{
  modulesettings: {
    "topmodule": {
      modules: {
        "layoutpostmodule": {
          configuration: {
            class: "text-center"
          },
          modules: {
            "titlemodule": {
              configuration: {
                class: "title bg-info",
                htmltag: "h3"
              }
            },
            "postcontentmodule": {
              configuration: {
                maxheight: "400px"
              },
              modules: {
                "authoravatarmodule": {
                  configuration: {
                    class: "img-thumbnail",
                    maxwidth: "50px"
                  }
                }
              }
            }
          }
        }
      }
    }
  }
}
```

## When to use PoP

Among others, PoP is suitable for the following use cases:

### 👉🏽 As an API

The [PoP API](https://github.com/getpop/api) is a world-class API, very easy to be consumed in the client, and also very easy to be created on the server. Its component-based architecture offers features that can't be supported through schemas, such as composition of fields.

### 👉🏽 As a replacement for GraphQL and REST

The [PoP API](https://github.com/getpop/api) can combine the best of both GraphQL and REST in a single API: no under or over-fetching or data while supporting server-side cache and not being open to DoS attacks. API extensions [PoP GraphQL API](https://github.com/getpop/api-graphql) and [PoP REST API](https://github.com/getpop/api-rest) change the shape of the API's response to that produced by GraphQL and REST respectively, so they are compatible with these APIs.

### 👉🏽 To execute any type of operation supported by the CMS

PoP is CMS-agnostic, and can run on top of any CMS and be a proxy to execute its functionality (retrieve data, post data, log the user in, send an email, etc). It is extremely simple to set-up and use: PoP exposes a single URL-based interface to execute the whole functionality.

### 👉🏽 Homogenize the architecture of the application

The component-based architecture acts as the foundation for the overall application, including accessing data through the API, and implementation of its many features (many of them already provided out of the box, such as code splitting, A/B testing, client-side state management and layout cache).

### 👉🏽 Maximize the output from a small team

The architectural single source of truth makes it possible to produce HTML for the server-side, client-side, transactional emails, and any other desired output, and power more than one application (for instance, a website + a mobile app), allowing a single developer to handle all these tasks.

### 👉🏽 Make the application easily maintainable in the long term

PoP modules are focused on a single task or goal. Hence, to modify a functionality, quite likely just a single module needs be updated, and because of the high degree of modularity attained by the architecture, other modules will not be affected. 

Also, each module is cleary decoupled in its responsibilities across its stack (eg: PHP, CSS, JavaScript templates and JavaScript for functionalities), so only the appropriate team members will need to work on the module.

### 👉🏽 Avoid having to document your components

Because the website is already the documentation for the API, and component pattern libraries can be automatically generated by rendering each component on their own, PoP reduces the amount of documentation that needs be produced.
<!--
### 👉🏽 Robust architecture based on splitting a component's responsibilities into server and client-side

Using components as the building unit of a website has many advantages over other methods, such as through templates. Modern frameworks bring the magic of components to the client-side for functionality (such as JavaScript libraries React and Vue) and for styles through component pattern libraries (such as Bootstrap). PoP splits a component's responsibilities into server-side (props, configuration, other) and client-side (view, reactivity), creating a more resilient and robust architecture.
-->
<!--### Avoid (or lessen) JavaScript fatigue

PoP is not a JavaScript framework, but a framework spanning the server and client-side. While developers can add client-side JavaScript to enhance the application, it is certainly not a requirement, and powerful applications can be created with basic knowledge of JavaScript.-->

### 👉🏽 Implement the "Create Once, Publish Everywhere" strategy

[COPE](https://www.programmableweb.com/news/cope-create-once-publish-everywhere/2009/10/13) ("Create Once, Publish Everywhere") is a technique for creating several outputs (website, AMP, newsletters, mobile app, etc) from a single source of truth of content. PoP supports the implementation of COPE or similar techniques.

### 👉🏽 Decentralize data sources across domains

<!--
PoP supports to set a module as lazy, so that its data is loaded from the client instead of the server, and change the domain from which to fetch the data to any other domain or subdomain, on a module by module basis, which enables to split an application into microservices. In addition, 
-->
PoP allows to establish more than one data source for any module, so a module can aggregate its data from several domains concurrently, as demonstrated by the content aggregator SukiPoP's [feed](https://sukipop.com/en/posts/), [events calendar](https://sukipop.com/en/calendar/) and [user's map](https://sukipop.com/en/users/?format=map).

<!--### Make the most out of cloud services

From the two foundations "everything is a module" and "a module is its own API", we conclude that everything on a PoP site is an API. And since APIs are greatly suitable to take advantage of cloud services (for instance, serving and caching the API response through a CDN), then PoP calls the cloud "home".-->
<!--
## Timeline

Currently, only the 1st layer, data + configuration API, is available in the repository. We are currently working on the 2nd and 3rd layers, client-side rendering and server-side rendering respectively, and these should be ready and available during the 1st quarter of 2019.
-->
<!--
## Motivation

We have been working on it for more than 5 years, and we are still on the early stages of it (or so we hope!) It was created by Leonardo Losoviz as a solution to connect communities together directly from their own websites, offering an alternative to always depending on Facebook and similar platforms.

PoP didn't start straight as a framework, but as a website for connecting environmental movements in Malaysia, called [MESYM](https://www.mesym.com). After developing plenty of social networking features for this website, we became aware that the website code could be abstracted and turned into a framework for implementing any kind of social network. The PoP framework was thus born, after which we launched a few more websites: [TPPDebate](https://my.tppdebate.org) and [Agenda Urbana](https://agendaurbana.org). 

We then worked towards connecting all the platforms together, so each community could own its own data on their website and share it with the other communities, and break away from depending on the mainstream platforms. We implemented the decentralization feature in PoP, and launched the demonstration site [SukiPoP](https://sukipop.com), which aggregates data from these previous websites and enables different community members to interact with each other.

However, at this point PoP was not a progressive framework for building any kind of site, but a framework for building social networks and nothing else. It was all or nothing, certainly not ideal. For this reason, most of 2018 we have been intensively working on transforming PoP into an all-purpose site builder, which led us to design the component-based architecture for the API, split the framework into several layers, and decouple the API specification from the implementation. 

If the open specification succeeds at attracting interest from the development community and eventually gets implemented for other CMSs and technologies, our goal of connecting sites together will have had a big boost. This is the dream that drives us forward and keeps us working long into the night.
-->

## Examples
<!--
Some examples of PoP in the wild:
-->
### PoP API
<!--
You can play with the PoP API here: https://nextapi.getpop.org. Check the following examples:
-->
<!--
**Requesting specific fields:**

In the following links, data for a resource or collection of resources is fetched as typically done through REST; however, through parameter `fields` we can also specify what specific data to retrieve for each resource, avoiding over or underfetching data: 

- A [single post](https://nextapi.getpop.org/posts/a-lovely-tango/?output=json&action=api&fields=title,content,datetime) and a [collection of posts](https://nextapi.getpop.org/posts/?output=json&action=api&fields=title,content,datetime) adding parameter `fields=title,content,datetime`
- A [user](https://nextapi.getpop.org/u/leo/?output=json&action=api&fields=name,username,description) and a [collection of users](https://nextapi.getpop.org/users/?output=json&action=api&fields=name,username,description) adding parameter `fields=name,username,description`

This works for relationships too. For instance, let's say that we want to retrieve a list of posts with fields `"title"` and `"content"`, each post's comments with fields `"content"` and `"date"`, and the author of each comment with fields `"name"` and `"url"`. To achieve this in GraphQL we would implement the following query:

```javascript
query {
  post {
    title
    content
    comments {
      content
      date
      author {
        name
        url
      }
    }
  }
}
```

For PoP, the query is translated into its corresponding "dot syntax" expression, which can then be supplied through parameter `fields`. Querying on a "post" resource, this value is:

```javascript
fields=title,content,comments.content,comments.date,comments.author.name,comments.author.url
```

Or it can be simplified, using `|` to group all fields applied to the same resource:

```javascript
fields=title|content,comments.content|date,comments.author.name|url
```

When executing this query [on a single post](https://nextapi.getpop.org/posts/a-lovely-tango/?output=json&action=api&fields=title|content,comments.content|date,comments.author.name|url) we obtain exactly the required data for all involved resources.
-->
<!--
**PoP, GraphQL and REST-like API:**
-->
<!--
We can fetch exactly the required data for all involved resources from a URL, in different formats:

- [PoP native response](https://nextapi.getpop.org/2013/01/11/markup-html-tags-and-formatting/api/?fields=title|content,comments.content|date,comments.author.name|url)
-->

Refer to [PoP API](https://github.com/getpop/api#examples) for more examples.

- Query: [posts.id|title|url|comments.id|content|date|author.id|name|url|posts.id|title|url](https://nextapi.getpop.org/api/graphql/?fields=posts.id|title|url|comments.id|content|date|author.id|name|url|posts.id|title|url)

### PoP Sites

> Note: The websites below run on an old version of the software, and will be migrated to the version eventually.

- [PoP Demo](https://demo.getpop.org) is a playground for PoP: create a random post or event, follow a user, add a comment, etc.
- [MESYM](https://www.mesym.com) and [Agenda Urbana](https://agendaurbana.org) are social networks.
- [SukiPoP](https://sukipop.com) is a decentralized social network.

## Documentation

### Technical documentation

Alongside the code, each repository on the [PoP organization account](https://github.com/getpop/) contains its corresponding technical documentation, in its README file.

Currently, most of the technical documentation is found on these repositories:

- [Component Model](https://github.com/getpop/component-model)<!--- [Engine](https://github.com/getpop/engine): Adds services over the component model-->
- [Configuration for Component Model](https://github.com/getpop/component-model-configuration)
- [API](https://github.com/getpop/api)<!--- [GraphQL API](https://github.com/getpop/api-graphql)- [REST API](https://github.com/getpop/api-rest)-->
- [Site Builder](https://github.com/getpop/site-builder)<!--- [Static Site Generator](https://github.com/getpop/static-site-generator)-->


<!--

## Installation

Have your WordPress instance running (the latest version of WordPress can be downloaded from [here](https://wordpress.org/download/)). Then copy the contents of folders `/mu-plugins` and `/plugins` under `/wp-content/mu-plugins` and `/wp-content/plugins` respectively, and activate the 11 plugins from this repository:

- pop-cmsmodel
- pop-cmsmodel-wp
- pop-engine
- pop-engine-wp
- pop-examplemodules
- pop-queriedobject
- pop-queriedobject-wp
- pop-taxonomy
- pop-taxonomy-wp
- pop-taxonomyquery
- pop-taxonomyquery-wp

The first 4 plugins are needed to produce the PoP API, and the 5th plugin (pop-examplemodules) provides basic implementations of modules for all supported hierarchies (home, author, single, tag, page and 404). 

> Note: this way to install PoP is temporary. We are currently introducing Composer to the codebase, which will provide a more convenient way to install PoP. It should be ready sometime in March 2019.

That's it. You can then access PoP's API by adding parameter `output=json` to any URL on the site: https://yoursite.com/?output=json.

![If adding parameter output=json to your site produces a JSON response, then you got it!](https://uploads.getpop.org/wp-content/uploads/2018/12/api-json-response.png?)

> Note 1: Currently PoP runs in WordPress only. Hopefully, in the future it will be available for other CMSs and technologies too.

> Note 2: Only the API has been released so far; we are currently implementing the client-side and server-side rendering layers, which should be released during the first quarter of 2019.

> Note 3: The retrieved fields are defined in plugin pop-examplemodules. You can explore the contents of this plugin, and modify it to bring more or less data.

-->
<!--
## Configuration

PoP allows the configuration of the following properties, set in file wp-config.php:

`USE_COMPONENT_MODEL_CACHE` (`true`|`false`, default: `false`): Create and re-use a cache of the settings for the requested page.

`COMPACT_RESPONSE_JSON_KEYS` (`true`|`false`, default: `false`): Compress the keys in the JSON response.

`ENABLE_CONFIG_BY_PARAMS` (`true`|`false`, default: `false`): Enable to set the application configuration through URL param "config".

`ENABLE_VERSION_BY_PARAMS` (`true`|`false`, default: `false`): Enable to set the application version through URL param "version".

`POP_SERVER_FAILIFMODULESDEFINEDTWICE` (`true`|`false`, default: `false`): Throw an exception if two different modules have the same name.

`POP_SERVER_ENABLEEXTRAURISBYPARAMS` (`true`|`false`, default: `false`): Allow to request extra URIs through URL param "extrauris".

`DISABLE_API` (`true`|`false`, default: `false`): Disable the custom-querying capabilities of the API.

`EXTERNAL_SITES_RUN_SAME_SOFTWARE` (`true`|`false`, default: `false`): Indicate if the external sites from which the origin site is fetching data has the same components installed. In this case, the data can be retrieved using the standard methods. Otherwise, it will be done through the custom-querying API.

`FAIL_IF_SUBCOMPONENT_DATALOADER_IS_UNDEFINED` (`true`|`false`, default: `false`): Whenever switching domain to a field which doesn't have a default dataloader, and without specifying what dataloader to use, throw an exception if `true` or ignore and avoid loading that data if `false`.
-->
<!--
### Decentralization: enabling crossdomain

To have a website consume data coming from other domains, crossdomain access must be allowed. For this, edit your .htaccess file like this:

    <IfModule mod_headers.c>
      SetEnvIf Origin "http(s)?://(.+\.)?(source-website.com|aggregator-website.com)$" AccessControlAllowOrigin=$0
      Header add Access-Control-Allow-Origin %{AccessControlAllowOrigin}e env=AccessControlAllowOrigin

      # Allow for cross-domain setting of cookies, so decentralized log-in also works
      Header set Access-Control-Allow-Credentials true
      Header add Access-Control-Allow-Methods GET
      Header add Access-Control-Allow-Methods POST
    </IfModule>

**Important**: For POST operations to work, we need to make sure the user's browser isn't blocking third-party cookies, otherwise [cross-origin credentialed requests will not work](https://stackoverflow.com/questions/24687313/what-exactly-does-the-access-control-allow-credentials-header-do#24689738). In Chrome, this configuration is set under Settings > Advanced Settings > Privacy > Content Settings > Block third-party cookies and site data.
-->

<!--
### Integration between the Content CDN and Service Workers

To allow the website's service-worker.js be able to cache content coming from the content CDN, access to reading the ETag header must be granted:

    <IfModule mod_headers.c>
      Header add Access-Control-Allow-Headers ETag
      Header add Access-Control-Expose-Headers ETag
    </IfModule>
-->

### Articles concerning PoP

The following articles give a step-by-step process of how many features in PoP were implemented:

- [Introducing the Component-based API](https://www.smashingmagazine.com/2019/01/introducing-component-based-api/): article describing all the main concepts of this architecture, published on Smashing Magazine.
- [Caching Smartly In The Age Of Gutenberg](https://www.smashingmagazine.com/2018/12/caching-smartly-gutenberg/): Caching mechanism implemented in PoP, allowing to cache pages even when the user is logged-in (to be emulated for Gutenberg)
- [Avoiding The Pitfalls Of Automatically Inlined Code](https://www.smashingmagazine.com/2018/11/pitfalls-automatically-inlined-code/): How PoP generates JS/CSS resources to improve performance
- [Sending Emails Asynchronously Through AWS SES](https://www.smashingmagazine.com/2018/11/sending-emails-asynchronously-through-aws-ses/): Mechanism to send emails through AWS SES implemented for PoP
- [Adding Code-Splitting Capabilities To A WordPress Website Through PoP](https://www.smashingmagazine.com/2018/02/code-splitting-wordpress-pop/): How PoP implements code-splitting of JavaScript files
- [How To Make A Dynamic Website Become Static Through A Content CDN](https://www.smashingmagazine.com/2018/02/dynamic-website-static-content-cdn/): Mechanism implemented for PoP to route dynamic content through a CDN to improve performance
- [Implementing A Service Worker For Single-Page App WordPress Sites](https://www.smashingmagazine.com/2017/10/service-worker-single-page-application-wordpress-sites/): The strategy behind the creation of the service-worker.js file in PoP (when running under WordPress), which powers its offline-first caching strategy

## Codebase Migration

[PoP in PHP](https://github.com/leoloso/PoP-PHP) is currently being migrated to Composer packages. We are welcoming first-time contributors to help with the migration: This is a good way to become aquainted with PoP, and we will teach you all there is to know about its architecture. [Find out more](https://github.com/leoloso/PoP-PHP#codebase-migration).

## 🔥 Become involved!

Contributors are welcome! If either you want to get involved, or simply find out more about PoP, simply [send Leo an email](mailto:leo@getpop.org) or [tweet](https://twitter.com/losoviz) 😀❤️.

<!--
## Want to contribute?

Anybody willing to can become involved in the development of PoP. If there is any new development you are interested in implementing, such as integration with this or that plugin, please let us know and we'll be able to assist you. In addition, check the [issues tagged with "help wanted"](https://github.com/leoloso/PoP/issues?q=is%3Aissue+is%3Aopen+label%3A%22help+wanted%22), we will be very happy if you can tackle any of them.

For more info or have a chat, just [contact us](https://getpop.org/en/contact-us/).
-->


















<!-- 
## Linked resources

- [Implementing a module](Link to pop-examplemodules/README.md)
- Documentation:
  - [fieldprocessors](https://getpop.org/en/documentation/...)




-->
<!-- 
Below is a technical summary. For a more in-depth description, please visit [PoP's documentation page](https://getpop.org/en/documentation/overview/).

## What is PoP?

PoP creates [Single-Page Application](https://en.wikipedia.org/wiki/Single-page_application) websites, by combining [Wordpress](https://wordpress.org) and [Handlebars](http://handlebarsjs.com/) into an [MVC architecture](https://en.wikipedia.org/wiki/Model-view-controller) framework:

- Wordpress is the model/back-end
- Handlebars templates are the view/front-end
- the PoP engine is the controller

![How it works](https://uploads.getpop.org/wp-content/uploads/2016/10/Step-5-640x301.png)

## Design principles

1. PoP provides the WordPress website of its own API:

 - Available via HTTP
 - By adding parameter `output=json` to any URL

2. Decentralized

 - All PoP websites can communicate among themselves
 - Fetch/process data in real time

## What can be implemented with it?

- Niche social networks
- Decentralized websites
- Content aggregators
- Server back-end for mobile apps
- Microservices
- APIs for Wordpress websites

## Installation

We are currently creating scripts to automate the installation process, we expect them to be ready around mid-October 2018.

Until then, we provide a zip file including all code (PoP, WordPress and plugins), and a database dump from the [GetPoP Demo website](https://demo.getpop.org/), to set-up this same site in a quick-and-dirty manner in your localhost. Download the files and read the installation instructions [here](https://github.com/leoloso/PoP/blob/master/install/getpop-demo/install.md).

## Configuration

PoP allows the configuration of the following properties, done in file wp-config.php:

- `USE_APPSHELL` (_true_|_false_): Load an empty Application Shell (or appshell), which loads the page content after loading.

- `DISABLE_SERVER_SIDE_RENDERING` (_true_|_false_): Disable producing HTML on the server-side for the first-loaded page.

- `USE_CODE_SPLITTING` (_true_|_false_): Load only the .js and .css that is needed on each page and nothing more.

- `USE_PROGRESSIVE_BOOTING` (_true_|_false_): If doing code splitting, load JS resources on 2 stages: critical ones immediately, and non-critical ones deferred, to lower down the Time to Interactive of the application.

- `GENERATE_BUNDLEGROUP_FILES` and `GENERATE_BUNDLE_FILES` (_true_|_false_): (Only if doing code-splitting) When executing the `/generate-theme/` build script, generate a single bundlegroup and/or a series of bundle files for each page on the website containing all resources it needs.

- `GENERATE_BUNDLE_FILES_ON_RUNTIME` (_true_|_false_): (Only if doing code-splitting) Generate the bundlegroup or bundle files on runtime, so no need to pre-generate these.

- `GENERATE_LOADING_FRAME_RESOURCE_MAPPING` (_true_|_false_): (Only if doing code-splitting) Pre-generate the mapping listing what resources are needed for each route in the application, created when executing the `/generate-theme/` build script.

- `ENQUEUE_FILES_TYPE` (_resource_|_bundle_|_bundlegroup_): (Only if doing code-splitting) Choose how the initial-page resources are loaded:

    - "resource": Load the required resources straight
    - "bundle": through a series of bundle files, each of them comprising up to x resources (defined through constant `BUNDLE_CHUNK_SIZE`)
    - "bundlegroup": through a unique bundlegroup file

- `BUNDLE_CHUNK_SIZE` (_int_): (Only if doing code-splitting) How many resources to pack inside a bundle file. Default: 4.

- `POP_SERVER_TEMPLATERESOURCESINCLUDETYPE` (_header_|_body_|_body-inline_): (Only if doing server-side rendering, code-splitting and enqueue type = "resource") Choose how to include those resources depended by a module (mainly CSS styles):

    - "header": Link in the header
    - "body": Link in the body, right before the module HTML
    - "body-inline": Inline in the body, right before the module HTML

- `POP_SERVER_GENERATERESOURCESONRUNTIME` (_true_|_false_): Allow to extract configuration code from the HTML output and into Javascript files on runtime.

- `USE_MINIFIED_RESOURCES` (_true_|_false_): Include the minified version of .js and .css files.

- `USE_BUNDLED_RESOURCES` (_true_|_false_): (Only if not doing code-splitting) Insert script and style assets from a single bundled file.

- `POP_SERVER_USECDNRESOURCES` (_true_|_false_): Whenever available, use resources from a public CDN.

- `INCLUDE_SCRIPTS_AFTER_HTML` (_true_|_false_): If doing server-side rendering, re-order script tags so that they are included only after rendering all HTML.

- `POP_SERVER_REMOVEDATABASEFROMOUTPUT` (_true_|_false_): If doing server-side rendering, remove all database data from the HTML output.

- `POP_SERVER_TEMPLATEDEFINITION_TYPE` (_0_|_1_|_2_): Allows to replace the name of each module with a base36 number instead, to generate a smaller response (around 40%).

    - 0: Use the original name of each module
    - 1: Use both
    - 2: Use the base36 counter number

- `POP_SERVER_TEMPLATEDEFINITION_CONSTANTOVERTIME` (_true_|_false_): When mangling the template names (template definition type is set to 2), use a database of all template definitions, which will be constant over time and shared among different plugins, to avoid errors in the website from accessed pages (localStorage, Service Workers) with an out-of-date configuration.

- `POP_SERVER_TEMPLATEDEFINITION_USENAMESPACES` (_true_|_false_): If the template definition type is set to 2, then we can set namespaces for each plugin, to add before each template definition. It is needed for decentralization, so that different websites can communicate with each other without conflict, mangling all template definitions the same way. (Otherwise, having different plugins activated will alter the mangling counter, and produce different template definitions).

- `USE_COMPONENT_MODEL_CACHE` (_true_|_false_): Create and re-use a cache of the settings of the requested page.

- `POP_SERVER_COMPACTJSKEYS` (_true_|_false_): Common keys from the JSON code sent to the front-end are replaced with a compact string. Output response will be smaller.

- `USE_LOCAL_STORAGE` (_true_|_false_): Save special loaded-in-the-background pages in localStorage, to not have to retrieve them again (until software version changes).

- `ENABLE_CONFIG_BY_PARAMS` (_true_|_false_): Enable to set the application configuration through URL param "config".

`ENABLE_VERSION_BY_PARAMS` (`true`|`false`, default: `false`): Enable to set the application version through URL param "version".

- `DISABLE_JS` (_true_|_false_): Strip the output of all Javascript code.

- `POP_SERVER_USEGENERATETHEMEOUTPUTFILES` (_true_|_false_): Indicates that we are using all the output files produced from running `/generate-theme/` in this environment, namely:

    - resourceloader-bundle-mapping.json
    - resourceloader-generatedfiles.json
    - All `pop-memory/` files

- `LOAD_FRAME_RESOURCES` (_true_|_false_): When generating file `resources.js`, with the list of resources to dynamically load on the client, include those resources initially loaded in the website (through "loading-frame").

### Decentralization: enabling crossdomain

To have a website consume data coming from other domains, crossdomain access must be allowed. For this, edit your .htaccess file like this:

    <IfModule mod_headers.c>
      SetEnvIf Origin "http(s)?://(.+\.)?(source-website.com|aggregator-website.com)$" AccessControlAllowOrigin=$0
      Header add Access-Control-Allow-Origin %{AccessControlAllowOrigin}e env=AccessControlAllowOrigin

      # Allow for cross-domain setting of cookies, so decentralized log-in also works
      Header set Access-Control-Allow-Credentials true
      Header add Access-Control-Allow-Methods GET
      Header add Access-Control-Allow-Methods POST
    </IfModule>

#### Important

For POST operations to work, we need to make sure the user's browser isn't blocking third-party cookies, otherwise [cross-origin credentialed requests will not work](https://stackoverflow.com/questions/24687313/what-exactly-does-the-access-control-allow-credentials-header-do#24689738). In Chrome, this configuration is set under Settings > Advanced Settings > Privacy > Content Settings > Block third-party cookies and site data.

### Integration between the Content CDN and Service Workers

To allow the website's service-worker.js be able to cache content coming from the content CDN, access to reading the ETag header must be granted:

    <IfModule mod_headers.c>
      Header add Access-Control-Allow-Headers ETag
      Header add Access-Control-Expose-Headers ETag
    </IfModule>

## Optimization

_**Important:** Similar to the installation process, there is room for improvement for the optimization process. If you would like to help us, please [check here](https://github.com/leoloso/PoP/issues/49)._

PoP allows to mangle, minify and bundle together all required .css, .js and .tmpl.js files (suitable for PROD environment), both at the plug-in and website levels:

- **At the plug-in level** (it generates 1.js + 1 .tmpl.js + 1.css files per plug-in): execute `bash -x plugins/PLUGIN-NAME/build/minify.sh` for each plugin
- **At the website level** (it generates 1.js + 1 .tmpl.js + 1.css files for the whole website): execute `bash -x themes/THEME-NAME/build/minify.sh` for the theme

Executing the `minify.sh` scripts requires the following software (_I'll welcome anyone proposing a better way to do this_):
 
1. [UglifyJS](https://github.com/mishoo/UglifyJS2)

 To minify (as to reduce the file size of) JS files

2. [UglifyCSS](https://github.com/fmarcia/UglifyCSS)

 To minify (as to reduce the file size of) CSS files

3. [Google's minimizer Min](https://github.com/mrclay/minify)

 To bundle and minify files. The min webserver must be deployed under http://min.localhost/.

The following environment variables are used in `minify.sh`: `POP_APP_PATH`, `POP_APP_MIN_PATH` and `POP_APP_MIN_FOLDER`. To set their values, for Mac, execute `sudo nano ~/.bash_profile`, then add and save:
    
      export POP_APP_PATH=path to your website (eg: "/Users/john/Sites/PoP")
      export POP_APP_MIN_PATH=path to Google's min website (eg: "/Users/john/Sites/min")
      export POP_APP_MIN_FOLDER=path to folder in min, used for copy files to minimize (eg: "PoP", with the folder being /Users/john/Sites/min/PoP/)

The `minify.sh` script copies all files to minimize under folder `POP_APP_MIN_FOLDER`, from where it minimizes them. The structure of this folder must be created in advance, as follows:
 
 for each theme:
  
      apps/THEME-NAME/css/
      apps/THEME-NAME/js/
      themes/THEME-NAME/css/
      themes/THEME-NAME/js/
     
 for each plug-in:
  
      plugins/PLUGIN-NAME/css/
      plugins/PLUGIN-NAME/js/

## Want to help?

We are looking for developers who want to become involved. Check here the issues we need your help with:

https://github.com/leoloso/PoP/issues?q=is%3Aissue+is%3Aopen+label%3A%22help+wanted%22

### Many thanks to BrowserStack!

Open to Open Source projects for free, PoP uses the Live, Web-Based Browser Testing provided by [BrowserStack](https://www.browserstack.com/).

![BrowserStack](http://www.softcrylic.com/wp-content/uploads/2017/03/browser-stack.png)

-->