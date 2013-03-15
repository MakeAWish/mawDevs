<?php

function sec_session_start()
{
    $session_name = 'sec_session_id'; // Set a custom session name
    $secure       = false; // Set to true if using https.
    $httponly     = true; // This stops javascript being able to access the session id.

    ini_set('session.use_only_cookies', 1); // Forces sessions to only use cookies.
    $cookieParams = session_get_cookie_params(); // Gets current cookies params.
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
    session_name($session_name); // Sets the session name to the one set above.
    session_start(); // Start the php session
    session_regenerate_id(true); // regenerated the session, delete the old one.
}

function login($with_username, $with_password, $bdd)
{
    echo "username : '" . $with_username . "'<br />";
    echo "Sha-ed Pwd : '" . $with_password . "'<br />";
    // Using prepared Statements means that SQL injection is not possible.
    if ($stmt = $bdd->prepare("SELECT id, username, password, salt FROM users WHERE username = :username LIMIT 1")) {
        $stmt->bindParam(':username', $with_username, PDO::PARAM_STR, 50); // Bind "$username" to parameter.
        $stmt->execute(); // Execute the prepared query.

        if ($existing_user = $stmt->fetch()) { // If the user exists
            extract($existing_user); // creates $id, $username, $password & $salt
            $with_password = hash('sha512', $with_password . $salt); // hash the password with the unique salt.

            // We check if the account is locked from too many login attempts
            if (checkbrute($id, $bdd) == true) {
                // Account is locked
                // Send an username to user saying their account is locked
                return "locked";
            } else {
                if ($password == $with_password) { // Check if the password in the database matches the password the user submitted.
                    // Password is correct!
                    $ip_address               = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user.
                    $user_browser             = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
                    $id                       = preg_replace("/[^0-9]+/", "", $id); // XSS protection as we might print this value
                    $_SESSION['user_id']      = $id;
                    $s_username                 = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username); // XSS protection as we might print this value
                    $_SESSION['username']     = $s_username;
                    $_SESSION['login_string'] = hash('sha512', $password . $ip_address . $user_browser);
                    // Login successful.

                    return "ok";
                } else {
                    // Password is not correct
                    // We record this attempt in the database
                    $now = time();
                    $bdd->query("INSERT INTO login_attempts (user_id, time) VALUES ('$id', '$now')");
                    return "failed";
                }
            }
        } else {
            // No user exists.
            return "no_user";
        }
    }
}

function checkbrute($user_id, $bdd)
{
    // Get timestamp of current time
    $now            = time();
    // All login attempts are counted from the past 2 hours.
    $valid_attempts = $now - (2 * 60 * 60);

    if ($stmt = $bdd->prepare("SELECT time FROM login_attempts WHERE user_id = :user_id AND time > '$valid_attempts'")) {
        $stmt->bindParam(':user_id', $user_id);
        // Execute the prepared query.
        $stmt->execute();
        // If there has been more than 5 failed logins
        if ($stmt->rowCount() > 5) {
            return true;
        } else {
            return false;
        }
    }
}

function resetPassword($username, $password, $salt, $bdd)
{
    if ($stmt = $bdd->prepare("UPDATE users SET password = :password, salt = :salt WHERE users.username = :username ;")) {
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':salt', $salt);
        $stmt->bindParam(':username', $username);
        // Execute the prepared query.
        $stmt->execute();
    }
    return true;
}

function login_check($bdd)
{
    // Check if all session variables are set
    if (isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {
        $user_id      = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username     = $_SESSION['username'];
        $ip_address   = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.

        if ($stmt = $bdd->prepare("SELECT password FROM users WHERE id = :user_id LIMIT 1")) {
            $stmt->bindParam(':user_id', $user_id); // Bind "$user_id" to parameter.
            $stmt->execute(); // Execute the prepared query.
            if ($stmt->rowCount() == 1) { // If the user exists
                extract($stmt->fetch());
                $login_check = hash('sha512', $password . $ip_address . $user_browser);
                if ($login_check == $login_string) {
                    // Logged In!!!!
                    return true;
                } else {
                    // Not logged in
                    return false;
                }
            } else {
                // Not logged in
                return false;
            }
        } else {
            // Not logged in
            return false;
        }
    } else {
        // Not logged in
        return false;
    }
}

?>