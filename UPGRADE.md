# Upgrade guide

This document provides guidance for upgrading between major versions.

## v3 to v4

### View

If you have published and/or customized the view, you need to republish or update it.
See [views/index.blade.php](views/index.blade.php) for the latest version.

Major changes:

- The URLs for the GraphiQL assets are now provided by class `MLL\GraphiQL\GraphiQLAsset` instead of `MLL\GraphiQL\DownloadAssetsCommand`.
- The setup now uses GraphiQL version 4.

## v1 to v2

### Multiple routes

Instead of the configuration option `route`, the configuration file now expects an option `routes`
that defines any number of routes, see https://github.com/mll-lab/laravel-graphiql/pull/14/files#diff-1c777d8014cec320798bb3882fc51a53b38ba3426d07c1ba77b8b8f33bb062a0.

The view can now be rendered from different routes which have different endpoints assigned to them.
Use the provided variables `$url` and `$subscriptionUrl` instead of accessing the configuration directly, see
