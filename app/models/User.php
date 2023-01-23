<?php
class User {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // Find user by email
    public function findUserByEmail( $email ) {
        $this->db->query( 'SELECT * FROM users WHERE email = :email' );
        $this->db->bind( ':email', $email );

        $row = $this->db->single();

        // Check row
        if ( $this->db->rowCount() > 0 ) {
            return true;
        } else {
            return false;
        }
    }

    // Register user
    public function register( $data ) {
        $this->db->query( 'INSERT INTO users (name, email, password) VALUES (:name, :email, :password)' );
        $this->db->bind( ':name', $data['name'] );
        $this->db->bind( ':email', $data['email'] );
        $this->db->bind( ':password', $data['password'] );

        return $this->db->execute();
    }

    // Register user
    public function login( $email, $password ) {
        $this->db->query( 'SELECT * FROM users WHERE email = :email' );
        $this->db->bind( ':email', $email );

        $row = $this->db->single();

        $hashed_password = $row->password;

        if ( password_verify( $password, $hashed_password ) ) {
            return $row;
        } else {
            return false;
        }
    }

    public function getUserById( $id ) {
        $this->db->query( 'SELECT * FROM users WHERE id = :id' );
        $this->db->bind( ':id', $id );

        return $this->db->single();
    }
}
