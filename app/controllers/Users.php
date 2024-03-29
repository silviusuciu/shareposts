<?php

class Users extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = $this->model( 'User' );
    }

    public function register() {
        // Check for POST
        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
            // Process form

            // Sanitize POST data
            $_POST = filter_input_array( INPUT_POST, FILTER_SANITIZE_STRING );

            // Init data
            $data = [
                'name'                 => trim( $_POST['name'] ),
                'email'                => trim( $_POST['email'] ),
                'password'             => trim( $_POST['password'] ),
                'confirm_password'     => trim( $_POST['confirm_password'] ),
                'name_err'             => '',
                'email_err'            => '',
                'password_err'         => '',
                'confirm_password_err' => ''
            ];

            // Validation
            if ( empty( $data['email'] ) ) {
                $data['email_err'] = 'Please enter email';
            } else {
                // Check email
                if ( $this->userModel->getByParam( [ 'email' => $data['email'] ], true ) ) {
                    $data['email_err'] = 'Email is already taken';
                }
            }

            if ( empty( $data['name'] ) ) {
                $data['name_err'] = 'Please enter name';
            }

            if ( empty( $data['password'] ) ) {
                $data['password_err'] = 'Please enter password';
            } else if ( strlen( $data['password'] ) < 6 ) {
                $data['password_err'] = 'Password must be at least 6 characters';
            }

            if ( empty( $data['confirm_password'] ) ) {
                $data['confirm_password_err'] = 'Please confirm password';
            } else {
                if ( $data['password'] !== $data['confirm_password'] ) {
                    $data['confirm_password_err'] = 'Passwords do not match';
                }
            }

            // Make sure errors are empty
            if (
                empty( $data['email_err'] ) &&
                empty( $data['name_err'] ) &&
                empty( $data['password_err'] ) &&
                empty( $data['confirm_password_err'] )
            ) {
                // Hash password
                $data['password'] = password_hash( $data['password'], PASSWORD_DEFAULT );

                // Register user
                $update_data = [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => $data['password']
                ];

                if ( $this->userModel->create( $update_data ) ) {
                    flash( 'register_success', 'You are registered and can log in' );
                    redirect( 'users/login' );
                } else {
                    die( 'Something went wrong' );
                }
            } else {
                $this->view( lcfirst( __CLASS__ ) . '/register', $data );
            }

        } else {
            // Init data
            $data = [
                'name'                 => '',
                'email'                => '',
                'password'             => '',
                'confirm_password'     => '',
                'name_err'             => '',
                'email_err'            => '',
                'password_err'         => '',
                'confirm_password_err' => ''
            ];

            $this->view( lcfirst( __CLASS__ ) . '/register', $data );
        }
    }

    public function login() {
        // Check for POST
        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
            // Process form

            // Sanitize POST data
            $_POST = filter_input_array( INPUT_POST, FILTER_SANITIZE_STRING );

            // Init data
            $data = [
                'email'                => trim( $_POST['email'] ),
                'password'             => trim( $_POST['password'] ),
                'email_err'            => '',
                'password_err'         => ''
            ];

            // Validation
            if ( empty( $data['email'] ) ) {
                $data['email_err'] = 'Please enter email';
            }

            if ( empty( $data['password'] ) ) {
                $data['password_err'] = 'Please enter password';
            }

            // Check for user/email
            if ( $this->userModel->getByParam( [ 'email' => $data['email'] ], true ) ) {
                // User found
            } else {
                // User not found
                $data['email_err'] = 'No user found';
            }

            // Make sure errors are empty
            if (
                empty( $data['email_err'] ) &&
                empty( $data['password_err'] )
            ) {
                // Validated
                // Check and set logged in user
                $loggedInUser = $this->userModel->login( $data['email'], $data['password'] );

                if ( $loggedInUser ) {
                    // Create session
                    $this->createUserSession( $loggedInUser );
                } else {
                    $data['password_err'] = 'Password incorrect';
                    $this->view( lcfirst( __CLASS__ ) . '/login', $data );
                }
            } else {
                $this->view( lcfirst( __CLASS__ ) . '/login', $data );
            }

        } else {
            // Init data
            $data = [
                'email'                => '',
                'password'             => '',
                'email_err'            => '',
                'password_err'         => ''
            ];

            $this->view( lcfirst( __CLASS__ ) . '/login', $data );
        }
    }

    public function logout() {
        unset( $_SESSION['user_id'] );
        unset( $_SESSION['user_email'] );
        unset( $_SESSION['user_name'] );
//        session_destroy(); flash won't work

        flash( 'logout_success', 'You have been logged out!' );
        redirect( 'users/login' );
    }

    public function createUserSession( $user ) {
        $_SESSION['user_id']    = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name']  = $user->name;

        redirect( 'posts' );
    }
}
