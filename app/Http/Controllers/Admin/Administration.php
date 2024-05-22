<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Roles;
use App\Models\Admin;
use App\Models\Driver;
use Hash;
use DB;

use Illuminate\Http\Request;

class Administration extends Controller
{
    public function index(Request $request)
    {
        $data['pageTitle']  = "User Group";

        $roles = Roles::where('name','!=','my permission')->orderBy('id','DESC')->get();

        return view('admin.role.role',compact('roles'),$data)
            ->with('i', ($request->input('page', 1) - 1) * 5);

         return view('admin.role.role');
    }
    public function roleAdd(Request $request)
    {
        if(request()->isMethod("post"))
        {

            $role=Roles::where('name',$request->role_type)->first();
            if($role)
            {
                return redirect()->route('administration.role.add')->with('error', 'Role Already Added!');
            }
            else
            {
                $this->validate($request, [
                    'role_type' => 'required|unique:roles,name',
                 ]);

                $alphas = range('A', 'Z');
                shuffle($alphas);
                $alphas = array_slice($alphas, 0, 2);
                shuffle($alphas);
                $code= implode($alphas);
                $myuid = rand(000,999);
                $customer_id    =$code.$myuid;

                 $create = Roles::insertGetId([
                                     'role_id'         => '#'.$customer_id,
                                     'name'            => $request->role_type,
                                     'description'     => $request->description,
                                     'added_date'      => date('j,F,Y'),
                                     ]);


                    if($request->input('permission'))
                    {
                    foreach($request->input('permission') as $value)
                        {
                            $permission = DB::table('role_has_permissions')->insert([
                            'role_id'       => $create,
                            'permission_id' => $value,
                            ]);
                        }
                    }

                 return redirect()->route('administration.role')->with('message', 'Role created successfully!');
            }
        }
        $data['permission']=DB::table('permissions')->get();
        return view('admin.role.role-add',$data);
    }


    public function roleEdit(Request $request,$id)
    {
        $data['roleDetail']=Roles::whereId($id)->first();
        $data['id']  = $id;
        $data['roleDetail']=Roles::whereId($id)->first();
        $data['id']  = $id;
        $data['permission']=DB::table('permissions')->get();
        $set_permission = DB::table('role_has_permissions')->where('role_id', $id)->get('permission_id');
        $d = json_decode(json_encode($set_permission),true);
        $data['array'] = array_column($d, 'permission_id');

        if(request()->isMethod("post"))
        {
            $request->validate([
                'name' => 'unique:roles,name,'.$id,
              ]);

            $coupon = $request->except(['status','_token']);
            Roles::whereId($id)->update($coupon);
            return redirect()->route('administration.role')->with('message', 'Role Update successfully!');

        }



        return view('admin.role.role-edit',$data);
    }

    public function deleterole(Request $request)
    {
        $id=$request->input('common');
        Roles::whereId($id)->delete();
        return redirect()->route('administration.role')->with('message', 'User role deleted successfully!');
    }

    public function viewRolePermission( Request $request,$id)
    {
        $data['roleDetail']=Roles::whereId($id)->first();
        $data['id']  = $id;
        $data['permission']=DB::table('permissions')->get();
        $set_permission = DB::table('role_has_permissions')->where('role_id', $id)->get('permission_id');
        $d = json_decode(json_encode($set_permission),true);
        $data['array'] = array_column($d, 'permission_id');
        return view('admin.role.role-view-permission',$data);
    }

     public function editRolePermission( Request $request,$id)
    {

        $data['roleDetail']=Roles::whereId($id)->first();
        $data['id']  = $id;
        $data['permission']=DB::table('permissions')->get();
        $set_permission = DB::table('role_has_permissions')->where('role_id', $id)->get('permission_id');
        $d = json_decode(json_encode($set_permission),true);
        $data['array'] = array_column($d, 'permission_id');
        return view('admin.role.role-edit',$data);
    }


    public function userAccess()
    {
        $data['userDetail'] = Admin::where('role_id','!=','1')->orderBy('id','DESC')->get();
        return view('admin.role.user-access',$data);
    }
    public function userAccessAssign(Request $request)
    {

        $data['pageTitle']  = "Add user group";
        if(request()->isMethod("post")){

                if(request()->isMethod("post"))
                {
                     $this->validate($request, [
                                    'email' => 'required|unique:drivers,email',
                                 ]);
                }
                $request->request->remove('_token');

                $input = $request->all();
                $role_data= Roles::whereIn('id',[$input['roles']])->first()->id;
                $person=  Driver::select('id','fullName')->where('id',$input['first_name'])->first();
                // $input['name']      = $input['first_name'] . $input['last_name'];
                $input['name']      = $person->fullName;
                $input['email']      = $input['email'];
                $input['role_id']    = $role_data;
                $input['status']    = $input['status'];
                $input['password']   = Hash::make($input['password']);
                $input['added_date'] = date("j F, Y");
                $user = Admin::create($input);
                return redirect()->route('administration.userAccess')->with('message', 'User added successfully!');

        }
        $data['roles'] = Roles::select('id','name')->get();
        $data['person'] = Driver::select('id','userName')->get();
        return view('admin.role.user-access-assign',$data);
    }


    public function getUserDetail(Request $request)
    {

       $getUserDetail=Driver::select('id','surname','email')->where('id',$request->input('clientId'))->get();
        if(count($getUserDetail)>0)
        {
            return response()->json(
            [
            "success" => 200,
            "message" => "Success",
            "userName"    =>$getUserDetail,

            ]);
        }
        else{
                return response()->json(
            [
                'success' => 400,
                'items' => "Not found any items",
            ]);
        }
    }



    public function deleteAccessRole(Request $request)
    {
        $id=$request->input('common');
        Admin::whereId($id)->delete();
        return redirect()->route('administration.userAccess')->with('message', 'User Access Role deleted successfully!');
    }



    public function assignEdit(Request $request,$id)
    {
        $data['roles'] = Roles::select('id','name')->get();
        if(request()->isMethod("post")){
            $request->validate([
            'email'              => 'unique:admins,email,'.$id,
          ]);

          $rolesData = $request->except(['_token']);
          $rolesData['password'] = Hash::make($request->input('password'));
          Admin::whereId($id)->update($rolesData);
          return redirect()->route('administration.userAccess')->with('message', 'User roles updated successfully!');

        }
        $data['users']=Admin::whereId($id)->first();
        return view('admin.role.user-access-assign-edit',$data);
    }


    public function viewRole(Request $request)
    {

        $alphas = range('A', 'Z');
        shuffle($alphas);
        $alphas = array_slice($alphas, 0, 2);
        shuffle($alphas);
        $code= implode($alphas);
        $myuid = rand(000,999);
        $customer_id    =$code.$myuid;
         $role_id=$request->input('roleId');




            DB::table('role_has_permissions')->where('role_id',$role_id)->delete();

            if($request->input('permission'))
            {
            foreach($request->input('permission') as $value)
                {
                    $permission = DB::table('role_has_permissions')->insert([
                    'role_id'       => $role_id,
                    'permission_id' => $value,
                    ]);
                }
            }
              $id=$request->input('roleId');
              $coupon = [
                       "name" => $request->input('name'),
                        "description" => $request->input('description'),
                        // "status" => $request->input('status'),
                      ];
            Roles::whereId($id)->update($coupon);


            return redirect('admin/administration/role')->with('message', 'Role Permission Updated successfully!');
    }




    public function systemConfiguration()
    {
        return view('admin.role.system-configuration');
    }

}
