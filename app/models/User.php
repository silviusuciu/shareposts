<?php
class User extends Model {
    protected $name = 'users';

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
}
