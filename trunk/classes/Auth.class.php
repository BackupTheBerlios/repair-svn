<?php
require_once 'exceptions/PublicKeyException.class.php';
require_once 'UserList.class.php';
require_once 'User.class.php';

/**
	 * Deze klasse zorgt ervoor dat de gebruiker ingelogd is en dat zijn identiteit gecontroleerd wordt
	 * Indien hij nog niet ingelogd is wordt hij naar webauth doorverwezen
	 * Indien hij wel al ingelogd is wordt zijn corresponderend user object aangemaakt
	 *
	 */
class Auth{	
	
	private $user;
	private static $aid="rep";//application id die meegegeven wordt bij het inloggen. mag maximaal 4 tekens lang zijn
	private static $threshold = 300;//aantal seconden dat een webauth key geldig is
	
	
	public function __construct(){
		if(isset($_SESSION['userid'])){//is de gebruiker ingelogd?
			$this->user=new User($_SESSION['userid']);
		}
		else{//de gebruiker is nog niet ingelogd
			if(isset($_GET['key'])){//is hij aan het inloggen?
				//we beginnen met de key public key in te lezen
				$pubkey = openssl_get_publickey('file://ugent.pub'); 
				if(!$pubkey)//er loopt iets fout
					throw new PublicKeyException();
					
				//we doen wat hocuspocus met de key die we terug krijgen
				$ticket = $_GET['key'];
    			$ticket = strtr($ticket,'*-.','+/=');
    			$ticket = base64_decode($ticket);
				
				if (openssl_public_decrypt($ticket,$data,$pubkey)) {//decrypteren
			        $_data = explode(":",$data);
			        list($user,$time,$aid) = $_data;
			        //gedecrypteerde data verifi�ren
			        if($aid==self::$aid ){//klopt het application id?
			        	if((time()-$time) < self::$threshold){//is het geen oude key?
			        		//zit de gebruiker al in onze databank?
			        		$id=UserList::isExistingUser($user);
			        		if($id!=0)//als dat zo is maak zijn object aan
			        			$this->user=new User($id);
			        		else //anders, haal zen gegevens uit de ldap
			        			$this->user=new User("", "joske de niet bestaande gebruiker", "", "a@a.aa");//TODO: vervangen als de LDAP werkt

			        		$_SESSION['userid'] = $this->user->getId();
			        	}
			        	else throw new Exception("InvalidKeyException");//TODO: custom InvalidKeyException		        	
			        }
			        else throw new Exception("InvalidKeyException");//TODO: custom InvalidKeyException
			    }
			    else throw new Exception("InvalidKeyException");//TODO: custom InvalidKeyException
			}
			else{//nog niet ingelogd en niet bezig, dus we zwieren hem naar webauth
				echo("<meta http-equiv=\"Refresh\" content=\"0; URL=https://webauth.ugent.be/?aid=".self::$aid ."&url=http://".$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']."\">");
				die();//we stoppen de uitvoering
			}
		}
	}
	
	public function getUser(){
		return $this->user;
	}
}
?>