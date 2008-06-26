<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	    <title>Dringende Herstellingen</title>
	    <link rel="stylesheet" type="text/css" href="style.css"/>
	</head>
	<body>
		<!--logo linksboven-->
		<div id="logo"><img src="img/logo.gif" width="200" height="60" alt="Logo Universiteit Gent" usemap="#linklogo" /><map name="linklogo" id="linklogo"><area shape="rect" coords="60,0,142,60" href="http://www.ugent.be" alt="Startpagina Universiteit Gent" /></map></div>
		
		<!--pagina titel-->
		<div id="siteid"><img src="img/siteid-portal.jpg" width="300" height="80" alt="Portaalsite Universiteit Gent" /><a class="text" >Dringende Herstellingen</a></div>
		
		<!--linkjes rechtsboven-->
		<div id="utility">
			<a href="/en">English</a> | <a href="/extra">Contact</a> | <a href="#" onclick="window.print()">Print</a>
		</div>
		
		<!--zoekveldje-->
		<div id="search">
			<form method="get" action="">
				<a href="#" class="advanced"/> 
				<input name="q" value="" class="searchinput" type="text" /> 
				<input type="submit" value="zoek" class="searchbutton" />
			</form>
		</div>
		
		<!--info aan de rechterkant-->
		<div id="related">
			<dl class="box">
				<dt>titeltje</dt>
				<dd>
					<ul>
						<li>puntje</li>
						<li>nog een puntje</li>
					</ul>
				</dd>
			</dl>
		</div>
		
		<!--broodkruimeltjes-->
		<div id="breadcrumb"> 
			<a href='/ugentnet/'>Ugentnet</a> &gt; Index
		</div>
		
		<!--main content-->
		<div id="container">
			
			<!--horizontale navigatiebalk bovenaan-->
			<div id="mainnav">
				<ul>
					<li><a href="#">Linkje</a></li>
					<li><a href="#">Linkje</a></li>
					<li><a href="#">Linkje</a></li>
				</ul>
			</div>
			
			<!--de inhoud van de pagina-->
			<div id="contenthome">
				
				<!--Titel met alinea-->
				<div>
					<h2>Titeltje</h2>
					<p>Dit is een introtekstje blablabla</p>
					<p>De tweede alinea van de intro</p>
				</div>
				
				<!--formuliertje-->
				<div class="block">
					<form class="bodyform" method="post" action="">
						<fieldset>
							<legend>Formuliertje</legend>
							<div>
								<label>username:</label>
								<input name="user" size="8" type="text"/>
							</div>
							<div>
								<label>password:</label>
								<input name="pass" size="8" type="password"/>
							</div>
							<input type="submit" value="login"/>
							<input type="reset" value="reset"/>
						</fieldset>
					</form>					
				</div>				
			</div>		
		</div>		
		
		<!--de footer-->
		<div id="footer">&#169; 2008 Bart Mesuere &amp; Bert Vandeghinste, <a href="#">disclaimer</a></div>
		
		<!--navigatie aan de linkerkant-->
		<div id="leftnav">
			<dl id="nav"> 
				<dt>Titel</dt> 
				<dd><ul> 
					<li id=selected><a href="#">Linkje</a></li> 
					<li ><a href="#">Linkje</a></li> 
					<li class="subnav"> 
						<ul> 
							<li ><a href="#">Linkje</a></li> 
						</ul> 
					</li> 
					<li ><a href="#">linkje</a></li> 
					</ul></dd> 
				</dl>
			
			<!--linkjes onderaan-->
			<dl class="facet">
				<dt>Handige links</dt>
				<dd><ul>
					<li><a href="https://minerva.ugent.be/">&#187; Minerva</a></li>
					<li><a href="http://www.ugent.be/phonebook">&#187; Telefoonboek</a></li>
					<li><a href="http://www.lib.ugent.be/">&#187; Bibliotheek</a></li>
					<li><a href="http://www.opleidingen.ugent.be/studiekiezer/nl/index.htm">&#187; Studiekiezer</a></li>
					<li><a href="/extra/hd.php">&#187; Andere helpdesken</a></li>
				</ul></dd>
			</dl>				
		</div>
		
		<!--login aan de rechterkant-->
		 <div id="login">
			 <a href="#">aanmelden</a>
		 </div>
		 <div id="login-act" class="hidden">
			 &nbsp;-&nbsp;<a href="#">afmelden</a>
		 </div>
		
		<div id="topanchor"><a name="top" id="top">&nbsp;</a></div>		
	</body>
</html>