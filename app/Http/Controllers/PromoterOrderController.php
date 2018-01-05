<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Promoter;
use App\Http\Requests\CreatePromoterOrderPost;

class PromoterOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Promoter $promoter)
    {
        if (!$promoter) {
            return redirect()->back();
        }
        $this->authorize('view', $promoter);
        $departments = Department::all();
        return view('mobile.promoters.order-create', compact('departments'));
    }

    public function store(CreatePromoterOrderPost $request, Promoter $promoter)
    {
        $this->authorize('create', $promoter);
        $promoterOrder = $promoter->addOrder($request->validated());
        return response($promoterOrder, 201);
    }
}
