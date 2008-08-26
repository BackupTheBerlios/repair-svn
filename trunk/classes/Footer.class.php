<?php
class Footer{
	function __construct(){
		require_once 'Taal.class.php';
		$taal = new Taal();
		echo("<div id='footer-wrap'>
			<div id='footer'>
				<ul id='copyright' class='swapUnderline'>
					<li>
						<span class='byline_author'>Reacties op de inhoud</span>: 
						<a class='byline_author' href='mailto:huisvesting@UGent.be'>huisvesting@UGent.be</a>
					</li>
  					<li>".$taal->msg('footer')."</li>
  				</ul>
  			</div>
  		</div>	");
	}
}
?>