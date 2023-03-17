<?php

class Posts extends Controller {
    private $postModel;
    private $userModel;

    public function __construct() {
        if ( ! isLoggedIn() ) {
            redirect('users/login');
        }

        $this->postModel = $this->model( 'Post' );
        $this->userModel = $this->model( 'User' );
    }

    public function index() {
        $posts = $this->postModel->getPosts();
        $data = [
            'posts' => $posts,
        ];

        $this->view( lcfirst( __CLASS__ ) . '/index', $data );
    }

    public function add() {
        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
            // Sanitize POST array
            $_POST = filter_input_array( INPUT_POST, FILTER_SANITIZE_STRING );

            $data = [
                'title' => trim( $_POST['title'] ),
                'body' => trim( $_POST['body'] ),
                'user_id' => $_SESSION['user_id'],
                'title_err' => '',
                'body_err' => '',
            ];

            // Validate data
            if ( empty( $data['title'] ) ) {
                $data['title_err'] = 'Please enter title';
            }

            if ( empty( $data['body'] ) ) {
                $data['body_err'] = 'Please enter post content';
            }

            // Make sure no errors
            if ( empty( $data['title_err'] ) && empty( $data['body_err'] ) ) {
                // Validated
                $update_data = [
                    'user_id' => $data['user_id'],
                    'title' => $data['title'],
                    'body' => $data['body']
                ];

                if ( $this->postModel->create( $update_data ) ) {
                    flash('post_message', 'Post published');
                    redirect('posts');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view( lcfirst( __CLASS__ ) . '/add', $data );
            }

        } else {
            $data = [
                'title' => '',
                'body' => ''
            ];

            $this->view( lcfirst( __CLASS__ ) . '/add', $data );
        }
    }

    public function edit( $id ) {
        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
            // Sanitize POST array
            $_POST = filter_input_array( INPUT_POST, FILTER_SANITIZE_STRING );

            $data = [
                'id' => $id,
                'title' => trim( $_POST['title'] ),
                'body' => trim( $_POST['body'] ),
                'user_id' => $_SESSION['user_id'],
                'title_err' => '',
                'body_err' => '',
            ];

            // Validate data
            if ( empty( $data['title'] ) ) {
                $data['title_err'] = 'Please enter title';
            }

            if ( empty( $data['body'] ) ) {
                $data['body_err'] = 'Please enter post content';
            }

            // Make sure no errors
            if ( empty( $data['title_err'] ) && empty( $data['body_err'] ) ) {
                // Validated
                $update_data = [
                    'title' => $data['title'],
                    'body' => $data['body'],
                    'where' => [
                        'id' => $data['id']
                    ]
                ];

                if ( $this->postModel->update( $update_data ) ) {
                    flash('post_message', 'Post updated');
                    redirect('posts');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view( lcfirst( __CLASS__ ) . '/edit', $data );
            }

        } else {
            // Get existing post from model
            $post = $this->postModel->getById( $id );
            // Check for owner
            if ( $post->user_id != $_SESSION['user_id'] ) {
                redirect('posts');
            }

            $data = [
                'id'    => $id,
                'title' => $post->title,
                'body'  => $post->body
            ];

            $this->view( lcfirst( __CLASS__ ) . '/edit', $data );
        }
    }

    public function show( $id ) {

        $post = $this->postModel->getById( $id );
        $user = $this->userModel->getById( $post->user_id );

        $data = [
            'post' => $post,
            'user' => $user
        ];

        $this->view( lcfirst( __CLASS__ ) . '/show', $data );
    }

    public function delete( $id ) {
        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
            $post = $this->postModel->getById( $id );

            if ( $post->user_id != $_SESSION['user_id'] ) {
                redirect('posts');
                return;
            }

            if ( $this->postModel->delete( [ 'id' => $id ] ) ) {
                flash('post_message', 'Post deleted');
                redirect('posts');
            } else {
                die('Something went wrong');
            }
        } else {
            redirect('posts');
        }
    }
}
