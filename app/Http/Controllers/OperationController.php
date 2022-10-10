<?php

namespace App\Http\Controllers;

use App\Http\Resources\OperationCollection;
use App\Models\Balance;
use App\Models\Operation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperationController extends Controller
{
    /**
     * @param Request $request
     * @return OperationCollection
     */
    public function lastOperations(Request $request): OperationCollection
    {
        $balance = Balance::where('user_id', Auth::id())->first();

        $operations = Operation::where('balance_id', $balance->id)->orderBy('id', 'desc')->limit(5)->get();
        return (new OperationCollection($operations))
            ->additional(['meta' => [
                'balance' => $balance->balance,
            ]]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $params = $request->all();

        $balance = Balance::where('user_id', Auth::id())->first();
        $query = Operation::where('balance_id', $balance->id);

        if (!empty($params['order_by'])) {
            strpos($params['order_by'], '-') === false ? $query->orderBy('created_at', 'asc') : $query->orderBy('created_at', 'desc');
        }
        if (!empty($params['description'])) {
            $query->where('description', 'like', '%' . $params['description'] . '%');
        }

        $operations = $query->paginate(env('DEFAULT_PAGINATION', 15))->withQueryString();
        return view('operations')->with('operations', $operations);
    }
}
