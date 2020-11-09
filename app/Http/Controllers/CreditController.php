<?php

namespace App\Http\Controllers;

use App\Http\Resources\CreditResource;
use App\Models\Credit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class CreditController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $credits = Auth::user()->credits()->paginate(15, ['id', 'from', 'note', 'amount', 'created_at']);
        return Response::json([
            'credits' => CreditResource::collection($credits),
            'total' => ceil($credits->total() / 15)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'from' => 'required|min:2|max:255',
            'note' => '',
            'amount' => 'required|integer|min:2'
        ]);

        Auth::user()->credits()->create($data);
        return Response::json([
            'message' => 'Record added successfully!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Credit  $credit
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Credit $credit)
    {
        return Response::json([
            'credit' => new CreditResource($credit)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Credit  $credit
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Credit $credit)
    {
        $this->checkAuthority($credit);

        $data = $this->validate($request, [
            'from' => 'required|min:2|max:255',
            'note' => '',
            'amount' => 'required|integer|min:2'
        ]);

        $credit->update($data);
        return Response::json([
            'message' => 'Record updated successfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Credit  $credit
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Credit $credit)
    {
        $this->checkAuthority($credit);

        try {
            $credit->delete();
            $msg = 'Record deleted successfully!';
        } catch (Exception $e) {
            $msg = 'Something went wrong!';
        }

        return Response::json([
            'message' => $msg
        ]);
    }

    private function checkAuthority(Credit $credit) {
        if ($credit->getOriginal('user_id') !== Auth::user()->id) {
            return Response::json([
                'message' => 'You do not have permission!'
            ]);
        }
    }
}
