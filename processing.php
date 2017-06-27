<?php
    define("TO", "michellesimkins@hotmail.co.uk");
    define("SUBJECT", "New appointment [via website]");
    define("MESSAGE_HEADER", "Contact details:");
    
    $is_ajax_request = FALSE;
    
    if (isset($_SERVER["HTTP_X_REQUESTED_WITH"])
            && (strcasecmp($_SERVER["HTTP_X_REQUESTED_WITH"], "XMLHttpRequest") === 0)) {
        $is_ajax_request = TRUE;
    }

    if ($is_ajax_request) {
        if (isset($_POST["name"]) && trim($_POST["name"]) !== "") {
            $name = trim($_POST["name"]);
        }
        
        if (isset($_POST["telephone"]) && trim($_POST["telephone"]) !== "") {
            $telephone = trim($_POST["telephone"]);
        }
        
        if (isset($_POST["email"]) && trim($_POST["email"]) !== "") {
            $email = trim($_POST["email"]);
        }
        
        if (!(empty($name) || empty($telephone) || empty($email))
                && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            
            $message = "Name: " . $name . PHP_EOL
                    . "Telephone: " . $telephone . PHP_EOL 
                    . "Email: " . $email . PHP_EOL;

			if (isset($_POST["no_of_properties"]) && trim($_POST["no_of_properties"]) !== "") {
				$message .= "No of properties: " . trim($_POST["no_of_properties"]) . PHP_EOL;
			}
			
			if (isset($_POST["message"]) && trim($_POST["message"]) !== "") {
				$message .= PHP_EOL . trim($_POST["message"]);
			}
					
					
            if (!empty(MESSAGE_HEADER)) {
                $message = MESSAGE_HEADER . PHP_EOL .PHP_EOL . $message;
            }
            
            $additional_headers = "From: $email" . PHP_EOL
                    . "Reply-To: $email" . PHP_EOL
                    . "MIME-Version: 1.0" . PHP_EOL
                    . "Content-type: text/plain; charset=utf-8" . PHP_EOL
                    . "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;
            
            if (!mail(TO, SUBJECT, $message, $additional_headers)) {
                echo "Error: Mail";
            }
        } else {
            echo "Error: Form fields";
        }
    } else {
        
    }