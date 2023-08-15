<?php if(!defined('PLX_ROOT')) exit; ?>
<?php

# Control du token du formulaire
plxToken::validateFormToken($_POST);

# Liste des langues disponibles et prises en charge par le plugin
$aLangs = array($plxAdmin->aConf['default_lang']);

if(!empty($_POST)) {
	$plxPlugin->setParam('format', $_POST['format'], 'cdata');
	$plxPlugin->setParam('format_group', $_POST['format_group'], 'cdata');

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

?>
<style>
	textarea {vertical-align:top;}
</style>
<p class="alert blue"><?php echo $plxPlugin->lang('L_HELP') ?> <a href="https://wiki.pluxml.org/docs/develop/plxshow.html#staticlist">DOC staticList()</a>.</p>
<form class="inline-form" id="form_<?= basename(__DIR__) ?>" action="parametres_plugin.php?p=<?= basename(__DIR__) ?>" method="post">
			<fieldset>
				<p>
					<label for="format_group"><?php echo $plxPlugin->lang('L_FORMAT_GROUP') ?>&nbsp;:</label>
					<textarea id="format_group" name="format_group" cols="100" rows="1"  ><?= $var['format_group']?></textarea>
				</p>
				<p>
					<label for="format"><?php $plxPlugin->lang('L_FORMAT') ?>&nbsp;:</label>
					<textarea id="format" name="format" cols="100" rows="1" ><?= $var['format']?></textarea>
				</p>
			</fieldset>
		<p class="in-action-bar">
			<?php echo plxToken::getTokenPostMethod() ?>
			<input type="submit" name="submit" value="<?php $plxPlugin->lang('L_SAVE') ?>" />
		</p>
</form>