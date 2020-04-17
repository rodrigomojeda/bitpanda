<?php
namespace App\Http\Controllers\API;
use App\Country;
use App\UserDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;
use Validator;
class UserController extends Controller
{
    public $successStatus = 200;

    /**
     * login api
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->all();
        $user = new User($input);
        $user->save();
       return response()->json(['success' => $user->id], $this->successStatus);

    }


    /**
     * Returns actives users
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function getActives(Request $request){
        try {

            $validator = Validator::make($request->all(), [
                'country' => 'required',
                'actives' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }
            $input = $request->all();

            $country = $input['country'];
            $active = $input['actives'];
            $activeUsers=  User::whereHas('details.country',function ($query) use ($country,$active) {
                $query->where('name', '=', $country);
                $query->where('active','=',$active);
            });
            return response()->json(['success' => $activeUsers->get()], $this->successStatus);
        }catch (Exception $exception){
            return response()->json(['error' => $exception->getMessage()], $exception->getCode());
        }
    }

    /**
     * Returns actives users
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function update(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required',

            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 403);
            }
            $input = $request->all();
            $user = User::with('details.country')->where('id',$input['id'])->first();
            if($user->details()->count()){
                $user->details()->update($input);
                return response()->json(['success' => 'User updated'], $this->successStatus);
            }else{
                throw new Exception('Not details found cannot update',403);
            }
        }catch (Exception $exception){
            return response()->json(['error' => $exception->getMessage()], $exception->getCode());
        }
    }

    public function destroy(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required',

            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 403);
            }
            $input = $request->all();
            $user = User::with('details.country')->where('id',$input['id'])->first();
            if($user->details()->count() == 0){
                $user->delete();
                return response()->json(['success' => 'No details found user deleted'], $this->successStatus);

            }else{
                throw new Exception('Details found cannot be deleted',403);
            }
        }catch (Exception $exception){
            return response()->json(['error' => $exception->getMessage()], $exception->getCode());
        }
    }
}
