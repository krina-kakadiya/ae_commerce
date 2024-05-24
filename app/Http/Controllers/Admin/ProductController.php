<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Product::select('*');
            return  Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('product_image', function ($data) {
                     foreach($data->images as $each) {
                        $url = asset("product-image/$each->product_image");
                        return '<img src=' . $url . ' border="0" width="50"  height="50" class="img-rounded" align="center" />';
                     }
                })
                ->addColumn('category', function ($data) {
                    return $data->category->category_name;
                })

                ->editColumn('description', function ($row) {
                    $des = $row->description;
                    return Str::limit($des, 50) ;
                })

                ->editColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->format('d-M-Y');
                })

                ->editColumn('updated_at', function ($row) {
                    return Carbon::parse($row->updated_at)->format('d-M-Y');
                })

                ->editColumn('product_status', function ($row) {
                    $status = $row->product_status;
                    if ($status == "0") {
                        $data = "<a class='changeStatusOfProduct' href='javascript:void(0);' onclick='changeStatusOfProduct($row->id)' data-id='$row->id' data-toggle='tooltip' rel='tooltip' data-placement='top' title='Status = Active'> <span class='badge rounded-pill bg-success' style='cursor: pointer;'>Active</span> </a>";
                    } else {
                        $data = "<a class='changeStatusOfProduct' href='javascript:void(0);' onclick='changeStatusOfProduct($row->id)' data-id='$row->id' data-toggle='tooltip' rel='tooltip' data-placement='top' title='Status = Inactive'> <span class='badge rounded-pill bg-dark' style='cursor: pointer;'>Inactive</span> </a>";
                    }
                    return $data;
                })

                ->addColumn('action', function ($row) {
                    $btn = "<a href='/admin/product/view/$row->id' class='btn btn-warning btn-sm viewPost' data-id='$row->id' data-toggle='tooltip' rel='tooltip' data-placement='top' title='View Product'> View </a>";
                    $btn .= "&nbsp";
                    $btn .= "<a href='/admin/product/edit/$row->id' class='btn btn-info btn-sm editProduct' data-id='$row->id' data-toggle='tooltip' rel='tooltip' data-placement='top' title='Edit Product'> Edit </a>";
                    $btn .= "&nbsp";
                    $btn .= "<a class='btn btn-danger btn-sm deleteProduct'  href='javascript:void(0);' onclick='deleteConfirmation($row->id)' data-id='$row->id' data-toggle='tooltip' rel='tooltip' data-placement='top' title='Delete Product'> Delete </a>";

                    return $btn;
                })
                ->rawColumns(['product_image','category','description','product_status','action'])
                ->make(true);
        }
        return view('admin.pages.product.index');
    }

    public function create() {
        $categoryData = Category::where('category_status', 0)->get();
        return view('admin.pages.product.create', compact('categoryData'));
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'product_image'     => 'required',
            'product_image.*'   => 'mimes:jpg,jpeg,png',
            'title'             => 'required|min:8|max:150',
            'category'          => 'required',
            'price'             => 'required|max:8',
            'description'       => 'required',
            'product_status'    => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withInput($request->input())->withErrors($validator);
        }

        $product = new Product();

        // for date range picker
        $dateRange = $request->date_range;
        $from_date = $to_date = null;

        if(!empty($dateRange)) {
            $date_range_array = explode(' - ', $dateRange);
            $from_date = date('Y-m-d H:i:s', strtotime($date_range_array[0]));
            $to_date = date('Y-m-d H:i:s', strtotime($date_range_array[1]));
        }

        $product->title = $request->title;
        $product->category_id = $request->category;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->shipping_fee = $request->shipping_fee;
        $product->discount = $request->discount;
        $product->discount_start = $from_date;
        $product->discount_end = $to_date;
        $product->description = $request->description;
        $product->product_status = $request->product_status;
        $product->save();

        foreach($request->file('product_image') as $file) {
            $name =  time().rand(1,99).'.'. $file->extension();
            $file->move(public_path('/product-image'), $name);
            $productImages = new ProductImage();
            $productImages->product_image = $name;
            $productImages->product_id = $product->id;
            $productImages->save();
        }
        return redirect()->route('admin.product.index')->with(['success' => 'Product saved successfully !']);
    }

    public function view($id) {
        $productData = Product::findOrFail($id);
        $productImagesData = ProductImage::where('product_id',$id)->get();

        return view('admin.pages.product.view',compact('productData','productImagesData'));
    }

    public function edit($id) {
        $postData = Product::findOrFail($id);

        $startDate = date('Y-m-d H:i:s', strtotime($postData->discount_start));
        $endDate = date('Y-m-d H:i:s', strtotime($postData->discount_end));

        if(!empty($startDate && $endDate)) {
            $dateRange = $startDate.' - '.$endDate;
        } else {
            $dateRange = '';
        }

        $categoryData = Category::where('category_status', 0)->get();
        return view('admin.pages.product.edit', compact('postData', 'categoryData','dateRange'));
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'product_image.*'   => 'mimes:jpg,jpeg,png',
            'title'             => 'required|min:8|max:150',
            'category'          => 'required',
            'price'             => 'required|max:8',
            'description'       => 'required',
            'product_status'    => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withInput($request->input())->withErrors($validator);
        }

        $product = Product::findOrFail($id);
        $imageReq = $request->file('product_image');
        if ($imageReq != "") {
            $deleteImageArr = ProductImage::where('product_id',$id)->get();
            foreach($deleteImageArr as $eachImage) {
                $oldPath = public_path('product-image/' . $eachImage->product_image);
                if (File::exists($oldPath)) {
                    unlink($oldPath);
                }
                $eachImage->delete();
            }
            foreach($request->file('product_image') as $file) {
                $name =  time().rand(1,99).'.'. $file->extension();
                $file->move(public_path('/product-image'), $name);
                $productImages = new ProductImage();
                $productImages->product_image = $name;
                $productImages->product_id = $id;
                $productImages->save();
            }
        }


        // for date range picker
        $dateRange = $request->date_range;
        $from_date = $to_date = null;

        if(!empty($dateRange)) {
            $date_range_array = explode(' - ', $dateRange);
            $from_date = date('Y-m-d H:i:s', strtotime($date_range_array[0]));
            $to_date = date('Y-m-d H:i:s', strtotime($date_range_array[1]));

        }


        $product->title = $request->title;
        $product->category_id = $request->category;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->shipping_fee = $request->shipping_fee;
        $product->discount = $request->discount;
        $product->discount_start = $from_date;
        $product->discount_end = $to_date;
        $product->description = $request->description;
        $product->product_status = $request->product_status;
        $product->save();
        return redirect()->route('admin.product.index')->with(['success' => 'Product update successfully !']);
    }

    public function delete($id) {
        // $productImage = ProductImage::where('product_id',$id)->get();
        // foreach($productImage as $eachImage) {
        //     $oldPath = public_path('product-image/' . $eachImage->product_image);
        //     if (File::exists($oldPath)) {
        //         unlink($oldPath);
        //     }
        // }
        $post = Product::findOrFail($id);

        if($post->product_status == 0) {
            $post->product_status = "1";
            $post->save();
        }

        $post->delete();
        Session::flash('success', "Product deleted successfully.");

    }

    public function updateStatus($id) {
        $post = Product::findOrFail($id);
        $status = $post->product_status;

        if ($status == 0) {
            $post->product_status = "1";
        } elseif ($status == 1) {
            $post->product_status = "0";
        }
        $post->save();
        Session::flash('success', "Product status change successfully !");
    }

    public function trashed(Request $request) {
        if ($request->ajax()) {
            $data = Product::onlyTrashed();
            return  Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('product_image', function ($data) {
                     foreach($data->images as $each) {
                        $url = asset("product-image/$each->product_image");
                        return '<img src=' . $url . ' border="0" width="50"  height="50" class="img-rounded" align="center" />';
                     }
                })
                ->addColumn('category', function ($data) {
                    return $data->category->category_name;
                })

                ->editColumn('description', function ($row) {
                    $des = $row->description;
                    return Str::limit($des, 50) ;
                })

                ->editColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->format('d-M-Y');
                })

                ->editColumn('updated_at', function ($row) {
                    return Carbon::parse($row->updated_at)->format('d-M-Y');
                })

                ->editColumn('product_status', function ($row) {
                    $status = $row->product_status;
                    if ($status == "0") {
                        $data = "<a data-toggle='tooltip' rel='tooltip' data-placement='top' title='Status = Active'> <span class='badge rounded-pill bg-success' style='cursor: pointer;'>Active</span> </a>";
                    } else {
                        $data = "<a data-toggle='tooltip' rel='tooltip' data-placement='top' title='Status = Inactive'> <span class='badge rounded-pill bg-dark' style='cursor: pointer;'>Inactive</span> </a>";
                    }
                    return $data;
                })

                ->addColumn('action', function ($row) {
                    // $btn = "<a href='/admin/product/view/$row->id' class='btn btn-warning btn-sm viewPost' data-id='$row->id' data-toggle='tooltip' rel='tooltip' data-placement='top' title='View Product'> View </a>";
                    // $btn .= "&nbsp";
                    $btn = "<a class='btn btn-primary btn-sm' href='javascript:void(0);' onclick='restoreProduct($row->id)' data-id='$row->id' data-toggle='tooltip' rel='tooltip' data-placement='top' title='Restore Product'> Restore </a>";
                    $btn .= "&nbsp";
                    $btn .= "<a class='btn btn-danger btn-sm' href='javascript:void(0);' onclick='forceDeleteProduct($row->id)' data-id='$row->id' data-toggle='tooltip' rel='tooltip' data-placement='top' title='Force Delete'> Force Delete </a>";
                    return $btn;
                })
                ->rawColumns(['product_image','category','description','product_status','action'])
                ->make(true);
        }
        return view('admin.pages.product.trashed');
    }


    public function restore($id) {
        Product::where('id', $id)->withTrashed()->restore();
        Session::flash('success', "Product restored successfully.");
    }

    public function forceDelete($id) {

        $productImage = ProductImage::where('product_id',$id)->get();
        foreach($productImage as $eachImage) {
            $oldPath = public_path('product-image/' . $eachImage->product_image);
            if (File::exists($oldPath)) {
                unlink($oldPath);
            }
        }
        $product = Product::withTrashed()->where('id', $id)->first();
        $product->forceDelete();
        Session::flash('success', "Product force deleted successfully.");
    }
}
