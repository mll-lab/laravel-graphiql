# Upgrade guide

This document provides guidance for upgrading between major versions.

## v1 to v2

### Multiple routes

Instead of the configuration option `route`, the configuration file now expects an option `routes`
that defines any number of routes, see https://github.com/mll-lab/laravel-graphiql/pull/14/files#diff-1c777d8014cec320798bb3882fc51a53b38ba3426d07c1ba77b8b8f33bb062a0.

The view can now be rendered from different routes which have different endpoints assigned to them.
Use the provided variables `$url` and `$subscriptionUrl` instead of accessing the configuration directly, see
