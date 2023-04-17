# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

See [GitHub releases](https://github.com/mll-lab/laravel-graphiql/releases).

## Unreleased

## v2.0.1

### Fixed

- Allow scrolling in GraphiQL Explorer plugin

### Changed

- Adjusted styling of the GraphiQL Explorer tab title
- Added some margin to the select element within the GraphiQL Explorer actions

## v2.0.0

### Added

- Allow configuring multiple routes that point to different endpoints https://github.com/mll-lab/laravel-graphiql/pull/14

## v1.2.2

### Fixed

- Properly handle errors of `file_get_contents()` in `graphiql:download-assets`

## v1.2.1

### Fixed

- Only convert full URLs through `url()` helper https://github.com/mll-lab/laravel-graphiql/pull/9

## v1.2.0

### Added

- Add `@graphiql/plugin-explorer`

## v1.1.0

### Added

- Support Laravel 10

## v1.0.1

### Fixed

- Change env variable `GRAPHQL_PLAYGROUND_SUBSCRIPTION_ENDPOINT` to `GRAPHIQL_SUBSCRIPTION_ENDPOINT`

## v1.0.0

### Added

- Support GraphiQL 2
