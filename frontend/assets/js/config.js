// BASE URL (Apache)
const BASE_API = "http://localhost/SISTEM-INFORMASI-DESA/backend/api";

// TOKEN HELPERS
function setSession(token, role){
  localStorage.setItem("token", token);
  localStorage.setItem("role", role);
}

function getToken(){
  return localStorage.getItem("token");
}

function doLogout(redirect="login.html"){
  localStorage.removeItem("token");
  localStorage.removeItem("role");
  location.href = redirect;
}
