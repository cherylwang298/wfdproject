<?php
/**
 * data.php — shared in-memory database + session auth + helpers
 * Di-include oleh semua halaman. Semua CRUD disimpan di $_SESSION.
 *
 * 3 ROLE : admin | user | guest (tidak login)
 * 5 CRUD  : properti, penerbangan, pemesanan, promo, pengguna
 */

session_start();

/* ═══════════════════════════════════════════════════════════
   SEED — isi data awal ke session jika belum ada
   ═══════════════════════════════════════════════════════════ */
if (empty($_SESSION['seeded'])) {

    $_SESSION['users'] = [
        ['id'=>'u-001','name'=>'Admin StayGo','email'=>'admin@staygo.id',
         'phone'=>'+628111111111','role'=>'admin','city'=>'Surabaya',
         'status'=>'active','password'=>password_hash('admin123',PASSWORD_DEFAULT)],
        ['id'=>'u-002','name'=>'Budi Santoso','email'=>'user@staygo.id',
         'phone'=>'+628222222222','role'=>'user','city'=>'Surabaya',
         'status'=>'active','password'=>password_hash('user123',PASSWORD_DEFAULT)],
        ['id'=>'u-003','name'=>'Jessica Gabriel','email'=>'jessica@mail.com',
         'phone'=>'+628333333333','role'=>'user','city'=>'Surabaya',
         'status'=>'active','password'=>password_hash('jess123',PASSWORD_DEFAULT)],
        ['id'=>'u-004','name'=>'Manajer Properti','email'=>'manager@staygo.id',
         'phone'=>'+628444444444','role'=>'manager','city'=>'Bali',
         'status'=>'active','password'=>password_hash('manager123',PASSWORD_DEFAULT)],
    ];

    $_SESSION['properties'] = [
        ['id'=>'v-001','name'=>'Sky View Private Villa','type'=>'Villa & Balcony',
         'category'=>'villa','city'=>'Batu','location_detail'=>'Oro-Oro Ombo, Batu',
         'price'=>850000,'rating'=>4.8,'facilities'=>'Pool,Balcony,Wifi',
         'img'=>'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?w=600',
         'status'=>'active','desc'=>'Villa premium dengan pemandangan kota Batu yang spektakuler.'],
        ['id'=>'v-002','name'=>'Green Pine Family Homestay','type'=>'Villa Rumah',
         'category'=>'villa','city'=>'Batu','location_detail'=>'Songgokerto, Batu',
         'price'=>620000,'rating'=>4.6,'facilities'=>'Family Room,Garden,Wifi',
         'img'=>'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=600',
         'status'=>'active','desc'=>'Homestay keluarga yang nyaman di lereng Gunung Arjuno.'],
        ['id'=>'v-003','name'=>'Canggu Bliss Luxury Villa','type'=>'Private Pool Villa',
         'category'=>'villa','city'=>'Bali','location_detail'=>'Canggu, Bali',
         'price'=>1850000,'rating'=>4.9,'facilities'=>'Pool,Balcony,Wifi,AC',
         'img'=>'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=600',
         'status'=>'active','desc'=>'Villa mewah di jantung Canggu dengan kolam renang infinity.'],
        ['id'=>'v-004','name'=>'Ubud Rainforest Retreat','type'=>'Resort Villa',
         'category'=>'villa','city'=>'Bali','location_detail'=>'Sayan, Ubud, Bali',
         'price'=>2100000,'rating'=>4.9,'facilities'=>'Pool,Garden,Wifi,Spa',
         'img'=>'https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=600',
         'status'=>'active','desc'=>'Retreat tersembunyi di tengah hutan hujan Ubud.'],
        ['id'=>'v-005','name'=>'Seminyak Sun & Surf Villa','type'=>'Private Pool Villa',
         'category'=>'villa','city'=>'Bali','location_detail'=>'Seminyak, Kuta, Bali',
         'price'=>1650000,'rating'=>4.7,'facilities'=>'Pool,Balcony,Wifi',
         'img'=>'https://images.unsplash.com/photo-1512915922686-57c11dde9b6b?w=600',
         'status'=>'active','desc'=>'Villa pantai dekat Seminyak beach.'],
        ['id'=>'h-001','name'=>'The Grand Palace Hotel','type'=>'Luxury Hotel',
         'category'=>'hotel','city'=>'Surabaya','location_detail'=>'Genteng, Surabaya Pusat',
         'price'=>1200000,'rating'=>4.8,'facilities'=>'Pool,Gym,Breakfast,Spa',
         'img'=>'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600',
         'status'=>'active','desc'=>'Hotel bintang 5 di pusat kota Surabaya.'],
        ['id'=>'h-002','name'=>'Neo Horizon Business Hotel','type'=>'Business Hotel',
         'category'=>'hotel','city'=>'Surabaya','location_detail'=>'Gubeng, Surabaya',
         'price'=>650000,'rating'=>4.5,'facilities'=>'Meeting Room,Breakfast,Wifi',
         'img'=>'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=600',
         'status'=>'active','desc'=>'Hotel bisnis modern dengan fasilitas meeting room.'],
        ['id'=>'h-003','name'=>'Batu Heritage Resort','type'=>'Boutique Hotel',
         'category'=>'hotel','city'=>'Batu','location_detail'=>'Sisir, Kota Batu',
         'price'=>890000,'rating'=>4.6,'facilities'=>'Pool,Garden,Breakfast',
         'img'=>'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=600',
         'status'=>'active','desc'=>'Boutique hotel dengan arsitektur heritage Belanda.'],
        ['id'=>'a-001','name'=>'Ciputra World Residence','type'=>'Service Apartment',
         'category'=>'apartment','city'=>'Surabaya','location_detail'=>'Ciputra World, Surabaya',
         'price'=>750000,'rating'=>4.5,'facilities'=>'Pool,Gym,Wifi',
         'img'=>'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=600',
         'status'=>'active','desc'=>'Apartemen service premium di kawasan Ciputra World.'],
    ];

    $_SESSION['flights'] = [
        ['id'=>'f-001','airline'=>'Garuda Indonesia','logo'=>'GA','code'=>'GA-401',
         'from'=>'Surabaya','from_code'=>'SUB','to'=>'Bali','to_code'=>'DPS',
         'depart'=>'06:00','arrive'=>'07:10','duration'=>'1j 10m','stops'=>'Langsung',
         'price'=>850000,'class'=>'Ekonomi','status'=>'active'],
        ['id'=>'f-002','airline'=>'Lion Air','logo'=>'JT','code'=>'JT-712',
         'from'=>'Surabaya','from_code'=>'SUB','to'=>'Bali','to_code'=>'DPS',
         'depart'=>'08:30','arrive'=>'09:40','duration'=>'1j 10m','stops'=>'Langsung',
         'price'=>450000,'class'=>'Ekonomi','status'=>'active'],
        ['id'=>'f-003','airline'=>'Citilink','logo'=>'QG','code'=>'QG-156',
         'from'=>'Surabaya','from_code'=>'SUB','to'=>'Jakarta','to_code'=>'CGK',
         'depart'=>'10:00','arrive'=>'11:30','duration'=>'1j 30m','stops'=>'Langsung',
         'price'=>380000,'class'=>'Ekonomi','status'=>'active'],
        ['id'=>'f-004','airline'=>'Batik Air','logo'=>'ID','code'=>'ID-7204',
         'from'=>'Surabaya','from_code'=>'SUB','to'=>'Jakarta','to_code'=>'CGK',
         'depart'=>'13:15','arrive'=>'14:45','duration'=>'1j 30m','stops'=>'Langsung',
         'price'=>520000,'class'=>'Ekonomi','status'=>'active'],
        ['id'=>'f-005','airline'=>'Garuda Indonesia','logo'=>'GA','code'=>'GA-700',
         'from'=>'Surabaya','from_code'=>'SUB','to'=>'Bali','to_code'=>'DPS',
         'depart'=>'15:30','arrive'=>'16:40','duration'=>'1j 10m','stops'=>'Langsung',
         'price'=>920000,'class'=>'Bisnis','status'=>'active'],
        ['id'=>'f-006','airline'=>'Super Air Jet','logo'=>'IU','code'=>'IU-301',
         'from'=>'Surabaya','from_code'=>'SUB','to'=>'Lombok','to_code'=>'LOP',
         'depart'=>'07:00','arrive'=>'08:15','duration'=>'1j 15m','stops'=>'Langsung',
         'price'=>320000,'class'=>'Ekonomi','status'=>'active'],
        ['id'=>'f-007','airline'=>'AirAsia','logo'=>'QZ','code'=>'QZ-7956',
         'from'=>'Surabaya','from_code'=>'SUB','to'=>'Jogja','to_code'=>'JOG',
         'depart'=>'17:45','arrive'=>'18:30','duration'=>'45m','stops'=>'Langsung',
         'price'=>290000,'class'=>'Ekonomi','status'=>'active'],
        ['id'=>'f-008','airline'=>'Garuda Indonesia','logo'=>'GA','code'=>'GA-370',
         'from'=>'Surabaya','from_code'=>'SUB','to'=>'Makassar','to_code'=>'UPG',
         'depart'=>'09:00','arrive'=>'10:50','duration'=>'1j 50m','stops'=>'Langsung',
         'price'=>610000,'class'=>'Ekonomi','status'=>'active'],
    ];

    $_SESSION['bookings'] = [
        ['id'=>'B-001','user_id'=>'u-003','guest'=>'Jessica Gabriel','type'=>'accom',
         'product'=>'Canggu Bliss Luxury Villa','prop_id'=>'v-003',
         'checkin'=>'2026-06-10','checkout'=>'2026-06-13','total'=>5550000,
         'status'=>'confirmed','payment'=>'Credit Card','booked_at'=>'2026-06-01 10:30:00',
         'img'=>'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=500'],
        ['id'=>'B-002','user_id'=>'u-002','guest'=>'Budi Santoso','type'=>'flight',
         'product'=>'Garuda Indonesia GA-401','flight_id'=>'f-001',
         'airline'=>'Garuda Indonesia','flight_code'=>'GA-401',
         'from'=>'Surabaya (SUB)','to'=>'Bali (DPS)','depart'=>'06:00',
         'date'=>'2026-07-20','passenger'=>'2 Dewasa','total'=>1870000,
         'status'=>'confirmed','payment'=>'Bank Transfer','booked_at'=>'2026-06-15 14:00:00'],
        ['id'=>'B-003','user_id'=>'u-002','guest'=>'Budi Santoso','type'=>'accom',
         'product'=>'The Grand Palace Hotel','prop_id'=>'h-001',
         'checkin'=>'2026-06-20','checkout'=>'2026-06-22','total'=>2400000,
         'status'=>'pending','payment'=>'E-Wallet','booked_at'=>'2026-06-18 09:00:00',
         'img'=>'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=500'],
    ];

    $_SESSION['promos'] = [
        ['id'=>'p-001','code'=>'BALI40','title'=>'Diskon Bali 40%','discount'=>'40%',
         'min_tx'=>1000000,'valid_until'=>'2026-07-31','status'=>'active',
         'img'=>'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=400',
         'desc'=>'Hemat 40% untuk semua properti di Bali'],
        ['id'=>'p-002','code'=>'FLASH50','title'=>'Flash Sale 50%','discount'=>'50%',
         'min_tx'=>500000,'valid_until'=>'2026-06-30','status'=>'active',
         'img'=>'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400',
         'desc'=>'Flash sale khusus akhir Juni'],
        ['id'=>'p-003','code'=>'NEWUSER','title'=>'Pengguna Baru','discount'=>'25%',
         'min_tx'=>200000,'valid_until'=>'2026-12-31','status'=>'active',
         'img'=>'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=400',
         'desc'=>'Diskon 25% untuk pemesanan pertama'],
        ['id'=>'p-004','code'=>'TERBANG30','title'=>'Tiket Hemat 30%','discount'=>'30%',
         'min_tx'=>400000,'valid_until'=>'2026-08-15','status'=>'active',
         'img'=>'https://images.unsplash.com/photo-1555899434-94d1368aa7af?w=400',
         'desc'=>'Diskon tiket pesawat semua rute'],
        ['id'=>'p-005','code'=>'WEEKEND20','title'=>'Promo Weekend','discount'=>'20%',
         'min_tx'=>300000,'valid_until'=>'2026-09-30','status'=>'active',
         'img'=>'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?w=400',
         'desc'=>'Booking Sabtu-Minggu lebih hemat'],
        ['id'=>'p-006','code'=>'SURABAYA15','title'=>'Explore Surabaya','discount'=>'15%',
         'min_tx'=>500000,'valid_until'=>'2026-10-31','status'=>'active',
         'img'=>'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=400',
         'desc'=>'Khusus properti di Surabaya'],
    ];

    $_SESSION['reviews'] = [
        ['id'=>'r-001','user_id'=>'u-003','prop_id'=>'v-003','rating'=>5,
         'comment'=>'Villa di Canggu luar biasa! Kolam renang private, view sawah, staff ramah.',
         'created_at'=>'2026-06-14 10:00:00'],
        ['id'=>'r-002','user_id'=>'u-002','prop_id'=>'h-001','rating'=>5,
         'comment'=>'Hotel bintang 5 yang benar-benar worth it. Sarapan enak, kamar luas.',
         'created_at'=>'2026-06-23 08:00:00'],
    ];

    $_SESSION['seeded'] = true;
}

/* ═══════════════════════════════════════════════════════════
   AUTH HELPERS
   ═══════════════════════════════════════════════════════════ */

/** User yang sedang login (array) atau null */
function currentUser(): ?array {
    return $_SESSION['auth_user'] ?? null;
}

/** Cek apakah user sudah login */
function isLoggedIn(): bool {
    return isset($_SESSION['auth_user']);
}

/** Cek role. Param bisa string atau array. */
function hasRole(string|array $roles): bool {
    $u = currentUser();
    if (!$u) return false;
    $allowed = is_array($roles) ? $roles : [$roles];
    return in_array($u['role'], $allowed, true);
}

/**
 * Middleware guard — redirect ke login.php jika tidak memenuhi role.
 * Contoh: requireRole(['admin','manager'])
 */
function requireRole(string|array $roles): void {
    if (!hasRole($roles)) {
        $back = urlencode($_SERVER['REQUEST_URI']);
        header("Location: login.php?redirect=$back&err=unauthorized");
        exit;
    }
}

/** Redirect ke login jika belum login sama sekali */
function requireLogin(): void {
    if (!isLoggedIn()) {
        $back = urlencode($_SERVER['REQUEST_URI']);
        header("Location: login.php?redirect=$back");
        exit;
    }
}

/* ═══════════════════════════════════════════════════════════
   CRUD HELPERS
   ═══════════════════════════════════════════════════════════ */

function &getDB(string $key): array {
    if (!isset($_SESSION[$key])) $_SESSION[$key] = [];
    return $_SESSION[$key];
}

function dbFind(string $key, string $id): ?array {
    foreach ($_SESSION[$key] as $row) {
        if ($row['id'] === $id) return $row;
    }
    return null;
}

function dbInsert(string $key, array $row): void {
    $_SESSION[$key][] = $row;
}

function dbUpdate(string $key, string $id, array $data): bool {
    foreach ($_SESSION[$key] as &$row) {
        if ($row['id'] === $id) { $row = array_merge($row, $data); return true; }
    }
    return false;
}

function dbDelete(string $key, string $id): bool {
    $orig = count($_SESSION[$key]);
    $_SESSION[$key] = array_values(array_filter($_SESSION[$key], fn($r) => $r['id'] !== $id));
    return count($_SESSION[$key]) < $orig;
}

/* ═══════════════════════════════════════════════════════════
   UTILITY
   ═══════════════════════════════════════════════════════════ */

function rupiah(int $n): string {
    return 'Rp ' . number_format($n, 0, ',', '.');
}

function genId(string $prefix): string {
    return $prefix . '-' . substr(uniqid(), -6);
}

function h(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

function flash(string $msg, string $type = 'success'): void {
    $_SESSION['flash'] = ['msg' => $msg, 'type' => $type];
}

function getFlash(): ?array {
    $f = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $f;
}

/* ═══════════════════════════════════════════════════════════
   API HANDLER — proses POST request CRUD dari semua halaman
   ═══════════════════════════════════════════════════════════ */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_action'])) {
    $action = $_POST['_action'];
    $redirect = $_POST['_redirect'] ?? ($_SERVER['HTTP_REFERER'] ?? 'index.php');

    /* ── AUTH ── */
    if ($action === 'login') {
        $email = trim($_POST['email'] ?? '');
        $pass  = $_POST['password'] ?? '';
        $found = null;
        foreach ($_SESSION['users'] as $u) {
            if ($u['email'] === $email && password_verify($pass, $u['password'])) {
                $found = $u; break;
            }
        }
        if ($found) {
            $_SESSION['auth_user'] = $found;
            flash("Selamat datang, {$found['name']}! 🎉");
            $dest = urldecode($_POST['redirect'] ?? 'index.php');
            header("Location: $dest"); exit;
        } else {
            flash('Email atau password salah!', 'error');
            header("Location: login.php?err=invalid"); exit;
        }
    }

    if ($action === 'register') {
        $name  = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $pass  = $_POST['password'] ?? '';
        $conf  = $_POST['confirm'] ?? '';
        if (!$name || !$email || !$pass) { flash('Isi semua field!','error'); header("Location: login.php?tab=register"); exit; }
        if ($pass !== $conf)             { flash('Konfirmasi password tidak cocok!','error'); header("Location: login.php?tab=register"); exit; }
        if (strlen($pass) < 6)          { flash('Password minimal 6 karakter!','error'); header("Location: login.php?tab=register"); exit; }
        foreach ($_SESSION['users'] as $u) {
            if ($u['email'] === $email) { flash('Email sudah terdaftar!','error'); header("Location: login.php?tab=register"); exit; }
        }
        $newUser = ['id'=>genId('u'),'name'=>$name,'email'=>$email,'phone'=>$phone,
                    'role'=>'user','city'=>'','status'=>'active',
                    'password'=>password_hash($pass,PASSWORD_DEFAULT)];
        dbInsert('users', $newUser);
        $_SESSION['auth_user'] = $newUser;
        flash("Akun berhasil dibuat! Selamat datang, $name 🎊");
        header("Location: index.php"); exit;
    }

    if ($action === 'logout') {
        unset($_SESSION['auth_user']);
        flash('Berhasil logout. Sampai jumpa! 👋');
        header("Location: index.php"); exit;
    }

    if ($action === 'update_profile') {
        requireLogin();
        $uid = currentUser()['id'];
        $data = ['name'=>trim($_POST['name']??''), 'phone'=>trim($_POST['phone']??''), 'city'=>trim($_POST['city']??'')];
        dbUpdate('users', $uid, $data);
        $_SESSION['auth_user'] = array_merge($_SESSION['auth_user'], $data);
        flash('Profil berhasil diperbarui! ✅');
        header("Location: profil.php"); exit;
    }

    /* ── CRUD PROPERTI ── */
    if ($action === 'save_property') {
        requireRole(['admin','manager']);
        $id = trim($_POST['id'] ?? '');
        $data = [
            'name'            => h(trim($_POST['name']??'')),
            'type'            => h(trim($_POST['type']??'')),
            'category'        => $_POST['category'] ?? 'villa',
            'city'            => h(trim($_POST['city']??'')),
            'location_detail' => h(trim($_POST['location_detail']??'')),
            'price'           => (int)($_POST['price']??0),
            'rating'          => (float)($_POST['rating']??4.5),
            'facilities'      => h(trim($_POST['facilities']??'')),
            'img'             => trim($_POST['img']??''),
            'status'          => $_POST['status'] ?? 'active',
            'desc'            => h(trim($_POST['desc']??'')),
        ];
        if ($id && dbFind('properties',$id)) {
            dbUpdate('properties', $id, $data);
            flash('Properti berhasil diperbarui! ✅');
        } else {
            $data['id'] = genId('v');
            dbInsert('properties', $data);
            flash('Properti berhasil ditambahkan! ✅');
        }
        header("Location: admin.php?section=properties"); exit;
    }

    if ($action === 'delete_property') {
        requireRole(['admin','manager']);
        dbDelete('properties', $_POST['id']??'');
        flash('Properti dihapus.');
        header("Location: admin.php?section=properties"); exit;
    }

    /* ── CRUD PENERBANGAN ── */
    if ($action === 'save_flight') {
        requireRole(['admin','manager']);
        $id = trim($_POST['id'] ?? '');
        $al = trim($_POST['airline']??'');
        $data = [
            'airline'   => h($al),
            'logo'      => strtoupper(substr($al,0,2)),
            'code'      => h(trim($_POST['code']??'')),
            'from'      => h(trim($_POST['from']??'')),
            'from_code' => strtoupper(substr(trim($_POST['from_code']??''),0,3)),
            'to'        => h(trim($_POST['to']??'')),
            'to_code'   => strtoupper(substr(trim($_POST['to_code']??''),0,3)),
            'depart'    => h(trim($_POST['depart']??'')),
            'arrive'    => h(trim($_POST['arrive']??'')),
            'duration'  => h(trim($_POST['duration']??'')),
            'stops'     => 'Langsung',
            'price'     => (int)($_POST['price']??0),
            'class'     => $_POST['class'] ?? 'Ekonomi',
            'status'    => $_POST['status'] ?? 'active',
        ];
        if ($id && dbFind('flights',$id)) {
            dbUpdate('flights', $id, $data);
            flash('Penerbangan berhasil diperbarui! ✅');
        } else {
            $data['id'] = genId('f');
            dbInsert('flights', $data);
            flash('Penerbangan berhasil ditambahkan! ✅');
        }
        header("Location: admin.php?section=flights"); exit;
    }

    if ($action === 'delete_flight') {
        requireRole(['admin','manager']);
        dbDelete('flights', $_POST['id']??'');
        flash('Penerbangan dihapus.');
        header("Location: admin.php?section=flights"); exit;
    }

    /* ── CRUD PEMESANAN ── */
    if ($action === 'book_property') {
        requireLogin();
        $propId = $_POST['prop_id'] ?? '';
        $prop   = dbFind('properties', $propId);
        if (!$prop) { flash('Properti tidak ditemukan!','error'); header("Location: index.php"); exit; }
        $cin    = $_POST['checkin'] ?? '';
        $cout   = $_POST['checkout'] ?? '';
        $nights = max(1, (int)(( strtotime($cout) - strtotime($cin) ) / 86400));
        $total  = $prop['price'] * $nights;
        // apply promo
        $promoCode = strtoupper(trim($_POST['promo_code']??''));
        $discount  = 0;
        if ($promoCode) {
            foreach ($_SESSION['promos'] as $pr) {
                if ($pr['code'] === $promoCode && $pr['status']==='active' && $total >= $pr['min_tx']) {
                    $pct = (int)$pr['discount'];
                    $discount = (int)($total * $pct / 100);
                    break;
                }
            }
        }
        $u = currentUser();
        $booking = [
            'id'        => genId('B'),
            'user_id'   => $u['id'],
            'guest'     => $u['name'],
            'type'      => 'accom',
            'product'   => $prop['name'],
            'prop_id'   => $propId,
            'checkin'   => $cin,
            'checkout'  => $cout,
            'nights'    => $nights,
            'total'     => $total - $discount,
            'discount'  => $discount,
            'status'    => 'pending',
            'payment'   => h($_POST['payment']??'Transfer'),
            'booked_at' => date('Y-m-d H:i:s'),
            'img'       => $prop['img'],
        ];
        dbInsert('bookings', $booking);
        flash("Booking {$prop['name']} berhasil! Total: " . rupiah($booking['total']) . ' 🎉');
        header("Location: pesanan.php"); exit;
    }

    if ($action === 'book_flight') {
        requireLogin();
        $fid    = $_POST['flight_id'] ?? '';
        $fl     = dbFind('flights', $fid);
        if (!$fl) { flash('Penerbangan tidak ditemukan!','error'); header("Location: penerbangan.php"); exit; }
        $qty    = max(1,(int)($_POST['qty']??1));
        $tax    = (int)($fl['price'] * 0.1);
        $total  = ($fl['price'] + $tax) * $qty;
        $u = currentUser();
        $booking = [
            'id'          => genId('B'),
            'user_id'     => $u['id'],
            'guest'       => $u['name'],
            'type'        => 'flight',
            'product'     => "{$fl['airline']} {$fl['code']}",
            'flight_id'   => $fid,
            'airline'     => $fl['airline'],
            'flight_code' => $fl['code'],
            'from'        => "{$fl['from']} ({$fl['from_code']})",
            'to'          => "{$fl['to']} ({$fl['to_code']})",
            'depart'      => $fl['depart'],
            'date'        => $_POST['travel_date'] ?? date('Y-m-d'),
            'passenger'   => "$qty Dewasa",
            'total'       => $total,
            'status'      => 'pending',
            'payment'     => h($_POST['payment']??'Transfer'),
            'booked_at'   => date('Y-m-d H:i:s'),
        ];
        dbInsert('bookings', $booking);
        flash("Tiket {$fl['airline']} berhasil dipesan! ✈");
        header("Location: pesanan.php"); exit;
    }

    if ($action === 'cancel_booking') {
        requireLogin();
        $bid = $_POST['booking_id'] ?? '';
        $b   = dbFind('bookings', $bid);
        $u   = currentUser();
        // User hanya bisa cancel miliknya sendiri; admin bisa semua
        if ($b && ($b['user_id'] === $u['id'] || hasRole('admin'))) {
            dbUpdate('bookings', $bid, ['status'=>'cancelled']);
            flash('Pemesanan dibatalkan.');
        }
        header("Location: " . ($_POST['_redirect'] ?? 'pesanan.php')); exit;
    }

    if ($action === 'approve_booking') {
        requireRole(['admin','manager']);
        dbUpdate('bookings', $_POST['booking_id']??'', ['status'=>'confirmed']);
        flash('Pemesanan dikonfirmasi! ✅');
        header("Location: admin.php?section=bookings"); exit;
    }

    if ($action === 'delete_booking') {
        requireRole('admin');
        dbDelete('bookings', $_POST['id']??'');
        flash('Booking dihapus.');
        header("Location: admin.php?section=bookings"); exit;
    }

    /* ── CRUD PROMO ── */
    if ($action === 'save_promo') {
        requireRole('admin');
        $id = trim($_POST['id'] ?? '');
        $data = [
            'code'        => strtoupper(h(trim($_POST['code']??''))),
            'title'       => h(trim($_POST['title']??'')),
            'discount'    => h(trim($_POST['discount']??'')),
            'min_tx'      => (int)($_POST['min_tx']??0),
            'valid_until' => $_POST['valid_until'] ?? '',
            'status'      => $_POST['status'] ?? 'active',
            'desc'        => h(trim($_POST['desc']??'')),
            'img'         => trim($_POST['img']??'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=400'),
        ];
        if ($id && dbFind('promos',$id)) {
            dbUpdate('promos', $id, $data);
            flash('Promo diperbarui! ✅');
        } else {
            $data['id'] = genId('p');
            dbInsert('promos', $data);
            flash('Promo ditambahkan! ✅');
        }
        header("Location: admin.php?section=promos"); exit;
    }

    if ($action === 'delete_promo') {
        requireRole('admin');
        dbDelete('promos', $_POST['id']??'');
        flash('Promo dihapus.');
        header("Location: admin.php?section=promos"); exit;
    }

    /* ── CRUD PENGGUNA ── */
    if ($action === 'save_user') {
        requireRole('admin');
        $id = trim($_POST['id'] ?? '');
        $data = [
            'name'   => h(trim($_POST['name']??'')),
            'email'  => trim($_POST['email']??''),
            'phone'  => h(trim($_POST['phone']??'')),
            'role'   => $_POST['role'] ?? 'user',
            'city'   => h(trim($_POST['city']??'')),
            'status' => $_POST['status'] ?? 'active',
        ];
        if ($id && dbFind('users',$id)) {
            dbUpdate('users', $id, $data);
            flash('Pengguna diperbarui! ✅');
        } else {
            $pass = $_POST['password'] ?? 'user123';
            $data['id']       = genId('u');
            $data['password'] = password_hash($pass, PASSWORD_DEFAULT);
            dbInsert('users', $data);
            flash('Pengguna ditambahkan! ✅');
        }
        header("Location: admin.php?section=users"); exit;
    }

    if ($action === 'delete_user') {
        requireRole('admin');
        $del = $_POST['id'] ?? '';
        // Prevent deleting self
        if ($del !== (currentUser()['id'] ?? '')) {
            dbDelete('users', $del);
            flash('Pengguna dihapus.');
        } else {
            flash('Tidak bisa menghapus akun sendiri!','error');
        }
        header("Location: admin.php?section=users"); exit;
    }

    /* ── CRUD ULASAN / REVIEW ── */
    if ($action === 'save_review') {
        requireLogin();
        $u = currentUser();
        $data = [
            'id'         => genId('r'),
            'user_id'    => $u['id'],
            'prop_id'    => $_POST['prop_id'] ?? '',
            'rating'     => max(1,min(5,(int)($_POST['rating']??5))),
            'comment'    => h(trim($_POST['comment']??'')),
            'created_at' => date('Y-m-d H:i:s'),
        ];
        dbInsert('reviews', $data);
        flash('Ulasan berhasil dikirim! ⭐');
        header("Location: " . ($_POST['_redirect'] ?? 'index.php')); exit;
    }

    if ($action === 'delete_review') {
        requireRole('admin');
        dbDelete('reviews', $_POST['id']??'');
        flash('Ulasan dihapus.');
        header("Location: admin.php?section=reviews"); exit;
    }
}