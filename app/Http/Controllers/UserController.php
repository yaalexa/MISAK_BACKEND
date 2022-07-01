<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules\Exist;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;


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
            "res" => true,
            "mensaje" => "¡Registro de usuario exitoso!",
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
                    "rol_id" => $user->rol_id,
                    "usr_name" => $user->name,
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
        $user = User::where('id',$id) ->get();
       return $user;

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
            "name" => "required",
            "full_name" => "required",
            "document_type" => "required",
            "document_number" => "required",
            "certificate_misak" => "required",
            "email" => "required",
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
                $user->rol_id = $request->rol_id;
                $user->save();
                 return response()->json([
                'res'=> true,
                'mensaje' => 'Usuario actualizado correctamente'
            ]);

            }else{
                return response()->json([
                    'res'=> false,
                    'mensaje' => 'error al actualizar!'
                ]);
            }
        }else{
            return response()->json([
                'res'=> false,
                'mensaje' => 'Entrada duplicada!'
            ]);
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
    public function restablecer(Request $request){
        $validar=Validator::make($request->all(), [
            "email" => "required",
            "password" => "required",
            "newpassword"=> "required|confirmed",
        ]);
        $correo=User::where("email","=", $request->email)->first();
        if(isset($correo)){
            if(Hash::check($request->password, $correo->password)){
                $correo->password = Hash::make($request->newpassword);
                $correo->save();
                return response()->json([
                    'mensaje'=>"Se actualizo la contraseña correctamente"
                ]);
            }else{
                return response()->json([
                    'mensaje'=>"Contraseña no coincide"
                ]);
            }
        }else{
                return response()->json([
                    'mensaje'=>"Correo no coincide",
                    'otra'=>$correo

                ]);
            }
    }
    public function update1(Request $request, $id)
    {
        $validar= Validator::make($request->all(), [
            "name" => "required",
            "full_name" => "required",
            "document_type" => "required",
            "document_number" => "required",
            "certificate_misak" => "required",
            "email" => "required",
            'password' => '',
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
                $password=User::where("password","=",$request->pasdword)->first();
                if(isset($password)){
                $password->password=Hash::make($request->password);
                }
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
    function sacarjosue(){
        $docente =  DB::table('users')->select(
            'users.id',
            'users.name',
            'a.visualizado',
            'b.descargado'
        )
        ->leftjoin(DB::raw("(select material__users.users_id as idu, count(material__users.id) as visualizado
        from material__users
        inner join users on users.id = material__users.users_id
        where material__users.detalle_material = 'visualizado'
        GROUP BY material__users.users_id) as a"), function ($join) {
            $join->on("a.idu", "=", "users.id");
        })
        ->leftjoin(DB::raw("(select material__users.users_id as idd, count(material__users.id) as descargado
        from material__users
        inner join users on users.id = material__users.users_id
        where material__users.detalle_material = 'visbalizado'
        GROUP BY material__users.users_id) as b"), function ($join) {
            $join->on("b.idd", "=", "users.id");
        })
        ->join ('rols', 'rols.id', '=', 'users.rol_id')
        ->get();
        return $docente;
    }
}
