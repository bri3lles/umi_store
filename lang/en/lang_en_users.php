<?php

/**
 * English strings for the "User" admin module:
 * - Users list page      (admin/users/index.blade.php)
 * - User detail page     (admin/users/show.blade.php)
 * - Change-role & delete modals (admin/users/_role-modal.blade.php, _delete-modal.blade.php)
 */
return [

    // ==== Labels for Role & Status options (used by UserController) ====
    'roles' => [
        'owner'    => 'Owner',
        'admin'    => 'Admin',
        'customer' => 'Customer',
    ],

    'statuses' => [
        'active'   => 'Active',
        'inactive' => 'Inactive',
    ],

    // ==== Page: Manage Users (index) ====
    'index' => [
        'title'            => 'Manage Users',
        'subtitle'         => 'List of accounts registered on Umi Store. You can view details, change roles, or delete a user.',
        'search_placeholder' => 'Search by name or email...',
        'search_label'     => 'Search user',
        'filter_role_label'   => 'Filter by role',
        'filter_role_all'     => 'All Roles',
        'filter_status_label' => 'Filter by status',
        'filter_status_all'   => 'All Statuses',
        'reset'            => 'Reset',

        'col_no'         => 'No',
        'col_name'       => 'Name',
        'col_email'      => 'Email',
        'col_role'       => 'Role',
        'col_status'     => 'Status',
        'col_joined'     => 'Registered On',
        'col_actions'    => 'Actions',

        'action_detail'    => 'Detail',
        'action_detail_for'   => 'View details for :name',
        'action_role'      => 'Change role',
        'action_role_for'    => 'Change role for :name',
        'action_delete'    => 'Delete',
        'action_delete_for'  => 'Delete :name',

        'empty' => 'No matching users. Try a different search term or filter.',
    ],

    // ==== Page: User Detail (show) ====
    'show' => [
        'title'    => 'User Detail',
        'subtitle' => 'Complete information about this user account.',
        'back'     => 'Back',
        'edit_role' => 'Change Role',
        'delete'    => 'Delete',

        'account_info_title' => 'Account Information',
        'field_name'      => 'Name',
        'field_email'     => 'Email',
        'field_role'      => 'Role',
        'field_status'    => 'Status',
        'field_created_at'  => 'Created on',
        'field_updated_at'  => 'Last updated',
        'field_user_id'   => 'User ID',
        'field_total_orders' => 'Total orders',
        'orders_count'    => ':count orders',
        'not_applicable'  => '—',

        'date_format' => 'F d, Y',
    ],

    // ==== Modal: Change Role ====
    'role_modal' => [
        'title'       => 'Change role',
        'description' => 'Choose a new role for :name.',
        'field_label' => 'Role',
        'cancel'      => 'Cancel',
        'submit'      => 'Save Role',
        'success'     => 'User role updated successfully (dummy data, not saved yet).',
    ],

    // ==== Modal: Delete User ====
    'delete_modal' => [
        'title'       => 'Delete user?',
        'description' => 'Are you sure you want to delete :name? This action cannot be undone.',
        'cancel'      => 'Cancel',
        'submit'      => 'Delete',
        'success'     => 'User deleted successfully (dummy data, not actually deleted).',
    ],

];