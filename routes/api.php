<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\EditorialController;
use App\Http\Controllers\Educational_LevelController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\Type_MaterialController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\Author_MaterialController;
use App\Http\Controllers\Material_UserController;
use App\Http\Controllers\Material_EducationalController;

//use App\Http\Controllers\AuthorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//Rutas de areas
Route::get('/areas',[AreaController::class,'index']); // con esta ruta puedo ver todas la areas
Route::post('areas',[AreaController::class,'store']); //con esta ruta puedo registrar una nueva area
Route::get('areas/{id}',[AreaController::class,'show']); // con esta ruta puedo buscar un area especifica
Route::put('areas/{id}',[AreaController::class,'update']); // con esta ruta puedo actualizar un area
Route::delete('areas/{id}',[AreaController::class,'destroy']); // con esta ruta puedo eliminar un area

//rutas de author
Route::get('authors',[AuthorController::class,'index']); // con esta ruta puedo ver todos los autores  
Route::post('authors',[AuthorController::class,'store']); //con esta ruta puedo registrar una nuevo autor
Route::get('authors/{id}',[AuthorController::class,'show']); // con esta ruta puedo buscar un author especifico
Route::put('authors/{id}',[AuthorController::class,'update']); // con esta ruta puedo actualizar un autor
Route::delete('authors/{id}',[AuthorController::class,'destroy']); // con esta ruta puedo eliminar un autor      

//rutas de User
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::group( ['middleware' => ["auth:sanctum"]], function(){
    //rutas
    Route::get('userprofile', [UserController::class, 'userProfile']);
    Route::get('logout', [UserController::class, 'logout']);
});
Route::get('users',[UserController::class,'index']); // con esta ruta puedo ver todos los usuarios
Route::post('users',[UserController::class,'store']); //con esta ruta puedo registrar una nuevo usuario
Route::get('users/{id}',[UserController::class,'show']); // con esta ruta puedo buscar un usuario especifico
Route::put('users/{id}',[UserController::class,'update']); // con esta ruta puedo actualizar un usuario
Route::delete('users/{id}',[UserController::class,'destroy']); // con esta ruta puedo eliminar un usuario 


//de esta forma nos genera todas las rutas

Route::get('editorials',[EditorialController::class,'index']); // con esta ruta puedo ver todas las editoriales
Route::post('editorials',[EditorialController::class,'store']); //con esta ruta puedo registrar una nueva editorial
Route::get('editorials/{id}',[EditorialController::class,'show']); // con esta ruta puedo buscar una editorial especifica
Route::put('editorials/{id}',[EditorialController::class,'update']); // con esta ruta puedo actualizar una editorial
Route::delete('editorials/{id}',[EditorialController::class,'destroy']); // con esta ruta puedo eliminar una editorial

//rutas de Nivel de educacion
Route::get('educational_levels',[Educational_LevelController::class,'index']); 
Route::post('educational_levels',[Educational_LevelController::class,'store']); 
Route::get('educational_levels/{id}',[Educational_LevelController::class,'show']); 
Route::put('educational_levels/{id}',[Educational_LevelController::class,'update']); 
Route::delete('educational_levels/{id}',[Educational_LevelController::class,'destroy']);

//rutas de tipos de material
Route::get('type_materials',[Type_MaterialController::class,'index']);
Route::get('type_materials/{id}',[Type_MaterialController::class,'show']);
Route::post('type_materials',[Type_MaterialController::class,'store']);
Route::put('type_materials/{id}',[Type_MaterialController::class,'update']);
Route::delete('type_materials/{id}',[Type_MaterialController::class,'destroy']);
// Route::Apiresource('type_materials',[Type_MaterialController::class]);

//rutas de tipos de rol
Route::get('rols',[RolController::class,'index']);
Route::get('rols/{id}',[RolController::class,'show']);
Route::post('rols',[RolController::class,'store']);
Route::put('rols/{id}',[RolController::class,'update']);
Route::delete('rols/{id}',[RolController::class,'destroy']);

//rutas de tipos de autor material
Route::get('author_materials',[Author_MaterialController::class,'index']);
Route::get('author_materials/{id}',[Author_MaterialController::class,'show']);
Route::post('author_materials',[Author_MaterialController::class,'store']);
Route::put('author_materials/{id}',[Author_MaterialController::class,'update']);
Route::delete('author_materials/{id}',[Author_MaterialController::class,'destroy']);

//rutas de material
Route::get('/materials',[MaterialController::class,'index']);
Route::get('/materials/{id}',[MaterialController::class,'show']);
Route::get('/buscar/{id}',[MaterialController::class,'buscar']);
Route::post('/materials',[MaterialController::class,'store']);
Route::put('/materials/{id}',[MaterialController::class,'update']);
Route::delete('/materials/{id}',[MaterialController::class,'destroy']);
Route::get('/download/{id}',[MaterialController::class,'download']);
Route::get('/search',[MaterialController::class,'buscarm']);

//rutas de material_user
Route::get('material__users',[Material_UserController::class,'index']);
Route::get('material__users/{id}',[Material_UserController::class,'show']);
Route::post('material__users',[Material_UserController::class,'store']);
Route::put('material__users/{id}',[Material_UserController::class,'update']);
Route::delete('material__users/{id}',[Material_UserController::class,'destroy']);
Route::get('visualmuser',[Material_UserController::class,'visualizacion']);
Route::get('descargasuser',[Material_UserController::class,'descarga']);

//rutas de material educational level
Route::get('material__educational_levels',[Material_EducationalController::class,'index']);
Route::get('material__educational_levels/{id}',[Material_EducationalController::class,'show']);
Route::post('material__educational_levels',[Material_EducationalController::class,'store']);
Route::put('material__educational_levels/{id}',[Material_EducationalController::class,'update']);
Route::delete('material__educational_levels/{id}',[Material_EducationalController::class,'destroy']);