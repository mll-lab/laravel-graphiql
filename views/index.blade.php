<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset=utf-8/>
    <meta name="viewport"
          content="user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, minimal-ui">
    <title>GraphiQL</title>
    <style>
        body {
            height: 100%;
            margin: 0;
            width: 100%;
            overflow: hidden;
        }

        #graphiql {
            height: 100vh;
        }
    </style>
    <script src="{{ \MLL\GraphiQL\DownloadAssetsCommand::reactPath() }}"></script>
    <script src="{{ \MLL\GraphiQL\DownloadAssetsCommand::reactDOMPath() }}"></script>
    <link rel="stylesheet" href="{{ \MLL\GraphiQL\DownloadAssetsCommand::cssPath() }}"/>
    <link rel="shortcut icon" href="{{ \MLL\GraphiQL\DownloadAssetsCommand::faviconPath() }}"/>
</head>

<body>

<div id="graphiql">Loading...</div>
<script src="{{ \MLL\GraphiQL\DownloadAssetsCommand::jsPath() }}"></script>
<script src="{{ \MLL\GraphiQL\DownloadAssetsCommand::explorerPluginPath() }}"></script>
<script>
    const fetcher = GraphiQL.createFetcher({
        url: '{{ filter_var($endpoint = config('graphiql.endpoint'), FILTER_VALIDATE_URL) ? url($endpoint) : $endpoint }}',
        subscriptionUrl: '{{ config('graphiql.subscription-endpoint') }}',
    });

    function GraphiQLWithExplorer() {
        const [query, setQuery] = React.useState('');

        return React.createElement(GraphiQL, {
            fetcher: fetcher,
            query: query,
            onEditQuery: setQuery,
            defaultEditorToolsVisibility: true,
            plugins: [
                GraphiQLPluginExplorer.useExplorerPlugin({
                    query: query,
                    onEdit: setQuery,
                })
            ],
        });
    }

    ReactDOM.render(
        React.createElement(GraphiQLWithExplorer),
        document.getElementById('graphiql'),
    );
</script>

</body>
</html>
