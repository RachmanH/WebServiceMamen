<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Matakuliah;
use Illuminate\Http\Request;

class MatakuliahController extends Controller
{
    public function index()
    {
        return response()->json(Matakuliah::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_mk' => 'required|string|unique:matakuliahs,kode_mk',
            'nama_mk' => 'required|string',
        ]);

        $data = Matakuliah::create($request->all());
        return response()->json($data, 201);
    }

    public function show($id)
    {
        $data = Matakuliah::find($id);
        if (!$data) return response()->json(['message' => 'Not Found'], 404);
        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $data = Matakuliah::find($id);
        if (!$data) return response()->json(['message' => 'Not Found'], 404);

        $request->validate([
            'kode_mk' => 'required|string|unique:matakuliahs,kode_mk,' . $id,
            'nama_mk' => 'required|string',
        ]);

        $data->update($request->all());
        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $data = Matakuliah::find($id);
        if (!$data) return response()->json(['message' => 'Not Found'], 404);

        $data->delete();
        return response()->json(['message' => 'Deleted'], 200);
    }
}
