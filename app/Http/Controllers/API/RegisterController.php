<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request) {
        $register = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $detail = UserDetail::create([
            'status' => $request->status,
            'position' => $request->position,
        ]);

        return ResponseFormatter::success($register);
    }

    public function show(Request $request) {
        $id = $request->input('id');
        $limit = $request->input('limit', 5);
        $name = $request->input('name');
        $email = $request->input('email');

        if($id) {
            $users = User::with(['details'])->find($id);

            if($users)
                return ResponseFormatter::success($users, 'Data User Berhasil Diambil');
            else
                return ResponseFormatter::error(null, 'Data Produk Tidak Ada', 404);
        }

        $users = User::with(['details']);

        if($name)
            $users->where('name', 'like', '%'.$name.'%');

        if($email)
            $users->where('email', 'like', '%'.$email.'%');

        return ResponseFormatter::success(
            $users->paginate($limit), 'Data User Berhasil Diambil'
        );
    }

    public function update(RegisterRequest $request, $id) {
        $data = $request->except(['status', 'position']);
        $data['password'] = Hash::make($request->password);

        $details = $request->only(['status', 'position']);

        $item = User::findOrFail($id);
        $item->update($data);
        $item->details()->update($details);
        
        return ResponseFormatter::success($item, 'Data User Berhasil Diubah');
    }

    public function destroy($id) {
        $removeUser = User::findOrFail($id);
        $removeUser->details()->delete();
        $removeUser->delete();

        return ResponseFormatter::success($removeUser, 'Data User Berhasil Dihapus');
    }
}
