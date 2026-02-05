// ===== REGISTER =====
const regForm = document.getElementById("registerForm");
if(regForm){
  regForm.addEventListener("submit", async (e)=>{
    e.preventDefault();
    const username = document.getElementById("reg_username").value;
    const password = document.getElementById("reg_password").value;

    const res = await fetch(`${BASE_API}/auth-register.php`,{
      method:"POST",
      headers:{ "Content-Type":"application/json" },
      body: JSON.stringify({ username, password })
    });
    const data = await res.json();
    document.getElementById("reg_msg").innerText = data.message || "";
    if(data.success) setTimeout(()=>location.href="login.html",700);
  });
}

// ===== LOGIN =====
const loginForm = document.getElementById("loginForm");
if(loginForm){
  loginForm.addEventListener("submit", async (e)=>{
    e.preventDefault();
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    const res = await fetch(`${BASE_API}/auth-login.php`,{
      method:"POST",
      headers:{ "Content-Type":"application/json" },
      body: JSON.stringify({ username, password })
    });
    const data = await res.json();

    if(!data.success){
      document.getElementById("loginError").innerText = data.message || "Login gagal";
      return;
    }

    setSession(data.token, data.role);

    const staff = ["admin","kepala_desa","sekretaris","kaur"];
    if(staff.includes(data.role)) location.href = "admin/dashboard.html";
    else location.href = "index.html";
  });
}

// ===== PENGAJUAN (opsional kalau ada form) =====
const ajForm = document.getElementById("pengajuanForm");
if(ajForm){
  ajForm.addEventListener("submit", async (e)=>{
    e.preventDefault();
    const nik = document.getElementById("nik").value;
    const nama = document.getElementById("nama").value;
    const jenis = document.getElementById("jenis").value;
    const keperluan = document.getElementById("keperluan").value;

    const res = await fetch(`${BASE_API}/pengajuan-create.php`,{
      method:"POST",
      headers:{ "Content-Type":"application/json" },
      body: JSON.stringify({ nik, nama, jenis, keperluan })
    });
    const data = await res.json();
    alert(data.success ? ("Kode Tracking: "+data.kode) : (data.message || "Gagal"));
  });
}

// ===== TRACKING (opsional kalau ada tombol) =====
const trackBtn = document.getElementById("trackBtn");
if(trackBtn){
  trackBtn.addEventListener("click", async ()=>{
    const kode = document.getElementById("kode").value;
    const hasil = document.getElementById("hasil");
    const res = await fetch(`${BASE_API}/tracking.php?kode=${encodeURIComponent(kode)}`);
    const d = await res.json();
    hasil.innerHTML = d.nama ? `<b>${d.nama}</b> — ${d.status}` : "Tidak ditemukan";
  });
}

// ===== PROFIL + GALERI + UMKM =====
async function loadProfil(){
  if(!document.getElementById("namaDesa")) return;

  const prof = await fetch(`${BASE_API}/profil.php`).then(r=>r.json());
  document.getElementById("namaDesa").innerText = prof.nama_desa || "Profil Desa";
  document.getElementById("deskripsi").innerText = prof.deskripsi || "";

  const umkm = await fetch(`${BASE_API}/umkm.php`).then(r=>r.json());
  document.getElementById("umkm").innerHTML = umkm.map(x=>`
    <div class="card"><h4>${x.nama}</h4><p>${x.deskripsi}</p></div>
  `).join("");

  const galeri = await fetch(`${BASE_API}/galeri.php`).then(r=>r.json());
  document.getElementById("galeri").innerHTML = galeri.map(g=>`
    <figure class="g-item">
      <img src="assets/img/${g.filename}" alt="${g.keterangan||""}">
      <figcaption>${g.keterangan||""}</figcaption>
    </figure>
  `).join("");
}
loadProfil();

// ===== ADMIN DASHBOARD =====
async function loadAdminDashboard(){
  const chartEl = document.getElementById("chartPenduduk");
  if(!chartEl) return;

  await requireAdmin();

  const res = await fetch(`${BASE_API}/demografi.php`,{
    headers:{ Authorization:`Bearer ${getToken()}` }
  });
  const d = await res.json();

  document.getElementById("total").innerText = d.total;
  document.getElementById("laki").innerText = d.laki;
  document.getElementById("perempuan").innerText = d.perempuan;
  document.getElementById("dusun").innerText = d.dusun;

  new Chart(chartEl,{
    type:"doughnut",
    data:{ labels:["Laki-laki","Perempuan"], datasets:[{ data:[d.laki,d.perempuan] }] }
  });
}
loadAdminDashboard();

// ===== ADMIN PENGAJUAN LIST =====
async function loadAdminPengajuan(){
  const tbody = document.getElementById("tblPengajuan");
  if(!tbody) return;

  await requireAdmin();

  const rows = await fetch(`${BASE_API}/admin-pengajuan-list.php`,{
    headers:{ Authorization:`Bearer ${getToken()}` }
  }).then(r=>r.json());

  tbody.innerHTML = rows.map(r=>`
    <tr>
      <td>${r.created_at}</td>
      <td>${r.nama}</td>
      <td>${r.nik}</td>
      <td>${r.nama_surat}</td>
      <td><code>${r.tracking_code}</code></td>
      <td>
        <select class="statusSel" data-id="${r.id}">
          ${["Diproses","Disetujui","Ditolak"].map(s=>`
            <option ${s===r.status?"selected":""}>${s}</option>
          `).join("")}
        </select>
      </td>
    </tr>
  `).join("");

  document.querySelectorAll(".statusSel").forEach(sel=>{
    sel.addEventListener("change", async ()=>{
      const id = sel.dataset.id;
      const status = sel.value;

      const out = await fetch(`${BASE_API}/admin-pengajuan-update.php`,{
        method:"POST",
        headers:{
          "Content-Type":"application/json",
          Authorization:`Bearer ${getToken()}`
        },
        body: JSON.stringify({ id, status })
      }).then(r=>r.json());

      if(!out.success) alert(out.message || "Gagal update");
    });
  });
}
loadAdminPengajuan();

// ===== LOAD JENIS SURAT DARI DATABASE =====
async function loadJenisSurat(){
  const el = document.getElementById("jenis");
  if(!el){
    console.log("❌ select #jenis tidak ditemukan");
    return;
  }

  try{
    const res = await fetch(`${BASE_API}/jenis-surat.php`);
    console.log("STATUS:", res.status);

    const data = await res.json();
    console.log("DATA JENIS SURAT:", data);

    el.innerHTML =
      `<option value="">-- Pilih Jenis Surat --</option>` +
      data.map(j=>`
        <option value="${j.id}">${j.nama_surat}</option>
      `).join("");
  }catch(err){
    console.error("❌ Gagal load jenis surat:", err);
  }
}
loadJenisSurat();
