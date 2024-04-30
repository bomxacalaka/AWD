<?php

namespace App\Controllers;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $usersModel = new UserModel();
        $loggedUserId = session()->get('loggedUserId');
        $userInfo = $usersModel->find($loggedUserId);
        $data = [
            'title' => "Dashboard",
            'name' => $userInfo['firstname_usr'],
        ];
        return view('dashboard/index', $data);
    }

    public function profile()
    {
        $usersModel = new UserModel();
        $loggedUserId = session()->get('loggedUserId');
        $userInfo = $usersModel->find($loggedUserId);
        $data = [
            'title' => "Profile",
            'name' => $userInfo['firstname_usr'],
        ];
        return view('dashboard/profile', $data);
    }
}
