<?php

namespace App\Controllers;

class Profile extends BaseController
{
    public function upload_picture()
    {
        // Check if the request contains a file named 'avatar'
        if ($this->request->getFile('avatar')->isValid()) {
            // Get the uploaded file
            $avatar = $this->request->getFile('avatar');

            // Validate the file type and size (optional)
            if ($avatar->isImage() && $avatar->getSize() < 2048) { // Adjust the size limit as needed
                // Generate a unique name for the file
                $newName = $avatar->getRandomName();

                // Move the uploaded file to the writable/uploads directory
                $avatar->move('writable/uploads', $newName);

                // You can save the file name or path to the user's profile in the database
                // Example: $userModel->update($userId, ['avatar' => $newName]);

                // Set a success message
                session()->setFlashdata('success', 'Picture uploaded successfully.');
            } else {
                // Set an error message if the file is not an image or exceeds the size limit
                session()->setFlashdata('error', 'Invalid file. Please upload a valid image file (max size: 2MB).');
            }
        } else {
            // Set an error message if no file is uploaded
            session()->setFlashdata('error', 'No file uploaded.');
        }

        // Redirect back to the profile page
        return redirect()->to('/profile');
    }
}
