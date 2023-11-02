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
<form class="inline-form" id="form_<?= basename(__DIR__) ?>" action="parametres_plugin.php?p=<?= basename(__DIR__) ?>" method="post">
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
			
			</fieldset>
		<p class="in-action-bar">
			<?php echo plxToken::getTokenPostMethod() ?>
			<input type="submit" name="submit" value="<?php $plxPlugin->lang('L_SAVE') ?>" />
		</p>

</form>