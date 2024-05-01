<?php

namespace App\Controllers;

class BaseData {

    // Methods
    public static function getFullPage($view, $data = []) {
        $defaultData = [
            'title' => 'Default Title',
            'heading' => 'Default Heading',
            'content' => 'Default Content',
        ];
        // Load views with header and footer
        $data = array_merge($defaultData, $data);
        return view('templates/header', $data)
            . view('' . $view, $data)
            . view('templates/footer', $data);
    }
}
