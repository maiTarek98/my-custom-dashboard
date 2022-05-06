<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Image;
use Yajra\DataTables\DataTables;
class UserController extends Controller
{
    public function __construct() {
        $this->middleware('permission:create-user')->only('create','store');
        $this->middleware('permission:read-user')->only('index','show');
        $this->middleware('permission:edit-user')->only('edit','update');
        $this->middleware('permission:delete-user')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = User::select('*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                            $show_route= route("users.show",$row->id);
                            $edit_route= route("users.edit",$row->id);
                            $delete_route= route("users.destroy",$row->id);
                            $csrf_token=csrf_token() ;
                            $btn = '<a href="'.$show_route.'" class="edit btn btn-primary btn-sm">View</a><a href="'.$edit_route.'" class="edit btn btn-warning btn-sm">Edit</a>
                                <form class="del-form" method="POST" action="'.$delete_route.'"><input type="hidden" name="_method" value="delete"><input type="hidden" name="_token" value="'.$csrf_token.'"><button type="submit" class="edit btn btn-danger btn-sm">Delete</button></form>';
      
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
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
            'email'=>"required|email|unique:users,email",
            'password'=>"required|min:6|max:20",
            'profile_image' => 'sometimes|nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
        ]);
        $user = User::create([
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
         
            \Storage::disk('local')->put('public/users'.'/'.$imageName, $img, 'public');
            $user->update(['profile_image'=> 'users/'.$imageName]);
        }
        else{
            $imageName= 'avatar.png';
            $admin->update(['profile_image'=> 'admins/'.$imageName]);
        }

        return redirect()->route('users.index')->with('success', 'User is created')->with('imageName',$imageName);
            
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user= User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user= User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
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
            'email'=>"required|email|unique:users,email,".$id,
            'password'=>"sometimes|nullable|min:6|max:20",
            'profile_image' => 'sometimes|nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
        ]);
        $user = User::where('id', $id)->update([
            "name"=>$request->name,
            "email"=>$request->email,
            // "password"=>\Hash::make($request->password),
        ]);
        if($request->password!=null){
            $user->update([
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
         
            \Storage::disk('local')->put('public/users'.'/'.$imageName, $img, 'public');
            User::where('id', $id)->update(['profile_image'=> 'users/'.$imageName]);
         
        }

        return redirect()->route('users.index')->with('success', 'User is updated');
            

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if($user){
            $user->delete();
        }
        return redirect()->route('users.index')->with('success', 'User is deleted');

    }
}
