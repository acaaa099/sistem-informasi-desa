<?php
include "_init.php";
$me = require_token();
echo json_encode(["success"=>true,"me"=>$me]);
