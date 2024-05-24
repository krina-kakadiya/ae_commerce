<?php
namespace App\Http\Controllers\Admin;

use DataTables;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class UserController extends Controller {
    
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = User::select('*');
            return  Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->format('d-M-Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return Carbon::parse($row->updated_at)->format('d-M-Y');
                })
                ->editColumn('user_status', function ($row) {
                    $status = $row->user_status;
                    if ($status == "0") {
                        $data = "<a class='changeStatusOfUser'  href='javascript:void(0);' onclick='changeStatusOfUser($row->id)' data-id='$row->id' data-toggle='tooltip' rel='tooltip' data-placement='top' title='Status = Active'> <span class='badge rounded-pill bg-success' style='cursor: pointer;'>Active</span> </a>";
                    } else {
                        $data = "<a class='changeStatusOfUser'  href='javascript:void(0);' onclick='changeStatusOfUser($row->id)' data-id='$row->id' data-toggle='tooltip' rel='tooltip' data-placement='top' title='Status = Inactive'> <span class='badge rounded-pill bg-dark' style='cursor: pointer;'>Inactive</span> </a>";
                    }
                    return $data;
                })
                ->addColumn('action', function ($row) {
                    $btn  = "<a href='/admin/user/view/$row->id' class='btn btn-info btn-sm' data-id='$row->id' data-toggle='tooltip' rel='tooltip' data-placement='top' title='View User'> View </a>";
                    $btn .= "&nbsp";
                    $btn .= "<a class='btn btn-danger btn-sm deleteUser' href='javascript:void(0);' onclick='deleteConfirmation($row->id)' data-id='$row->id' data-toggle='tooltip' rel='tooltip' data-placement='top' title='Delete User'> Delete </a>";
                    return $btn;
                })
                ->rawColumns(['action', 'user_status'])
                ->make(true);
        }
        return view('admin.pages.user.index');
    }

    public function view($id) {
        $user = User::findOrFail($id);
        return view('admin.pages.user.view', compact('user'));
    }

    public function delete($id) {
        $user = User::findOrFail($id);
        $user->delete();
        Session::flash('success', "User deleted successfully.");
    }

    public function updateStatus($id) {
        $user = User::findOrFail($id);
        $status = $user->user_status;
        if ($status == 0) {
            $user->user_status = "1";
        } elseif ($status == 1) {
            $user->user_status = "0";
        }
        $user->save();
        Session::flash('success', "User status change successfully.");
    }
}
