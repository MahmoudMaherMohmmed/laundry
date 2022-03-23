<?php

namespace App\Http\Controllers;

use App\Models\ClothesType;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Repository\LanguageRepository;
use App\Http\Services\UploaderService;
use Illuminate\Http\UploadedFile;
use Validator;

class ClothesTypeController extends Controller
{
   /**
     * @var IMAGE_PATH
     */
    const IMAGE_PATH = 'clothes_types';
    /**
     * @var UploaderService
     */
    private $uploaderService;

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(LanguageRepository $languageRepository, UploaderService $uploaderService)
    {
        $this->get_privilege();
        $this->languageRepository    = $languageRepository;
        $this->uploaderService = $uploaderService;
    }

    public function index()
    {
        $clothes_types = ClothesType::latest()->get();
        $languages = $this->languageRepository->all();
        return view('clothes_type.index', compact('clothes_types', 'languages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clothes_type = null;
        $services = Service::latest()->get();
        $languages = $this->languageRepository->all();

        return view('clothes_type.form', compact('clothes_type', 'services', 'languages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|array',
            'name.*' => 'required|string',
            'description' => 'array',
            'service_id' => 'array',
            'image' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $clothes_type = new ClothesType();
        $clothes_type->fill($request->except('name', 'description', 'ímage'));

        if ($request->image) {
            $imgExtensions = array("png", "jpeg", "jpg");
            $file = $request->image;
            if (!in_array($file->getClientOriginalExtension(), $imgExtensions)) {
                \Session::flash('failed', trans('messages.Image must be jpg, png, or jpeg only !! No updates takes place, try again with that extensions please..'));
                return back();
            }

            $clothes_type->image = $this->handleFile($request['image']);
        }

        foreach ($request->name as $key => $value) {
            $clothes_type->setTranslation('name', $key, $value);
        }
    
        foreach ($request->description as $key => $value) {
            $value!=null ? $clothes_type->setTranslation('description', $key, $value) : null;
        }
        
        $clothes_type->save();

        $clothes_type->services()->attach($request->service_id);

        \Session::flash('success', trans('messages.Added Successfully'));
        return redirect('/clothes_type');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $clothes_type = ClothesType::findOrFail($id);
        return view('clothes_type.index', compact('clothes_type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $clothes_type = ClothesType::findOrFail($id);
        $services = Service::latest()->get();
        $languages = $this->languageRepository->all();
        return view('clothes_type.form', compact('clothes_type', 'services', 'languages'));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|array',
            'name.*' => 'required|string',
            'description' => 'array',
            'service_id' => 'array',
            'image' => ''
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $clothes_type = ClothesType::findOrFail($id);

        $clothes_type->fill($request->except('name', 'description', 'ímage'));

        if ($request->image) {
            $imgExtensions = array("png", "jpeg", "jpg");
            $file = $request->image;
            if (!in_array($file->getClientOriginalExtension(), $imgExtensions)) {
                \Session::flash('failed', trans('messages.Image must be jpg, png, or jpeg only !! No updates takes place, try again with that extensions please..'));
                return back();
            }

            if ($clothes_type->image) {
                $this->delete_image_if_exists(base_path('/uploads/clothes_types/' . basename($clothes_type->image)));
            }

            $clothes_type->image = $this->handleFile($request['image']);
        }

        foreach ($request->name as $key => $value) {
            $clothes_type->setTranslation('name', $key, $value);
        }
    
        foreach ($request->description as $key => $value) {
            $value!=null ? $clothes_type->setTranslation('description', $key, $value) : null;
        }
        
        $clothes_type->services()->sync($request->service_id);

        $clothes_type->save();

        \Session::flash('success', trans('messages.updated successfully'));
        return redirect('/clothes_type');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $clothes_type = ClothesType::find($id);
        $clothes_type->services()->detach();
        $clothes_type->delete();

        return redirect()->back();
    }

    /**
     * handle image file that return file path
     * @param File $file
     * @return string
     */
    public function handleFile(UploadedFile $file)
    {
        return $this->uploaderService->upload($file, self::IMAGE_PATH);
    } 
}
