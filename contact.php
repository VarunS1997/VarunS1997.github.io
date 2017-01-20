<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Contact | Varun Singh</title>

    <link rel="stylesheet" type="text/css" href="CSS/contactForms.css" />
    <?php include "modules/std-config.html"; ?>
    <?php
    $userName = "";
    $userEmail = "";
    $userMessage = "";

    $success = false;

    function clean($in){
        $out = htmlspecialchars(stripslashes(trim($in)), ENT_QUOTES);
        return $out;
    }

    if($_SERVER["REQUEST_METHOD"] == "POST" && (!(empty($_POST["userName"]) || empty($_POST["userEmail"]) || empty($_POST["userMessage"])))){ //method is post and all fields filled
        $userName = clean($_POST["userName"]);
        $userEmail = clean($_POST["userEmail"]);
        $userMessage = wordwrap(clean($_POST["userMessage"]), 70, "\r\n");

        if(!(filter_var($userEmail, FILTER_VALIDATE_EMAIL) === false)){
            $success = mail("varun.1997.singh@gmail.com", "WEBSITE CONTACT SUBMISSION: " . $userName, $userMessage, "From: " . $userEmail) . "\r\n";

            //TODO log the error

            echo "<script>
            window.onload = function () { timedAlert('" . ($success ? "Email sent successfully!" : "An error occurred: " . error_get_last()) . "'); };
            </script>";
        } else{
            $errMessage = "Error! Please enter a valid email address";

            echo "<script>
            window.onload = function(){ timedAlert('" . $errMessage . "'); };
            </script>";
        }
    }
    ?>
    <script>
    var formSize;
    var formElements;
    var textArea;
    var submitButton;

    function initForms(){
        formElements = document.getElementById("contactForm").getElementsByTagName("input");
        textArea = document.getElementById("messageField");

        submitButton = document.getElementById("submitButton");

        formSize = formElements.length-1; //exclude submit button

        for(var i = 0; i < formSize; i++){
            formElements[i].addEventListener("input", checkForm);
            textArea.addEventListener("input", checkForm);
        }
    }

    function checkForm(){
        if(isBlank(textArea.value)){
            submitButton.disabled = "disabled";
            return false;
        }

        for(var i = 0; i < formSize; i++){
            if(isBlank(formElements[i].value)){
                submitButton.disabled = "disabled";
                return false;
            }
        }

        submitButton.removeAttribute("disabled");
        return true;
    }

    // AUXILLARY FUNCTIONS
    function isBlank(str) {
        return (!str || /^\s*$/.test(str));
    }
    </script>
</head>
<body onload="initResponsive(); initForms();">
    <?php include "modules/page-header.php"; ?>
    <div class="wrapper" id="body-wrapper">
        <div class="container">
            <span class="section-title title">Interested in working with me?</span>
            <div class="text-container">
                Fill out this short form, and I'll get back to you.
                <form id="contactForm" autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <span class="input-wrapper">
                        <span>Name</span><input name="userName" type="text" value="<?php echo (!$success ? $userName : ""); ?>"/>
                    </span>
                    <span class="input-wrapper">
                        <span>Email</span><input name="userEmail" type="text" value="<?php echo (!$success ? $userEmail : ""); ?>"/>
                    </span><br />
                    <span class="input-wrapper long-input-wrapper">
                        <span>Your Message</span>
                        <textarea id="messageField" name="userMessage" rows="20" type="text"><?php echo (!$success ? $userMessage : ""); ?></textarea><br/>
                        <input id="submitButton" disabled="disabled" value="Submit" name="submit" type="submit" />
                    </span><br />
                </form>
            </div>
        </div>
    </div>
    <?php
    include "modules/footer.php";
    ?>
</body>
</html>
