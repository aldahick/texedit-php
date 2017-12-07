<?php
class User {
    public $id;
    public $email;
    public $password_hash;
    public $password_salt;
    public $reset_token;

    public function __construct($partial) {
        foreach ($partial as $k => $v) {
            $this->{$k} = $v;
        }
    }

    /**
     * Returns a User object if login was successful, false if the email or password was invalid
     */
    public static function login($email, $password) {
        global $db;
        $user = $db->query_single("SELECT * FROM `user` WHERE `email` = :email", array("email" => $email));
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
     * Returns a User object if registration was successful, false if the email already exists
     */
    public static function register($email, $password) {
        global $db;
        $user = array(
            "email" => $email
        );
        $user["password_salt"] = generate_random_string(32);
        $user["password_hash"] = User::hash_password($password, $user["password_salt"]);
        $user["reset_token"] = generate_random_string(32);
        // check for existing user
        $sql = "SELECT * FROM `user` WHERE `email` = :email";
        $rows = $db->query($sql, array("email" => $user["email"]));
        if (count($rows) != 0) return false;
        // insert this user
        $sql = "INSERT INTO `user`
            (`email`, `password_hash`, `password_salt`, `reset_token`) VALUES
            (:email, :password_hash, :password_salt, :reset_token)";
        $db->query($sql, $user);
        // get the user's ID
        $sql = "SELECT LAST_INSERT_ID() AS id";
        $row = $db->query_single($sql);
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
