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
