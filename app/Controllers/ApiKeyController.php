<?php

namespace App\Controllers;

use App\Models\ApiKeyModel;
use App\Controllers\BaseData;

class ApiKeyController extends BaseController
{

    public function index()
    {
        // Fetch all API keys belonging to the logged-in user
        $apiKeyModel = new ApiKeyModel();
        $userId = session()->get('loggedUserId');
        $apiKeys = $apiKeyModel->where('user_id', $userId)->findAll();

        $data = [
            'title' => 'API Keys',
            'apiKeys' => $apiKeys,
        ];

        return BaseData::getFullPage('dashboard/apikeys', $data);
    }
    public function generate()
    {
        // Get the user ID from the session
        $userId = session()->get('loggedUserId');
        // Ensure the user ID is valid
        if (!is_numeric($userId)) {
            return "Invalid user ID";
        }

        $apiKeyModel = new ApiKeyModel();

        // Generate a unique API key
        $apiKey = bin2hex(random_bytes(16));

        // Save the API key to the database along with the user ID
        $apiKeyModel->insert(['user_id' => $userId, 'api_key' => $apiKey]);

        // Return the generated API key
        return json_encode(['status' => 'success', 'api_key' => $apiKey, 'api_key_id' => $apiKeyModel->getInsertID()]);
    }

    public function delete($keyId)
    {

        // Get the user ID from the session
        $userId = session()->get('loggedUserId');
        if (!is_numeric($userId)) {
            return "Invalid user ID";
        }

        // Ensure both the user ID and key ID are valid
        if (!is_numeric($userId) || !is_numeric($keyId)) {
            return "Invalid user ID or API key ID";
        }

        $apiKeyModel = new ApiKeyModel();

        // Check if the API key belongs to the specified user
        $apiKey = $apiKeyModel->where('id', $keyId)
                                ->where('user_id', $userId)
                                ->first();

        if ($apiKey) {
            // Delete the API key
            $deleted = $apiKeyModel->delete($keyId);

            if ($deleted) {
                return json_encode(['status' => 'success']);
            } else {
                return json_encode(['status' => 'error', 'message' => 'Failed to delete API key']);
            }
        } else {
            return json_encode(['status' => 'error', 'message' => 'API key not found']);
        }
    }
    
}
