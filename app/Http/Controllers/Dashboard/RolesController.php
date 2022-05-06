<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
class RolesController extends Controller {
	public function __construct() {
        $this->middleware('permission:create-role')->only('create','store');
        $this->middleware('permission:read-role')->only('index','show');
        $this->middleware('permission:edit-role')->only('edit','update');
        $this->middleware('permission:delete-role')->only('destroy');
    }

	// Roles Listing Page
	public function index(Request $request) {
		//
		if ($request->ajax()) {
			$data = Role::select('*');
			return Datatables::of($data)
			->addIndexColumn()
			->addColumn('action', function($row){
				$edit_route= route("roles.edit",$row->id);
				$delete_route= route("roles.destroy",$row->id);
				$csrf_token=csrf_token() ;
				$btn = '<a href="'.$edit_route.'" class="edit btn btn-warning btn-sm">Edit</a>
				<form class="del-form" method="POST" action="'.$delete_route.'"><input type="hidden" name="_method" value="delete"><input type="hidden" name="_token" value="'.$csrf_token.'"><button type="submit" class="edit btn btn-danger btn-sm">Delete</button></form>';
				
				return $btn;
			})
			->rawColumns(['action'])
			->make(true);
		}
		return view('admin.roles.index');
	}

	// Roles Creation Page
	public function create() {
		//
		$permissions = Permission::get();

		$params = [
			'title' => 'Create Roles',
			'permissions' => $permissions,
		];

		return view('admin.roles.create')->with($params);
	}

	// Roles Store to DB
	public function store(Request $request) {
		//
		$this->validate($request, [
			'name' => 'required|unique:roles',
		]);

		$role = Role::create([
			'name' => $request->input('name'),
			'display_name' => $request->input('name'),
		]);

		// Attach permission to role
		if (!empty(request('permission_id')) && count(request('permission_id')) > 0) {
			foreach ($request->input('permission_id') as $key => $value) {
				$role->attachPermission($value);
			}
		}

		return redirect()->route('roles.index')->with('success', "تم الاضافه بنجاح");
	}

	// Roles Delete Confirmation Page
	public function show($id) {
		// $role = Role::findOrFail($id);

		// $params = [
		// 	'title' => 'Delete Role',
		// 	'role' => $role,
		// ];

		// return view('admin.roles.show')->with($params);
		
	}

	// Roles Editing Page
	public function edit($id) {
		$role = Role::findOrFail($id);
		$permissions = Permission::all();
		$role_permissions = $role->permissions()->get()->pluck('id')->toArray();

		$params = [
			'title' => 'Edit Role',
			'role' => $role,
			'permissions' => $permissions,
			'role_permissions' => $role_permissions,
		];

		return view('admin.roles.edit')->with($params);
	}

	// Roles Update to DB
	public function update(Request $request, $id) {
		$role = Role::findOrFail($id);

		$this->validate($request, [
			'name' => 'required',
		]);

		$role->name = $request->input('name');
		$role->display_name = $request->input('display_name');
		$role->description = $request->input('description');

		$role->save();

		if (!empty(request('permission_id')) && count(request('permission_id')) > 0) {

			DB::table("permission_role")->where("permission_role.role_id", $id)->delete();
				// Attach permission to role
			foreach ($request->input('permission_id') as $key => $value) {
				$role->attachPermission($value);
			}
		}

		return redirect()->route('roles.index')->with('success', "تم التعديل بنجاح");
		
	}

	// Delete Roles from DB
	public function destroy($id) {
		$role = Role::findOrFail($id);

			//$role->delete();

			// Force Delete
			$role->users()->sync([]); // Delete relationship data
			$role->permissions()->sync([]); // Delete relationship data

			$role->forceDelete(); // Now force delete will work regardless of whether the pivot table has cascading delete

			return redirect()->route('roles.index')->with('success', "تم الحذف بنجاح");
			
		}
	}
