<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\User;
use App\Support\Cropper;
use Illuminate\Http\Request;
use App\Http\Requests\Property as PropertyRequest;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Storage;
use function GuzzleHttp\Promise\all;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $properties = Property::orderby('id', 'DESC')->get();
        $users = User::all();
        return view('admin.properties.index', [
            'properties' => $properties,
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $users = User::orderBy('name')->get();

        if (!empty($request->user)) {
            $user = User::where('id', $request->user)->first();
        }

        return view('admin.properties.create', [
            'users' => $users,
            'selected' => (!empty($user) ? $user : null)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PropertyRequest $request)
    {
//        $property = new Property();
//        $property->fill($request->all());

//        var_dump($property->getAttributes());
        $createProperty = Property::create($request->all());

        if ($request->allFiles()) {
            foreach ($request->allFiles()['files'] as $image) {
                $propertyImage = new PropertyImage();
                $propertyImage->property_id = $createProperty->id;
                $propertyImage->path = $image->store('properties/' . $createProperty->id);
                $propertyImage->save();
                unset($propertyImage);
            }
        }

        return redirect()->route('admin.properties.edit', [
            'property' => $createProperty->id
        ])->with(['message' => 'Imóvel cadastrado com sucesso!']);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Property $property
     * @return \Illuminate\Http\Response
     */
    public function show(Property $property)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $property = Property::where('id', $id)->first();
        $users = User::orderBy('name')->get();

        return view('admin.properties.edit', [
            'property' => $property,
            'users' => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PropertyRequest $request, $id)
    {
        $property = Property::where('id', $id)->first();
        $property->fill($request->all());

        $property->setSaleAttribute($request->sale);
        $property->setRentAttribute($request->rent);
        $property->setAirConditioningAttribute($request->air_conditioning);
        $property->setBarAttribute($request->bar);
        $property->setLibraryAttribute($request->library);
        $property->setBarbecueGrillAttribute($request->barbecue_grill);
        $property->setAmericanKitchenAttribute($request->american_kitchen);
        $property->setFittedKitchenAttribute($request->fitted_kitchen);
        $property->setPantryAttribute($request->pantry);
        $property->setEdiculeAttribute($request->edicule);
        $property->setOfficeAttribute($request->office);
        $property->setBathtubAttribute($request->bathtub);
        $property->setFirePlaceAttribute($request->fireplace);
        $property->setLavatoryAttribute($request->lavatory);
        $property->setFurnishedAttribute($request->furnished);
        $property->setPoolAttribute($request->pool);
        $property->setSteamRoomAttribute($request->steam_room);
        $property->setViewOfTheSeaAttribute($request->view_of_the_sea);

        $property->save();

        if ($request->allFiles()) {
            foreach ($request->allFiles()['files'] as $image) {
                $propertyImage = new PropertyImage();
                $propertyImage->property_id = $property->id;
                $propertyImage->path = $image->store('properties/' . $property->id);
                $propertyImage->save();
                unset($propertyImage);
            }
        }

        return redirect()->route('admin.properties.edit', [
            'property' => $property->id
        ])->with(['message' => 'Imóvel editado com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Property $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property)
    {
        //
    }

    public function imageSetCover(Request $request)
    {
        // Pega uma imagem CAPA
        $imageSetCover = PropertyImage::where('id', $request->image)->first();
        // Pega todas as imagens da mesma classe que foi resgatado a cima
        $allImage = PropertyImage::where('property_id', $imageSetCover->property_id)->get();

        foreach ($allImage as $image){
            $image->cover = null;
            $image->save();
        }

        $imageSetCover->cover = true;
        $imageSetCover->save();

        $json = [
            'success' => true
        ];

        return response()->json($json);
    }

    public function imageRemove(Request $request)
    {
        $imageDelete = PropertyImage::where('id', $request->image)->first();

        Storage::delete($imageDelete->path);
        Cropper::flush($imageDelete->path);
        $imageDelete->delete();

        $json = [
            'success' => true
        ];

        return response()->json($json);
    }
}
