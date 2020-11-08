<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExpenditureResource;
use App\Models\Expenditure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ExpenditureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $expenditures = Auth::user()->expenditures()->paginate(15, ['id', 'from', 'note', 'amount', 'created_at']);
        return Response::json([
            'expenditures' => ExpenditureResource::collection($expenditures),
            'total' => ceil($expenditures->total() / 15)
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
            'reason' => 'required|min:2|max:255',
            'note' => '',
            'amount' => 'required|integer|min:2'
        ]);

        Auth::user()->expenditures()->create($data);
        return Response::json([
            'message' => 'Record added successfully!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expenditure  $expenditure
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Expenditure $expenditure)
    {
        return Response::json([
            'expenditure' => new ExpenditureResource($expenditure)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expenditure  $expenditure
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Expenditure $expenditure)
    {
        $this->checkAuthority($expenditure);

        $data = $this->validate($request, [
            'reason' => 'required|min:2|max:255',
            'note' => '',
            'amount' => 'required|integer|min:2'
        ]);

        $expenditure->update($data);
        return Response::json([
            'message' => 'Record updated successfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expenditure  $expenditure
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Expenditure $expenditure)
    {
        $this->checkAuthority($expenditure);

        try {
            $expenditure->delete();
            $msg = 'Record deleted successfully!';
        } catch (Exception $e) {
            $msg = 'Something went wrong!';
        }

        return Response::json([
            'message' => $msg
        ]);
    }

    private function checkAuthority(Expenditure $expenditure) {
        if ($expenditure->getOriginal('user_id') !== Auth::user()->id) {
            return Response::json([
                'message' => 'You do not have permission!'
            ]);
        }
    }
}
