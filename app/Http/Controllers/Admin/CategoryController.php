<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use Carbon\Carbon;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Category::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('category_image', function ($data) {
                    $url = asset("category-image/$data->category_image");
                    return '<img src=' . $url . ' border="0" width="50"  height="50" class="img-rounded" align="center" />';
                })
                ->editColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->format('d-M-Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return Carbon::parse($row->updated_at)->format('d-M-Y');
                })
                ->editColumn('category_status', function ($row) {
                    $status = $row->category_status;
                    if ($status == "0") {
                        $data = "<a class='changeStatusOfCategory'  href='javascript:void(0);' onclick='changeStatusOfCategory($row->id)' data-id='$row->id' data-toggle='tooltip' rel='tooltip' data-placement='top' title='Status = Active'> <span class='badge rounded-pill bg-success' style='cursor: pointer;'>Active</span> </a>";
                    } else {
                        $data = "<a class='changeStatusOfCategory'   href='javascript:void(0);' onclick='changeStatusOfCategory($row->id)' data-id='$row->id' data-toggle='tooltip' rel='tooltip' data-placement='top' title='Status = Inactive'> <span class='badge rounded-pill bg-dark' style='cursor: pointer;'>Inactive</span> </a>";
                    }
                    return $data;
                })
                ->addColumn('action', function ($row) {
                    $btn  = "<a href='/admin/category/edit/$row->id' class='btn btn-info btn-sm editCategory' data-id='$row->id' data-toggle='tooltip' rel='tooltip' data-placement='top' title='Edit'> Edit </a>";
                    $btn .= "&nbsp";
                    $btn .= "<a class='btn btn-danger btn-sm deleteCategory' href='javascript:void(0);' onclick='deleteConfirmation($row->id)' data-id='$row->id' data-toggle='tooltip' rel='tooltip' data-placement='top' title='Delete'> Delete </a>";
                    return $btn;
                })
                ->rawColumns(['category_image', 'category_status', 'action'])
                ->make(true);
        }
        return view('admin.pages.category.index');
    }

    public function create() {
        return view('admin.pages.category.create');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'category_image'    => 'required|image|mimes:jpg,jpeg,png,ico,bmp',
            'category_name'     => 'required|unique:categories|min:5|max:50',
            'category_status'   => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withInput($request->input())->withErrors($validator);
        }

        $category = new Category();

        $categoryImageRequest = $request->file('category_image');
        $imageName = time() . '.' . $categoryImageRequest->extension();
        $categoryImageRequest->move(public_path('/category-image'), $imageName);

        $category->category_name = $request->category_name;
        $category->category_image = $imageName;
        $category->category_status = $request->category_status;
        $category->save();
        return redirect()->route('admin.category.index')->with(['success' => 'Category saved successfully !']);
    }

    public function edit($id) {
        $categoryData = Category::findOrFail($id);
        return view('admin.pages.category.edit', compact('categoryData'));
    }

    public function checkCategory(Request $request) {
        $id = $request->id;
        if (!empty($id)) {
            $rules = array('category_name' => 'required|min:5|max:50|unique:categories,category_name,' . $id . ',id');
        } else {
            $rules = array('category_name' => 'required|min:5|max:50|unique:categories');
        }
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            echo "false";
        } else {
            echo "true";
        }
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'category_image'    => 'mimes:jpg,jpeg,png,ico,bmp',
            'category_name'     => 'required|min:5|max:50|unique:categories,category_name,' . $id,
            'category_status'   => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withInput($request->input())->withErrors($validator);
        }

        $category = Category::findOrFail($id);
        // for image update
        $categoryImageRequest = $request->file('category_image');
        if ($categoryImageRequest != "") {
            $oldPath = public_path('category-image/' . $category->category_image);
            if (File::exists($oldPath)) {
                unlink($oldPath);
            }
            $imageName = time() . '.' . $categoryImageRequest->extension();
            $categoryImageRequest->move(public_path('/category-image'), $imageName);
            $category->category_image = $imageName;
        }

        $category->category_name = $request->category_name;
        $category->category_status = $request->category_status;
        $category->save();

        Session::flash('success', "Category update successfully.");
        return redirect()->route('admin.category.index');
    }

    public function delete($id) {
        $category = Category::findOrFail($id);

        if($category->category_status == 0) {
            $category->category_status = "1";
            $category->save();
        }

        $category->product()->delete();
        $category->delete();
        Session::flash('success', "Category deleted successfully.");
    }

    public function updateStatus($id) {
        $category = Category::findOrFail($id);
        $status = $category->category_status;

        if ($status == 0) {
            $category->category_status = "1";
        } elseif ($status == 1) {
            $category->category_status = "0";
        }
        $category->save();
        Session::flash('success', "Category status change successfully.");
    }

    public function trashedCategory(Request $request) {
        if ($request->ajax()) {
            $data = Category::onlyTrashed();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('category_image', function ($data) {
                    $url = asset("category-image/$data->category_image");
                    return '<img src=' . $url . ' border="0" width="50"  height="50" class="img-rounded" align="center" />';
                })
                ->editColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->format('d-M-Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return Carbon::parse($row->updated_at)->format('d-M-Y');
                })
                ->editColumn('category_status', function ($row) {
                    $status = $row->category_status;
                    if ($status == "0") {
                        $data = "<a data-toggle='tooltip' rel='tooltip' data-placement='top' title='Status = Active'> <span class='badge rounded-pill bg-success' style='cursor: pointer;'>Active</span> </a>";
                    } else {
                        $data = "<a data-toggle='tooltip' rel='tooltip' data-placement='top' title='Status = Inactive'> <span class='badge rounded-pill bg-dark' style='cursor: pointer;'>Inactive</span> </a>";
                    }
                    return $data;
                })
                ->addColumn('action', function ($row) {
                    $btn = "<a class='btn btn-primary btn-sm' href='javascript:void(0);' onclick='restoreCategory($row->id)' data-id='$row->id' data-toggle='tooltip' rel='tooltip' data-placement='top' title='Restore Category'> Restore </a>";
                    $btn .= "&nbsp";
                    $btn .= "<a class='btn btn-danger btn-sm' href='javascript:void(0);' onclick='forceDeleteCategory($row->id)' data-id='$row->id' data-toggle='tooltip' rel='tooltip' data-placement='top' title='Force Delete'> Force Delete </a>";
                    return $btn;
                })
                ->rawColumns(['category_image', 'category_status', 'action'])
                ->make(true);
        }
        return view('admin.pages.category.trashed');
    }

    public function restoreCategory($id) {
        Category::where('id', $id)->withTrashed()->restore();
        Session::flash('success', "Category restored successfully.");
    }

    public function forceDeleteCategory($id) {
        $category = Category::withTrashed()->where('id', $id)->first();
        $oldPath = public_path('category-image/' . $category->category_image);
        if (File::exists($oldPath)) {
            unlink($oldPath);
        }
        $category->forceDelete();
        Session::flash('success', "Category force deleted successfully.");
    }

}
