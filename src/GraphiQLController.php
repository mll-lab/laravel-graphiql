<?php declare(strict_types=1);

namespace MLL\GraphiQL;

class GraphiQLController
{
    public function __invoke()
    {
        return view('graphiql::index');
    }
}
