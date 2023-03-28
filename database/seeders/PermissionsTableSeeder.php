<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'audit_log_show',
            ],
            [
                'id'    => 18,
                'title' => 'audit_log_access',
            ],
            [
                'id'    => 19,
                'title' => 'company_create',
            ],
            [
                'id'    => 20,
                'title' => 'company_edit',
            ],
            [
                'id'    => 21,
                'title' => 'company_show',
            ],
            [
                'id'    => 22,
                'title' => 'company_delete',
            ],
            [
                'id'    => 23,
                'title' => 'company_access',
            ],
            [
                'id'    => 24,
                'title' => 'department_create',
            ],
            [
                'id'    => 25,
                'title' => 'department_edit',
            ],
            [
                'id'    => 26,
                'title' => 'department_show',
            ],
            [
                'id'    => 27,
                'title' => 'department_delete',
            ],
            [
                'id'    => 28,
                'title' => 'department_access',
            ],
            [
                'id'    => 29,
                'title' => 'vehicle_type_create',
            ],
            [
                'id'    => 30,
                'title' => 'vehicle_type_edit',
            ],
            [
                'id'    => 31,
                'title' => 'vehicle_type_show',
            ],
            [
                'id'    => 32,
                'title' => 'vehicle_type_delete',
            ],
            [
                'id'    => 33,
                'title' => 'vehicle_type_access',
            ],
            [
                'id'    => 34,
                'title' => 'company_vehicle_create',
            ],
            [
                'id'    => 35,
                'title' => 'company_vehicle_edit',
            ],
            [
                'id'    => 36,
                'title' => 'company_vehicle_show',
            ],
            [
                'id'    => 37,
                'title' => 'company_vehicle_delete',
            ],
            [
                'id'    => 38,
                'title' => 'company_vehicle_access',
            ],
            [
                'id'    => 39,
                'title' => 'vehicle_document_type_create',
            ],
            [
                'id'    => 40,
                'title' => 'vehicle_document_type_edit',
            ],
            [
                'id'    => 41,
                'title' => 'vehicle_document_type_show',
            ],
            [
                'id'    => 42,
                'title' => 'vehicle_document_type_delete',
            ],
            [
                'id'    => 43,
                'title' => 'vehicle_document_type_access',
            ],
            [
                'id'    => 44,
                'title' => 'vehicle_document_create',
            ],
            [
                'id'    => 45,
                'title' => 'vehicle_document_edit',
            ],
            [
                'id'    => 46,
                'title' => 'vehicle_document_show',
            ],
            [
                'id'    => 47,
                'title' => 'vehicle_document_delete',
            ],
            [
                'id'    => 48,
                'title' => 'vehicle_document_access',
            ],
            [
                'id'    => 49,
                'title' => 'expense_category_create',
            ],
            [
                'id'    => 50,
                'title' => 'expense_category_edit',
            ],
            [
                'id'    => 51,
                'title' => 'expense_category_show',
            ],
            [
                'id'    => 52,
                'title' => 'expense_category_delete',
            ],
            [
                'id'    => 53,
                'title' => 'expense_category_access',
            ],
            [
                'id'    => 54,
                'title' => 'expense_create',
            ],
            [
                'id'    => 55,
                'title' => 'expense_edit',
            ],
            [
                'id'    => 56,
                'title' => 'expense_show',
            ],
            [
                'id'    => 57,
                'title' => 'expense_delete',
            ],
            [
                'id'    => 58,
                'title' => 'expense_access',
            ],
            [
                'id'    => 59,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
