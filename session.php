<?php

class session
{
    private $root;
    private $db_conn;
    //This function sets our custom session handler, so it is available for use as soon as the class is instantiated (i.e., made/built/constructed).
    function __construct() {
        // set our custom session functions.
        session_set_save_handler(array($this, 'open'), array($this, 'close'), array($this, 'read'), array($this, 'write'), array($this, 'destroy'), array($this, 'gc'));
        $this->root= dirname(__FILE__);//$_SERVER['DOCUMENT_ROOT'];
        // This line prevents unexpected effects when using objects as save handlers.
        register_shutdown_function('session_write_close');
    }
    //This function will be called every time you want to start a new session, use it instead of session_start()
    function start_session($session_name, $secure) {
        /*// Make sure the session cookie is not accessible via javascript.
        $httponly = true;

        // Hash algorithm to use for the session. (use hash_algos() to get a list of available hashes.)
        $session_hash = 'sha512';

        // Check if hash is available
        if (in_array($session_hash, hash_algos())) {
            // Set the has function.
            ini_set('session.hash_function', $session_hash);
        }
        // How many bits per character of the hash.
        // The possible values are '4' (0-9, a-f), '5' (0-9, a-v), and '6' (0-9, a-z, A-Z, "-", ",").
        ini_set('session.hash_bits_per_character', 5);

        // Force the session to only use cookies, not URL variables.
        ini_set('session.use_only_cookies', 1);

        // Get session cookie parameters
        $cookieParams = session_get_cookie_params();
        // Set the parameters
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
        // Change the session name
        session_name($session_name);
        // Now we can start the session
        // create sessions to know the user is logged in

        require_once $this->root . '\session.php';
        $session = new session();
        // Set to true if using https
        $session->start_session('_s', false);
        // This line regenerates the session and delete the old one.
        // It also generates a new encryption key in the database.
        session_regenerate_id(true);*/
    }

    function open() {
        require_once $this->root . '\db_connection.php'; //$_SERVER['DOCUMENT_ROOT']."db_connection.php";
        $this->db_conn = DBconnection::OpenCon();
        return true;
    }

    function close(){
        DBconnection::CloseCon();
        return true;
    }

    //This function will be called by PHP when we try to access a session for example when we use echo $_SESSION['something'];. Because there might be many calls to this function on a single page, we take advantage of prepared statements, not only for security but for performance also. We only prepare the statement once then we can execute it many times.
    //We also decrypt the session data that is encrypted in the database. We are using 256-bit AES encryption in our sessions.
    function read($id) {
        $data = ""; //FIXME CLAUDIA
        if(!isset($this->read_stmt)) {
            $this->read_stmt = $this->db->prepare("SELECT data FROM session WHERE id = ? LIMIT 1");
        }
        $this->read_stmt->bind_param('s', $id);
        $this->read_stmt->execute();
        $this->read_stmt->store_result();
        $this->read_stmt->bind_result($data);
        $this->read_stmt->fetch();
        $key = $this->getkey($id);
        $data = $this->decrypt($data, $key);
        return $data;
    }

    //This function is used when we assign a value to a session, for example $_SESSION['something'] = 'something else';. The function encrypts all the data which gets inserted into the database.
    function write($id, $data) {
        // Get unique key
        $key = $this->getkey($id);
        // Encrypt the data
        $data = $this->encrypt($data, $key);

        $time = time();
        if(!isset($this->w_stmt)) {
            $this->w_stmt = $this->db->prepare("REPLACE INTO session (id, set_time, data, session_key) VALUES (?, ?, ?, ?)");
        }

        $this->w_stmt->bind_param('siss', $id, $time, $data, $key);
        $this->w_stmt->execute();
        return true;
    }

    //This function deletes the session from the database, it is used by php when we call functions like session__destroy();.
    function destroy($id) {
        if(!isset($this->delete_stmt)) {
            $this->delete_stmt = $this->db->prepare("DELETE FROM session WHERE id = ?");
        }
        $this->delete_stmt->bind_param('s', $id);
        $this->delete_stmt->execute();
        return true;
    }

    //This function is the garbage collector function it is called to delete old sessions.
    //The frequency in which this function is called is determined by two configuration directives, session.gc_probability and session.gc_divisor.
    function gc($max) {
        if(!isset($this->gc_stmt)) {
            $this->gc_stmt = $this->db->prepare("DELETE FROM session WHERE set_time < ?");
        }
        $old = time() - $max;
        $this->gc_stmt->bind_param('s', $old);
        $this->gc_stmt->execute();
        return true;
    }

    //This function is used to get the unique key for encryption from the sessions table. If there is no session it just returns a new random key for encryption.
    private function getkey($id) {
        $key = ""; //FIXME CLAUDIA
        if(!isset($this->key_stmt)) {
            $this->key_stmt = $this->db->prepare("SELECT session_key FROM session WHERE id = ? LIMIT 1");
        }
        $this->key_stmt->bind_param('s', $id);
        $this->key_stmt->execute();
        $this->key_stmt->store_result();
        if($this->key_stmt->num_rows == 1) {
            $this->key_stmt->bind_result($key);
            $this->key_stmt->fetch();
            return $key;
        } else {
            $random_key = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
            return $random_key;
        }
    }

    //FIXME use .env
    private function encrypt($msg_data, $encryption_key){
        //Store the cipher method
        $ciphering = "AES-128-CTR"; //TODO
        //Use OpenSSl Encryption method
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;

        // Non-NULL Initialization Vector for encryption
        $encryption_iv = 'cH!swe!retReGu7W6bEDRup7usuDUh9THeD2CHeGE*ewr4n39=E@rAsp7c-Ph@pH';

        // Use openssl_encrypt() function to encrypt the data
        $encryption = openssl_encrypt($msg_data, $ciphering,
            $encryption_key, $options, $encryption_iv);
        return $encryption;
    }

    private function decrypt($msg_data, $decryption_key){
        //Store the cipher method
        $ciphering = "AES-128-CTR"; //TODO
        //Use OpenSSl Encryption method
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;

        // Non-NULL Initialization Vector for encryption
        $decryption_iv = 'cH!swe!retReGu7W6bEDRup7usuDUh9THeD2CHeGE*ewr4n39=E@rAsp7c-Ph@pH';
    
        // Use openssl_encrypt() function to encrypt the data
        $decryption = openssl_decrypt($msg_data, $ciphering,
            $decryption_key, $options, $decryption_iv);
        return $decryption;
    }



}