<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Controluser;
use App\Models\LoginCredentials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class loginCredentialsController extends Controller
{
    public function getAll()
    {
        $users = Controluser::with('loginCredentials')->get();
        if ($users->isEmpty()) {
            return response()->json(['message' => 'Usuarios no encontrados'], 404);
        }
        return response()->json($users);
    }

    public function getOne($id)
    {
        $user = Controluser::with('loginCredentials')->find($id);

        if (!$user) {
            return response()->json([
                'message' => 'Usuarios no encontrados'
            ], 404);
        }

        $data = [
            'user' => $user,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function createUser(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'rol' => 'required|in:admin,user',
            // 'estatus' => 'required|in:activo,inactivo',
            'email' => 'required|email|unique:login_credentials,email',
            'password' => 'required|string|min:6',
        ]);

        $user = Controluser::create([
            'nombre' => $validated['nombre'],
            'apellidos' => $validated['apellidos'],
            'rol' => $validated['rol'],
            'estatus' => 'activo',
            'fecha_alta' => now(),
        ]);

        $credentials = LoginCredentials::create([
            'controluser_id' => $user->id,
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'message' => 'Usuario creado exitosamete',
            'user' => $user,
            'credentials' => $credentials
        ], 201);
    }

    public function updateUser(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'apellidos' => 'sometimes|required|string|max:255',
            'rol' => 'sometimes|required|in:admin,user',
            'estatus' => 'sometimes|required|in:activo,inactivo',
            'email' => 'sometimes|required|email|unique:login_credentials,email,' . $id . ',controluser_id',
            'password' => 'sometimes|required|string|min:6',
        ]);

        $user = Controluser::findOrFail($id);

        if (isset($validated['estatus']) && $validated['estatus'] === 'inactivo') {
            $user->update([
                'estatus' => 'inactivo',
                'fecha_baja' => now(),
                'fecha_modificacion' => now(),
            ]);
        } else {
            $user->update([
                'nombre' => $validated['nombre'] ?? $user->nombre,
                'apellidos' => $validated['apellidos'] ?? $user->apellidos,
                'rol' => $validated['rol'] ?? $user->rol,
                // 'estatus' => $validated['estatus'] ?? $user->estatus,
                'fecha_modificacion' => now(),
            ]);
        }

        if (isset($validated['email']) || isset($validated['password'])) {
            $credentials = LoginCredentials::where('controluser_id', $id)->first();
            if ($credentials) {
                $credentials->update([
                    'email' => $validated['email'] ?? $credentials->email,
                    'password' => isset($validated['password']) ? Hash::make($validated['password']) : $credentials->password,
                ]);
            }
        }

        return response()->json([
            'message' => 'Usuario actualizado exitosamente',
            'user' => $user,
        ]);
    }

    public function deleteUser($id)
    {
        $user = Controluser::find($id);

        if (!$user) {
            $data = [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $user->delete();

        $data = [
            'message' => 'Usuario eliminado',
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Busca al usuario por email
        $credentials = LoginCredentials::where('email', $validated['email'])->first();

        if (!$credentials || !Hash::check($validated['password'], $credentials->password)) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        // Si las credenciales son correctas
        $user = Controluser::find($credentials->controluser_id);
        return response()->json([
            'message' => 'Inicio de sesión exitoso',
            'user' => $user,
            'credentials' => $credentials,
            'success' => true
        ], 200);
    }
}
