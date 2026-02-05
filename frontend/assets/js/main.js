/* =========================================================
   KONFIG & AUTH HELPER
========================================================= */

async function authMe(){
  const token = getToken();
  if(!token) return null;

  const res = await fetch(`${BASE_API}/auth-me.php`,{
    headers:{ Authorization:`Bearer ${token}` }
  });

  if(!res.ok) return null;
  const d = await res.json();
  return d.me || null;
}

async function requireAdmin(){
  const me = await authMe();
  if(!me){
    location.href = "../login.html";
    return null;
  }
  const allowed = ["admin","kepala_desa","sekretaris","kaur"];
  if(!allowed.includes(me.role)){
    location.href = "../index.html";
    return null;
  }
  return me;
}

/* =========================================================
   REGISTER
========================================================= */
const regForm = document.getElementById("registerForm");
if(regForm){
  regForm.addEventListener("submit", async e=>{
    e.preventDefault();
    const username = reg_username.value.trim();
    const password = reg_password.value;

    const res = await fetch(`${BASE_API}/auth-register.php`,{
      method:"POST",
      headers:{ "Content-Type":"application/json" },
      body: JSON.stringify({ username, password })
    });
    const d = await res.json();
    reg_msg.innerText = d.message || "";
    if(d.success) setTimeout(()=>location.href="login.html",800);
  });
}

/* =========================================================
   LOGIN
========================================================= */
const loginForm = document.getElementById("loginForm");
if(loginForm){
  loginForm.addEventListener("submit", async e=>{
    e.preventDefault();
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    const res = await fetch(`${BASE_API}/auth-login.php`,{
      method:"POST",
      headers:{ "Content-Type":"application/json" },
      body: JSON.stringify({ username, password })
    });
    const d = await res.json();

    if(!d.success){
      loginError.innerText = d.message || "Login gagal";
      return;
    }

    setSession(d.token, d.role);
    const staff = ["admin","kepala_desa","sekretaris","kaur"];
    location.href = staff.includes(d.role) ? "admin/dashboard.html" : "index.html";
  });
}

/* =========================================================
   PENGAJUAN WARGA
========================================================= */
const ajForm = document.getElementById("pengajuanForm");
if(ajForm){
  ajForm.addEventListener("submit", async e=>{
    e.preventDefault();
    const nik = nik.value;
    const nama = nama.value;
    const jenis = jenis.value;
    const keperluan = keperluan.value;

    const res = await fetch(`${BASE_API}/pengajuan-create.php`,{
      method:"POST",
      headers:{ "Content-Type":"application/json" },
      body: JSON.stringify({ nik,nama,jenis,keperluan })
    });
    const d = await res.json();
    alert(d.success ? "Kode Tracking: "+d.kode : d.message);
  });
}

/* =========================================================
   TRACKING
========================================================= */
const trackBtn = document.getElementById("trackBtn");
if(trackBtn){
  trackBtn.addEventListener("click", async ()=>{
    const kode = document.getElementById("kode").value.trim();
    if(!kode) return hasil.innerText="Masukkan kode";

    const d = await fetch(`${BASE_API}/tracking.php?kode=${encodeURIComponent(kode)}`)
      .then(r=>r.json());

    if(!d.nama){
      hasil.innerText="Tidak ditemukan";
      return;
    }

    let html = `
      <p><b>Nama:</b> ${d.nama}</p>
      <p><b>Status:</b> ${d.status}</p>
    `;

    if(d.status==="Disetujui"){
      html += `
        <a href="${BASE_API}/surat-download.php?kode=${kode}"
           target="_blank"
           class="btn btn-primary"
           style="margin-top:10px;display:inline-block">
           Download Surat
        </a>`;
    }
    hasil.innerHTML = html;
  });
}

/* =========================================================
   PROFIL DESA
========================================================= */
async function loadProfil(){
  if(!document.getElementById("namaDesa")) return;

  const prof = await fetch(`${BASE_API}/profil.php`).then(r=>r.json());
  namaDesa.innerText = prof.nama_desa || "Profil Desa";
  deskripsi.innerText = prof.deskripsi || "";

  const umkm = await fetch(`${BASE_API}/umkm.php`).then(r=>r.json());
  document.getElementById("umkm").innerHTML = umkm.map(u=>`
    <div class="card"><h4>${u.nama}</h4><p>${u.deskripsi}</p></div>
  `).join("");

  const galeri = await fetch(`${BASE_API}/galeri.php`).then(r=>r.json());
  document.getElementById("galeri").innerHTML = galeri.map(g=>`
    <figure class="g-item">
      <img src="assets/img/${g.filename}">
      <figcaption>${g.keterangan||""}</figcaption>
    </figure>
  `).join("");
}
loadProfil();

/* =========================================================
   ADMIN DASHBOARD
========================================================= */
async function loadAdminDashboard(){
  const chart = document.getElementById("chartPenduduk");
  if(!chart) return;

  await requireAdmin();
  const d = await fetch(`${BASE_API}/demografi.php`,{
    headers:{ Authorization:`Bearer ${getToken()}` }
  }).then(r=>r.json());

  total.innerText = d.total;
  laki.innerText = d.laki;
  perempuan.innerText = d.perempuan;
  dusun.innerText = d.dusun;

  new Chart(chart,{
    type:"doughnut",
    data:{ labels:["Laki","Perempuan"], datasets:[{ data:[d.laki,d.perempuan] }] }
  });
}
loadAdminDashboard();

async function updateStatusPengajuan(id,status){
  await fetch(`${BASE_API}/admin-pengajuan-update.php`,{
    method:"POST",
    headers:{
      "Content-Type":"application/json",
      Authorization:`Bearer ${getToken()}`
    },
    body:JSON.stringify({id,status})
  });
}


/* =========================================================
   ADMIN - PENGAJUAN SURAT
========================================================= */

async function loadAdminPengajuan(){
  const tbody = document.getElementById("tblPengajuan");
  if(!tbody) return;

  try{
    const res = await fetch(`${BASE_API}/admin-pengajuan-list.php`);
    const rows = await res.json();

    tbody.innerHTML = rows.map(r=>`
      <tr>
        <td>${r.created_at || "-"}</td>
        <td>${r.nama}</td>
        <td>${r.nik}</td>
        <td>${r.nama_surat || "-"}</td>
        <td><code>${r.tracking_code}</code></td>
        <td>
          <select onchange="updateStatus(${r.id},this.value)">
            ${["Diproses","Disetujui","Ditolak"].map(s=>`
              <option ${s===r.status?"selected":""}>${s}</option>
            `).join("")}
          </select>
        </td>
      </tr>
    `).join("");

  }catch(e){
    tbody.innerHTML = `<tr><td colspan="6" style="color:red">Gagal memuat data</td></tr>`;
  }
}

async function updateStatus(id,status){
  await fetch(`${BASE_API}/admin-pengajuan-update.php`,{
    method:"POST",
    headers:{ "Content-Type":"application/json" },
    body: JSON.stringify({id,status})
  });
}

loadAdminPengajuan();



/* =========================================================
   ADMIN – CRUD WARGA (FIX TOTAL)
========================================================= */

// READ
async function loadAdminWarga(){
  const tbody = document.getElementById("tblWarga");
  if(!tbody) return;

  await requireAdmin();

  const rows = await fetch(`${BASE_API}/admin-warga.php`,{
    headers:{ Authorization:`Bearer ${getToken()}` }
  }).then(r=>r.json());

  tbody.innerHTML = rows.map(w=>`
    <tr>
      <td>${w.nik}</td>
      <td>${w.nama}</td>
      <td>${w.jenis_kelamin}</td>
      <td>${w.pekerjaan}</td>
      <td>
        <button onclick="hapusWarga('${w.nik}')" style="color:red">Hapus</button>
      </td>
    </tr>
  `).join("");
}
loadAdminWarga();

// CREATE
const formWarga = document.getElementById("formWarga");
if(formWarga){
  formWarga.addEventListener("submit", async e=>{
    e.preventDefault();

    const nik = w_nik.value.trim();
    const nama = w_nama.value.trim();
    const jenis_kelamin = w_jk.value;
    const pekerjaan = w_pekerjaan.value.trim();

    if(!nik||!nama||!jenis_kelamin||!pekerjaan){
      alert("Data tidak lengkap");
      return;
    }

    const res = await fetch(`${BASE_API}/admin-warga-create.php`,{
      method:"POST",
      headers:{
        "Content-Type":"application/json",
        Authorization:`Bearer ${getToken()}`
      },
      body: JSON.stringify({ nik,nama,jenis_kelamin,pekerjaan })
    });

    const d = await res.json();
    alert(d.message);
    if(d.success){
      formWarga.reset();
      loadAdminWarga();
    }
  });
}

// DELETE
async function hapusWarga(nik){
  if(!confirm("Hapus warga ini?")) return;

  await fetch(`${BASE_API}/admin-warga-delete.php`,{
    method:"POST",
    headers:{
      "Content-Type":"application/json",
      Authorization:`Bearer ${getToken()}`
    },
    body: JSON.stringify({ nik })
  });

  loadAdminWarga();
}

/* =========================================================
   JENIS SURAT
========================================================= */
async function loadJenisSurat(){
  const el = document.getElementById("jenis");
  if(!el) return;

  const data = await fetch(`${BASE_API}/jenis-surat.php`).then(r=>r.json());
  el.innerHTML = `<option value="">-- Pilih Jenis Surat --</option>` +
    data.map(j=>`<option value="${j.id}">${j.nama_surat}</option>`).join("");
}
loadJenisSurat();
