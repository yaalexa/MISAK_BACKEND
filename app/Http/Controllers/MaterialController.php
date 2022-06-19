<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Validation\Rules\Exist;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

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
            'img' => 'required',
            'type_material_id' => 'required',
            'editorial_id' => 'required',
            'area_id' => 'required'
        ]); 
       // if(!$validar ->fails()){
            $material = new Material();
           
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
            $material->img = $image;
            $material->name = $request ->name;
            $material->isbn = $request ->isbn;
            $material->year = $request ->year;
            $material->num_pages = $request ->num_pages;
            $material->priority = $request ->priority;
            $material->type_material_id = $request ->type_material_id;
            $material->editorial_id = $request ->editorial_id;
            $material->area_id = $request ->area_id;
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
        ->get();
        if (isset($material)){
            return $material;
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function buscar( Request $request, $name)
    {

        $material = Material::where('name','like','%'.$name.'%')
        ->get();
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

    public function buscarm(Request $request,$buscador)
    {
        if (isset($buscador)){
        $libros = Material::filtroPorTituloYAutor( $buscador )->get();
        return $libros;
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
            'type_material_id' => 'required',
            'editorial_id' => 'required',
            'area_id' => 'required'
           
        ]);

        if(!$validar->fails()){
            $material = Material::find($id);
            if(isset($material)){
                $material->name = $request ->name;
                $material->year = $request ->year;
                $material->isbn = $request ->isbn;
                $material->priority = $request ->priority;
                $material->num_pages = $request ->num_pages;
                $material->type_material_id = $request->type_material_id;
                $material->editorial_id = $request->editorial_id;
                $material->area_id = $request->area_id;
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
    public function download($uuid)
    {
        $book = Material::where('id', $uuid)->firstOrFail();
        $pathToFile = storage_path("../storage/app/public/$book->pdf" );
        //return response()->download($pathToFile);
        return response()->file($pathToFile);
    }

    public function visualizacion()
    {
        $visualizacion=DB::table('materials')
        ->select('materials.id AS id', 'materials.name AS NOMBRE', 'materials.isbn AS ISBN', 'materials.num_pages AS #PAG',
                'materials.priority AS PRIORIDAD', 'materials.year AS AÑO', 'type__materials.name AS TIPO MATERIAL' ,
                'editorials.name AS EDITORIAL', 'areas.name AS AREA')
        ->join('type__materials', 'materials.type_material_id','=','type__materials.id')
        ->join('editorials', 'materials.editorial_id','=','editorials.id')
        ->join('areas', 'materials.area_id','=','areas.id')
        ->groupBy('ID', 'NOMBRE', 'ISBN', '#PAG', 'PRIORIDAD', 'AÑO', 'TIPO MATERIAL' , 'EDITORIAL', 'AREA')
        ->get();
        return $visualizacion;
    }
    public function buscarvisualizacion($name){
    {
        $visualizacion1=DB::table('author__materials')
        ->select('materials.id AS ID', 'materials.name AS NOMBRE', 'materials.isbn AS ISBN', 'materials.num_pages AS #PAG',
                'materials.priority AS PRIORIDAD', 'materials.year AS AÑO', 'authors.name AS AUTOR' ,
                'editorials.name AS EDITORIAL', 'areas.name AS AREA')
        ->join('materials', 'author__materials.material_id','=','materials.id')
        ->join('authors', 'author__materials.author_id','=','authors.id')
        ->join('editorials', 'materials.editorial_id','=','editorials.id')
        ->join('areas', 'materials.area_id','=','areas.id')
        ->where('materials.name','like','%'.$name.'%')
        ->groupBy('ID', 'NOMBRE', 'ISBN', '#PAG', 'PRIORIDAD', 'AÑO', 'AUTOR' , 'EDITORIAL', 'AREA')
        ->get();
        return $visualizacion1;
    }
    }
    public function buscadorfinal($search)
    {
        $visualizacion1 = Material::select(
                'materials.id as id',
                'materials.priority as prioridad',
                'materials.name as nombre',
                'editorials.name AS editorial',
                'areas.name AS area',
                'type__materials.name AS tipo_material',
                'materials.img AS imagen',
                'a.autores AS autor',
                't.nivel AS nivel_educativo'
            )
            ->leftjoin('areas', 'areas.id', '=', 'materials.area_id')
            ->leftjoin('type__materials', 'type__materials.id', '=', 'materials.type_material_id')
            ->leftjoin('editorials', 'editorials.id', '=', 'materials.editorial_id')
            ->join(DB::raw("(select materials.id as idmaterial,group_concat(authors.name separator ',') as autores 
                    from authors 
                    left join author__materials on authors.id=author__materials.author_id 
                    left join materials on materials.id=author__materials.material_id 
                    GROUP BY idmaterial
                        ) as a"),function($join){
                            $join->on("a.idmaterial","=","materials.id");
                    })
            ->join(DB::raw("(select materials.id as idmaterialt,group_concat(educational_levels.name separator ',') as nivel 
            from educational_levels 
               left join material__educational_levels on material__educational_levels.educational_level_id=educational_levels.id
               left join materials on materials.id=material__educational_levels.material_id
               GROUP BY idmaterialt) as t"), function($join1){
                    $join1->on("t.idmaterialt","=","materials.id");
               })
            ->where('materials.name', 'like', '%' . $search . '%')
            ->orWhere('editorials.name', 'like', '%' . $search . '%')
            ->orWhere('type__materials.name', 'like', '%' . $search . '%')
            ->orWhere('areas.name', 'like', '%' . $search . '%')
            ->orWhere('a.autores', 'like', '%' . $search . '%')
            ->orWhere('t.nivel', 'like', '%' . $search . '%')
            ->get();
        return $visualizacion1;
    }
    
  
}
