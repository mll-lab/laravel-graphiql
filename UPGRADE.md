# Upgrade guide

This document provides guidance for upgrading between major versions.

## v3 to v4

### View

The URLs for the GraphiQL assets are now provided by class `MLL\GraphiQL\GraphiQLAsset` instead of `MLL\GraphiQL\DownloadAssetsCommand`.
If you have published the view, update it according to this diff:

```diff
@@ -1,6 +1,8 @@
 <!DOCTYPE html>
 <html lang="en">
-@php use MLL\GraphiQL\DownloadAssetsCommand; @endphp
+@php
+use MLL\GraphiQL\GraphiQLAsset;
+@endphp
 <head>
     <meta charset=utf-8/>
     <meta name="viewport"
@@ -45,17 +47,17 @@
             margin-left: var(--px-12);
         }
     </style>
-    <script src="{{ DownloadAssetsCommand::reactPath() }}"></script>
-    <script src="{{ DownloadAssetsCommand::reactDOMPath() }}"></script>
-    <link rel="stylesheet" href="{{ DownloadAssetsCommand::cssPath() }}"/>
-    <link rel="shortcut icon" href="{{ DownloadAssetsCommand::faviconPath() }}"/>
+    <script src="{{ GraphiQLAsset::reactJS() }}"></script>
+    <script src="{{ GraphiQLAsset::reactDOMJS() }}"></script>
+    <link rel="stylesheet" href="{{ GraphiQLAsset::graphiQLCSS() }}"/>
+    <link rel="shortcut icon" href="{{ GraphiQLAsset::favicon() }}"/>
 </head>
 
 <body>
 
 <div id="graphiql">Loading...</div>
-<script src="{{ DownloadAssetsCommand::jsPath() }}"></script>
-<script src="{{ DownloadAssetsCommand::pluginExplorerPath() }}"></script>
+<script src="{{ GraphiQLAsset::graphiQLJS() }}"></script>
+<script src="{{ GraphiQLAsset::pluginExplorerJS() }}"></script>
 <script>
     const fetcher = GraphiQL.createFetcher({
         url: '{{ $url }}',
```

## v1 to v2

### Multiple routes

Instead of the configuration option `route`, the configuration file now expects an option `routes`
that defines any number of routes, see https://github.com/mll-lab/laravel-graphiql/pull/14/files#diff-1c777d8014cec320798bb3882fc51a53b38ba3426d07c1ba77b8b8f33bb062a0.

The view can now be rendered from different routes which have different endpoints assigned to them.
Use the provided variables `$url` and `$subscriptionUrl` instead of accessing the configuration directly, see
