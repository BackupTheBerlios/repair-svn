<?
	session_start(); 
	require_once 'classes/Config.class.php';
	require_once 'AccessException.php';
	require_once 'Home.class.php';
	require_once 'Categorie.class.php';
	require_once 'Auth.class.php';
	require_once 'Menu.class.php';
	require_once 'Header.class.php';
	require_once 'Footer.class.php';
	require_once 'Taal.class.php';
	$taal = new Taal();
	$auth = new Auth(true);
	if(!$auth->getUser()->isPersoneel())
		throw new AccessException();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	    <title><?=$taal->msg('titel');?></title>
	    <style type="text/css" media="all">@import url(reset.css);</style>
		<style type="text/css" media="all">@import url(screen.css);</style>
		<style type="text/css" media="print">@import url(print.css);</style>
		<style type="text/css" media="all">@import url(ploneCustom.css);</style>
		
		<!-- Internet Explorer 6 CSS Fixes -->
		<!--[if IE 6]>
			        <style type="text/css" media="all">@import url(ie6.css);</style>
		<![endif]-->
		
		<!-- Internet Explorer 7 CSS Fixes -->
		<!--[if IE 7]>
			        <style type="text/css" media="all">@import url(ie7.css);</style>
		<![endif]-->

		<meta http-equiv="imagetoolbar" content="no" />
		<script type="text/javascript" src="js/jquery/jquery.js"></script>
		<script type="text/javascript" src="js/jquery/json.js"></script>
		<script type="text/javascript" src="js/jquery/jquery.getUrlParam.js"></script>
		<script type="text/javascript" src="js/personeelAdminCategorie.js"></script>
	</head>
	<body>
		<div id="container">
			<?new Header(array("#"), array("Index")); ?>
			<div id="main">
				<?new Menu("Beheer"); ?>
				<div id="content" class="normal">
					<div class="documentActions">                 
						<ul> 
					        <li><a href="javascript:this.print();"><img src="images/print_icon.gif" alt="<?=$taal->msg('afdrukken')?>" title="<?=$taal->msg('afdrukken')?>" id="icon-print"/></a></li> 
    					</ul> 
   					</div>
   					
					<div>
						<h1>Beheer Categorieën</h1>
						<p class='disclaimer'>Hier kunt u categoriën toevoegen en bewerken. Klik op het <img src="images/page_edit.gif"/>-icoon om een bestaande categorie aan te passen. Onderaan heeft u ook de mogelijkheid om een nieuwe categorie toe te voegen.</p>
						<table>
							<tr class="tabelheader"><td colspan="5">Beheer Categoriën</td></tr>
							<tr class="subheader"><td colspan="5">Kamer</td></tr>
							<tr class="legende"><td>id</td><td>Nederlandse naam</td><td>Engelse naam</td><td></td><td></td></tr>
							<?
								$cats = Categorie::getCategorieObjects("Kamer");
								foreach($cats as $cat){
									$id = $cat->getId();
									echo("<tr id='".$id."_'><td>$id</td><td class='edit' id='naamNL_$id'>".$cat->getNaamNL()."</td><td class='edit' id='naamEN_$id'>".$cat->getNaamEN()."</td><td class='img1'><img src='images/page_edit.gif' /></td><td class='img2'></td></tr>");
								}
								echo("<tr id='kamer'><td></td><td class='edit' id='naamNL_kamer'><input class='naam' type='text'/></td><td class='edit' id='naamEN_kamer'><input class='naam' type='text'/></td><td class='img'><img src='images/page_add.gif'/></td><td></td></tr>");
							?>
							<tr class="subheader"><td colspan="5">Verdieping</td></tr>
							<tr class="legende"><td>id</td><td>Nederlandse naam</td><td>Engelse naam</td><td></td><td></td></tr>
							<?
								$cats = Categorie::getCategorieObjects("Verdiep");
								foreach($cats as $cat){
									$id = $cat->getId();
									echo("<tr id='".$id."_'><td>$id</td><td class='edit' id='naamNL_$id'>".$cat->getNaamNL()."</td><td class='edit' id='naamEN_$id'>".$cat->getNaamEN()."</td><td class='img1'><img src='images/page_edit.gif' /></td><td class='img2'></td></tr>");
								}
								echo("<tr id='verdiep'><td></td><td class='edit' id='naamNL_Verdiep'><input class='naam' type='text'/></td><td class='edit' id='naamEN_Verdiep'><input class='naam' type='text'/></td><td class='img'><img src='images/page_add.gif'/></td><td></td></tr>");
							?>
							<tr class="subheader"><td colspan="5">Gemeenschappelijk</td></tr>
							<tr class="legende"><td>id</td><td>Nederlandse naam</td><td>Engelse naam</td><td></td><td></td></tr>
							<?
								$cats = Categorie::getCategorieObjects("Gemeenschappelijk");
								foreach($cats as $cat){
									$id = $cat->getId();
									echo("<tr id='".$id."_'><td>$id</td><td class='edit' id='naamNL_$id'>".$cat->getNaamNL()."</td><td class='edit' id='naamEN_$id'>".$cat->getNaamEN()."</td><td class='img1'><img src='images/page_edit.gif' /></td><td class='img2'></td></tr>");
								}
								echo("<tr id='gemeenschappelijk'><td></td><td class='edit' id='naamNL_Gemeenschappelijk'><input class='naam' type='text'/></td><td class='edit' id='naamEN_Gemeenschappelijk'><input class='naam' type='text'/></td><td class='img'><img src='images/page_add.gif'/></td><td></td></tr>");
							?>
						</table>
					</div>
				</div>		
			</div>	
		</div>	
		<div class="visualClear"></div>
		<? new Footer(); ?>
	</body>
</html>