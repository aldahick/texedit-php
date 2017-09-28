<?php
class User {
    public $id;
    public $username;
    public $password_hash;
    public $password_salt;

    public function __construct($partial) {
        foreach ($partial as $k => $v) {
            $this->{$k} = $v;
        }
    }

    /**
     * Returns a User object if login was successful, false if the username or password was invalid
     */
    public static function login($username, $password) {
        global $db;
        $user = $db->query_single("SELECT * FROM `user` WHERE `username` = :username", array("username" => $username));
        if (!$user) {
            return false;
        }
        $user = new User($user);
        if (User::hash_password($password, $user->password_salt) != $user->password_hash) {
            return false;
        }
        return $user;
    }

    /**
     * Returns a User object if registration was successful, false if the username already exists
     */
    public static function register($username, $password) {
        global $db;
        $user = array(
            "username" => $username
        );
        $user["password_salt"] = generate_random_string(32);
        $user["password_hash"] = User::hash_password($password, $user["password_salt"]);
        // check for existing user
        $sql = "SELECT * FROM `user` WHERE `username` = :username";
        $rows = $db->query($sql, array("username" => $user["username"]));
        if (count($rows) != 0) return false;
        // insert this user
        $sql = "INSERT INTO `user`
            (`username`, `password_hash`, `password_salt`) VALUES
            (:username, :password_hash, :password_salt)";
        $db->query($sql, $user);
        // get the user's ID
        $sql = "SELECT LAST_INSERT_ID() AS id";
        $row = $db->query($sql);
        $user["id"] = $row["id"];
        return new User($user);
    }

    /**
     * Hashes the concatenation of salt and password
     */
    public static function hash_password($password, $salt) {
        return hash("sha256", $salt . $password);
    }
}
?>
