<?php
		$extra='';
		$home = ((empty($this->plxMotor->get) or preg_match('/^page[0-9]*/', $this->plxMotor->get)) and basename($_SERVER['SCRIPT_NAME']) == "index.php");
		# Si on a la variable extra, on affiche un lien vers la page d'accueil (avec $extra comme nom)
		if ($extra != '') {
			$menus[][] = strtr($format, [
				'#static_id'	=> 'static-home',
				'#static_class'	=> 'static menu',
				'#static_url'	=> $this->plxMotor->urlRewrite(),
				'#static_name'	=> plxUtils::strCheck($extra),
				'#static_status'	=> $home ? 'active' : 'noactive',
			]);
		}

		$group_active = '';
		if ($this->plxMotor->aStats) {
			foreach ($this->plxMotor->aStats as $k => $v) {
				if ($v['active'] == 1 and $v['menu'] == 'oui') { # La page  est bien active et dispo ds le menu
					if ($v['url'][0] == '?') # url interne commençant par ?
						$url = $this->plxMotor->urlRewrite($v['url']);
					elseif (plxUtils::checkSite($v['url'], false)) # url externe en http ou autre
						$url = $v['url'];
					else # url page statique
						$url = $this->plxMotor->urlRewrite('?static' . intval($k) . '/' . $v['url']);
					$stat = strtr($format, [
						'#static_id'		=> 'static-' . intval($k),
						'#static_class'		=> 'menu',
						'#static_name'		=> plxUtils::strCheck($v['name']),
						'#static_status'	=> ($this->staticId() == intval($k)) ? 'active' : 'noactive',
						'#static_url'		=> $url,
					]);
					if (empty($v['group']))
						$menus[][] = $stat;
					else
						$menus[$v['group']][] = $stat;
					if ($group_active == '' and $home === false and $this->staticId() == intval($k) and $v['group'] != '')
						$group_active = $v['group'];
					# est ce un sous groupe ?
					if(isset($this->plxMotor->aStats[substr($v['group'],0,3)]['group']) and $this->plxMotor->aStats[substr($v['group'],0,3)]['group'] !='' and $this->plxMotor->aStats[substr($v['group'],0,3)]['menu'] =='oui') {
					
						# insertion du marker de sous-groupe dans le menu
						if(!isset($found[$this->plxMotor->aStats[substr($v['group'],0,3)]['group']])) {// test si déjà vu
							$found[$this->plxMotor->aStats[substr($v['group'],0,3)]['group']] ='set';
							end($menus[$this->plxMotor->aStats[substr($v['group'],0,3)]['group']]);
							$key = key($menus[$this->plxMotor->aStats[substr($v['group'],0,3)]['group']]);	
							# ajout du marker.
							$menus[$this->plxMotor->aStats[substr($v['group'],0,3)]['group']][$key].='<!-- '.$this->plxMotor->aStats[substr($v['group'],0,3)]['group'].' -->';
							# nettoyage des class par défaut de pluxml, on ne garde que menu
							$menus[$this->plxMotor->aStats[substr($v['group'],0,3)]['group']][$key]=  str_replace(' noactive','',$menus[$this->plxMotor->aStats[substr($v['group'],0,3)]['group']][$key]);
							$menus[$this->plxMotor->aStats[substr($v['group'],0,3)]['group']][$key]=  str_replace(' active','',$menus[$this->plxMotor->aStats[substr($v['group'],0,3)]['group']][$key]);
						}
					}
				}
			}
		}

		if ($menublog) {
			if ($this->plxMotor->aConf['homestatic'] != '' and isset($this->plxMotor->aStats[$this->plxMotor->aConf['homestatic']])) {
				if ($this->plxMotor->aStats[$this->plxMotor->aConf['homestatic']]['active']) {
					$menu = '	'.strtr($format, [
					'#static_id'	=> 'static-blog',
					'#static_status'=> (
						$this->plxMotor->get and
						preg_match('#^(?:blog|categorie|archives|tag|article)#', $_SERVER['QUERY_STRING'] . $this->plxMotor->mode)
					) ? 'active' : 'noactive',
					'#static_url'	=> $this->plxMotor->urlRewrite('?blog'),
					'#static_name'	=> L_PAGEBLOG_TITLE,
					'#static_class'	=> 'static menu',
					]).PHP_EOL;
					array_splice($menus, (intval($menublog) - 1), 0, array($menu));
				}
			}
		}

		# Hook Plugins
		if (eval($this->plxMotor->plxPlugins->callHook('plxShowStaticListEnd'))) return;
		# Affichage des pages statiques + menu Accueil et Blog
		if ($menus) {
			foreach ($menus as $k => $v) {
				if (is_numeric($k)) {
					echo "\n" . (is_array($v) ? $v[0] : $v);
				} else {

					if( !array_key_exists(trim(substr($k,0,3)),$this->plxMotor->aStats))  {
					$group = strtr($format_group, [
						'#group_id'		=> 'static-group-' . plxUtils::urlify($k),
						'#group_class'	=> 'static group',
						'#group_status'	=> ($group_active == $k) ? 'active' : 'noactive',
						'#group_name'	=> plxUtils::strCheck($k),
					]).PHP_EOL;
?>

<li class="menu">
		<?= $group ?>
		<ul id="static-<?= plxUtils::urlify($k) ?>" class="sub-menu">
		<?= implode("\t\t" . PHP_EOL, $v); ?>
		</ul>
</li><?php
					}
				}
			}
		}
