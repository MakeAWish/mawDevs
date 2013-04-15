<?php

function sec_session_start()
{
    $session_name = 'sec_session_id'; // Set a custom session name
    $secure = false; // Set to true if using https.
    $httponly = true; // This stops javascript being able to access the session id.

    ini_set('session.use_only_cookies', 1); // Forces sessions to only use cookies.
    $cookieParams = session_get_cookie_params(); // Gets current cookies params.
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
    session_name($session_name); // Sets the session name to the one set above.
    session_start(); // Start the php session
    session_regenerate_id(true); // regenerated the session, delete the old one.
}

function debug($message)
{
    global $debugMessages;
    if (isset($debugMessages)) {
        array_push($debugMessages, $message);
    }
}

function login($with_username, $with_password, $bdd)
{
    // Using prepared Statements means that SQL injection is not possible.
    if ($stmt = $bdd->prepare("SELECT id, username, password, salt FROM users WHERE username = :username LIMIT 1")) {
        $stmt->bindParam(':username', $with_username, PDO::PARAM_STR, 50); // Bind "$username" to parameter.
        $stmt->execute(); // Execute the prepared query.

        if ($existing_user = $stmt->fetch()) { // If the user exists
            debug("User exists");
            extract($existing_user); // creates $id, $username, $password & $salt
            $with_password = hash('sha512', $with_password . $salt); // hash the password with the unique salt.
            // We check if the account is locked from too many login attempts
            if (checkbrute($id, $bdd) == true) {
                debug("User account is locked");
                return "locked";
            } else {
                if ($password == $with_password) { // Check if the password in the database matches the password the user submitted.
                    $ip_address = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user.
                    $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
                    $id = preg_replace("/[^0-9]+/", "", $id); // XSS protection as we might print this value
                    $_SESSION['user_id'] = $id;
                    $s_username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username); // XSS protection as we might print this value
                    $_SESSION['username'] = $s_username;
                    $_SESSION['login_string'] = hash('sha512', $password . $ip_address . $user_browser);
                    return "ok";
                } else {
                    debug("User password is wrong. We record this attempt in the database");
                    $now = time();
                    $bdd->query("INSERT INTO login_attempts (user_id, time) VALUES ('$id', '$now')");
                    return "failed";
                }
            }
        } else {
            debug("No user with this username");
            return "no_user";
        }
    }
}

function checkbrute($user_id, $bdd)
{
    // Get timestamp of current time
    $now = time();
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
        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];
        $ip_address = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.

        if ($stmt = $bdd->prepare("SELECT password FROM users WHERE id = :user_id LIMIT 1")) {
            $stmt->bindParam(':user_id', $user_id); // Bind "$user_id" to parameter.
            $stmt->execute(); // Execute the prepared query.

            if ($stmt->rowCount() == 1) { // If the user exists
                extract($stmt->fetch());
                $login_check = hash('sha512', $password . $ip_address . $user_browser);
                if ($login_check == $login_string) {
                    debug("User has been verified");
                    return true;
                } else {
                    debug("Login check failed : unable to match login string");
                    return false;
                }
            } else {
                debug("Login check failed : unable to find user");
                return false;
            }
        } else {
            debug("Login check failed : unable to prepare request");
            return false;
        }
    } else {
        debug("Login check failed : some parameters are not found");
        return false;
    }
}

function send_reset_mail($surname, $email, $linkId, $bdd)
{
    global $currentWebSite;
    require_once 'mail/swift_required.php';

    $aMailsDest = array(
        $email => $surname
    );

    $body = file_get_contents('mail/templates/reset/basic-inline.html');
    $body = str_replace("{surname}", $surname, $body);
    $body = str_replace("{reset-link}", $_SERVER['SERVER_NAME'] . "/?page=password-new&linkid=" . $linkId, $body);

    // SMTP
    $transport = Swift_SmtpTransport::newInstance('smtp.alwaysdata.com', 587)
        ->setUsername('makeawish@borisschapira.com')
        ->setPassword('!Liayf13*');

    $mailer = Swift_Mailer::newInstance($transport);

    $message = Swift_Message::newInstance()
        ->setSubject('Réinitialisation du mot de passe')
        ->setFrom(array('makeawish@borisschapira.com' => 'Make a Wish'))
        ->setTo($aMailsDest)
        ->setBody($body);

    // And optionally an alternative body
    //->addPart('<q>Here is the message itself</q>', 'text/html')

    // Optionally add any attachments
    //->attach(Swift_Attachment::fromPath('my-document.pdf'));

    $type = $message->getHeaders()->get('Content-Type');
    $type->setValue('text/html');
    $type->setParameter('charset', 'utf-8');

    $result = $mailer->send($message);
}

function issueLinkId($userid, $username, $bdd)
{
    // request from before are considered used
    $bdd->query("UPDATE public_links, public_links_type SET used = 1
        WHERE user_id = '$userid' AND public_links_type.id = public_links.type_id
        AND public_links_type.type='reset'");
    debug("All previous links marked as userd");

    // create new linkid
    $linkid = md5(uniqid($username, true));
    debug("Unique link id : $linkid");

    // create new request
    $logLink = $bdd->prepare("INSERT INTO public_links (user_id, type_id, linkid, time)
        SELECT :userId, id, :linkId, :now FROM public_links_type WHERE public_links_type.type='reset'");
    $logLink->bindParam(':userId', $userid);
    $logLink->bindParam(':linkId', $linkid);
    $logLink->bindParam(':now', time());
    $logLink->execute();
    if ($logLink->rowCount() > 0) {
        return $linkid;
    } else {
        return null;
    }
}

function bdd_getResetUser($bdd, $linkid)
{
    $getReset = $bdd->prepare("SELECT user_id FROM public_links
        INNER JOIN public_links_type ON public_links_type.id = public_links.type_id
        WHERE linkid = :linkId AND used=0 AND public_links_type.type='reset'");
    $getReset->bindParam(":linkId", $linkid);
    $getReset->execute();
    if ($getReset->rowCount() > 0) {
        $reset = $getReset->fetch(PDO::FETCH_OBJ);
        $resetIsUsed = $bdd->prepare("UPDATE public_links, public_links_type SET used = 1
        WHERE linkid = :linkId AND public_links_type.id = public_links.type_id
        AND public_links_type.type='reset'");
        $resetIsUsed->bindParam(":linkId", $linkid);
        $resetIsUsed->execute();
        return $reset;
    } else {
        return null;
    }
}

?>