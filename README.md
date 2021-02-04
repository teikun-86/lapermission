# LaPermission
Laravel role and permission manager
### Examples
#### Installation
1. Using composer require
   ```php
   composer require azizsama/lapermission
   ```
2. Publish config and migration files
   ```php
   php artisan vendor:publish --tag=lapermission-setup
   ```
3. Run migration
   ```php
   php artisan migrate
   ```
4. Add `HasRole` Trait to User model
   ```php
   <?php
   ...
   use AzizSama\LaPermission\Traits\HasRole;
   class User extends Authenticable
   {
      use HasRole;
      ...
   }
   ```
5. Finish

#### Usage
##### Basic usage
1. Check if authenticated user has required role.
   ```php
   use Illuminate\Support\Facades\Auth;
   ...
   if(Auth::user()->hasRole('Admin'))
   {
      // If user has 'Admin' role
   }
   // or you can pass array of roles.
   if(Auth::user()->hasRole(['Admin', 'Writer']))
   {
      // If user has 'Admin' or 'Writer' role
   }
   ```
2. Check if authenticated user has required permission.

   ```php
   use Illuminate\Support\Facades\Auth;
   ...
   if(Auth::user()->hasPermission('create post'))
   {
      // If user has permission to 'create post'
   }
   // or you can pass array of permissions
   if(Auth::user()->hasPermission(['create post', 'edit post']))
   {
      // If user has permission to 'create post' or 'edit post'
   }
   ```
   `hasPermission()` method also work with `Role` model
   ```php
   use AzizSama\LaPermission\Models\Role;
   ...
   $role = Role::first();
   if($role->hasPermission('create post'))
   {
      // if the role has permission to 'create post'
   }
   // or you can pass array of permissions
   if($role->hasPermission(['create post', 'edit post']))
   {
      // if the role has permission to 'create post' or 'edit post'
   }
   ```
3. Create new Role
   ```php
   use AzizSama\LaPermission\Models\Role;
   ...
   $newRole = Role::create([
      'name' => 'Administrator', // role name
      'description' => 'Administrator of this project' // Role description (optional)
   ]);
   ```
4. Create new Permission
   ```php
   use AzizSama\LaPermission\Models\Permission;
   ...
   $newPermission = Permission::create([
      'name' => 'create post', // Permission name
      'description' => 'Permission to create post' // Permission description (optional)
   ]);
   ```
5. Assign permission to role
   ```php
   use AzizSama\LaPermission\Models\Permission;
   use AzizSama\LaPermission\Models\Role;
   ...
   $role = Role::first();
   $permission = Permission::first();
   $role->attachPermission($permission->id);
   // or you can pass array of permission id
   $role->attachPermission([1, 2, 3]); // this code will assign permission with id 1, 2, 3 to selected role.
   ```
6. Assign role to user
   ```php
   use App\Models\User;
   ...
   $user = User::first();
   $user->attachRole('Administrator'); // this code will assign Administrator role to selected user.
   ```
7. Remove permission from role
   ```php
   use App\Models\User;
   ...
   $user = User::first();
   $user->detachRole('Administrator'); // this code will remove Administrator role from selected user.
   ```
##### Using Blade Directives
1. `@role` and `@endRole`
   
   `@role` directive works like `hasRole()` method.
   ```php
   @role('Admin')
      // If user has 'Admin' role
   @endRole
   // you can also pass array of roles
   @role(['Admin', 'Writer'])
      // if user has 'Admin' or 'Writer' role
   @endRole
   ```
1. `@permission` and `@endPermission`
   
   `@permission` directive works like `hasPermission()` method.
   ```php
   @permission('create post')
      // If user has 'create post' permission
   @endPermission
   // you can also pass array of permissions
   @permission(['create post', 'edit post'])
      // if user has 'create post' or 'edit post' permission
   @endPermission
   ```

##### Using Artisan Commands
1. Create new role `php artisan make:role <role_name>`

   Available options
   ```
   php artisan make:role <role_name> --options
   --description      set the description value. You will asked for description if you don't pass --description= option.
   --no-description   set the description value to null. You will not asked for description even if you don't pass the --description option. Also override --description value
   ```
2. Create new permission `php artisan make:permission <permission_name>`

   Available options
   ```
   php artisan make:permission <permission_name> --options
   --description      set the description value. You will asked for description if you don't pass --description= option.
   --no-description   set the description value to null. You will not asked for description even if you don't pass the --description option. Also override --description value
   ```
3. Assign Role to User `php artisan lapermission:assign-role [<user_id>] [<role_id>] `

   Main usage is
   ```
   php artisan lapermission:assign-role 1 2           Assign role with id 2 to user with id 1
   ```
   Or you can leave user_id and role_id blank like this
   ```
   php artisan lapermission:assign-role
   ```
   then you will asked for the user_id and role_id.
4. Assign Permission to Role `php artisan lapermission:assign-permission [<role_id>] [<permission_id>]`

   Main usage is
   ```
   php artisan lapermission:assign-permission 1 2     Assign permission with id 2 to role with id 1
   ```
   Or you can leave role_id and permission_id blank like this
   ```
   php artisan lapermission:assign-permission
   ```
   then you will asked for the role_id and permission_id.
5. Remove role from user `php artisan lapermission:remove-role [<user_id>] [<role_id>]`

   Main usage is
   ```
   php artisan lapermission:remove-role 1 2           Remove role with id 2 from user with id 1
   ```
   Or you can leave user_id and roe_id blank like this
   ```
   php artisan lapermission:remove-role
   ```
   then you will asked for user_id and role_id.
6. Show available roles `php artisan lapermission:roles`

   This command will show the available roles.
7. Show available permissions `php artisan lapermission:permissions`

   This command will show the available permissions.
   
##### Using Middleware
1. `role` middleware
   ```php
   ...
   Route::get('/dashboard', function() {
      return view('admin.dashboard');
   })->middleware('role:Administrator|Writer'); // important. Use '|' to separate between required roles.
   ```
   Will redirect to or abort the operation if the user does not have Administrator or Writer role.
2. `permission` middleware
   ```php
   ...
   Route::get('/write', function() {
      return view('admin.write');
   })->middleware('role:create post|edit post'); // important. Use '|' to separate between required permisions.
   ```
   Will redirect to or abort the operation if the user does not have create post or edit post permission.
3. Handling
   
   You can change middleware handling in `config/lapermission.php` By default, it will abort operation with 403 error code.
   You can configure it in `middleware.handling`. The available handling method is `redirect` and `abort`
