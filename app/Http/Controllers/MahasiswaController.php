<?php

namespace App\Http\Controllers;
use App\Models\Mahasiswa;

use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index()
    {
        return response()->json(Mahasiswa::all(), 200);
    }

    public function store(Request $request)
    {
        $data = Mahasiswa::create($request->all());
        return response()->json($data, 201);
    }

    public function show($id)
    {
        $data = Mahasiswa::find($id);
        if (!$data) return response()->json(['message' => 'Not Found'], 404);
        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $data = Mahasiswa::find($id);
        if (!$data) return response()->json(['message' => 'Not Found'], 404);

        $data->update($request->all());
        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $data = Mahasiswa::find($id);
        if (!$data) return response()->json(['message' => 'Not Found'], 404);

        $data->delete();
        return response()->json(['message' => 'Deleted'], 200);
    }
}
