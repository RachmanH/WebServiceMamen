<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dosen;

class DosenController extends Controller
{
    public function index()
    {
        return response()->json(Dosen::all(), 200);
    }

    public function store(Request $request)
    {
        $data = Dosen::create($request->all());
        return response()->json($data, 201);
    }

    public function show($id)
    {
        $data = Dosen::find($id);
        if (!$data) return response()->json(['message' => 'Not Found'], 404);
        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $data = Dosen::find($id);
        if (!$data) return response()->json(['message' => 'Not Found'], 404);

        $data->update($request->all());
        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $data = Dosen::find($id);
        if (!$data) return response()->json(['message' => 'Not Found'], 404);

        $data->delete();
        return response()->json(['message' => 'Deleted'], 200);
    }
}
