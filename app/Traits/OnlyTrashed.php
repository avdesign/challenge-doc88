<?php
/**
 * User: Anselmo Velame
 * Date: 24/10/19
 * Time: 09:34
 */
namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;


trait OnlyTrashed
{
    /**
     * Consultar a query com o lixo quando for requisitado.
     *
     * @param Request $request
     * @param Builder $query
     * @return Builder
     */
    protected function onlyTrashedIfRequested(Request $request, Builder $query)
    {
        if ($request->get('trashed') == 1) {
            $query = $query->onlyTrashed();
        }
        return $query;
    }

}