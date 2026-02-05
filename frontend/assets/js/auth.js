async function authMe(){
  const token = getToken();
  if(!token) return null;

  const res = await fetch(`${BASE_API}/auth-me.php`, {
    headers: { Authorization: `Bearer ${token}` }
  });

  if(!res.ok) return null;
  const data = await res.json();
  return data.me || null;
}

async function requireLogin(){
  const me = await authMe();
  if(!me) location.href = "login.html";
  return me;
}

async function requireAdmin(){
  const me = await authMe();
  const allowed = ["admin","kepala_desa","sekretaris","kaur"];
  if(!me) location.href = "../login.html";
  if(me && !allowed.includes(me.role)) location.href = "../index.html";
  return me;
}

async function doLogout(to="login.html"){
  const token = getToken();
  if(token){
    await fetch(`${BASE_API}/auth-logout.php`, {
      headers:{ Authorization:`Bearer ${token}` }
    }).catch(()=>{});
  }
  clearSession();
  location.href = to;
}
