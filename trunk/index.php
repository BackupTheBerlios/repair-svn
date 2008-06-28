<ul>
	<li><a href="pages/help.php">klik</a></li>
	<li><a href="https://webauth.ugent.be/?aid=rep&url=<? echo "http://".$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'];?>" >log in</a></li>
</ul>
<?

// test voor inloggen
$pubkey = openssl_get_publickey('file://ugent.pub') or die();
if (isset($_GET['key'])) {
    $ticket = $_GET['key'];
    $ticket = strtr($ticket,'*-.','+/=');
    $ticket = base64_decode($ticket);
    if (openssl_public_decrypt($ticket,$data,$pubkey)) {
        $_data = explode(":",$data);
        list($user,$time,$aid) = $_data;
        echo "user : $user </br>";
		echo "time : ".strftime('%Y/%m/%dT %H:%M:%S', $time)." </br>";
		echo "aid  : $aid</br>:";
    }
}

//test van bert
require_once("classes/Herstelformulier.class.php");
require_once("classes/Veld.class.php");

$h = new Herstelformulier(1);
print_r($h->getVeldenlijst());

foreach ($h->getVeldenlijst() as $index => $veldid) {
	$veldenlijst[$veldid] = new Veld($veldid);
}

print_r($veldenlijst);
?>