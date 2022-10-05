<?php

namespace App\Helpers;

class MSGHelper
{   
    const MSG_LOGIN_SUCCESS = 'Anda Berhasil Login';
    const MSG_LOGIN_FAILED = 'Incorrect Username / Password';
    const MSG_LOGIN_INCORRECT_ROLE = 'User Role Doesn\'t match';
    const MSG_ROLE_REQUIRED = 'Role Is Required';
    const MSG_LOGOUT_SUCCESS = 'Anda Berhasil Logout';

    const MSG_CREATE_SUCCESS = 'Berhasil Menyimpan Data';
    const MSG_CREATE_FAILED = 'Gagal Menyimpan Data';
    
    const MSG_UPDATE_SUCCESS = 'Berhasil Memperbarui Data';
    const MSG_UPDATE_FAILED = 'Gagal Memperbarui Data';
    
    const MSG_DELETE_SUCCESS = 'Berhasil Menghapus Data';
    const MSG_DELETE_FAILED = 'Gagal Menghapus Data';
}
