<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\Response;

class Logo extends Controller
{
    public function svgImage()
    {
        // Path to your SVG image file
        $filePath = WRITEPATH . 'uploads/image.svg';

        // Check if the file exists
        if (! file_exists($filePath)) {
            // Return a 404 response if the file does not exist
            return $this->response->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        // Read the contents of the SVG image file
        $fileContents = file_get_contents($filePath);

        // Set the response content type to indicate that this is an SVG image
        $response = $this->response->setContentType('image/svg+xml');

        // Return the SVG image contents as the response body
        return $response->setBody($fileContents);
    }
}
