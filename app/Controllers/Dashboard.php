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

        // Load views with header and footer
        return view('templates/header', $data)
            . view('dashboard/index', $data)
            . view('templates/footer', $data);
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

        // Load views with header and footer
        return view('templates/header', $data)
            . view('dashboard/profile', $data)
            . view('templates/footer', $data);
    }
}
