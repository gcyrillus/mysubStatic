<?php
	if(!defined('PLX_ROOT')) exit; 
	
	# pas d'affichage dans un autre plugin !	
	if(isset($_GET['p'])&& $_GET['p'] !== basename(__DIR__ ) ) {goto end;}
	
	# on charge la class du plugin pour y accéder
	$plxMotor = plxMotor::getInstance();
	$plxPlugin = $plxMotor->plxPlugins->getInstance(basename(__DIR__ )); 
	
	# On vide la valeur de session qui affiche le Wizard maintenant qu'il est visible.
	if (isset($_SESSION['justactivated'.basename(__DIR__)])) {unset($_SESSION['justactivated'.basename(__DIR__)]);}
	
	# initialisation des variables propres à chaque lanque 
	$langs = array();
	
	# initialisation des variables communes à chaque langue	
	$var = array();
	$var['format'] =  $plxPlugin->getParam('format')=='' ? '<li class="#static_class #static_status" id="#static_id"><a href="#static_url" title="#static_name">#static_name</a></li>' : $plxPlugin->getParam('format');
	$var['format_group'] =  $plxPlugin->getParam('format_group')=='' ? '<span class="#group_class #group_status">#group_name</span>' : $plxPlugin->getParam('format_group');
	$var['breadcrumbs'] = $plxPlugin->getParam('breadcrumbs')=='' ? 0 : $plxPlugin->getParam('breadcrumbs');
	$var['interlink'] = $plxPlugin->getParam('interlink')=='' ? 0 : $plxPlugin->getParam('interlink');
	
	
	#affichage
?>
<link rel="stylesheet" href="<?= PLX_PLUGINS.basename(__DIR__ )?>/css/wizard.css" media="all" />
<input id="closeWizard" type="checkbox">
<div class="wizard">	
	<div class="container">	
		<div class='title-wizard'>
			<h2><?= $plxPlugin->aInfos['title']?><br><?= $plxPlugin->aInfos['version']?></h2>
			<img src="<?php echo PLX_PLUGINS.basename(__DIR__ )?>/icon.png">
			<div><q> Made in <?= $plxPlugin->aInfos['author']?> </q></div>
		</div>
		<p></p>
		
		<div id="tab-status">
			<span class="tab active">1</span>
		</div>		
		<form action="parametres_plugin.php?p=<?php echo basename(__DIR__ ) ?>"  method="post">
			<div role="tab-list">		
				<div role="tabpanel" id="tab1" class="tabpanel">
					<h2>Bienvenue dans l’extension <b style="font-family:cursive;color:crimson;font-variant:small-caps;font-size:2em;vertical-align:-.5rem;display:inline-block;"><?= $plxPlugin->aInfos['title']?></b></h2>					
					<p>Merci de  l'avoir choisie.</p>
					<p>Dans ce court tutoriel, nous allons vous presenter cette extension et vous guider à travers quelques-uns des réglages de base pour en tirer le meilleur parti.</p>
					
				</div>	
				<div role="tabpanel" id="tab2" class="tabpanel hidden title">
					<h2>Configuration ~ sous&nbsp;groupe</h2>
				</div>								
				<div role="tabpanel" id="tab3" class="tabpanel hidden">
					.<p>Vous devez déjà avoir au moins un groupe configuré, sinon il vous faut le créer.</p>
					<h3>Pour créer un sous-groupe</h3>
					<p>Pour cela, votre nouvelle page statique doit avoir un nom de groupe <em>prefixé avec l'identifiant</em> de la page statique de groupe à laquelle vous voulez l'attachée.<br><sub>C'est la seule modification à faire en dehors de la configuration de l'extension.</sub></p>
					<p>Par Exemples:<br>
						<img src="<?= PLX_PLUGINS.basename(__DIR__ )?>/img/group-statiques.png" >
					</p>
					<dl>
						<dt>Legende :</dt>
						<dd><span class="bspan gray">gray</span> Une page statique de groupe <sup>fonction native de PluXml</sup></dd>
						<dd><span class="bspan green">green</span> Une page statique de sous groupe valide <sup>Un Groupe prefixé devient un sous-groupe<br> uniquement si le plugin est activé </sup></dd>
						<dd><span class="bspan red">red</span> Une page de sous groupe <b>invalide</b> car le préfixe n'a pas de numéro de correspondance.</dd>
					</dl>
					
				</div>	
				<div role="tabpanel" id="tab4" class="tabpanel hidden title">
					<h2>Des miettes de pain</h2>					
				</div>
				<div role="tabpanel" id="tab5" class="tabpanel hidden">
					<p>Cette option de configuration affiche le fil d'Arianne vers votre page statique.</p>
					<p>Visuel :<br><img src="<?= PLX_PLUGINS.basename(__DIR__ )?>/img/breadcrumbs-statiques.png" ></p>
					<p>
						<label for="breadcrumbs" ><?php $plxPlugin->lang('L_SHOW_BREADCRUMBS') ?>&nbsp;?
						<?php plxUtils::printSelect('breadcrumbs',array('1'=>L_YES,'0'=>L_NO),$var['breadcrumbs']); ?>:</label>
					</p>
				</div>		
				<div role="tabpanel" id="tab6" class="tabpanel hidden title">
					<h2>Cooconing</h2>
				<p>Lier vos pages similaires entre elles.</p>
				</div>
				<div role="tabpanel" id="tab7" class="tabpanel hidden">
					<p>Cette option de configuration affiche les liens entre pages statiques de même groupe.</p>
					<p>Visuel :<br><img src="<?= PLX_PLUGINS.basename(__DIR__ )?>/img/subnav-statiques.png" ></p>
					<p>
						<label for="interlink" ><?php $plxPlugin->lang('L_SHOW_INTERLINK') ?>&nbsp;?
						<?php plxUtils::printSelect('interlink',array('1'=>L_YES,'0'=>L_NO),$var['interlink']); ?></label>
					</p>
				</div>					
				<div role="tabpanel" id="tab8" class="tabpanel hidden title">
					<h2>Configuration du menu</h2>		
				</div>				
				<div role="tabpanel" id="tab9" class="tabpanel hidden">
					<p class="alert blue">L'affichage des sous groupes reprend le format par défaut des groupes de pages statiques.</p>
					<p class="alert warning">Cette configuration est celle par défaut.Il n'est generalement pas necessaire d'y toucher sauf si votre thème le requiert.</p>	
					
					<fieldset>
						<p>
							<label for="format_group"><?php echo $plxPlugin->lang('L_FORMAT_GROUP') ?>&nbsp;:</label>
							<textarea id="format_group" name="format_group" cols="100" rows="1"  ><?= $var['format_group']?></textarea>
						</p>
						<p>
							<label for="format"><?php $plxPlugin->lang('L_FORMAT') ?>&nbsp;:</label>
							<textarea id="format" name="format" cols="100" rows="1" ><?= $var['format']?></textarea>
						</p>
						<p>Voir la documentation Officielle si vous devez modifier cette affichage: <a href="https://wiki.pluxml.org/docs/develop/plxshow.html#staticlist">fonction staticList()</a>.</p>
						
					</fieldset>
					
					
				</div>								
				<div role="tabpanel" id="tab10" class="tabpanel hidden title">
					<h2>Configuration avançée</h2>
					<p>Ajoutez, enlevez des class ou autres ...</p>
					
				</div>										
				<div role="tabpanel" id="tab11" class="tabpanel hidden">
					<p class="alert warning">Cette partie s'adresse aux experts et plus téméraires</p>
					<p class="alert green">Si vous faite une erreur, cliquer le bouton <b><em>réinitialiser</em></b> pour retrouver la configuration par défaut.</p>
					<p>Visuel :<br><img src="<?= PLX_PLUGINS.basename(__DIR__ )?>/img/pregRaz.png" ></p>
					<p>Cette partie vous permet de gérer les class attribuées aux éléments de menu, cela vous permet d'utiliser vos class personnelles où celle de Bootstrap, entre autre possibilité.</p>
					<p>Dans la premiere colonne se trouve une regex pour rechercher la chaine de code à modifier, la seconde colonne correspond à la modification que vous souhaitez obtenir. Les modifications dépassent la portée du menu et il n'y a pas de limite à ce que vous pouvez modifier et injecter. Soyez prudent et ingénieux.</p>
				</div>								
				<div role="tabpanel" id="tab12" class="tabpanel hidden">
					<h2>FIN</h2>
					<p>Ce dictatoriel est fini, vous pouvez enregistrer votre configuration.</p>
					
				</div>				
				
				<div class="pagination">
					<a class="btn hidden" id="prev"><?php $plxPlugin->lang('L_PREVIOUS') ?></a>
					<a class="btn" id="next"><?php $plxPlugin->lang('L_NEXT') ?></a>
					<?php echo plxToken::getTokenPostMethod() ?>
					<button class="btn btn-submit hidden" id="submit"><?php $plxPlugin->lang('L_SAVE') ?></button>
				</div>
			</form>
		</div>
		
		<p class="idConfig">
			<?php
				if(file_exists(PLX_PLUGINS.basename(__DIR__ ).'/admin.php')) {echo ' 
				<a href="/core/admin/plugin.php?p='.basename(__DIR__ ).'">Page d\'administration '. basename(__DIR__ ).'</a>';}
				if(file_exists(PLX_PLUGINS.basename(__DIR__ ).'/config.php')) {echo ' 	<a href="/core/admin/parametres_plugin.php?p='.basename(__DIR__ ).'">Page de configuration '.basename(__DIR__ ).'</a>';}
			?>
			<label for="closeWizard"> Fermer </label>
		</p>	
	</div>	
	<script src="<?= PLX_PLUGINS.basename(__DIR__ )?>/js/wizard.js"></script>
</div>
<?php end: // FIN! ?>
