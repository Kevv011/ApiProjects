<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    //Metodo para listar a los proyectos (READ)
    public function list()
    {
        try {
            return response()->json([
                'message' => 'All projects selected Successfully',
                'data' => Project::all()
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'error' => $error->getMessage()
            ], 400);
        }
    }

    //Metodo para crear un nuevo proyecto (CREATE)
    public function store(Request $request)
    {
        $validateProject = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable',
            'status' => 'nullable',
            'date_start' => 'required|date',
            'date_finish' => 'required|date',
        ]);

        $newProject = Project::create([
            'name' => $validateProject['name'],
            'description' => $validateProject['description'],
            'status' => $validateProject['status'],
            'date_start' => $validateProject['date_start'],
            'date_finish' => $validateProject['date_finish']
        ]);

        return response()->json([
            'message' => 'A new project has benn added',
            'data' => $newProject
        ], 201);
    }

    //Metodo para actualizar un proyecto (UPDATE)
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $validateProject = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable',
            'status' => 'nullable',
            'date_start' => 'required|date',
            'date_finish' => 'required|date',
        ]);

        $project->update([
            'name' => $validateProject['name'],
            'description' => $validateProject['description'],
            'status' => $validateProject['status'],
            'date_start' => $validateProject['date_start'],
            'date_finish' => $validateProject['date_finish']
        ]);

        return response()->json([
            'message' => 'Project updated Successfully',
            'data' => $project
        ], 200);
    }

    //Metodo para hacer un softDelete de un proyecto (DELETE)
    public function softDelete($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        return response()->json([
            'message' => 'Project moved to trash'
        ], 200);
    }

    //Metodo para hacer la consulta de los projectos ejecutados con softDelete
    public function listDeleted()
    {
        $deletedProjects = Project::onlyTrashed()->get();
        return response()->json([
            'message' => 'Deleted projects retrieved successfully',
            'data' => $deletedProjects
        ], 200);
    }

    //Metodo para hacer inserciones de proyectos de prueba
    public function storeProjects()
    {

        DB::table('projects')->insert([
            [
                "name" => "Proyecto 1",
                "description" => "Esta es una descripcion del proyecto 1",
                "status" => "activo",
                "date_start" => "2025-02-28",
                "date_finish" => "2025-02-28",
                "created_at" => now(), 
                "updated_at" => now()
            ],
            [
                "name" => "Proyecto 2",
                "description" => "Esta es una descripcion del proyecto 2",
                "status" => "activo",
                "date_start" => "2025-02-28",
                "date_finish" => "2025-02-28",
                "created_at" => now(), 
                "updated_at" => now()
            ],
            [
                "name" => "Proyecto 3",
                "description" => "Esta es una descripcion del proyecto 3",
                "status" => "finalizado",
                "date_start" => "2025-02-28",
                "date_finish" => "2025-02-28",
                "created_at" => now(), 
                "updated_at" => now()
            ],
            [
                "name" => "Proyecto 4",
                "description" => "Esta es una descripcion del proyecto 4",
                "status" => "activo",
                "date_start" => "2025-02-28",
                "date_finish" => "2025-02-28",
                "created_at" => now(), 
                "updated_at" => now()
            ]
        ]);

        return response()->json([
            'Message' => 'Projects created successfully'
        ], 201);
    }

    //Metodo para eliminar todos los registros de proyectos (Creado para pruebas)
    public function deleteAll()
    {

        DB::table('projects')->delete();
        DB::statement('ALTER TABLE projects AUTO_INCREMENT = 1');

        return response()->json([
            'message' => 'Records delete successfully'
        ]);
    }
}
//    JSON agregado por si se necesita probar el agregar un proyecto
// { 
//     "name": "Proyecto 1",
//     "description": "Esta es una descripcion de un proyecto 2",
//     "status": "activo",
//     "date_start": "2025-02-28",
//     "date_finish": "2025-02-28"
//   }