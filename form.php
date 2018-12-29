<?php
 
// grab recaptcha library
require_once "recaptchalib.php";

// ваш секретный ключ
$secret = "6Le-w4QUAAAAANbK-mlGEJVBIjVyjhk3pImByPFp";
// пустой ответ
$response = null;
// проверка секретного ключа
$reCaptcha = new ReCaptcha($secret);

// if submitted check response
if ($_POST["g-recaptcha-response"]) {
    $response = $reCaptcha->verifyResponse(
        $_SERVER["REMOTE_ADDR"],
        $_POST["g-recaptcha-response"]
    );
}

if ($response != null && $response->success) {
    // echo "Hi " . $_POST["name"] . " (" . $_POST["email"] . "), thanks for submitting the form!";
} else {

}

echo json_encode($_POST);;
 
?>