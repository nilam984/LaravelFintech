<?php

namespace App\Services;

use App\Models\GlobalService;
use App\Models\Scheme;
use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class DataTableService
{
    public function make($table, Request $request)
    {
        if (!method_exists($this, $table)) {
            abort(404);
        }

        $config = $this->{$table}();

        $query = $config['model']::query();

        if (!empty($config['with'])) {
            $query->with($config['with']);
        }

        if (!empty($config['query'])) {
            $query = $config['query']($query, $request);
        }

        // return DataTables::eloquent($query)->toJson();

        return DataTables::eloquent($query)
            ->filter(function ($query) use ($request) {

                if ($request->filled('status')) {
                    $query->where('status', $request->status);
                }
            }, true) // <-- Keep DataTables global search enabled
            ->toJson();
    }


    protected function users()
    {
        return [

            'model' => User::class,

            'with' => [],

            'query' => function ($query, $request) {

                return $query->where('role', 'user');
            }

        ];
    }

    protected function globalServices()
    {
        return [

            'model' => GlobalService::class,

            'with' => [],

            'query' => function ($query, $request) {

                return $query;
            }

        ];
    }

    protected function serviceRequests()
    {
        return [

            'model' => ServiceRequest::class,

            'with' => ['service', 'user'],

            'query' => function ($query, $request) {

                $user = Auth::user();

                if ($request->user_id) {
                    $query = $query->where('user_id', $request->user_id);
                }

                if ($user->role === 'admin') {
                    return $query;
                }



                $userId = Auth::user()->id;
                return $query->where('user_id', $userId);
            }

        ];
    }

    protected function schemes()
    {
        return [

            'model' => Scheme::class,

            'with' => ['rules'],

            'query' => function ($query, $request) {

                return $query ;
            }

        ];
    }
}
