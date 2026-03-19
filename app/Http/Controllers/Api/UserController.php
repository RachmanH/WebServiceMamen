<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Mengambil data user. Anda bisa menambahkan ->paginate(10) jika datanya banyak.
        // Sebaiknya kita tidak mengembalikan password, jadi gunakan select()
        $users = User::select('id', 'name', 'email', 'created_at')->get();

        return response()->json([
            'success' => true,
            'message' => 'Data User Berhasil Diambil',
            'data'    => $users
        ], 200);
    }
}
