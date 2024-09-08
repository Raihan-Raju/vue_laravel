<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

use function Laravel\Prompts\password;

class UserController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->with('role', 'photo')->get();
        return $this->sendResponse($users, 'User list fetched successfully!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userData.name' => 'required|string|max:255',
            'userData.email' => 'required|string|email|max:255|unique:users,email',
            'userData.phone_number' => 'required|string|max:15',
            'userData.password' => 'required|string|min:5',
            'userData.address' => 'required|string|max:255',
            'userData.bank_info' => 'required|string|max:255',
            'userData.role_id' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $input = $request->userData;
        $input['password'] = bcrypt($request->userData['password']);
        $user = User::create($input);

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('photos/users'), $imageName);

        $image = $user->photo()->create(['path' => $imageName]);

        $data = [
            'user' => $user,
            'image' => $image
        ];

        return $this->sendResponse($data, 'User created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $users = User::find($id);
        return $this->sendResponse($users, 'User fetched successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            "address" => 'required',
            "phone_number" => 'required',
            "bank_info" => 'required',
            "role_id" => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }
        $input = $request->all();
        if (!empty($request->password)) {
            $input['password'] = bcrypt($request->password);
        } else {
            unset($input['password']);
        }
        $user = User::find($id)->update($input);
        return $this->sendResponse($user, 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();

        if ($user->photo) {
            // Get the photo path
            $photoPath = public_path('images') . '/' . $user->photo->path;

            // Delete the photo file if it exists
            if (File::exists($photoPath)) {
                File::delete($photoPath);
            }

            $user->photo->delete();
        }

        return $this->sendResponse($user, 'User deleted successfully!');
    }

    public function customerList()
    {
        $customerList = User::where('role_id', 2)
            ->orderBy('id', 'desc')
            ->get();

        return $this->sendResponse($customerList, 'User list fetched successfully!');
    }
}
