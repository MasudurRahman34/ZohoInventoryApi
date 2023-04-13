<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\PermissionRequest;
use App\Http\Requests\v1\RolePermissionRequest;
use App\Http\Resources\v1\RoleResource;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Role;
use App\Models\Scopes\AccountScope;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\UnauthorizedException;

// use Spatie\Permission\Models\Permission;


class RolePermissionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexRole()
    {

        $accountData = DB::table('roles')->where('account_id', Auth::guard('api')->user()->account_id);
        $role = DB::table('roles')->where('default', 'yes')->where('status', 'active')->select('id','name','status','created_at')->union($accountData->select('id','name','status','created_at'))->get();

        //return RoleResource::collection($role);
        return $this->success($role);
    }



    public function showRole($roleid)
    {
        try {

            $role = Role::with('permissions')->find($roleid);

            if ($role) {

                if ($role->default == 'yes') {
                    return $this->error('Sorry, predefined roles cannot be edited or deleted. Clone the role instead.', 403);
                }
                return $this->success(new RoleResource($role));
            }
            return $this->dataNotFound();
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 500);
        }
    }

    public function indexPermission(Request $request)
    {

        return $this->success(Permission::get());
    }

    public function indexPermissionGroup(Request $request)
    {

        return $this->success(PermissionGroup::with('permissions')->get());
    }


    public function storeRoleWithPermissions(RolePermissionRequest $request)
    {

        try {
            DB::beginTransaction();
            $roleRequest = $request->validated();

            $newRole = Role::create($roleRequest);
            //$newRole = DB::table('roles')->insert(["name" => $roleRequest['name'], 'guard_name' => 'api', 'default' => 'no', 'status' => 'active', 'account_id' => Auth::user()->account_id, 'created_at' => \now(), 'created_by' => Auth::user()->id]);

            $newRole->syncPermissions($request->permissions);
            DB::commit();
            return $this->success($newRole);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 500);
        }
    }

    public function updateRoleWithPermissions(RolePermissionRequest $request, $roleid)
    {

        $findRole = Role::find($roleid);
        if ($findRole) {
            try {
                $updateRole = $findRole;
                DB::beginTransaction();
                $roleRequest = $request->validated();
                $newRole = $updateRole->update($roleRequest);
                $updateRole->syncPermissions($roleRequest['permissions']);
                DB::commit();
                return $this->success($findRole);
            } catch (\Throwable $th) {
                return $this->error($th, 500);
            }
        }
        return $this->dataNotFound();
    }

    public function UpdatePermission(PermissionRequest $request, $id)
    {
        $findPermission = Permission::find($id);
        if ($findPermission) {
            $updatePermission = $findPermission;
            try {
                DB::beginTransaction();
                $permissionRequest = $request->validated();
                $updatePermission = $updatePermission->update($request->validated());
                DB::commit();
                return $this->success($findPermission->refresh);
            } catch (\Throwable $th) {
                DB::rollBack();
                return $this->error($th->getMessage(), 500);
            }
        }
        return $this->dataNotFound();
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


    public function storePermissionGroup(Request $request)
    {
        try {
            DB::beginTransaction();
            $newPermissionGroup = PermissionGroup::create($request->all());
            DB::commit();
            return $this->success($newPermissionGroup);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->error($th, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assignRole(Request $request)
    {
        try {
            $finduser = User::where('email', $request['email'])->first();
            if ($finduser) {
                DB::beginTransaction();
                $finduser->assignRole([$request['role']]); //should be

                // DB::table('model_has_roles')->create(['role_id'=>])

                DB::commit();
                return $this->success($finduser, 'Role Assigned Successfully', 200);
            } else {
                return $this->error('User Not Found', Response::HTTP_NOT_FOUND);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->error($th->getMessage(), 500);
        }
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
