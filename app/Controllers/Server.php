<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Controllers\BaseData;
use App\Models\ForgeVersionModel;
use App\Models\VoteModel;
use App\Models\ModModel;
use App\Services\PageViewService;

class Server extends BaseController
{
    // public function __construct()
    // {
    //     helper(['url', 'form', 'Form_helper']);
    // }

    public function index()
    {
        $pageViewService = new PageViewService();
        $pageViewService->incrementView('home');
        $viewCount = $pageViewService->getViewCount('home');

        // return view('welcome_message', ['viewCount' => $viewCount]);

        $forgeVersionModel = new ForgeVersionModel();
        $forgeVersions = $forgeVersionModel->findAll();
        // Get all forge versions from the database [{"id":"3","version":"test","created_at":"2024-05-20 18:09:44","updated_at":null}]
        
        $forgeVersions = array_map(function($forgeVersion) {
            return $forgeVersion['version'];
        }, $forgeVersions);
        
        
        $voteModel = new VoteModel();
        $votes = $voteModel->findAll();
        
        $modModel = new ModModel();
        $mods = $modModel->findAll();
        


        $data = [
            'title' => 'MC Home',
            'viewCount' => $viewCount,
            'mc_info' => [
                "Version: 1.17.1",
                "Players: 0",
                "IP: play.example.com",
            ],
            "forge_versions" => $forgeVersions,
            "mods" => $mods,
            "votes" => $votes,
            "test" => $forgeVersions
        ];

        return BaseData::getFullPage('minecraft/home', $data);
    }

    public function form()
    {
        $request = $this->request;
        $data = $request->getJSON(true); // Retrieve JSON data as associative array
        $forgeVersions = $data['forgeVersions']; // Array of selected forge versions
        $mods = $data['mods']; // Array of selected mods

        // Now you can save $forgeVersions and $mods to your database

        // For demonstration purposes, let's just return a success message
        return $this->response->setJSON(['success' => true, 'forgeVersions' => $forgeVersions, 'mods' => $mods]);
    }

    public function addMod()
    {
        $request = $this->request;
        $data = $request->getJSON(true); // Retrieve JSON data as associative array
        $modName = $data['mod']; // Mod name

        // Search for mod
        $client = \Config\Services::curlrequest();
        
        $headers = [
            'Accept' => 'application/json',
            'x-api-key' => '$2a$10$TcGQvL7.w.2MGO5xIE68Lu8hLHiCZ/r91IDaDSMrQk/zi0Nu.FLRy'
        ];

        $params = [
            'gameId' => '0'
        ];

        $response = $client->get('https://api.curseforge.com/v1/mods/search', [
            'headers' => $headers,
            'query' => $params
        ]);

        $body = $response->getBody();
    
        // Now you can save $mod to your database
        $modModel = new ModModel();

        $mods = $modModel->findAll();
    
        // Prepare data for insertion
        $modData = [
            'name' => $modName,
            'description' => 'This is a mod',
            'forge_version_id' => 3,
        ];
    
        // Save the mod to the database
        $modModel->save($modData);
    
        // For demonstration purposes, let's just return a success message
        return $this->response->setJSON(['success' => true, 'mod' => $modName, 'mods' => $mods, 'response' => $body]);
    }

    public function addForge()
    {
        $request = $this->request;
        $data = $request->getJSON(true); // Retrieve JSON data as associative array
        $forgeVersion = $data['forge']; // Forge version
    
        // Now you can save $forge to your database
        $forgeVersionModel = new ForgeVersionModel();

    
        // Prepare data for insertion
        $modData = [
            'version' => $forgeVersion,
        ];
    
        // Save the mod to the database
        $forgeVersionModel->save($modData);
    
        // For demonstration purposes, let's just return a success message
        return $this->response->setJSON(['success' => true, 'forge' => $forgeVersion]);
    }
}



// https://maven.minecraftforge.net/net/minecraftforge/forge/1.20.1-47.2.32/forge-1.20.1-47.2.32-installer.jar