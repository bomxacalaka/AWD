<?php

namespace App\Services;

use App\Models\PageViewCounter;

class PageViewService
{
    protected $counterModel;

    public function __construct()
    {
        $this->counterModel = new PageViewCounter();
    }

    public function incrementView($page)
    {
        $record = $this->counterModel->where('page', $page)->first();

        if ($record) {
            $this->counterModel->update($record['id'], ['views' => $record['views'] + 1]);
        } else {
            $this->counterModel->insert(['page' => $page, 'views' => 1]);
        }
    }

    public function getViewCount($page)
    {
        $record = $this->counterModel->where('page', $page)->first();
        return $record ? $record['views'] : 0;
    }
}
