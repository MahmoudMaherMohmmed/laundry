<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Service;
use App\Models\ClothesType;
use Illuminate\Http\Request;
use App\Http\Repository\LanguageRepository;
use App\Http\Services\UploaderService;
use Illuminate\Http\UploadedFile;
use Validator;

class ItemController extends Controller
{
   /**
     * @var IMAGE_PATH
     */
    const IMAGE_PATH = 'items';
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
        $items = Item::latest()->get();
        $languages = $this->languageRepository->all();
        return view('item.index', compact('items', 'languages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = null;
        $services = Service::latest()->get();
        $clothes_types = ClothesType::latest()->get();
        $languages = $this->languageRepository->all();

        return view('item.form', compact('item', 'services', 'clothes_types', 'languages'));
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
            'price' => 'required|numeric',
            'service_id' => 'required',
            'image' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $item = new Item();
        $item->fill($request->except('name', 'description', 'ímage'));

        if ($request->image) {
            $imgExtensions = array("png", "jpeg", "jpg");
            $file = $request->image;
            if (!in_array($file->getClientOriginalExtension(), $imgExtensions)) {
                \Session::flash('failed', trans('messages.Image must be jpg, png, or jpeg only !! No updates takes place, try again with that extensions please..'));
                return back();
            }

            $item->image = $this->handleFile($request['image']);
        }

        foreach ($request->name as $key => $value) {
            $item->setTranslation('name', $key, $value);
        }
    
        foreach ($request->description as $key => $value) {
            $value!=null ? $item->setTranslation('description', $key, $value) : null;
        }
        
        $item->save();
        \Session::flash('success', trans('messages.Added Successfully'));
        return redirect('/item');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Item::findOrFail($id);
        return view('item.index', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Item::findOrFail($id);
        $services = Service::latest()->get();
        $clothes_types = ClothesType::latest()->get();
        $languages = $this->languageRepository->all();
        return view('item.form', compact('item', 'services', 'clothes_types', 'languages'));
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
            'price' => 'numeric',
            'image' => ''
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $item = Item::findOrFail($id);

        $item->fill($request->except('name', 'description', 'ímage'));

        if ($request->image) {
            $imgExtensions = array("png", "jpeg", "jpg");
            $file = $request->image;
            if (!in_array($file->getClientOriginalExtension(), $imgExtensions)) {
                \Session::flash('failed', trans('messages.Image must be jpg, png, or jpeg only !! No updates takes place, try again with that extensions please..'));
                return back();
            }

            if ($item->image) {
                $this->delete_image_if_exists(base_path('/uploads/items/' . basename($item->image)));
            }

            $item->image = $this->handleFile($request['image']);
        }

        foreach ($request->name as $key => $value) {
            $item->setTranslation('name', $key, $value);
        }
    
        foreach ($request->description as $key => $value) {
            $value!=null ? $item->setTranslation('description', $key, $value) : null;
        }
        
        $item->save();

        \Session::flash('success', trans('messages.updated successfully'));
        return redirect('/item');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::find($id);
        $item->delete();

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
