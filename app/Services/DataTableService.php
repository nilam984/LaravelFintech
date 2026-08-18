<?php

namespace App\Services;

use App\Models\AssignedScheme;
use App\Models\BankUpdateRequest;
use App\Models\GlobalService;
use App\Models\IpWhitelist;
use App\Models\LoadMoney;
use App\Models\OauthUser;
use App\Models\PayinTransaction;
use App\Models\PayoutTransaction;
use App\Models\Scheme;
use App\Models\ServiceRequest;
use App\Models\User;
use App\Models\WebHookUrl;
use App\Models\CostSetup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class DataTableService
{
    public function make($table, Request $request)
    {
        if (! method_exists($this, $table)) {
            abort(404);
        }

        $config = $this->{$table}();

        $query = $config['model']::query();

        if (! empty($config['with'])) {
            $query->with($config['with']);
        }

        if (! empty($config['query'])) {
            $query = $config['query']($query, $request);
        }

        // return DataTables::eloquent($query)->toJson();

        return DataTables::eloquent($query)
            ->addColumn('user_name', function ($row) {
                return $row->user?->name ?? '-';
                })
            ->editColumn('type', function ($row) {
                return ucfirst($row->transaction_type);
            })
            ->filter(function ($query) use ($request, $table) {

                if ($request->filled('status')) {
                    $query->where('status', $request->status);
                }

                if ($request->filled('user_id')) {
                    $query->where('user_id', $request->user_id);
                }

                if ($request->filled('from_date') && $request->filled('to_date')) {

                    $query->whereBetween('created_at', [
                        $request->from_date . ' 00:00:00',
                        $request->to_date . ' 23:59:59',
                    ]);
                } elseif ($request->filled('from_date')) {

                    $query->whereDate('created_at', '>=', $request->from_date);
                } elseif ($request->filled('to_date')) {

                    $query->whereDate('created_at', '<=', $request->to_date);
                }

                if ($request->filled('search_key')) {

                    $key = $request->search_key;

                    $query->where(function ($q) use ($key, $table) {

                        if ($table === 'ledgerTransactions') {

                            $q->where('beneficiary_name', 'like', "%{$key}%")
                               ->orWhere('reference_id', 'like', "%{$key}%")
                                ->orWhere('account_number', 'like', "%{$key}%")
                                ->orWhere('order_id', 'like', "%{$key}%")
                                ->orWhere('transaction_type', 'like', "%{$key}%")
                                ->orWhere('narration', 'like', "%{$key}%")
                                ->orWhere('transaction_identifier', 'like', "%{$key}%")
                                ->orWhere('service_id', 'like', "%{$key}%")
                                ->orWhere('amount', 'like', "%{$key}%")
                                ->orWhere('fee', 'like', "%{$key}%")
                                ->orWhere('tax', 'like', "%{$key}%")
                                ->orWhereHas('user', function ($user) use ($key) {

                                    $user->where('name', 'like', "%{$key}%")
                                        ->orWhere('email', 'like', "%{$key}%")
                                        ->orWhere('mobile', 'like', "%{$key}%");

                            });
                        } else {

                            $q->where('payer_name', 'like', "%{$key}%")
                                ->orWhere('payer_email', 'like', "%{$key}%")
                                ->orWhere('payer_mobile', 'like', "%{$key}%")
                                ->orWhere('user_order_id', 'like', "%{$key}%")
                                ->orWhere('payment_reference_id', 'like', "%{$key}%")
                                ->orWhere('utr', 'like', "%{$key}%")

                                ->orWhereHas('user', function ($user) use ($key) {
                                    $user->where('name', 'like', "%{$key}%")
                                        ->orWhere('email', 'like', "%{$key}%")
                                        ->orWhere('mobile', 'like', "%{$key}%");
                                });
                        }
                    });
                }
            }, true)
        ->toJson();
    }

    protected function users()
    {
        return [

            'model' => User::class,

            'with' => ['reseller'],

            'query' => function ($query, $request) {

                $role = Auth::user()->role;
                $Id = Auth::id();

                if ($role === 'reseller') {
                    $query =  $query->where('role', 'user')->where('reseller_id', $Id);
                } elseif ($role === 'admin' || $role === 'verification') {
                    $query =  $query->where('role', 'user');
                }

                return $query;
            },

        ];
    }

    protected function globalServices()
    {
        return [

            'model' => GlobalService::class,

            'with' => [],

            'query' => function ($query, $request) {

                return $query;
            },

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
            },

        ];
    }

    protected function schemes()
    {
        return [

            'model' => Scheme::class,

            'with' => ['rules'],

            'query' => function ($query, $request) {

                return $query;
            },

        ];
    }

    protected function oauthUsers()
    {
        return [
            'model' => OauthUser::class,
            'with' => ['user', 'service'],
            'query' => function ($query, $request) {
                $user = Auth::user();
                if ($user->role === 'admin') {
                    return $query;
                }

                return $query->where('user_id', $user->id);
            },
        ];
    }

    protected function assignedScheme()
    {
        return [

            'model' => AssignedScheme::class,

            'with' => ['user', 'scheme', 'updatedBy'],

            'query' => function ($query, $request) {

                if ($request->user_id) {
                    $query = $query->where('user_id', $request->user_id);
                }

                if ($request->scheme_id) {
                    $query = $query->where('scheme_id', $request->scheme_id);
                }

                return $query;
            },

        ];
    }

    protected function webHookUrls()
    {
        return [

            'model' => WebHookUrl::class,

            'with' => ['service'],

            'query' => function ($query, $request) {

                $user = Auth::user();

                if ($user->role === 'admin') {
                    return $query;
                }

                return $query->where('user_id', $user->id);
            },

        ];
    }

    protected function loadMoney()
    {
        return [

            'model' => LoadMoney::class,

            'with' => ['user', 'updatedBy'],

            'query' => function ($query, $request) {

                $user = Auth::user();

                if ($user->role === 'admin') {
                    if ($request->user_id) {
                        $query = $query->where('user_id', $request->user_id);
                    }

                    return $query;
                }

                $userId = Auth::user()->id;

                $query = $query->where('user_id', $userId);

                return $query;
            },

        ];
    }

    protected function upiInitiation()
    {
        return [

            'model' => PayinTransaction::class,

            'with' => ['user'],

            'query' => function ($query, $request) {

                $user = Auth::user();

                $query->where('status', 'initiated');

                if ($user->role === 'admin') {

                    if ($request->filled('user_id')) {
                        $query->where('user_id', $request->user_id);
                    }

                    return $query;
                }

                return $query->where('user_id', $user->id);
            },

        ];
    }

    protected function upiCollection()
    {
        return [

            'model' => PayinTransaction::class,

            'with' => ['user'],

            'query' => function ($query, $request) {

                $user = Auth::user();

                $query->where('status', 'success');

                if ($user->role === 'admin') {

                    if ($request->filled('user_id')) {
                        $query->where('user_id', $request->user_id);
                    }

                    return $query;
                }

                return $query->where('user_id', $user->id);
            },

        ];
    }

    protected function allUpiTransaction()
    {
        return [

            'model' => PayinTransaction::class,

            'with' => ['user'],

            'query' => function ($query, $request) {

                $user = Auth::user();

                // Admin -> sabhi transactions
                if ($user->role === 'admin') {

                    if ($request->filled('user_id')) {
                        $query->where('user_id', $request->user_id);
                    }

                    return $query;
                }

                // User -> sirf apni transactions
                return $query->where('user_id', $user->id);
            },

        ];
    }

    protected function IpWhitelist()
    {
        return [

            'model' => IpWhitelist::class,

            'with' => ['service'],

            'query' => function ($query, $request) {

                $user = Auth::user();

                return $query->where('user_id', $user->id)->where('is_deleted', false);
            },

        ];
    }

    protected function payoutTransactions()
    {
        return [

            'model' => PayoutTransaction::class,

            'with' => ['user'],

            'query' => function ($query, $request) {

                $user = Auth::user();

                // Admin -> sabhi transactions
                if ($user->role === 'admin') {

                    if ($request->filled('user_id')) {
                        $query->where('user_id', $request->user_id);
                    }

                    return $query;
                }

                // User -> sirf apni transactions
                return $query->where('user_id', $user->id);
            },

        ];
    }

    protected function costSetup()
    {
        return [

            'model' => CostSetup::class,

            'with' => ['service'],

            'query' => function ($query, $request) {

                return $query;
            },

        ];
    }


    protected function verificationUser()
    {
        return [

            'model' => User::class,

            'with' => [],

            'query' => function ($query, $request) {

                return $query->where('role', 'verification');
            },

        ];
    }

    protected function resellerUser()
    {
        return [

            'model' => User::class,

            'with' => [],

            'query' => function ($query, $request) {

                return $query->where('role', 'reseller');
            },

        ];
    }

    protected function bankUpdateRequest()
    {
        return [

            'model' => BankUpdateRequest::class,

            'with' => ['user'],

            'query' => function ($query, $request) {

                $user = Auth::user();

                if ($user->role === 'admin') {

                    if ($request->filled('user_id')) {
                        $query->where('user_id', $request->user_id);
                    }

                    return $query;
                }

                return $query->where('user_id', $user->id);
            },

        ];
    }

 protected function ledgerTransactions()
{
    return [
        'model' => \App\Models\LedgerTransaction::class,

        'with' => ['user'],

        'query' => function ($query, $request) {

            $user = Auth::user();

            if ($user->role === 'admin') {

                if ($request->filled('user_id')) {
                    $query->where('user_id', $request->user_id);
                }

                return $query;
            }

            return $query->where('user_id', $user->id);
        },
    ];
}
}
