<?php
session_start();

function cekLogin(){
  if(!isset($_SESSION['role'])){
    http_response_code(403);
    exit("Akses ditolak");
  }
}

function cekRole($roles=[]){
  cekLogin();
  if(!in_array($_SESSION['role'],$roles)){
    exit("Role tidak diizinkan");
  }
}
