<?php

namespace App\Http\Controllers\User;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(Request $request) {
        $productData = Product::where('product_status', 0)->orderBy('id', 'DESC')->paginate(8);
        $data = '';

        if ($request->ajax()) {
            foreach ($productData as $item) {
                $data .= '<div class="col-lg-3 col-md-4">';
                $data .= '<div class="product">';
                $data .= '<a href=""><img src="/product-image/' . $item->images[0]['product_image'] . '" alt="" height="250" width="230"></a>';
                $data .= '<div class="text">';
                $data .= '<h3><a href="detail.html">' . $item->title . '</a></h3>';
                $data .= '<p class="price"> Rs.' . $item->price . ' /- </p>';
                $data .= '<p class="buttons">';
                $data .= '<a href="/product-view/' . $item->id . '" class="btn btn-outline-secondary">View detail</a>';
                $sessionData = session('cart');
                if (!empty($sessionData)) {
                    $arrayKeys = array_keys($sessionData);
                    if (in_array($item->id, $arrayKeys)) {
                        $data .= '<a href="cart/" class="btn btn-primary"><i class="fa fa-shopping-cart"></i>Added</a>';
                        // $data .= '<input type="number" value="1" class="form-control quantity update-cart">';
                    } else {
                        $data .= '<a href="/add-to-cart/' . $item->id . '" class="btn btn-primary"><i class="fa fa-shopping-cart"></i>Add to cart</a>';
                    }
                } else {
                    $data .= '<a href="/add-to-cart/' . $item->id . '" class="btn btn-primary"><i class="fa fa-shopping-cart"></i>Add to cart</a>';
                }
                $data .= '</p>';
                $data .= '</div></div></div>';
            }
            return $data;
        }
        return view('user.pages.home.index', compact('productData'));
    }

    public function categoryView($id) {
        $categoryDetails = Category::where('id', $id)->where('category_status', 0)->first();
        $productData = Product::where('category_id', $id)->where('product_status', 0)->paginate(6);
        return view('user.pages.home.category', compact('categoryDetails', 'productData'));
    }

    public function productView(Request $request, $id) {
        $productData = Product::findOrFail($id);
        return view('user.pages.home.product-view', compact('productData'));
    }
}
