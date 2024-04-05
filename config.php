<?php if(!defined('PLX_ROOT')) exit; ?>
<?php
	
	# Control du token du formulaire
	plxToken::validateFormToken($_POST);
	
	# Liste des langues disponibles et prises en charge par le plugin
	$aLangs = array($plxAdmin->aConf['default_lang']);
	
	
	if(!empty($_POST)) {
		$plxPlugin->setParam('format', $_POST['format'], 'cdata');
		$plxPlugin->setParam('format_group', $_POST['format_group'], 'cdata');
		$plxPlugin->setParam('breadcrumbs', $_POST['breadcrumbs'], 'numeric');
		$plxPlugin->setParam('interlink', $_POST['interlink'], 'numeric');
		$plxPlugin->setParam('sisters', $_POST['sisters'], 'numeric');
		$expert_array=array();
		foreach($_POST['expertNum'] as $expert_num) {
			$key_name= 'pregkey-'.$expert_num;
			if($_POST[$key_name] !='') { 
				$expert_array[$_POST[$key_name]]=$_POST['pregval-'.$expert_num];
			}
		}
		
		if(count($expert_array)>0) $plxPlugin->setParam('expert', json_encode($expert_array), 'cdata');
		else $plxPlugin->setParam('expert', '', 'cdata');
		
		$plxPlugin->saveParams();
		header('Location: parametres_plugin.php?p='.basename(__DIR__));
		exit;
	}
	
	$var = array();
	# initialisation des variables propres à chaque lanque
	$langs = array();
	# initialisation des variables communes à chaque langue
	$var['format'] =  $plxPlugin->getParam('format')=='' ? '<li class="#static_class #static_status" id="#static_id"><a href="#static_url" title="#static_name">#static_name</a></li>' : $plxPlugin->getParam('format');
	$var['format_group'] =  $plxPlugin->getParam('format_group')=='' ? '<span class="#group_class #group_status">#group_name</span>' : $plxPlugin->getParam('format_group');
	$var['breadcrumbs'] = $plxPlugin->getParam('breadcrumbs')=='' ? 0 : $plxPlugin->getParam('breadcrumbs');
	$var['interlink'] = $plxPlugin->getParam('interlink')=='' ? 0 : $plxPlugin->getParam('interlink');
	$var['expert'] = $plxPlugin->getParam('expert')==$plxPlugin->defaultExpert ? '' : $plxPlugin->getParam('expert');
	$var['sisters'] = $plxPlugin->getParam('sisters')=='' ? 0 :  $plxPlugin->getParam('sisters');
	
	# fermeture du wizard
	if (isset($_SESSION['justactivated'.basename(__DIR__)])) {unset($_SESSION['justactivated'.basename(__DIR__)]);}
	# affichage du wizard à la demande
	if(isset($_GET['wizard'])) {$_SESSION['justactivated'.basename(__DIR__)] = true;}
?>
<style>
	textarea {vertical-align:top;}
</style>
<p><a href="parametres_plugin.php?p=<?= basename(__DIR__) ?>&wizard" class="aWizard"><img src="<?= PLX_PLUGINS.basename(__DIR__)?>/img/icon.png" style="height:2em;vertical-align:middle"> Wizard</a></p>
<p class="alert blue"><?php echo $plxPlugin->lang('L_HELP') ?> <a href="https://wiki.pluxml.org/docs/develop/plxshow.html#staticlist">DOC staticList()</a>.</p>
<form class="inline-form" id="form_<?= basename(__DIR__) ?>" name="form_<?= basename(__DIR__) ?>" action="parametres_plugin.php?p=<?= basename(__DIR__) ?>" method="post">
	<fieldset>
		<legend>Format</legend>
		<p>
			<label for="format_group"><?php echo $plxPlugin->lang('L_FORMAT_GROUP') ?>&nbsp;:</label>
			<textarea id="format_group" name="format_group" cols="100" rows="1"  ><?= $var['format_group']?></textarea>
		</p>
		<p>
			<label for="format"><?php $plxPlugin->lang('L_FORMAT') ?>&nbsp;:</label>
			<textarea id="format" name="format" cols="100" rows="1" ><?= $var['format']?></textarea>
		</p>
	</fieldset>
	<fieldset>
		<legend><?php $plxPlugin->lang('L_STAT_NAVS') ?></legend>
		<p>
			<label for="breadcrumbs" ><?php $plxPlugin->lang('L_SHOW_BREADCRUMBS') ?>&nbsp;:</label>
			<?php plxUtils::printSelect('breadcrumbs',array('1'=>L_YES,'0'=>L_NO),$var['breadcrumbs']); ?>
		</p>
		<p>
			<label for="interlink" ><?php $plxPlugin->lang('L_SHOW_INTERLINK') ?>&nbsp;:</label>
			<?php plxUtils::printSelect('interlink',array('1'=>L_YES,'0'=>L_NO),$var['interlink']); ?>
		</p>
		<p>
			<label for="sisters" ><?php $plxPlugin->lang('L_SHOW_LEVEL') ?>&nbsp;:</label>
			<?php plxUtils::printSelect('sisters',array('1'=>L_YES,'0'=>L_NO),$var['sisters']); ?>
		</p>
		
	</fieldset>
	<hr class="alert warning">
	
	<fieldset>
		<legend class="alert red"><?php $plxPlugin->lang('L_CONFIG_EXPERT') ?></legend>
		<table data-rows-num='name$="_ordre"' id="pregR">
			<thead>
				<tr>
					<th>rechercher</th><td>=></td><th>Remplacer par</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					$i=0;
					foreach($plxPlugin->defaultExpert as $k => $v) {
						$i++;
						echo "<tr>
						<td><input type='hidden' name='expertNum[]' value='$i'><input id='pregkey-$i' name='pregkey-$i' value='$k' type='text' class='reset' ></td>
						<td>=></td>
						<td><input id='pregval-$i' name='pregval-$i' value='$v' type='text' class='reset' ></td>
						</tr>".PHP_EOL;
					}
					
				?>
			</tbody>
			<tfoot>
				<tr>
					<td><input type='hidden' name='expertNum[]' value='<?= $i + 1 ?>'><input id='pregkey-<?= $i + 1 ?>' name='pregkey-<?= $i + 1 ?>' placeholder='Rechercher'></td><td>=></td><td><input id='pregval-<?= $i + 1 ?>' name='pregval-<?= $i + 1 ?>' placeholder='Remplacer par'></td>
				</tr>
			</tfoot>
		</table>
		<span class="btn-reset" tabindex="-1" onclick="restoreToDefault()">réinitialiser</span>
		
	</fieldset>
	<p class="in-action-bar">
		<?php echo plxToken::getTokenPostMethod() ?>
		<input type="submit" name="btnsubmit" value="<?php $plxPlugin->lang('L_SAVE') ?>" />
	</p>
	
</form>
<script>
	function restoreToDefault() {
		let iptreset =document.querySelectorAll('input.reset');
		for (let i = 0; i < iptreset.length; i++) {
			iptreset[i].value='';
		}
		document.getElementById("form_<?= basename(__DIR__) ?>").submit();		
	}
</script>
