<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Controluser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class controluserController extends Controller
{
    public function index()
    {
        $controluser = Controluser::all();

        if ($controluser->isEmpty()) {
            return response()->json(['message' => 'No hay usuario registrados'], 404);
            // $data = [
            //     'message' => 'No hay estudiantes registrados', 
            //     'status' => 200
            // ];
            // return response()->json($data, 404);
        }

        return response()->json($controluser, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'apellidos' => 'required',
            'rol' => 'required|in:admin,user',
            'estatus' => 'required|in:activo,inactivo',
            'fecha_alta' => 'required',
            'fecha_baja' => 'required',
            'fecha_modificacion' => 'required',
        ]);

        //fails tiene como significado de que si falla va arrojar un mensaje de error
        if ($validator->fails()) {
            $data = [
                'message' => 'No en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $controluser = Controluser::create([
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'rol' => $request->rol,
            'estatus' => $request->estatus,
            'fecha_alta' => $request->fecha_alta,
            'fecha_baja' => $request->fecha_baja,
            'fecha_modificacion' => $request->fecha_modificacion,
        ]);

        if (!$controluser) {
            $data = [
                'message' => 'Error al añadir un nuevo usuario',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'users' => $controluser,
            'status' => 201
        ];
        return response()->json($data, 201);
    }

    public function show($id)
    {
        $controluser = Controluser::find($id);

        if (!$controluser) {
            $data = [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'users' => $controluser,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $controluser = Controluser::find($id);

        if (!$controluser) {
            $data = [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $controluser->delete();

        $data = [
            'message' => 'Usuario eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $controluser = Controluser::find($id);

        if (!$controluser) {
            $data = [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'apellidos' => 'required',
            'rol' => 'required|in:admin,user',
            'estatus' => 'required|in:activo,inactivo',
            'fecha_alta' => 'required',
            'fecha_baja' => 'required',
            'fecha_modificacion' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'No en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $controluser->nombre = $request->nombre;
        $controluser->apellidos = $request->apellidos;
        $controluser->rol = $request->rol;
        $controluser->estatus = $request->estatus;
        $controluser->fecha_alta = $request->fecha_alta;
        $controluser->fecha_baja = $request->fecha_baja;
        $controluser->fecha_modificacion = $request->fecha_modificacion;

        $controluser->save();

        $data = [
            'message' => 'Usuario actualizado',
            'users' => $controluser,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function updatePartial(Request $request, $id)
    {

        $controluser = Controluser::find($id);

        if (!$controluser) {
            $data = [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => '',
            'apellidos' => '',
            'rol' => 'in:admin,user',
            'estatus' => 'in:activo,inactivo',
            'fecha_alta' => '',
            'fecha_baja' => '',
            'fecha_modificacion' => '',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'No en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if ($request->has('nombre')) {
            $controluser->nombre = $request->nombre;
        }

        if ($request->has('apellidos')) {
            $controluser->apellidos = $request->apellidos;
        }

        if ($request->has('rol')) {
            $controluser->rol = $request->rol;
        }

        if ($request->has('estatus')) {
            $controluser->estatus = $request->estatus;
        }

        if ($request->has('fecha_alta')) {
            $controluser->fecha_alta = $request->fecha_alta;
        }

        if ($request->has('fecha_baja')) {
            $controluser->fecha_baja = $request->fecha_baja;
        }

        if ($request->has('fecha_modificacion')) {
            $controluser->fecha_modificacion = $request->fecha_modificacion;
        }

        $controluser->save();

        $data = [
            'message' => 'Usuario actualizado',
            'users' => $controluser,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}
