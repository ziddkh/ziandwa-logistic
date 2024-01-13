<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

final class UserController extends Controller
{
    public function __construct(
        private readonly User $user
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'List User';
        $users = $this->user->withoutSuperAdmin()->get();
        return view('pages.users.index', compact('title', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        try {
            $user = $this->user->where('uuid', $uuid)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        try {
            $permissions = Permission::get();
        } catch (\Throwable $e) {
            throw $e;
        }
        $title = "User - $user->name";

        return view('pages.users.show.index', compact('user', 'permissions', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $uuid)
    {
        try {
            $user = $this->user->where('uuid', $uuid)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(\Illuminate\Http\Response::HTTP_NOT_FOUND);
        }

        try {
            $user->update(Arr::except($request->toArray(), ['password', 'password_confirmation']));

            if ($request->filled('password')) {
                $user->update(['password' => Hash::make($request->password)]);
            }

            $user->syncPermissions($request->permissions ?? []);
        } catch (\Exception $e) {
            throw $e;
        }

        return back()->with("message", "User $user->name updated successully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        //
    }
}
