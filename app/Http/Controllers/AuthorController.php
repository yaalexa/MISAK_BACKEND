<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules\Exist;
use Illuminate\Support\Facades\Validator;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $author = Author::all();
        return $author;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validar= Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required'
        ]); 
        if(!$validar ->fails()){
            $author = new Author();
            
            $author->name = $request ->name;
            $author->address = $request ->address;
            $author->phone = $request ->phone;
            
            $author->save();

            return response()->json([
                'res'=> true,
                'mensaje' => 'registro guardado' 
            ]);
        }else{
            return response()->json([
                'res'=> false,
                'mensaje' => 'error entrada duplicada' 
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $author = Author::where('id',$id)
        ->get();
        return  $author;
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
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required'
        ]);

        if(!$validar->fails()){
            $author = Author::find($id);
            if(isset($author)){
                $author->name = $request ->name;
                $author->address = $request ->address;
                $author->phone = $request ->phone;

                $author->save();
                 return response()->json([
                'res'=> true,
                'mensaje' => 'autor actualizado' 
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
        $author = Author::find($id);
        if(isset($author)){
            $author->delete();
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
