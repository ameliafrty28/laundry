<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\User;

use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{

    // =====================================================
    // INDEX
    // =====================================================

    public function index()
    {

        $data = User::latest()->get();

        return view(

            'admin.user.index',

            compact('data')

        );
    }



    // =====================================================
    // STORE
    // =====================================================

    public function store(Request $request)
    {

        $request->validate([

            'user_nama' => 'required',

            'user_username' => 'required|unique:data,user_username',

            'user_password' => 'required|min:4',

            'user_role' => 'required'
        ]);



        User::create([

            'user_nama'     => $request->user_nama,

            'user_username' => $request->user_username,

            'user_password' => bcrypt($request->user_password),

            'user_role'     => $request->user_role,
        ]);



        return redirect()

            ->back()

            ->with(

                'success',

                'User berhasil ditambahkan'

            );
    }



    // =====================================================
    // UPDATE
    // =====================================================

    public function update(

        Request $request,

        $id

    ) {

        $user = User::findOrFail($id);



        $request->validate([

            'user_nama' => 'required',

            'user_username' =>

                'required|unique:data,user_username,'

                .$id.

                ',user_id',

            'user_role' => 'required'
        ]);



        $data = [

            'user_nama'     => $request->user_nama,

            'user_username' => $request->user_username,

            'user_role'     => $request->user_role,
        ];



        if ($request->user_password) {

            $data['user_password'] =

                bcrypt($request->user_password);
        }



        $user->update($data);



        return redirect()

            ->back()

            ->with(

                'success',

                'User berhasil diupdate'

            );
    }



    // =====================================================
    // DELETE
    // =====================================================

    public function destroy($id)
    {

        User::findOrFail($id)->delete();



        return redirect()

            ->back()

            ->with(

                'success',

                'User berhasil dihapus'

            );
    }
}