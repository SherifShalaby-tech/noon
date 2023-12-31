<?php

namespace App\Http\Controllers;

use App\Models\JobType;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class JobTypeController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return Application|Factory|View
   */
  public function index(): View|Factory|Application
  {
      $jobs = JobType::all();
      $modulePermissionArray = User::modulePermissionArray();
      return view('jobs.index')->with(compact('jobs','modulePermissionArray'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {

  }

  /**
   * Store a newly created resource in storage.
   *
   * @return RedirectResponse
   */
  public function store(Request $request)
    //  : RedirectResponse
  {
      try {
          $job = new JobType();
          $job->title=$request->title;
          $job->created_by = Auth::user()->id;
          $job->date_of_creation = date('Y-m-d');

          $job->save();
          $role = Role::create(['name' => $job->title]);
          $subModulePermissionArray = User::subModulePermissionArray(); 
        //   dd($request);
          foreach($request->permissions as $key=>$permission)
          {
            if (!empty($subModulePermissionArray[$key])) {
                foreach ($subModulePermissionArray[$key] as $key_sub_module =>  $sub_module) {
                    $permission=Permission::where('name', $key . '.' . $key_sub_module . '.view')->first();
                    if (!empty($permission)) {$role->givePermissionTo($permission->id);}
                    $permission=Permission::where('name', $key . '.' . $key_sub_module . '.edit')->first();
                    if (!empty($permission)) {$role->givePermissionTo($permission->id);}
                    $permission=Permission::where('name', $key . '.' . $key_sub_module . '.create')->first();
                    if (!empty($permission)) {$role->givePermissionTo($permission->id);}
                    $permission=Permission::where('name', $key . '.' . $key_sub_module . '.delete')->first();
                    if (!empty($permission)) {$role->givePermissionTo($permission->id);}
                }
            }
          }
          $output = [
              'success' => true,
              'msg' => __('lang.success')
          ];

      }
      catch (\Exception $e){
          Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
          $output = [

              'success' => false,
              'msg' => __('lang.something_went_wrong')
          ];
          dd($e);
      }
      return redirect()->back()->with('status',$output);

  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {

  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Application|Factory|View
   */
  public function edit($id)
  {
      $job = JobType::findOrFail($id);
      $modulePermissionArray = User::modulePermissionArray();
      $role = Role::where('name',$job->title)->first();
      $permissions = $role->permissions;

      $uniqueModuleNames = [];
      foreach ($permissions as $permission)
      {
          $moduleName = $permission->module_name;
          $uniqueModuleNames[$moduleName] = true;
      }

      $uniqueModuleNames = array_keys($uniqueModuleNames);
      return view('jobs.edit')
          ->with(compact('job','modulePermissionArray','permissions','uniqueModuleNames'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return RedirectResponse
   */
  public function update(Request $request ,$id)
  {
      try {
          $data = [
              'title' => $request->title,
              'updated_by' => Auth::user()->id,
          ];
          $job=JobType::where('id', $id)->first();
          $role=Role::where('name',$job->title)->first();
          $role->update([
            'name' => $request->title,
          ]);
          $job->update($data);
          $rolePermissions = $role->permissions()->delete();
          $subModulePermissionArray = User::subModulePermissionArray();
          foreach($request->permissions as $key=>$permission)
          {
            if (!empty($subModulePermissionArray[$key])) {
                foreach ($subModulePermissionArray[$key] as $key_sub_module =>  $sub_module) {
                    $permission=Permission::where('name', $key . '.' . $key_sub_module . '.view')->first();
                    if (!empty($permission)) {$role->givePermissionTo($permission->id);}
                    $permission=Permission::where('name', $key . '.' . $key_sub_module . '.edit')->first();
                    if (!empty($permission)) {$role->givePermissionTo($permission->id);}
                    $permission=Permission::where('name', $key . '.' . $key_sub_module . '.create')->first();
                    if (!empty($permission)) {$role->givePermissionTo($permission->id);}
                    $permission=Permission::where('name', $key . '.' . $key_sub_module . '.delete')->first();
                    if (!empty($permission)) {$role->givePermissionTo($permission->id);}
                }
            }
          }
          $output = [
              'success' => true,
              'msg' => __('lang.success')
          ];
      } catch (\Exception $e) {
          Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
          $output = [
              'success' => false,
              'msg' => __('messages.something_went_wrong')
          ];
      }

      return redirect()->back()->with('status', $output);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return RedirectResponse
   */
    public function destroy($id): RedirectResponse
    {
        try {
            $job = JobType::find($id);
            $job->delete();

             $output = [
                 'success' => true,
                 'msg' => __('lang.job_deleted')
             ];
        }

        catch (\Exception $e) {
          Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
          $output = [
              'success' => false,
              'msg' => __('messages.something_went_wrong')
          ];
        }

        return redirect()->back()->with('status', $output);
    }

    public function forceDelete($id): RedirectResponse
    {
        try {
            JobType::withTrashed()->find($id)->forceDelete();
            $output = [
                'success' => true,
                'msg' => __('lang.job_deleted')
            ];
        }
        catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong')
            ];

       }
        return redirect()->back()->with('status', $output);
    }

}

?>
