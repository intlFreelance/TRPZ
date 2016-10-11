<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use Session;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    /**
     * Display a listing of the Client.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $data['categories'] = Category::all();

        return view('admin.categories.index',$data);
    }

    /**
     * Show the form for creating a new Client.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created Category in storage.
     *
     * @param Category $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        if($request->file())
        {
            $image = $request->file('image');
            $filename  = time() . '.' . $image->getClientOriginalExtension();

            $path = public_path('img/categories/' . $filename);

            Image::make($image->getRealPath())->save($path);
            $input['image'] = $filename;
        }

        $category = Category::create($input);

        Session::flash('success','Category saved successfully.');

        return redirect(route('categories.index'));
    }

    /**
     * Display the specified Category.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $category = Category::find($id);

        if (empty($category)) {
            Session::flash('error','Category not found');

            return redirect(route('admin.categories.index'));
        }

        return view('admin.categories.show')->with('category', $category);
    }

    /**
     * Show the form for editing the specified Category.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $category = Category::find($id);

        if (empty($category)) {
            Session::flash('error','Category not found');

            return redirect(route('admin.categories.index'));
        }

        return view('admin.categories.edit')->with('category', $category);
    }

    /**
     * Update the specified Category in storage.
     *
     * @param  int              $id
     * @param Category $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $category = Category::find($id);

        if (empty($category)) {
          Session::flash('error','Category not found');

          return redirect(route('categories.index'));
        }

        $input = $request->all();

        if($request->file())
        {
            $image = $request->file('image');
            $filename  = time() . '.' . $image->getClientOriginalExtension();

            $path = public_path('img/categories/' . $filename);

            Image::make($image->getRealPath())->save($path);
            $input['image'] = $filename;
        }

        $category = Category::find($id)->update($input);

        Session::flash('success','Category updated successfully.');

        return redirect(route('categories.index'));
    }
    public function ajaxGetAll(){
        $categories = Category::all();
        return response()->json($categories);
    }

    /**
     * Remove the specified Category from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        if (empty($category)) {
          Session::flash('error','Category not found');

          return redirect(route('categories.index'));
        }

        Category::find($id)->delete();

        Session::flash('success','Category deleted successfully.');

        return redirect(route('categories.index'));
    }
}
