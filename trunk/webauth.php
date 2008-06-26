<?
$pubkey = openssl_get_publickey('file://ugent.pub') or die();

if (isset($_GET['key'])) {
    $ticket = $_GET['key'];
    $ticket = strtr($ticket,'*-.','+/=');
    $ticket = base64_decode($ticket);
    if (openssl_public_decrypt($ticket,$data,$pubkey)) {
        $_data = explode(":",$data);
        list($user,$time,$aid) = $_data;
    }
}

if (!$user) {
    header('Location: https://webauth.ugent.be/?url=https://catalpa.ugent.be/webauth_test/');
    exit();
}

header('Content-type: text/plain');

?>
user : '<?= $user ?>'
time : '<?= strftime('%Y/%m/%dT %H:%M:%S', $time) ?>'
aid  : '<?= $aid ?>'