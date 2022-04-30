<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Validation\Rules\Exist;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $material = Material::all();
        return $material;   

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
            'isbn' => 'required|unique:materials',
            'year' => 'required',
            'num_pages' => 'required',
            'priority' => 'required',
            'pdf' => 'required',
            'img' => 'required'
        ]); 
       // if(!$validar ->fails()){
            $material = new Material();
           /* 
            $image="";
            if($request->hasFile('img')){
            $image=$request->file('img')->store('image','public');
            }else{
            $image=Null;
            }
            $file="";
            if($request->hasFile('pdf')){
            $file=$request->file('pdf')->store('file','public');
            }else{
            $file=Null;
            }
            $material->pdf = $file;
            $material->img = $image;*/
            $material->name = $request ->name;
            $material->isbn = $request ->isbn;
            $material->year = $request ->year;
            $material->num_pages = $request ->num_pages;
            $material->priority = $request ->priority;
            $material->pdf = $request ->pdf;
            $material->img = $request ->img;
            /*$material->type_material_id = $request ->type_material_id;
            $material->editorial_id = $request ->editorial_id;
            $material->area_id = $request ->area_id;*/
           // $material->save();
        $result=$material->save();
        if($result){
            return response()->json([
                'res'=> true,
                'mensaje' => 'material guardado' ,
                'ruta'=> url('storage/image/'.$material)
            ]);
        }else{
            return response()->json([
                'res'=> false,
                'mensaje' => 'error entrada duplicada' ,
                'ruta' => null
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( Request $request, $id)
    {
        $material = Material::where('id',$id)
        ->first();
        if (isset($material)){
            return response()->json([
                'res'=> true,
                'material' => $material 
            ]);
        }else{
            return response()->json([
                'res'=> false,
                'mensaje' => 'registro no encontrado' 
            ]);
        }
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
            'isbn' => 'required',
            'year' => 'required',
            'num_pages' => 'required',
            'priority' => 'required',
            'pdf' => 'required',
            'img' => 'required',
           
        ]);

        if(!$validar->fails()){
            $material = Material::find($id);
            if(isset($material)){
                $material->name = $request ->name;
                $material->year = $request ->year;
                $material->isbn = $request ->isbn;
                $material->priority = $request ->priority;
                $material->num_pages = $request ->num_pages;
                $material->img = $request ->img;
                $material->pdf = $request ->pdf;
                $material->save();
                 return response()->json([
                'res'=> true,
                'mensaje' => 'material actualizado' 
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
    public function destroy(Request $request, $id)
    {
        $material = Material::find($id);
        if(isset($material)){
            $material->delete();
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
