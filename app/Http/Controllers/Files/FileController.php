<?php

namespace App\Http\Controllers\Files;

use App\Http\Controllers\Controller;
use App\Http\Requests\Files\DestroyFileRequest;
use App\Http\Requests\Files\StoreFileRequest;
use App\Models\File;
use App\Services\StorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FileController extends Controller
{
    protected $storage;

    public function __construct(StorageService $storage)
    {
        $this->storage = $storage;
    }

    public function index()
    {
        $this->authorize('index', File::class);

        $user = request()->user();

        $files = File::getFilesByRole($user);

        abort_if($files->isEmpty(), 204, 'No se encontraron documentos.');

        return response()->json($files, 200);
    }

    public function store(StoreFileRequest $request)
    {
        $this->authorize('store', File::class);

        $user = $request->user();

        if ($user->hasRole(['jefeSDUMA','directorDpt', 'subDirectorDpt', 'jefeUnidadDpt', 'colaboradorDpt'])) {
            $route = 'public/mpio/public_files';
        }else if ($user->hasRole(['directorCol','subDirectorCol', 'colaboradorCol'])){
            $college = $user->college->pluck('id')->toArray();
            $route = "public/colegios/{$college[0]}/public_files";
        }else if ($user->hasRole(['dro', 'particular'])) {
            $route = "public/solicitantes/$user->id/perfil";
        }else abort(403, 'Rol indefinido');

        try {
            $uploadedFile = $this->storage->saveDocumentBlueprint(
                $request->archivo,
                $route,
                $request->nombre
            );

            $file  = new File([
                'nombre' =>  $request->nombre,
                'ubicacion' => $uploadedFile['path'],
                'url' => $uploadedFile['url'],
                'para' => $request->para,
                'college_id' =>  $request->college_id
            ]);

            $user->file()->save($file);

        } catch (\Throwable $th) {
            $this->storage
                ->deleteDirectory($route);
            abort(500, 'No se ha podido cargar el archivo, intentelo más tarde.'. $th);
        }
        return response()->json($file, 200);
    }

    public function destroy(DestroyFileRequest $request, File $file)
    {
        $this->authorize('destroy', [File::class, $request->contrasenia]);

        DB::beginTransaction();
        try {
            $this->storage->deleteFiles([$file->url]);
            $file->delete();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            abort(500, 'No se ha podido eliminar al archivo.'- $th->getMessage());
        }
        DB::commit();

        return response()->json('Archivo Eliminado', 200,);
    }
}
