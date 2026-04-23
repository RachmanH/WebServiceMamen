<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ruang;
use Illuminate\Http\Request;

class RuangController extends Controller
{
    public function index()
    {
        return response()->json(Ruang::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_ruang' => 'required|string',
            'gedung' => 'required|string',
        ]);

        $data = Ruang::create($request->all());
        return response()->json($data, 201);
    }

    public function show($id)
    {
        $data = Ruang::find($id);
        if (!$data) return response()->json(['message' => 'Not Found'], 404);
        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $data = Ruang::find($id);
        if (!$data) return response()->json(['message' => 'Not Found'], 404);

        $request->validate([
            'nama_ruang' => 'required|string',
            'gedung' => 'required|string',
        ]);

        $data->update($request->all());
        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $data = Ruang::find($id);
        if (!$data) return response()->json(['message' => 'Not Found'], 404);

        $data->delete();
        return response()->json(['message' => 'Deleted'], 200);
    }
}
