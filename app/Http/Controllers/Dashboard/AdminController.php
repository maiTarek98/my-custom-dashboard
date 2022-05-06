<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Role;
use Image;
use Yajra\DataTables\DataTables;
use Auth;
class AdminController extends Controller
{
    public function __construct() {
        $this->middleware('permission:create-admin')->only('create','store');
        $this->middleware('permission:read-admin')->only('index','show');
        $this->middleware('permission:edit-admin')->only('edit','update');
        $this->middleware('permission:delete-admin')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Admin::select('*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                            $show_route= route("admins.show",$row->id);
                            $edit_route= route("admins.edit",$row->id);
                            $delete_route= route("admins.destroy",$row->id);
                            $csrf_token=csrf_token() ;
                            $btn = '<a href="'.$show_route.'" class="edit btn btn-primary btn-sm">View</a><a href="'.$edit_route.'" class="edit btn btn-warning btn-sm">Edit</a>
                                <form class="del-form" method="POST" action="'.$delete_route.'"><input type="hidden" name="_method" value="delete"><input type="hidden" name="_token" value="'.$csrf_token.'"><button type="submit" class="edit btn btn-danger btn-sm">Delete</button></form>';
      
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.admins.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::get();

        return view('admin.admins.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>"required|string|min:3|max:190",
            'email'=>"required|email|unique:admins,email",
            'password'=>"required|min:6|max:20",
            'role_id'=>"required|integer",
            'profile_image' => 'sometimes|nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
        ]);
        $admin = Admin::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=>\Hash::make($request->password),
        ]);

        if($request->hasFile('profile_image')){
            $image = $request->file('profile_image');
            $imageName = time().'.'.$image->extension();
           
            $destinationPathThumbnail = public_path('/thumbnail');
            $img = Image::make($image->path());
            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPathThumbnail.'/'.$imageName);
         
            \Storage::disk('local')->put('public/admins'.'/'.$imageName, $img, 'public');
            $admin->update(['profile_image'=> 'admins/'.$imageName]);
        }
        else{
            $imageName= 'avatar.png';
            $admin->update(['profile_image'=> 'admins/'.$imageName]);
        }
        $role = Role::find($request->input('role_id'));

        $admin->attachRole($role);
        return redirect()->route('admins.index')->with('success', 'Admin is created')->with('imageName',$imageName);
            
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $admin= Admin::findOrFail($id);
        return view('admin.admins.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
                $roles = Role::get();
        $admin= Admin::findOrFail($id);
        return view('admin.admins.edit', compact('admin','roles'));
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
        $request->validate([
            'name'=>"required|string|min:3|max:190",
            'email'=>"required|email|unique:admins,email,".$id,
            'password'=>"sometimes|nullable|min:6|max:20",
           'role_id'=>"required|integer", 
            'profile_image' => 'sometimes|nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
        ]);
        $admin =Admin::findOrFail($id);
         Admin::where('id', $id)->update([
            "name"=>$request->name,
            "email"=>$request->email,
            // "password"=>\Hash::make($request->password),
        ]);

         if($request->password!=null){
            $admin->update([
                "password"=>\Hash::make($request->password)
            ]);
        }
        if($request->hasFile('profile_image')){
            $image = $request->file('profile_image');
            $imageName = time().'.'.$image->extension();
           
            $destinationPathThumbnail = public_path('/thumbnail');
            $img = Image::make($image->path());
            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPathThumbnail.'/'.$imageName);
         
            \Storage::disk('local')->put('public/admins'.'/'.$imageName, $img, 'public');
            Admin::where('id', $id)->update(['profile_image'=> 'admins/'.$imageName]);
         
        }

        // Update role of the admin
            $roles = $admin->roles;
            foreach ($roles as $key => $value) {
                $admin->detachRole($value);
            }

            $role = Role::find($request->input('role_id'));

            $admin->attachRole($role);
        return redirect()->route('admins.index')->with('success', 'Admin is updated');
            

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        if($admin){
            $roles = $admin->roles;
            foreach ($roles as $key => $value) {
                $admin->detachRole($value);
            }
            $admin->delete();
        }
        return redirect()->route('admins.index')->with('success', 'Admin is deleted');

    }
}
