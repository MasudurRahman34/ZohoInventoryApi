<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Helper\ApiFilter;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\UserRequest;
use App\Http\Resources\v1\UserResource;
use App\Http\Services\V1\UserService;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use ApiFilter, ApiResponse;
    private $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function update(UserRequest $request, $uuid)
    {

        $user = User::where('uuid', $uuid)->where('account_id', Auth::user()->account_id)->first();
        if ($user) {

            DB::beginTransaction();
            try {

                $updateUser = $this->userService->update($request, $user);
                DB::commit();
                $user = User::with('account')->where('uuid', $uuid)->first();
                return $this->success(new UserResource($user));
            } catch (\Throwable $th) {
                DB::rollBack();
                return $this->error($th->getMessage(), 404);
            }
        }
        return $this->error("Data Not Found.", 404);
    }

    public function users(Request $request)
    {

        $this->setFilterProperty($request);
        //$accounts=Accounts::with('user')->get();

        $users = User::where('account_id', Auth::user()->account_id)->orderBy($this->column_name, $this->sort)->paginate($this->show_per_page)->withQueryString();
        return $this->success(new UserResource($users));
    }

    public function user($user_id)
    {

        //return Auth::user()->account->account_id;
        $user = User::where('uuid', $user_id)->where('account_id', Auth::user()->account_id)->first();
        if ($user) {
            return $this->success($user);
        } else {
            return $this->error('Data Not Found', 404);
        }
    }
}
