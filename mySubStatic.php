<?php
/**
	* Plugin 	mySubStatic
	* @author	Cyrille G.  @ re7net.com
	* pages statique à deux niveaux
**/
class mySubStatic extends plxPlugin {
const BEGIN_CODE = '<?php' . PHP_EOL;
const END_CODE = PHP_EOL . '?>';
public $subs;
# exemple par défaut
public $defaultExpert = array(
	'@li class="static menu@'			=> 'li class="static menu-item ',
	'@li class="menu menu-item active@' => 'li class="menu-item active',
	'@li class="menu has-children"@'    => 'li class="menu-item has-children"',
	'@menu-item  menu-item@'			=> 'menu-item '
	);
		
/**
	* Constructeur de la classe
	*
	* @param	default_lang	langue par défaut
	* @return	stdio
	* @author	Stephane F
**/
public function __construct($default_lang) {
			
	# appel du constructeur de la classe plxPlugin (obligatoire)
	parent::__construct($default_lang);	
			
	# droits pour accèder à la page config.php du plugin
	$this->setConfigProfil(PROFIL_ADMIN);
			
	# déclaration des hooks
	$this->addHook('IndexBegin','IndexBegin');
	$this->addHook('plxShowStaticListBegin','plxShowStaticListBegin');
	$this->addHook('ThemeEndBody','ThemeEndBody');
	$this->addHook('plxShowStaticContentBegin','plxShowStaticContentBegin');
	$this->addHook('AdminTopBottom','AdminTopBottom');
	$this->addHook('AdminStaticsPrepend','AdminStaticsPrepend');
			
	$this->defaultExpert=json_decode($this->getParam('expert'),true)== '' ? $this->defaultExpert : json_decode($this->getParam('expert'),true);			
			
}
		
# Activation / desactivation
public function OnActivate() {
	# activation du wizard
	$_SESSION['justactivated'.basename(__DIR__)] = true;			
}
# page administration
public function AdminTopBottom() {
	# code à executer à l’activation du plugin
	if (isset($_SESSION['justactivated'.basename(__DIR__)])) {$this->wizard();}
}
		
public function wizard() {
	# affichage uniquement dans les page d'administration du plugin.
	if(basename($_SERVER['SCRIPT_FILENAME']) =='parametres_plugins.php' || basename($_SERVER['SCRIPT_FILENAME']) =='parametres_plugin.php' || basename($_SERVER['SCRIPT_FILENAME']) =='plugin.php') {	
		include(PLX_PLUGINS.__CLASS__.'/wizard.php');
	}
}		
		
# filtrage des statiques avec un prefixe numerique sur 3 chiffre correspondant au un group de page statique
public function IndexBegin() {
	$plxShow  = plxShow::getInstance();
	$plxMotor = plxMotor::getInstance();			
	$group_active = '';
	$format = '				';
	$format .=$this->getParam('format')=='' ? '			<li class="#static_class #static_status" id="#static_id"><a href="#static_url" title="#static_name">#static_name</a></li>' : $this->getParam('format');
	$format .=PHP_EOL;
	$format_group = '			';
	$format_group.=$this->getParam('format_group')=='' ? '			<span class="#group_class #group_status">#group_name</span>' : $this->getParam('format_group');
	$format_group.=PHP_EOL;
	$mySubstats =array();
			
	foreach ($plxShow->plxMotor->aStats as $k => $v) {
		if($v['group'] !=''  and $v['group'] !='home' and array_key_exists(trim(substr($v['group'],0,3)),$plxShow->plxMotor->aStats)  ) {
			if ($group_active == ''  and $plxShow->staticId() == intval($k) and $v['group'] != '') 	$group_active = $v['group'];	
			$substat =strtr($format_group, [
			'#group_id'	=> 'static-group-' . plxUtils::urlify($k),
			'#group_class'	=> 'static group',
			'#group_status'	=> ($group_active == $k) ? 'active' : 'noactive',
			'#group_name'	=> substr($v['group'],3),
			]);
		
			#maj $url 
			if ($v['url'][0] == '?') # url interne commençant par ?
			{$url = $plxShow->plxMotor->urlRewrite($v['url']);}
			elseif (plxUtils::checkSite($v['url'], false)) # url externe en http ou autre
			{$url = $v['url'];}
			else # url page statique
			{	$url = $plxShow->plxMotor->urlRewrite('?static' . intval($k) . '/' . $v['url']);}
					
			$li=  strtr($format, [
			'#static_id'		=> 'static-' . intval($k),
			'#static_class'		=> 'static menu menu-item',
			'#static_name'		=> plxUtils::strCheck($v['name']),
			'#static_status'	=> ($plxShow->staticId() == intval($k)) ? 'active' : 'noactive',
			'#static_url'		=> $url,
			]);
			$mySubstats[$plxShow->plxMotor->aStats[substr($v['group'],0,3)]['group']][$substat][]= $li;
		}
	}
	$this->subs = $mySubstats;
}
		
# modification de la fonction staticList();
public function plxShowStaticListBegin() {		
	echo self::BEGIN_CODE;
	?>
		include('<?= PLX_ROOT.'plugins/'.basename(__DIR__)?>/staticList.php');
		return true;
	<?php
        echo self::END_CODE;
}
		
# inclure une navigation entre statiques du même groupe
public function plxShowStaticContentBegin() {
	$ariane 	= $this->getParam('breadcrumbs')=='' ? 0 : $this->getParam('breadcrumbs');
	$navgroup 	= $this->getParam('interlink')	=='' ? 0 : $this->getParam('interlink');
	echo self::BEGIN_CODE;
	?>	
		$active =$this->plxMotor->aStats[$this->plxMotor->cible]['name'];
		$breacrumbs='';
		$nav='';
		$rel='<?= L_PAGINATION_PREVIOUS_TITLE  ?>: ';
		$group_active ='';
		$cocoon=array();
		foreach ($this->plxMotor->aStats as $k => $v) {
			if(
			$v['group'] !=''  and $v['group'] !='home' 
			and
			($k == substr($this->plxMotor->cible,0,3) or $v['group'] == $this->plxMotor->aStats[$this->plxMotor->cible]['group'])  
			) {
				if ($group_active == ''  and $this->staticId() == intval($k) and $v['group'] != '') {
					$active = plxUtils::strCheck($v['name']);
					$cocoon[plxUtils::strCheck($v['name'])]= '<a class="active">'.$active.'</a>';
					$rel='<?= L_PAGINATION_NEXT_TITLE  ?>: ';
					continue;// on passe la page courante
				}
				#recup URL
				if ($v['url'][0] == '?') # url interne commençant par ?
				$url = $this->plxMotor->urlRewrite($v['url']);
				elseif (plxUtils::checkSite($v['url'], false)) # url externe en http ou autre
				$url = $v['url'];
				else # url page statique
				$url = $this->plxMotor->urlRewrite('?static' . intval($k) . '/' . $v['url']);
					
				$cocoon[plxUtils::strCheck($v['name'])]= '<a href="'.$url.'" rel="'.$rel.'" title="'.$rel.' '.plxUtils::strCheck($v['name']).'">'.plxUtils::strCheck($v['name']).'</a>';
			}		
		}
			
		if(<?= $ariane ?> == 1  and $this->plxMotor->aStats[$this->plxMotor->cible]['group'] !='' ) {			
			#fil d'ariane
			$breacrumbs='
			<ul class="repertory menu breadcrumb">
				<li><a href="'.$this->plxMotor->urlRewrite().'">'.$this->getLang('HOME').'</a></li>'.PHP_EOL;
			if(array_key_exists(trim(substr($this->plxMotor->aStats[$this->plxMotor->cible]['group'],0,3)),$this->plxMotor->aStats)) {
				$breacrumbs.= '				<li><a href="'.$this->plxMotor->urlRewrite('?static' . intval(substr($this->plxMotor->aStats[$this->plxMotor->cible]['group'],0,3)) . '/'.$this->plxMotor->aStats[substr($this->plxMotor->aStats[$this->plxMotor->cible]['group'],0,3)]['url']).'">'.$this->plxMotor->aStats[substr($this->plxMotor->aStats[$this->plxMotor->cible]['group'],0,3)]['group'].'</a></li>
				<li>'.substr($this->plxMotor->aStats[$this->plxMotor->cible]['group'],3).'</li>'.PHP_EOL;
			}
			else {
				$breacrumbs.='					<li>'.$this->plxMotor->aStats[$this->plxMotor->cible]['group'].'</li>'.PHP_EOL;
			}
				$breacrumbs.='					<li><em class="active">'.$active.'</em></li>'.PHP_EOL;			
				$breacrumbs.='				</ul>';
			}		
			if(<?= $navgroup ?> == 1 ) {				
				#navigation niveau groupe
				if(count($cocoon)>1) {				
					if(array_key_exists(trim(substr($this->plxMotor->aStats[$this->plxMotor->cible]['group'],0,3)),$this->plxMotor->aStats)) {
						$groupName= substr($this->plxMotor->aStats[$this->plxMotor->cible]['group'],3);
					}
					else {
						$groupName=$this->plxMotor->aStats[$this->plxMotor->cible]['group'];
					}				
					$nav = '<nav id="<?= __CLASS__ ?>" class="prevNext"><b style="text-transform:uppercase">'.$groupName.': </b>';
						foreach ($cocoon as $adj) {
							$nav .=  $adj;
						}
					$nav .=  '</nav>';
				}
			}
			
			# On va verifier que la page a inclure est lisible
			if ($this->plxMotor->aStats[$this->plxMotor->cible]['readable'] == 1) {
				# On genere le nom du fichier a inclure
				$file = PLX_ROOT . $this->plxMotor->aConf['racine_statiques'] . $this->plxMotor->cible;
				$file .= '.' . $this->plxMotor->aStats[$this->plxMotor->cible]['url'] . '.php';
				# Inclusion du fichier
				ob_start();
				require $file;
				$output = ob_get_clean();
				eval($this->plxMotor->plxPlugins->callHook('plxShowStaticContent'));
				
				$output= $breacrumbs.PHP_EOL.$output.PHP_EOL.$nav;
				echo $output;
			} else {
				echo $breacrumbs.'<p class="alert orange">' . L_STATICCONTENT_INPROCESS . '</p>'.$nav;
			}			
			
			# fin de traitement de la page statique
			return true;
	<?php
        echo self::END_CODE;
			
}
		
		
# reinjection des sous statiques
public function ThemeEndBody() {
	if(count($this->subs)>0) {
		foreach($this->subs as $sub => $li) {
			$html='';
			$name=$sub;
			if(is_array($li)) {
				foreach($li as $k => $val) { 
					$html .= $k.'			<ul class="sub-menu">'.PHP_EOL;				
					if(is_array($val)) {
						foreach($val as $sub => $v) {
							$v = str_replace("'", "&rsquo;", $v);
							$html .= $v;
						}
					}
					$html .='			</ul>'.PHP_EOL;
				}
			}			  
			$pregArray=json_encode($this->defaultExpert);
			$reformat=array(
			'@{@'	=>	'(',
			'@}@'=>	')'.PHP_EOL,
			'@:@'	=>	'=>'
			);
			$pregArrayjs = preg_replace(array_keys( $reformat ), array_values( $reformat ), $pregArray);
					
		echo self::BEGIN_CODE;
		?>	
			$output = str_replace('</li><!-- <?= $name ?> -->', ob_get_clean().PHP_EOL.'<?= $html ?>		</li>'.PHP_EOL, $output);
		<?php
		echo self::END_CODE;
		}			  
	# nettoyage final
	echo self::BEGIN_CODE;
	?>	
			$replace= <?= 'array'.$pregArrayjs  ?>;
			$output = preg_replace(array_keys( $replace ), array_values( $replace ), $output);
			$output = str_replace('</body>', ob_get_clean().'<script src="'.PLX_ROOT.'plugins/<?= __CLASS__ ?>/js/<?= __CLASS__ ?>.js"></script>'.PHP_EOL.'</body>', $output);
	<?php
	echo self::END_CODE;
	}
}

public function AdminStaticsPrepend() {		
	echo self::BEGIN_CODE;
	?>
		$plgPlugin = $plxAdmin->plxPlugins->aPlugins['<?= __CLASS__ ?>'];
		include PLX_PLUGINS . '<?= __CLASS__ ?>/statiques.php';
		exit;
	<?php
	echo self::END_CODE;
	}
}
