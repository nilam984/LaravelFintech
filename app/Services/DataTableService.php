<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DataTableService
{
    public function make(string $table, Request $request)
    {
        if (!method_exists($this, $table)) {
            abort(404, 'Invalid DataTable.');
        }

        $config = $this->{$table}();

        $query = $config['model']::query();

        /*
        |--------------------------------------------------------------------------
        | Select Columns
        |--------------------------------------------------------------------------
        */

        if (!empty($config['select'])) {
            $query->select($config['select']);
        }

        /*
        |--------------------------------------------------------------------------
        | Relationships
        |--------------------------------------------------------------------------
        */

        if (!empty($config['with'])) {
            $query->with($config['with']);
        }

        /*
        |--------------------------------------------------------------------------
        | Filters
        |--------------------------------------------------------------------------
        */

        foreach ($config['filters'] ?? [] as $column) {

            if ($request->filled($column)) {

                $query->where($column, $request->$column);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search, $config) {

                foreach ($config['search'] as $column) {

                    $q->orWhere($column, 'LIKE', "%{$search}%");
                }
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Ordering
        |--------------------------------------------------------------------------
        */

        $orderBy = $request->order_by ?? $config['order']['column'];
        $direction = $request->direction ?? $config['order']['direction'];

        if (!in_array($orderBy, $config['orderable'])) {

            $orderBy = $config['order']['column'];
        }

        $query->orderBy($orderBy, $direction);

        /*
        |--------------------------------------------------------------------------
        | Custom Query
        |--------------------------------------------------------------------------
        */

        if (!empty($config['query']) && is_callable($config['query'])) {

            $query = call_user_func($config['query'], $query, $request);
        }

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->toJson();
    }

    /*
    |--------------------------------------------------------------------------
    | Users Table Configuration
    |--------------------------------------------------------------------------
    */

    protected function users(): array
    {
        return [

            'model' => User::class,

            'select' => [
                'id',
                'name',
                'email',
                'mobile',
                'status',
                'created_at'
            ],

            'with' => [],

            'search' => [
                'name',
                'email',
                'mobile'
            ],

            'filters' => [
                'status'
            ],

            'order' => [
                'column' => 'id',
                'direction' => 'desc'
            ],

            'orderable' => [
                'id',
                'name',
                'email',
                'mobile',
                'status',
                'created_at'
            ],

            /*
            |--------------------------------------------------------------------------
            | Extra Query (Optional)
            |--------------------------------------------------------------------------
            */

            'query' => function ($query, $request) {

                // Example:
                // $query->where('role', 'user');

                return $query;
            }

        ];
    }
}
