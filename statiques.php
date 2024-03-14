<?php

/**
 * Plugin MysubStatic
 * Clone et remplace l'édition des pages statiques
 *
 * @package PLX
 * @author	Stephane F, Florent MONTHEL et Griboval Cyrille
 * @adaptation G.Cyrille 
 * @ version v3.0.1
 * @ date 14/03/2024
*/
# Control de l'accès à la page en fonction du profil de l'utilisateur connecté
$plxAdmin->checkProfil(PROFIL_ADMIN, PROFIL_MANAGER);

# On édite les pages statiques
if(!empty($_POST)) {
	if(isset($_POST['homeStatic']))
	{ $plxAdmin->editConfiguration($plxAdmin->aConf, array('homestatic'=>$_POST['homeStatic'][0]));
		}
	else
	{$plxAdmin->editConfiguration($plxAdmin->aConf, array('homestatic'=>''));}
	$plxAdmin->editStatiques($_POST);
	header('Location: statiques.php');
	exit;
}

# On inclut le header
include 'top.php';
?>
<script>
function checkBox(cb) {
	cbs=document.getElementsByName('homeStatic[]');
	for (var i = 0; i < cbs.length; i++) {
		if(cbs[i].checked==true) {
			cbs[i].checked = ((i+1) == cb) ? true: false;
		}
	}
}
</script>
<form action="statiques.php" method="post" id="form_statics">

	<div class="inline-form action-bar">
		<h2><?php echo L_STATICS_PAGE_TITLE ?></h2>
		<p><a class="back" href="index.php"><?php echo L_BACK_TO_ARTICLES ?></a></p>
		<?php plxUtils::printSelect('selection', array( '' =>L_FOR_SELECTION, 'delete' =>L_DELETE), '', false, 'no-margin', 'id_selection') ?>
		<input type="submit" name="submit" value="<?php echo L_OK ?>" onclick="return confirmAction(this.form, 'id_selection', 'delete', 'idStatic[]', '<?php echo L_CONFIRM_DELETE ?>')" />
		<?php echo plxToken::getTokenPostMethod() ?>
		<span class="sml-hide med-show">&nbsp;&nbsp;&nbsp;</span>
		<input type="submit" name="update" value="<?php echo L_STATICS_UPDATE ?>" />
	</div>

	<?php eval($plxAdmin->plxPlugins->callHook('AdminStaticsTop')) # Hook Plugins ?>

	<div class="scrollable-table">
		<table id="statics-table" class="full-width"  data-rows-num='name$="_ordre"'>
			<thead>
				<tr>
					<th class="checkbox"><input type="checkbox" onclick="checkAll(this.form, 'idStatic[]')" /></th>
					<th><?php echo L_ID ?></th>
					<th><?php echo L_STATICS_HOME_PAGE ?></th>
					<th><?php echo L_STATICS_GROUP ?></th>
					<th class="subgroup"><?php echo ' <big style="color: hotpink;vertical-align:.75em;margin-inline-end:-1em;"><big> ↷ </big></big>'.L_STATICS_GROUP ?></th>
					<th><?php echo L_STATICS_TITLE ?></th>
					<th><?php echo L_STATICS_URL ?></th>
					<th><?php echo L_STATICS_ACTIVE ?></th>
					<th><?php echo L_STATICS_ORDER ?></th>
					<th><?php echo L_STATICS_MENU ?></th>
					<th><?php echo L_STATICS_ACTION ?></th>
				</tr>
			</thead>
			<tbody>
			<?php
			# Initialisation de l'ordre
			$ordre = 1;
			# Si on a des pages statiques
			$parentGroup = array();
			$option = "<option value='---' selected>".L_NONE1."</option>";
			if($plxAdmin->aStats) {
				foreach($plxAdmin->aStats as $k=>$v) { # Pour chaque page statique
					echo '<tr>'.PHP_EOL;
					echo '<td><input type="checkbox" name="idStatic[]" value="'.$k.'" /><input type="hidden" name="staticNum[]" value="'.$k.'" /></td>'.PHP_EOL;
					echo '<td>'.$k.'</td>'.PHP_EOL.'<td>'.PHP_EOL;
					$selected = $plxAdmin->aConf['homestatic']==$k ? ' checked="checked"' : '';
					echo '<input title="'.L_STATICS_PAGE_HOME.'" type="checkbox" name="homeStatic[]" value="'.$k.'"'.$selected.' onclick="checkBox(\''.$ordre.'\')" />'.PHP_EOL;
					echo '</td>'.PHP_EOL.'<td>'.PHP_EOL;;

					if (is_numeric(substr(plxUtils::strCheck($v['group']),0,3))) {
						plxUtils::printInput($k.'_group', plxUtils::strCheck($v['group']), 'hidden', '-100');
						plxUtils::printInput($k.'_group_cleaned',substr(plxUtils::strCheck($v['group']), 3), 'text', '-100');
						}
					else {plxUtils::printInput($k.'_group', plxUtils::strCheck($v['group']), 'hidden', '-100');
						  plxUtils::printInput($k.'_group_cleaned" class="level1', plxUtils::strCheck($v['group']), 'text', '-100');}
					echo '</td>'.PHP_EOL.'<td class="subgroup">'.PHP_EOL;
					if (is_numeric(substr(plxUtils::strCheck($v['group']),0,3))) {
					plxUtils::printInput($k.'_group_sub', substr(plxUtils::strCheck($v['group']),0,3), 'text', '-30');
					}
					else {
					 if($v['group'] !='' && $plxAdmin->aConf['homestatic']!=$k) $parentGroup[]=$k;
					plxUtils::printInput($k.'_group_sub', '', 'text', '-30');
					
					}
					
					echo '</td>'.PHP_EOL.'<td>'.PHP_EOL;;
					plxUtils::printInput($k.'_name', plxUtils::strCheck($v['name']), 'text', '-255');
					echo '</td>'.PHP_EOL.'<td>'.PHP_EOL;;
					plxUtils::printInput($k.'_url', $v['url'], 'text', '-255');
					echo '</td>'.PHP_EOL.'<td>'.PHP_EOL;;
					plxUtils::printSelect($k.'_active', array('1'=>L_YES,'0'=>L_NO), $v['active']);
					echo '</td>'.PHP_EOL.'<td>'.PHP_EOL;;
					plxUtils::printInput($k.'_ordre', $ordre, 'text', '2-3');
					echo '</td>'.PHP_EOL.'<td>'.PHP_EOL;;
					plxUtils::printSelect($k.'_menu', array('oui'=>L_DISPLAY,'non'=>L_HIDE), $v['menu']);
					echo '</td>'.PHP_EOL.'<td>'.PHP_EOL;;
					$url = $v['url'];
					if(!plxUtils::checkSite($url)) {
						echo '<a href="statique.php?p='.$k.'" title="'.L_STATICS_SRC_TITLE.'">'.L_STATICS_SRC.'</a>'.PHP_EOL;
						if($v['active']) {
							echo '&nbsp;&nbsp;<a href="'.$plxAdmin->urlRewrite('?static'.intval($k).'/'.$v['url']).'" title="'.L_STATIC_VIEW_PAGE.' '.plxUtils::strCheck($v['name']).' '.L_STATIC_ON_SITE.'">'.L_VIEW.'</a>';
						}
					}
					elseif($v['url'][0]=='?')
						echo '<a href="'.$plxAdmin->urlRewrite($v['url']).'" title="'.plxUtils::strCheck($v['name']).'">'.L_VIEW.'</a>'.PHP_EOL;
					else
						echo '<a href="'.$v['url'].'" title="'.plxUtils::strCheck($v['name']).'">'.L_VIEW.'</a>'.PHP_EOL;
					echo '</td>'.PHP_EOL.'</tr>'.PHP_EOL;;
					$ordre++;
				}
				# On récupère le dernier identifiant
				$a = array_keys($plxAdmin->aStats);
				rsort($a);
			} else {
				$a['0'] = 0;
			}
			$new_staticid = str_pad($a['0']+1, 3, "0", STR_PAD_LEFT);
			?>
			</tbody>
			<tfoot>
				<tr class="new">
					<td colspan="3"><?php echo L_STATICS_NEW_PAGE ?></td>
					<td>
					<?php
						echo '<input type="hidden" name="staticNum[]" value="'.$new_staticid.'" />'.PHP_EOL;
						plxUtils::printInput($new_staticid.'_group', '', 'hidden', '-100');
						plxUtils::printInput($new_staticid.'_group_cleaned', '', 'text', '-100');
						echo '</td>'.PHP_EOL.'<td class="subgroup">'.PHP_EOL;;
						foreach($parentGroup as $g ) {
						 $option .="<option value=$g >$g</option>".PHP_EOL;;
						}
						echo '<select name="substatics">'.$option.'</select>'.PHP_EOL;
						echo '</td>'.PHP_EOL.'<td>';
						plxUtils::printInput($new_staticid.'_name', '', 'text', '-255');
						plxUtils::printInput($new_staticid.'_template', 'static.php', 'hidden');
						echo '</td>'.PHP_EOL.'<td>'.PHP_EOL;;
						plxUtils::printInput($new_staticid.'_url', '', 'text', '-255');
						echo '</td>'.PHP_EOL.'<td>'.PHP_EOL;;
						plxUtils::printSelect($new_staticid.'_active', array('1'=>L_YES,'0'=>L_NO), '0');
						echo '</td>'.PHP_EOL.'<td>'.PHP_EOL;;
						plxUtils::printInput($new_staticid.'_ordre', $ordre, 'text', '2-3');
						echo '</td>'.PHP_EOL.'<td>'.PHP_EOL;;
						plxUtils::printSelect($new_staticid.'_menu', array('oui'=>L_DISPLAY,'non'=>L_HIDE), '1');
					?>
					</td>
					<td>&nbsp;</td>
				</tr>
			</tfoot>
		</table>
	</div>

</form>
<script>
//met à jour le champ groupe d'une nouvelle statiquelet newStat = document.querySelector("tr.new");
let statToAdd = document.querySelectorAll('input[name$="_group"]');
let statGroupName = document.querySelectorAll('input[name$="_group_cleaned"]');
let statRelGroup = document.querySelectorAll("input[name$=_group_sub], select[name=substatics]");

for (i = 0; i < statToAdd.length; i++) {
  let el = statToAdd[i];
  let relipt = statRelGroup[i];
  let groupipt = statGroupName[i];
  statGroupName[i].addEventListener(
    "change",
    function () {
      let groupe = this.value;
      let rel = relipt.value;
      update(el, rel, groupe);
    },
    false
  );

  statRelGroup[i].addEventListener(
    "change",
    function () {
      let groupe = groupipt.value;
      let rel = this.value;
      update(el, rel, groupe);
    },
    false
  );
}

function update(el, rel, groupe) {
  if (rel == undefined) rel = "";
  if (groupe == undefined) groupe = "";
  let newval = rel + groupe;
  el.value = newval;
  console.log(newval);
}
</script>
<?php
# Hook Plugins
eval($plxAdmin->plxPlugins->callHook('AdminStaticsFoot'));

# On inclut le footer
include 'foot.php';