<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {
    
    // Data user statis
    private $users = array(
        'admin' => array(
            'password' => 'admin123', // Password dalam bentuk plain text
            'nama' => 'admin'
        ),
        'user' => array(
            'password' => 'user123',
            'nama' => 'Regular User'
        )
    );
    
    public function __construct() {
        parent::__construct();
    }
    
    public function login($username, $password) {
        // Cek apakah username ada
        if (array_key_exists($username, $this->users)) {
            $user = $this->users[$username];
            
            // Verifikasi password (plain text comparison)
            if ($password === $user['password']) {
                return $user;
            }
        }
        
        return false;
    }
    
    // Method untuk mendapatkan daftar users (debugging)
    public function get_users() {
        return $this->users;
    }
}
?>