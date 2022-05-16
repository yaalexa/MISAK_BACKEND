<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules\Exist;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{
    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'full_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'rol_id' => 'required' , 
                   
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->full_name = $request->full_name;
        $user->document_type = $request->document_type;
        $user->document_number = $request->document_number;
        $user->certificate_misak = $request->certificate_misak;
        $user->password = Hash::make($request->password);
        $user->rol_id = $request->rol_id;
        $user->save();
        

        return response()->json([
            "status" => 1,
            "msg" => "¡Registro de usuario exitoso!",
        ]);    
    }


    public function login(Request $request) {

        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        $user = User::where("email", "=", $request->email)->first();
        // revisamos si el id es existente
        if( isset($user->id) ){
            // revisamos la encriptacion
            if(Hash::check($request->password, $user->password)){
                //creamos el token
                $token = $user->createToken("auth_token")->plainTextToken;
                //si está todo es correcto
                return response()->json([
                    "status" => 1,
                    "msg" => "usuario correctamente logeado",
                    "access_token" => $token,
                    "usr_id" => $user->id,
                    "rol_id" => $user->rol_id
                ]);        
            }else{
                return response()->json([
                    "status" => 0,
                    "msg" => "password incorrecto",
                ]);    
            }

        }else{
            return response()->json([
                "status" => 0,
                "msg" => "Usuario no registrado",
            ]);  
        }
    }

    public function userProfile() {
        return response()->json([
            "status" => 0,
            "msg" => "Acerca del perfil de usuario",
            "data" => auth()->user()
        ]); 
    }
 
    public function logout() {
        auth()->user()->tokens()->delete();
        
        return response()->json([
            "status" => 1,
            "msg" => "Cierre de Sesión",            
        ]); 
    }
    public function show($id)
    {
        $user = User::where('id',$id)
        ->first();
        if (isset($user)){
            return response()->json([
                'res'=> true,
                'user' => $user 
            ]);
        }else{
            return response()->json([
                'res'=> false,
                'mensaje' => 'registro no encontrado' 
            ]);
        }
    }
    public function index()
    {
        $user = User::all();
        return $user;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validar= Validator::make($request->all(), [
            "name" => "required|unique:users",
            "full_name" => "required",
            "document_type" => "required",
            "document_number" => "required|unique:users",
            "certificate_misak" => "required|unique:users",
            "email" => "required|unique:users",
            "password" => "required",
            "rol_id" =>"required", //se agrego id rol y se borro de tabla roles
        ]);

        if(!$validar->fails()){
            $user = User::find($id);
            if(isset($user)){
                $user->name = $request ->name;
                $user->full_name = $request ->full_name;
                $user->document_type = $request ->document_type;
                $user->document_number = $request ->document_number;
                $user->certificate_misak = $request ->certificate_misak;
                $user->email = $request ->email;
                $user->password = $request ->password;
                $user->rol_id = $request->rol_id;

                $user->save();
                 return response()->json([
                'res'=> true,
                'mensaje' => 'Usuario actualizado' 
            ]);

            }else{
                return response()->json([
                    'res'=> false,
                    'mensaje' => 'error al actualizar'
                ]);
            }
        }else{
            return "entrada duplicada";
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if(isset($user)){
            $user->delete();
            return response()->json([
                'res'=> true,
                'mensaje' => 'exito al elimar'
            ]);
        }else{
            return response()->json([
                'res'=> false,
                'mensaje' => 'falla al elimar no se encontro registro'
            ]);
        }
    }
}
