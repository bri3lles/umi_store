<?php

/**
 * Teks Bahasa Indonesia untuk modul "User" di admin:
 * - Halaman daftar user      (admin/users/index.blade.php)
 * - Halaman detail user      (admin/users/show.blade.php)
 * - Modal ubah role & hapus  (admin/users/_role-modal.blade.php, _delete-modal.blade.php)
 */
return [

    // ==== Label untuk pilihan Role & Status (dipakai UserController) ====
    'roles' => [
        'owner'    => 'Owner',
        'admin'    => 'Admin',
        'customer' => 'Pelanggan',
    ],

    'statuses' => [
        'active'   => 'Aktif',
        'inactive' => 'Nonaktif',
    ],

    // ==== Halaman: Kelola User (index) ====
    'index' => [
        'title'            => 'Kelola User',
        'subtitle'         => 'Daftar akun yang terdaftar di Umi Store. Anda dapat melihat detail, mengubah role, atau menghapus user.',
        'search_placeholder' => 'Cari nama atau email...',
        'search_label'     => 'Cari user',
        'filter_role_label'   => 'Filter role',
        'filter_role_all'     => 'Semua Role',
        'filter_status_label' => 'Filter status',
        'filter_status_all'   => 'Semua Status',
        'reset'            => 'Reset',

        'col_no'         => 'No',
        'col_name'       => 'Nama',
        'col_email'      => 'Email',
        'col_role'       => 'Role',
        'col_status'     => 'Status',
        'col_joined'     => 'Tanggal Daftar',
        'col_actions'    => 'Aksi',

        'action_detail'    => 'Detail',
        'action_detail_for'   => 'Detail :name',
        'action_role'      => 'Ubah role',
        'action_role_for'    => 'Ubah role :name',
        'action_delete'    => 'Hapus',
        'action_delete_for'  => 'Hapus :name',

        'empty' => 'Tidak ada user yang cocok. Ubah kata kunci atau filter pencarian.',
    ],

    // ==== Halaman: Detail User (show) ====
    'show' => [
        'title'    => 'Detail User',
        'subtitle' => 'Informasi lengkap akun pengguna.',
        'back'     => 'Kembali',
        'edit_role' => 'Ubah Role',
        'delete'    => 'Hapus',

        'account_info_title' => 'Informasi Akun',
        'field_name'      => 'Nama',
        'field_email'     => 'Email',
        'field_role'      => 'Role',
        'field_status'    => 'Status',
        'field_created_at'  => 'Tanggal dibuat',
        'field_updated_at'  => 'Terakhir diperbarui',
        'field_user_id'   => 'ID User',
        'field_total_orders' => 'Total pesanan',
        'orders_count'    => ':count pesanan',
        'not_applicable'  => '—',

        'date_format' => 'd F Y',
    ],

    // ==== Modal: Ubah Role ====
    'role_modal' => [
        'title'       => 'Ubah role',
        'description' => 'Pilih role baru untuk :name.',
        'field_label' => 'Role',
        'cancel'      => 'Batal',
        'submit'      => 'Simpan Role',
        'success'     => 'Role user berhasil diubah (data dummy, belum tersimpan).',
    ],

    // ==== Modal: Hapus User ====
    'delete_modal' => [
        'title'       => 'Hapus user?',
        'description' => 'Apakah Anda yakin ingin menghapus user :name? Tindakan ini tidak dapat dibatalkan.',
        'cancel'      => 'Batal',
        'submit'      => 'Hapus',
        'success'     => 'User berhasil dihapus (data dummy, belum terhapus).',
    ],

];