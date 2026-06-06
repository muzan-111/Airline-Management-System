<?php
function response($code, $message, $data = null) {
    header("Content-Type: application/json");
    http_response_code($code);
    
    $res = ["message" => $message];
    if ($data !== null) {
        $res["data"] = $data;
    }
    
    echo json_encode($res);
    exit();
}
?>