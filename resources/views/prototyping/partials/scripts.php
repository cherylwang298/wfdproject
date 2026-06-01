<?php
// scripts.php: seluruh JS + data dari index.php
?>

<script>
// ═══════════════════ DATABASES ═══════════════════

// CRUD 1: Properti
let propertyDB=[
  {id:"v-001",name:"Sky View Private Villa",type:"Villa & Balcony",category:"villa",city:"Batu",locationDetail:"Oro-Oro Ombo, Batu",pricePerNight:850000,rating:4.8,facilities:["🏊 Pool","🌅 Balcony","📶 Wifi"],imageUrl:"https://images.unsplash.com/photo-1580587771525-78b9dba3b914?w=500",status:"active",desc:"Villa premium dengan pemandangan kota Batu yang spektakuler. Dilengkapi kolam renang private dan balkon luas."},
  {id:"v-002",name:"Green Pine Family Homestay",type:"Villa Rumah",category:"villa",city:"Batu",locationDetail:"Songgokerto, Batu",pricePerNight:620000,rating:4.6,facilities:["👪 Fam Room","🌳 Garden","📶 Wifi"],imageUrl:"https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=500",status:"active",desc:"Homestay keluarga yang nyaman di lereng Gunung Arjuno. Cocok untuk liburan bersama keluarga besar."},
  {id:"v-003",name:"Canggu Bliss Luxury Villa",type:"Private Pool Villa",category:"villa",city:"Bali",locationDetail:"Canggu, Bali",pricePerNight:1850000,rating:4.9,facilities:["🏊 Pool","🌅 Balcony","📶 Wifi"],imageUrl:"https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=500",status:"active",desc:"Villa mewah di jantung Canggu dengan kolam renang infinity dan desain interior modern Bali."},
  {id:"v-004",name:"Ubud Rainforest Retreat",type:"Resort Villa",category:"villa",city:"Bali",locationDetail:"Sayan, Ubud, Bali",pricePerNight:2100000,rating:4.9,facilities:["🏊 Pool","🌳 Garden","📶 Wifi"],imageUrl:"https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=500",status:"active",desc:"Retreat tersembunyi di tengah hutan hujan Ubud. Nikmati harmoni alam dan kemewahan dalam satu tempat."},
  {id:"v-005",name:"Seminyak Sun & Surf Villa",type:"Private Pool Villa",category:"villa",city:"Bali",locationDetail:"Seminyak, Kuta, Bali",pricePerNight:1650000,rating:4.7,facilities:["🏊 Pool","🌅 Balcony","📶 Wifi"],imageUrl:"https://images.unsplash.com/photo-1512915922686-57c11dde9b6b?w=500",status:"active",desc:"Villa pantai dekat Seminyak beach. Parfait untuk menikmati sunset Bali yang iconic."},
  {id:"h-001",name:"The Grand Palace Hotel",type:"Luxury Hotel",category:"hotel",city:"Surabaya",locationDetail:"Genteng, Surabaya Pusat",pricePerNight:1200000,rating:4.8,facilities:["🏊 Pool","🏋 Gym","🍳 Breakfast"],imageUrl:"https://images.unsplash.com/photo-1566073771259-6a8506099945?w=500",status:"active",desc:"Hotel bintang 5 di pusat kota Surabaya. Fasilitas kelas dunia termasuk spa, rooftop bar, dan restoran fine dining."},
  {id:"h-002",name:"Neo Horizon Business Hotel",type:"Business Hotel",category:"hotel",city:"Surabaya",locationDetail:"Gubeng, Surabaya",pricePerNight:650000,rating:4.5,facilities:["💻 Meeting Rm","🍳 Breakfast","📶 Wifi"],imageUrl:"https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=500",status:"active",desc:"Hotel bisnis modern dengan fasilitas meeting room state-of-the-art. Lokasi strategis dekat pusat bisnis."},
  {id:"h-003",name:"Batu Heritage Resort",type:"Boutique Hotel",category:"hotel",city:"Batu",locationDetail:"Sisir, Kota Batu",pricePerNight:890000,rating:4.6,facilities:["🏊 Pool","🌳 Garden","🍳 Breakfast"],imageUrl:"https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=500",status:"active",desc:"Boutique hotel dengan arsitektur heritage Belanda. Dikelilingi kebun teh dan pemandangan Gunung Arjuno."},
  {id:"a-001",name:"Ciputra World Residence",type:"Service Apartment",category:"apartment",city:"Surabaya",locationDetail:"Ciputra World, Surabaya",pricePerNight:750000,rating:4.5,facilities:["🏊 Pool","🏋 Gym","📶 Wifi"],imageUrl:"https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=500",status:"active",desc:"Apartemen service premium di kawasan Ciputra World. Dilengkapi gym, rooftop pool, dan akses mall."},
];

// CRUD 2: Penerbangan
let flightDB=[
  {id:"f-001",airline:"Garuda Indonesia",logo:"GA",code:"GA-401",from:"Surabaya",fromCode:"SUB",to:"Bali",toCode:"DPS",depart:"06:00",arrive:"07:10",duration:"1j 10m",stops:"Langsung",price:850000,class:"Ekonomi",status:"active"},
  {id:"f-002",airline:"Lion Air",logo:"JT",code:"JT-712",from:"Surabaya",fromCode:"SUB",to:"Bali",toCode:"DPS",depart:"08:30",arrive:"09:40",duration:"1j 10m",stops:"Langsung",price:450000,class:"Ekonomi",status:"active"},
  {id:"f-003",airline:"Citilink",logo:"QG",code:"QG-156",from:"Surabaya",fromCode:"SUB",to:"Jakarta",toCode:"CGK",depart:"10:00",arrive:"11:30",duration:"1j 30m",stops:"Langsung",price:380000,class:"Ekonomi",status:"active"},
  {id:"f-004",airline:"Batik Air",logo:"ID",code:"ID-7204",from:"Surabaya",fromCode:"SUB",to:"Jakarta",toCode:"CGK",depart:"13:15",arrive:"14:45",duration:"1j 30m",stops:"Langsung",price:520000,class:"Ekonomi",status:"active"},
  {id:"f-005",airline:"Garuda Indonesia",logo:"GA",code:"GA-700",from:"Surabaya",fromCode:"SUB",to:"Bali",toCode:"DPS",depart:"15:30",arrive:"16:40",duration:"1j 10m",stops:"Langsung",price:920000,class:"Bisnis",status:"active"},
  {id:"f-006",airline:"Super Air Jet",logo:"IU",code:"IU-301",from:"Surabaya",fromCode:"SUB",to:"Lombok",toCode:"LOP",depart:"07:00",arrive:"08:15",duration:"1j 15m",stops:"Langsung",price:320000,class:"Ekonomi",status:"active"},
  {id:"f-007",airline:"AirAsia",logo:"QZ",code:"QZ-7956",from:"Surabaya",fromCode:"SUB",to:"Jogja",toCode:"JOG",depart:"17:45",arrive:"18:30",duration:"45m",stops:"Langsung",price:290000,class:"Ekonomi",status:"active"},
  {id:"f-008",airline:"Garuda Indonesia",logo:"GA",code:"GA-370",from:"Surabaya",fromCode:"SUB",to:"Makassar",toCode:"UPG",depart:"09:00",arrive:"10:50",duration:"1j 50m",stops:"Langsung",price:610000,class:"Ekonomi",status:"active"},
];

// CRUD 3: Pemesanan
let bookingDB=[
  {id:"B-001",guest:"Jessica Gabriel",type:"accom",product:"Canggu Bliss Luxury Villa",checkin:"2026-06-10",checkout:"2026-06-13",total:5550000,status:"confirmed",paymentMethod:"Credit Card",bookedAt:"2026-06-01T10:30:00",imageUrl:"https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=500",villaName:"Canggu Bliss Luxury Villa"},
  {id:"B-002",guest:"Ahmad Fauzi",type:"flight",product:"Garuda Indonesia GA-401",airline:"Garuda Indonesia",flightCode:"GA-401",from:"Surabaya (SUB)",to:"Bali (DPS)",depart:"06:00",date:"2026-07-20",passenger:"2 Dewasa",total:1870000,status:"confirmed",paymentMethod:"Bank Transfer",bookedAt:"2026-06-15T14:00:00"},
  {id:"B-003",guest:"Sari Dewi",type:"accom",product:"The Grand Palace Hotel",checkin:"2026-06-20",checkout:"2026-06-22",total:2400000,status:"pending",paymentMethod:"E-Wallet",bookedAt:"2026-06-18T09:00:00",imageUrl:"https://images.unsplash.com/photo-1566073771259-6a8506099945?w=500",villaName:"The Grand Palace Hotel"},
];

// CRUD 4: Promo / Voucher
let promoDB=[
  {id:"p-001",code:"BALI40",title:"Diskon Bali 40%",discount:"40%",minTx:1000000,validUntil:"2026-07-31",status:"active",imageUrl:"https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=400",desc:"Hemat 40% untuk semua properti di Bali"},
  {id:"p-002",code:"FLASH50",title:"Flash Sale 50%",discount:"50%",minTx:500000,validUntil:"2026-06-30",status:"active",imageUrl:"https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400",desc:"Flash sale khusus akhir Juni"},
  {id:"p-003",code:"NEWUSER",title:"Pengguna Baru",discount:"25%",minTx:200000,validUntil:"2026-12-31",status:"active",imageUrl:"https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=400",desc:"Diskon 25% untuk pemesanan pertama"},
  {id:"p-004",code:"TERBANG30",title:"Tiket Hemat 30%",discount:"30%",minTx:400000,validUntil:"2026-08-15",status:"active",imageUrl:"https://images.unsplash.com/photo-1555899434-94d1368aa7af?w=400",desc:"Diskon tiket pesawat semua rute"},
  {id:"p-005",code:"WEEKEND20",title:"Promo Weekend",discount:"20%",minTx:300000,validUntil:"2026-09-30",status:"active",imageUrl:"https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?w=400",desc:"Booking Sabtu-Minggu lebih hemat"},
  {id:"p-006",code:"SURABAYA15",title:"Explore Surabaya",discount:"15%",minTx:500000,validUntil:"2026-10-31",status:"active",imageUrl:"https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=400",desc:"Khusus properti di Surabaya"},
];

// CRUD 5: Users
let userDB=[
  {id:"u-001",name:"Admin StayGo",email:"admin@staygo.id",phone:"+628111111111",role:"admin",city:"Surabaya",totalBookings:0,status:"active",password:"admin123"},
  {id:"u-002",name:"Budi Santoso",email:"user@staygo.id",phone:"+628222222222",role:"user",city:"Surabaya",totalBookings:2,status:"active",password:"user123"},
  {id:"u-003",name:"Jessica Gabriel",email:"jessica@mail.com",phone:"+628333333333",role:"user",city:"Surabaya",totalBookings:1,status:"active",password:"jess123"},
];

// ═══════════════════ AUTH SYSTEM (Middleware Role) ═══════════════════
let currentUser = null;

function doLogin(){
  const email=document.getElementById('login-email').value.trim();
  const pass=document.getElementById('login-pass').value;
  const u=userDB.find(u=>u.email===email&&u.password===pass);
  if(!u){showToast('Email atau password salah!');return}
  currentUser=u;
  document.getElementById('authModal')?.classList.remove('active');
  updateNavForUser();
  showToast(`Selamat datang, ${u.name.split(' ')[0]}! 🎉`);
}

function doRegister(){
  const name=document.getElementById('reg-name').value.trim();
  const email=document.getElementById('reg-email').value.trim();
  const phone=document.getElementById('reg-phone').value.trim();
  const pass=document.getElementById('reg-pass').value;
  if(!name||!email||!pass){showToast('Isi semua field!');return}
  if(userDB.find(u=>u.email===email)){showToast('Email sudah terdaftar!');return}
  const newUser={id:'u-'+Date.now(),name,email,phone,role:'user',city:'',totalBookings:0,status:'active',password:pass};
  userDB.push(newUser);
  currentUser=newUser;
  document.getElementById('authModal')?.classList.remove('active');
  updateNavForUser();
  showToast(`Akun berhasil dibuat! Selamat datang, ${name.split(' ')[0]}! 🎊`);
}

function logout(){
  currentUser=null;
  updateNavForUser();
  showToast('Berhasil logout. Sampai jumpa! 👋');
  // tetap di page saat ini
}

function updateNavForUser(){
  const actions=document.getElementById('navActions');
  const adminLink=document.getElementById('nl-admin');
  const pesananContent=document.getElementById('pesananContent');
  const pesananGuest=document.getElementById('pesananGuestMsg');
  if(!actions||!adminLink) return;

  if(currentUser){
    const initials=currentUser.name.split(' ').map(n=>n[0]).join('').substring(0,2).toUpperCase();
    const roleBadge=currentUser.role==='admin'?'<span class="role-badge admin">Admin</span>':'<span class="role-badge">User</span>';
    actions.innerHTML=`<div class="user-chip" tabindex="0">
      <div class="avatar">${initials}</div>
      ${currentUser.name.split(' ')[0]}
      ${roleBadge}
      <div class="user-dropdown">
        <a href="profil.php" onclick="return false;">👤 Profil Saya</a>
        <a href="pesanan.php" onclick="return false;">📋 Pesanan Saya</a>
        ${currentUser.role==='admin'?'<a href="admin.php" onclick="return false;" style="color:var(--gold)">⚙ Admin Panel</a>':''}
        <a href="#" onclick="logout(); return false;" style="color:var(--red)">🚪 Logout</a>
      </div>
    </div>`;

    if(currentUser.role==='admin') adminLink.classList.remove('hidden');
    else adminLink.classList.add('hidden');

    if(pesananContent) pesananContent.classList.remove('hidden');
    if(pesananGuest) pesananGuest.classList.add('hidden');

  } else {
    actions.innerHTML=`<button class="btn-ghost" onclick="openAuthModal('login')">Masuk</button><button class="btn-solid" onclick="openAuthModal('register')">Daftar</button>`;
    adminLink.classList.add('hidden');
    if(pesananContent) pesananContent.classList.add('hidden');
    if(pesananGuest) pesananGuest.classList.remove('hidden');
  }
}

function requireLoginThen(fn){
  if(!currentUser){openAuthModal('login');showToast('Silakan login terlebih dahulu');return}
  fn();
}

function openAuthModal(tab){
  document.getElementById('authModal')?.classList.add('active');
  switchAuthTab(tab);
}

function switchAuthTab(tab){
  const atLogin=document.getElementById('at-login');
  const atReg=document.getElementById('at-register');
  const afLogin=document.getElementById('af-login');
  const afReg=document.getElementById('af-register');
  if(atLogin) atLogin.classList.toggle('active',tab==='login');
  if(atReg) atReg.classList.toggle('active',tab==='register');
  if(afLogin) afLogin.classList.toggle('active',tab==='login');
  if(afReg) afReg.classList.toggle('active',tab==='register');
}

function fillDemo(email,pass){
  document.getElementById('login-email').value=email;
  document.getElementById('login-pass').value=pass;
  switchAuthTab('login');
  showToast('Akun demo diisi! Klik Masuk');
}

// ═══════════════════ UTIL & FORMAT ═══════════════════
const fmt=n=>new Intl.NumberFormat('id-ID',{style:'currency',currency:'IDR',minimumFractionDigits:0,maximumFractionDigits:0}).format(n);

function showToast(msg){
  const t=document.getElementById('toast');
  if(!t) return;
  t.innerText=msg;
  t.classList.add('show');
  setTimeout(()=>t.classList.remove('show'),2800);
}

// ═══════════════════ RENDER (Props / Promos / Flights / Pesanan) ═══════════════════

function renderProps(filter){
  const grid=document.getElementById('propGrid');
  if(!grid) return;
  let data=propertyDB;
  if(filter&&filter!=='semua') data=propertyDB.filter(p=>p.category===filter||p.city.toLowerCase()===filter.toLowerCase());
  grid.innerHTML=data.map(p=>`
    <div class="prop-card" onclick="openPropModal('${p.id}')">
      <img class="prop-card-img" src="${p.imageUrl}" alt="${p.name}" loading="lazy">
      <div class="prop-card-body">
        <div class="prop-card-tag">${p.type}</div>
        <div class="prop-card-name">${p.name}</div>
        <div class="prop-card-loc"><svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>${p.city}</div>
        <div class="prop-card-fac">${p.facilities.map(f=>`<span>${f}</span>`).join('')}</div>
        <div class="prop-card-footer">
          <div class="prop-card-price">${fmt(p.pricePerNight)}<span>/malam</span></div>
          <div class="prop-card-rating"><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>${p.rating}</div>
        </div>
      </div>
    </div>`).join('');
}

function renderPromos(){
  const mini=document.getElementById('promoGrid');
  const full=document.getElementById('promoGridFull');
  const html=promoDB.filter(p=>p.status==='active').map(p=>`
    <div class="promo-card" onclick="copyPromo('${p.code}')">
      <img src="${p.imageUrl}" alt="${p.title}" loading="lazy">
      <div class="promo-overlay">
        <div class="promo-badge">${p.discount} OFF</div>
        <div class="promo-title">${p.title}</div>
        <div class="promo-code">Kode: <strong>${p.code}</strong> · Min. ${fmt(p.minTx)}</div>
      </div>
    </div>`).join('');
  if(mini) mini.innerHTML=html;
  if(full) full.innerHTML=html;
}

function renderFlights(){
  const wrap=document.getElementById('flightResults');
  if(!wrap) return;
  wrap.innerHTML=flightDB.map(f=>`
    <div class="flight-card" onclick="openFlightModal('${f.id}')">
      <div class="airline-logo"><span style="font-size:11px;letter-spacing:.5px">${f.logo}</span></div>
      <div class="flight-times">
        <div class="flight-time-block"><div class="flight-time">${f.depart}</div><div class="flight-airport">${f.from} (${f.fromCode})</div></div>
        <div class="flight-line"><div class="flight-duration">${f.duration}</div><div class="flight-track"><div class="flight-track-plane">✈</div></div><div style="font-size:10px;color:var(--green);font-weight:600">${f.stops}</div></div>
        <div class="flight-time-block"><div class="flight-time">${f.arrive}</div><div class="flight-airport">${f.to} (${f.toCode})</div></div>
      </div>
      <div style="flex:1;min-width:120px"><div class="flight-airline">${f.airline}</div><div style="font-size:11px;color:var(--muted)">${f.code} · ${f.class}</div></div>
      <div class="flight-price"><div class="flight-price-note">/ orang</div><div class="flight-price-val">${fmt(f.price)}</div><button class="flight-book-btn" onclick="event.stopPropagation();openFlightModal('${f.id}')">Pilih →</button></div>
    </div>`).join('');
}

let currentProp=null, currentFlight=null;

function openPropModal(id){
  const p=propertyDB.find(x=>x.id===id);
  if(!p) return;
  currentProp=p;
  document.getElementById('modalImg').src=p.imageUrl;
  document.getElementById('modalTag').textContent=p.type;
  document.getElementById('modalTitle').textContent=p.name;
  document.getElementById('modalLoc').textContent=p.locationDetail;
  document.getElementById('modalFac').innerHTML=p.facilities.map(f=>`<span>${f}</span>`).join('');
  document.getElementById('modalDesc').textContent=p.desc||'';
  document.getElementById('modalPrice').textContent=fmt(p.pricePerNight)+'/malam';
  document.getElementById('propModal')?.classList.add('active');
}

function closePropModal(e){
  const modal=document.getElementById('propModal');
  if(modal && e.target===modal) modal.classList.remove('active');
}

function confirmBooking(){
  if(!currentUser){openAuthModal('login');showToast('Login dulu untuk memesan');return}
  const name=document.getElementById('bk-name').value.trim();
  const cin=document.getElementById('bk-cin').value;
  const cout=document.getElementById('bk-cout').value;
  if(!name||!cin||!cout){showToast('Lengkapi semua field!');return}
  const nights=Math.max(1,Math.round((new Date(cout)-new Date(cin))/(1000*60*60*24)));
  const total=currentProp.pricePerNight*nights;
  const booking={id:'B-'+Date.now(),guest:name,type:'accom',product:currentProp.name,checkin:cin,checkout:cout,total,status:'confirmed',paymentMethod:document.getElementById('bk-pay').value,bookedAt:new Date().toISOString(),imageUrl:currentProp.imageUrl,villaName:currentProp.name};
  bookingDB.unshift(booking);
  document.getElementById('bookModal')?.classList.remove('active');
  renderPesanan('all');
  showToast(`Booking ${currentProp.name} berhasil! ✅`);
}

function openFlightModal(id){
  const f=flightDB.find(x=>x.id===id);
  if(!f) return;
  currentFlight=f;
  document.getElementById('fModalDetail').innerHTML=`
    <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap">
      <div class="airline-logo"><span>${f.logo}</span></div>
      <div style="flex:1">
        <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap">
          <div><div style="font-family:'Cormorant Garamond',serif;font-size:22px;font-weight:700">${f.depart}</div><div style="font-size:11px;color:var(--muted)">${f.from} (${f.fromCode})</div></div>
          <div style="flex:1;text-align:center"><div style="font-size:11px;color:var(--muted)">${f.duration}</div><div style="font-size:18px">→</div><div style="font-size:10px;color:var(--green);font-weight:600">${f.stops}</div></div>
          <div><div style="font-family:'Cormorant Garamond',serif;font-size:22px;font-weight:700">${f.arrive}</div><div style="font-size:11px;color:var(--muted)">${f.to} (${f.toCode})</div></div>
        </div>
      </div>
      <div style="text-align:right"><div style="font-size:13px;font-weight:700">${f.airline}</div><div style="font-size:11px;color:var(--muted)">${f.code} · ${f.class}</div></div>
    </div>`;

  document.getElementById('fModalSummary').innerHTML=`
    <div style="font-size:13px;font-weight:700;color:var(--ink);margin-bottom:12px">Ringkasan Harga</div>
    <div class="order-row"><span>Harga tiket</span><span>${fmt(f.price)}</span></div>
    <div class="order-row"><span>Pajak & Biaya</span><span>${fmt(Math.round(f.price*.1))}</span></div>
    <div class="order-row"><span>Total Pembayaran</span><span style="color:var(--sky)">${fmt(Math.round(f.price*1.1))}</span></div>`;

  if(currentUser){
    document.getElementById('fp-name').value=currentUser.name;
    document.getElementById('fp-email').value=currentUser.email;
  }

  document.getElementById('flightModal')?.classList.add('active');
}

function confirmFlightBooking(){
  if(!currentUser){openAuthModal('login');showToast('Login dulu untuk memesan');return}
  const name=document.getElementById('fp-name').value.trim();
  if(!name){showToast('Isi nama lengkap terlebih dahulu');return}
  const booking={id:'B-'+Date.now(),guest:name,type:'flight',product:currentFlight.airline+' '+currentFlight.code,airline:currentFlight.airline,flightCode:currentFlight.code,from:currentFlight.from+' ('+currentFlight.fromCode+')',to:currentFlight.to+' ('+currentFlight.toCode+')',depart:currentFlight.depart,date:'2026-07-20',passenger:'1 Dewasa',total:Math.round(currentFlight.price*1.1),status:'confirmed',paymentMethod:document.getElementById('fp-pay').value,bookedAt:new Date().toISOString()};
  bookingDB.unshift(booking);
  document.getElementById('flightModal')?.classList.remove('active');
  renderPesanan('all');
  showToast(`Tiket ${currentFlight.airline} berhasil dipesan! ✈`);
}

function renderPesanan(filter){
  const wrap=document.getElementById('pesananList');
  if(!wrap||!currentUser) return;
  let list=bookingDB.filter(b=>b.guest===currentUser.name);
  if(filter!=='all') list=list.filter(b=>b.type===(filter==='flight'?'flight':'accom'));
  if(list.length===0){
    wrap.innerHTML=`<div style="text-align:center;padding:60px;color:var(--muted);font-size:15px">Belum ada pesanan</div>`;
    return;
  }

  wrap.innerHTML=list.map(b=>`
    <div class="pesanan-card">
      ${b.type==='accom'?`<img class="pesanan-img" src="${b.imageUrl||''}" alt=">`:
        `<div class="airline-logo" style="flex-shrink:0;width:60px;height:50px;border-radius:10px"><span>${(b.airline||'').substring(0,2).toUpperCase()}</span></div>`}
      <div class="pesanan-info">
        <div class="pesanan-name">${b.type==='accom'?b.villaName:b.airline+' · '+b.flightCode}</div>
        <div class="pesanan-detail">${b.type==='accom'?`📅 ${b.checkin} → ${b.checkout}`:`✈ ${b.from} → ${b.to} · ${b.depart} · ${b.date}`}</div>
        <div class="pesanan-detail">💳 ${b.paymentMethod}</div>
        <div class="pesanan-detail" style="margin-top:4px">Dipesan: ${new Date(b.bookedAt).toLocaleDateString('id-ID',{day:'numeric',month:'long',year:'numeric'})}</div>
        <span class="pesanan-badge ${b.status}">${b.status==='confirmed'?'✓ Terkonfirmasi':b.status==='pending'?'⏳ Menunggu':'✕ Dibatalkan'}</span>
      </div>
      <div class="pesanan-price">${fmt(b.total)}</div>
    </div>`).join('');
}

function searchFlights(){
  const from=document.getElementById('fi-from')?.value || '';
  const to=document.getElementById('fi-to')?.value || '';
  const title=document.getElementById('flightResultTitle');
  const sub=document.getElementById('flightResultSub');
  if(title) title.innerText=`${from.split('(')[0].trim()} → ${to.split('(')[0].trim()}`;
  if(sub) sub.innerText=`${flightDB.length} penerbangan tersedia`;
  showToast('Menampilkan semua penerbangan tersedia ✈');
  renderFlights();
}

function switchSearchTab(tab){
  const stStay=document.getElementById('st-stay');
  const stFlight=document.getElementById('st-flight');
  if(stStay) stStay.classList.toggle('active',tab==='stay');
  if(stFlight) stFlight.classList.toggle('active',tab==='flight');
  const swStay=document.getElementById('sw-stay');
  const swFlight=document.getElementById('sw-flight');
  if(swStay) swStay.style.display=tab==='stay'?'flex':'none';
  if(swFlight) swFlight.style.display=tab==='flight'?'flex':'none';
}

function toggleFlightType(t){
  const ftSekali=document.getElementById('ft-sekali');
  const ftPP=document.getElementById('ft-pp');
  if(ftSekali) ftSekali.classList.toggle('active',t==='sekali');
  if(ftPP) ftPP.classList.toggle('active',t==='pp');
  const returnDateField=document.getElementById('returnDateField');
  if(returnDateField) returnDateField.style.display=t==='pp'?'block':'none';
}

function swapAirports(){
  const a=document.getElementById('fi-from');
  const b=document.getElementById('fi-to');
  if(!a||!b) return;
  [a.value,b.value]=[b.value,a.value];
  showToast('Rute ditukar! 🔄');
}

function scrollToProps(){
  const el=document.getElementById('propSection');
  el?.scrollIntoView({behavior:'smooth'});
}

function copyPromo(code){
  navigator.clipboard?.writeText(code).catch(()=>{});
  showToast(`Kode ${code} disalin! 🎁`);
}

// Filter chips (beranda)
document.addEventListener('click',e=>{
  const target=e.target.closest?.('#filterChips .chip');
  if(!target) return;
  document.querySelectorAll('#filterChips .chip').forEach(x=>x.classList.remove('active'));
  target.classList.add('active');
  renderProps(target.dataset.filter);
});

// Modal booking buttons: delegasi aman
if(typeof document !== 'undefined'){
  document.addEventListener('click',e=>{
    if(e.target && e.target.id==='modalBookBtn'){
      e.preventDefault();
      confirmBooking();
    }
    if(e.target && e.target.id==='login-register-proxy'){
      e.preventDefault();
    }
  });
}

// Image fallback
window.addEventListener('error',function(e){
  const el=e.target;
  if(el && el.tagName==='IMG' && !el.dataset.fb){
    el.dataset.fb='1';
    el.src='data:image/svg+xml;charset=UTF-8,'+encodeURIComponent('<svg xmlns="http://www.w3.org/2000/svg" width="400" height="300" viewBox="0 0 400 300"><rect width="400" height="300" fill="#f3f7ff"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-family="sans-serif" font-size="16" fill="#6b88a8">Gambar tidak tersedia</text></svg>');
  }
},true);
</script>


