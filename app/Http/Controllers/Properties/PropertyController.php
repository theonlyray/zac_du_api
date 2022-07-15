<?php

namespace App\Http\Controllers\Properties;

use App\Http\Controllers\Controller;
use App\Http\Requests\Property\StorePropertyRequest as PropertyStorePropertyRequest;
use App\Http\Requests\Property\UpdatePropertyRequest;
use App\Models\Property as ModelsProperty;
use App\Models\User;
use App\Services\StorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller
{

    protected $storage;

    public function __construct(StorageService $storage)
    {
        $this->storage = $storage;
    }

    public function index()
    {
        $this->authorize('index', ModelsProperty::class);

        $properties = ModelsProperty::getPropertiesByUserRole(request()->user());

        if ($properties->isNotEmpty()) return response()->json($properties, 200);

        abort(204, 'No se encontraron predios.');
    }

    public function show(ModelsProperty $property)
    {
        $this->authorize('show', $property);

        return response()->json($property->load(['user', 'licenses']), 200);
    }

    public function store(PropertyStorePropertyRequest $request)
    {
        $this->authorize('store', ModelsProperty::class);

        $user = $request->user();
        $propertyData = $request->validated();

        $property = new ModelsProperty($propertyData);

        DB::beginTransaction();

        try {
            $property->save();
            //?uploading map
            $uploadedFile = $this->storage->uploadBase64File($request->mapa, "public/solicitantes/{$user->id}/predios/{$property->id}/docs/", 'map');
            $property['mapa_ubicacion'] = $uploadedFile['url'];
            $property['mapa_url'] = $uploadedFile['path'];
            $property->save();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->storage
                ->deleteDirectory("public/solicitantes/{$user->id}/predios/{$property->id}");
            abort(500, 'No se ha guardado el predio, inténtalo más tarde. '. $th);
        }

        DB::commit();

        return response()->json($property, 200);
    }

    public function update(UpdatePropertyRequest $request, ModelsProperty $property){

        $this->authorize('update', $property);
        $user = $request->user();

        $property->fill($request->validated());

        DB::beginTransaction();
        try {
            $uploadedFile = $this->storage->uploadBase64File($request->doc_value, "public/solicitantes/{$user->id}/predios/{$property->id}/docs/", $request->doc_key);
            $property["{$request->doc_key}_ubicacion"] = $uploadedFile['url'];
            $property["{$request->doc_key}_url"] = $uploadedFile['path'];
            $property->save();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->storage
                ->deleteFiles([$uploadedFile['path']]);
            abort(500, 'No se ha actualizado el predio, inténtalo más tarde. '. $th);
        }

        DB::commit();

        return response()->json($property, 200);
    }


    /**
     * Get propety by user id
     */
    public function getByUser(User $user){
        $this->authorize('getPropertyByUser', [ModelsProperty::class, $user->roles]);

        $properties = ModelsProperty::where('user_id',$user->id)->get();

        if ($properties->isNotEmpty()) return response()->json($properties->load('licenses'), 200);

        abort(204, 'No se encontraron predios.');
    }



}
