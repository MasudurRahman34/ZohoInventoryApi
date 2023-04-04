<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\PermissionRequest;
use App\Http\Requests\v1\RolePermissionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function roleIndex()
    {
        //
    }

    public function indexPermission(Request $request)
    {

        return $this->success(Permission::get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function assignRole()
    {
        Auth::guard('api')->user()->assignRole('Purchase Manager');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeRoleWithPermission(RolePermissionRequest $request)
    {

        try {
            DB::beginTransaction();
            $roleRequest = $request->validated();
            $newRole = Role::create($roleRequest);
            $newRole->syncPermissions($request->permissions);
            DB::commit();
            return $this->success($newRole);
        } catch (\Throwable $th) {
            return $this->error($th, 500);
        }
    }

    public function storePermission(PermissionRequest $request)
    {

        try {
            DB::beginTransaction();
            $permissionRequest = $request->validated();
            $newPermisison = Permission::create($permissionRequest);
            DB::commit();
            return $this->success($newPermisison);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->error($th->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
