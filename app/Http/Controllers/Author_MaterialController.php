<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Author_Material;
use Illuminate\Validation\Rules\Exist;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Author_MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $author_material = Author_material::all();
        return $author_material;
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
            'author_id'=> 'required',
            'material_id'=> 'required'
        ]);
        if(!$validar ->fails()){
            $author_material = new Author_material();
            
            $author_material->author_id = $request ->author_id;
            $author_material->material_id = $request ->material_id;

            $author_material->save();

            return response()->json([
                'res'=> true,
                'mensaje' => 'Guardado con exito' 
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
        //$author_material= DB::select('SELECT authors.id, authors.name as material_id FROM authors, author__materials where authors.id=author__materials.id ');
        $author_material = DB::table('authors')
        ->join('author__materials','author__materials.author_id','=','authors.id')
        ->where('author__materials.material_id','=',$id)
        ->select('author__materials.id','authors.name')
        ->get();
        return $author_material;
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
            'author_id' => "required|unique:author__materials",
            'material_id' => "required|unique:author__materials"
        ]);

        if(!$validar->fails()){
            $author_material = Author_material::find($id);
            if(isset($author_material)){
                $author_material->author_id= $request->author_id;
                $author_material->material_id= $request->material_id;

                $author_material->save();
                 return response()->json([
                'res'=> true,
                'mensaje' => 'Se actualizado el registro' 
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
        $author_material = Author_material::find($id);
        if(isset($author_material)){
            $author_material->delete();
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

    public function mostrarautormaterial($id){
        /*$mostrarautor = Author_Material::where('id',$id);*/
       /* $mostrarautormaterial = DB::select('SELECT authors.id, authors.name FROM authors, author__materials where authors.id=author__materials.id and authors.id=1');
        if (isset($mostrarautormaterial)){
           return response()->json([
                'res'=>true,
                'Author_material'=>$mostrarautormaterial
            ]);*/
        $mostrarautormaterial = DB::table('authors')
        ->join('author_materials','author_materials.author_id','authors.id')
        ->where('author_materials.material_id','=',$id)
        ->select('authors-id','authors.name')
        ->get();
        return $mostrarautormaterial;
        }   

    }


