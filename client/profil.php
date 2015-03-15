<?php
	include 'include.php';	
	isAllowed();

	
	if(isset($_GET['id']))
	{
		$url = 'http://api-rest-youcef-m.c9.io/user/show/'.$_GET['id'];
		$result =  httpGet([],$url);
		$user = json_decode($result['content'],true);
	}else{
		$user = $_SESSION['profil'];	
	}

	$pages = userPages($user['id']);

	if($pages > 0)
	{
		if(isset($_GET['page']))
		{
			$content = userPosts($user['id'],$_GET['page']);
		}else{
			$content = userPosts($user['id']);
		}
		$content = $content->posts;
	}

	getHeader();
?>
	<section id="profil">	
		<img src="http://api-rest-youcef-m.c9.io/avatar/<?= $user['id']; ?>_200x200.jpg" alt="" />
		<h1><?= $user['username']; ?></h1>
		<p> <a href="amis.php">Amis</a>, <a href="abonnes.php">Abonn&eacute;s</a>, <a href="abonnements.php">Abonnements</a></p>
		<a href="importerphoto.php">Importer une photo</a><br/>
		<a href="modifierprofil.php">Modifier mes informations</a><br/>
		<hr>
	</section>
	<section id="photos">
		<ul id="inedit">
			<?php if ($pages > 0): ?>
				<?php foreach ($content as $k => $v): ?>
					<li>
						<a href="afficherphoto.php?id=<?= $v->id?>"> 
							<img src="http://api-rest-youcef-m.c9.io<?= implode("_200x200.",explode(".",$v->chemin));?>">
						</a>
					</li>
				<?php endforeach ?>
			<?php endif ?>
			
		</ul>
	</section>

	<?php if ($pages > 0): ?>
		<nav>
		  <ul class="pagination">
		    <li>
			    </li>
				    
			    	<?php if (isset($_GET['id'])): ?>
				    	<?php for($v=1;$v<=$pages;$v++): ?>
				   			<li><a href="profil.php?page=<?= $v; ?>&id=<?= $_GET['id']; ?>"><?= $v; ?></a></li>
				   		<?php endfor?>
				    <?php else: ?>
				    	<?php for($v=1;$v<=$pages;$v++): ?>
				   			<li><a href="profil.php?page=<?= $v; ?>"><?= $v; ?></a></li>
				   		<?php endfor?>
				    <?php endif ?>
				 
			    <li>
		    </li>
		  </ul>
		</nav>
		<hr>
	<?php endif ?>

	<script type="text/javascript" src="popup.js"></script>
<?php
	include 'partials/footer.php';
?>