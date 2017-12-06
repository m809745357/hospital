<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserPost;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('mobile.user.index');
    }

    public function update(UpdateUserPost $request)
    {
        $user = auth()->user();

        tap($user)->update($request->validated());

        return response(['data' => '更新成功'], 201);
    }
}
