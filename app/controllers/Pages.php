<?php

class Pages extends Controller {

    public function index() {
        if ( isLoggedIn() ) {
            redirect('posts');
        }

        $data = [
            'title' => 'SharePosts',
            'description' => 'Tiny social network built with PHP'
        ];

        $this->view( lcfirst( __CLASS__ ) . '/index', $data );
    }

    public function about() {
        $data = [
            'title' => 'About Us',
            'description' => 'App to share posts with other users'
        ];

        $this->view( lcfirst( __CLASS__ ) . '/about', $data );
    }
}
