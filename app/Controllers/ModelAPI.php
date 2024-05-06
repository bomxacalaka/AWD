<?php

namespace App\Controllers;

use App\Models\Student;
use CodeIgniter\RESTful\ResourceController;

class ModelAPI extends Controller
{

    private $student;

    public function __construct()
    {
        $this->student = new Student();
    }

    use ResponseTrait;

    public function test ( $data = null)
    {
        return $this->respondCreated($data);
    }
}