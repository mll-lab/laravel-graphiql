<?php declare(strict_types=1);

namespace MLL\GraphiQL;

use Illuminate\Contracts\View\View;

class GraphiQLController
{
    public function __invoke(): View
    {
        return view('graphiql::index');
    }
}
