<?php

namespace App\Controllers;

use App\Models\ContentModel;
use App\Controllers\BaseData;


class ContentController extends BaseController
{
public function add() {
    $data = [
        'title' => 'Add Content',
    ];
    return BaseData::getFullPage('content/add', $data);
}

public function create() {
    $contentModel = new ContentModel();
    $contentModel->save([
        'title' => $this->request->getPost('title'),
        'content' => $this->request->getPost('content'),
    ]);
    return redirect()->to('/content');
}

}