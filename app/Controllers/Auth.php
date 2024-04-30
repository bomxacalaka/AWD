<?php namespace App\Controllers;

use App\Models\UserModel;
use App\Libraries\Hash;

class Auth extends BaseController
{
    public function __construct()
    {
        helper(['url', 'form', 'Form_helper']);
    }


    public function index()
    {

        // Cookie encryption not in use
        // Generate a random secret key
        // $secretKey = bin2hex(random_bytes(32)); // 256-bit key

        // // Generate a random IV for AES encryption in CBC mode
        // $iv = random_bytes(16); // 128-bit IV

        // // Retrieve and decrypt remember me cookie securely
        // try {
        //     if (isset($_COOKIE['remember'])) {
        //         $rememberData = json_decode(openssl_decrypt($_COOKIE['remember'], 'AES-256-CBC', $secretKey, 0, $iv), true);
                
        //         $email = $rememberData['email'];
        //         $passwordHash = $rememberData['passwordHash'];
            
        //         // Validate credentials using hashed password
        //         $userModel = new UserModel();
        //         $userInfo = $userModel->where('email_usr', $email)->first();
            
        //         if ($userInfo && Hash::passwordVerify($password, $passwordHash)) {
        //             // Valid credentials, log in user
        //             $loggedUserId = $userInfo['id_usr'];
        //             $loggedUserFullName = $userInfo['firstname_usr'];

        //             session()->set('loggedUserId', $loggedUserId);
        //             session()->set('loggedUserFullName', $loggedUserFullName);

        //             // Redirect to dashboard or wherever you want
        //             return redirect()->to('/dashboard')->with('success', 'Automatic login successful');
        //         }
        //     }
        //     } catch (\Exception $e) {
        //         // Handle decryption error
        //         // Log error, clear cookie, etc.
        //         $error = $e->getMessage();

        //         // Clear cookie
        //         //setcookie('remember', '', time() - 3600, '/', '', true, true); // Set secure and HttpOnly flags

        //         // Log error
        //         log_message('error', 'Remember me cookie decryption error: ' . $error);
        // }

        // return view('auth/login');
        // return view('form/index', $data);

        $data['title'] = "Login";

        return view('templates/header', $data)
        . view('auth/login')
        . view('templates/footer');
    }

    public function register()
    {
        // return view('auth/register');
        return view('templates/header', ['title' => 'Register'])
        . view('auth/register')
        . view('templates/footer');
    }
    public function save() {
        $validation = $this->validate([
            'userName' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "If 47 has a name, so should you"
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[user_usr.email_usr]',
                'errors' => [
                    'required' => "Without an email, how do we spam you?",
                    'valid_email' => "Make it legit, enter a valid email address",
                    'is_unique' => "So much for creativity, this email already exists",
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[10]|max_length[255]',
                'errors' => [
                    'required' => "I mean, you need a password to login right?",
                    'min_length' => "10 inches is the minimum length for a password",
                    'max_length' => "Trying to make up for something? 255 max length for password"
                ]
            ],
            'confirmPassword' => [
                'rules' => 'required|max_length[255]|matches[password]',
                'errors' => [
                    'required' => "Same drill, just confirm the password",
                    'matches' => "Just copy paste the password from above",
                ]
            ],
        ]);
        
        if(!$validation) {
            // return view('auth/register', ['validation' => $this->validator]);

            return view('templates/header', ['title' => 'Register'])
            . view('auth/register', ['validation' => $this->validator])
            . view('templates/footer');
        } else {
            $userName = $this->request->getPost('userName');
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $values = [
                'firstname_usr' => $userName,
                'email_usr' => $email,
                'password_usr' => Hash::make($password),
            ];

            $userModel = new UserModel();
            $query = $userModel->insert( $values );
            if(!$query) {
                return redirect()->back()->with('fail', "Something went wrong");
            } else {
                $lastId = $userModel->insertID();
                session()->set('loggedUserId', $lastId);
                session()->set('loggedUserFullName', $userName);
                return redirect()->to('/dashboard')->with('success', "Registration successful");
            }
        }
    }

    public function check() {
        $validation = $this->validate([
            'email' => [
                'rules' => 'required|valid_email|is_not_unique[user_usr.email_usr]',
                'errors' => [
                    'required' => "Email Field Required buddy",
                    'valid_email' => "Huh? That's not an email address",
                    'is_not_unique' => "Never seen you before, please register first",
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Like seriously, you need a password to login"
                ]
            ],
        ]);
        if(!$validation) {
            // return view('auth/login', ['validation' => $this->validator]);

            return view('templates/header', ['title' => 'Login'])
            . view('auth/login', ['validation' => $this->validator])
            . view('templates/footer');

        } else {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $userModel = new UserModel();
            $userInfo = $userModel->where('email_usr', $email)->first();
            $checkPassword = Hash::passwordVerify($password, $userInfo['password_usr']);
            if(!$checkPassword) {
                session()->setFlashdata('fail', 'Incorrect password');
                return redirect()->to('/auth')->withInput();
            } else {
                $loggedUserId = $userInfo['id_usr'];
                $loggedUserFullName = $userInfo['firstname_usr'];
    
                session()->set('loggedUserId', $loggedUserId);
                session()->set('loggedUserFullName', $loggedUserFullName);

                session()->setFlashdata('success', 'Login success');
                return redirect()->to('/dashboard')->withInput();
    
                // Cookie encryption not in use
                // if ($this->request->getPost('remember')) {
                //     // Set cookie to remember user
                //     // Save remember me cookie securely
                //     $rememberData = [
                //         'email' => $email,
                //         'passwordHash' => Hash::make($password), // Hash the password before saving
                //     ];

                //     $secretKey = bin2hex(random_bytes(32)); // 256-bit key

                //     // Generate a random IV for AES encryption in CBC mode
                //     $iv = random_bytes(16); // 128-bit IV

                //     $cookieValue = openssl_encrypt(json_encode($rememberData), 'AES-256-CBC', $secretKey, 0, $iv);

                //     setcookie('remember', $cookieValue, time() + (86400 * 30), '/', '', true, true); // Set secure and HttpOnly flags

                //     return redirect()->to('/dashboard')->withCookies([$cookieValue])->with('success', 'Login success');
                // } else {
                //     return redirect()->to('/dashboard')->with('success', 'Login success');
                // }
            }
        }
    }


    public function logout() {
        if(session()->has('loggedUserId')) {
            session()->remove('loggedUserId');
            return redirect()->to('/auth?access=out')->with('fail', 'You have been logged out');
        }
    }
}