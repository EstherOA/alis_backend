<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [];
        // iterate though all routes
        foreach (Route::getRoutes()->getRoutes() as $key => $route)
        {
            // get route action
            $action = $route->getActionname();
            // separating controller and method
            $_action = explode('@',$action);

            $controller = $_action[0];
            $method = end($_action);

            // check if this permission is already exists
            $permission_check = Permission::where(
                 ['controller'=>$controller,'method'=>$method]
             )->first();
            if(!$permission_check){
                $permission = new Permission;
                $permission->controller = $controller;
                $permission->method = $method;
//                $permission->roles()->attach(1);
                $permission->save();
                // add stored permission id in array
                array_push($permissions, $permission->id);
//                logger()->debug($permission->id);
            }
        }
        $admin_role = Role::where('name', '=', 'admin')->first();
        $admin_role->permissions()->sync($permissions);
    }
}
