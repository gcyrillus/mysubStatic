<h1>Aide mySubStatic</h1>
<h2>Configuration d'un sous groupe</h2>
<p>Un nom de groupe de page statique peut-être utilisé comme un groupe parent.</p>
<p>Pour cela, votre nouvelle page statique doit avoir un nom de groupe prefixé avec l'identifiant d'une page statique ayant un  nom de groupe</p>
<p>Par Exemples</p>
<div class="scrollable-table" style="pointer-events:none;background:rgba(0,0,0,0.01);border:solid 1px;">
  <table id="statics-table" class="full-width" data-rows-num='name$="_ordre"'>
    <thead>
      <tr>
        <th class="checkbox"><input type="checkbox" /></th>
        <th>N°</th>
        <th>Page<br />d'accueil</th>
        <th>Groupe</th>
        <th>Titre</th>
        <th>Url</th>
        <th>Active</th>
        <th>Ordre</th>
        <th>Menu</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><input type="checkbox" name="idStatic[]" value="001" /</td>
        <td>001</td>
        <td><input title="Définir en tant que page d'accueil" type="checkbox" name="homeStatic[]" value="001" /></td>
        <td><input id="id_001_group" name="001_group" type="text" maxlength="100" /></td>
        <td><input id="id_001_name" name="001_name" type="text" value="Statique 1" maxlength="255" /></td>
        <td><input id="id_001_url" name="001_url" type="text" value="statique-1" maxlength="255" /></td>
        <td><select id="id_001_active" name="001_active">
            <option value="1" selected="selected">Oui</option>
            <option value="0">Non</option>
          </select>
        </td>
        <td><input id="id_001_ordre" name="001_ordre" type="text" value="1" size="2" maxlength="3" /></td>
        <td><select id="id_001_menu" name="001_menu">
            <option value="oui" selected="selected">Afficher</option>
            <option value="non">Masquer</option>
          </select>
        </td>
        <td><a href="#" title="Éditer le code source de cette page">Éditer</a>&nbsp;&nbsp;<a href="#" title="Visualiser la page Statique 1 sur le site">Voir</a></td>
      </tr>
      <tr style="background:rgba(0,0,0,0.1)">
        <td><input type="checkbox" name="idStatic[]" value="002" /><input type="hidden" name="staticNum[]" value="002" /></td>
        <td>002</td>
        <td><input title="Définir en tant que page d'accueil" type="checkbox" name="homeStatic[]" value="002" /></td>
        <td><input id="id_002_group" name="002_group" type="text" value="test" maxlength="100" /></td>
        <td><input id="id_002_name" name="002_name" type="text" value="test" maxlength="255" /></td>
        <td><input id="id_002_url" name="002_url" type="text" value="test" maxlength="255" /></td>
        <td><select id="id_002_active" name="002_active">
            <option value="1" selected="selected">Oui</option>
            <option value="0">Non</option>
          </select>
        </td>
        <td><input id="id_002_ordre" name="002_ordre" type="text" value="2" size="2" maxlength="3" /></td>
        <td><select id="id_002_menu" name="002_menu">
            <option value="oui" selected="selected">Afficher</option>
            <option value="non">Masquer</option>
          </select>
        </td>
        <td><a href="#" title="Éditer le code source de cette page">Éditer</a>&nbsp;&nbsp;<a href="#" title="Visualiser la page test sur le site">Voir</a></td>
      </tr>
      <tr style="background:lightgreen">
        <td><input type="checkbox" name="idStatic[]" value="003" /><input type="hidden" name="staticNum[]" value="003" /></td>
        <td>003</td>
        <td><input title="Définir en tant que page d'accueil" type="checkbox" name="homeStatic[]" value="003" onclick="checkBox('3')" /></td>
        <td><input id="id_003_group" name="003_group" type="text" value="002sous-test" maxlength="100" /></td>
        <td><input id="id_003_name" name="003_name" type="text" value="sous test" maxlength="255" /></td>
        <td><input id="id_003_url" name="003_url" type="text" value="sous-test" maxlength="255" /></td>
        <td><select id="id_003_active" name="003_active">
            <option value="1" selected="selected">Oui</option>
            <option value="0">Non</option>
          </select>
        </td>
        <td><input id="id_003_ordre" name="003_ordre" type="text" value="3" size="2" maxlength="3" /></td>
        <td><select id="id_003_menu" name="003_menu">
            <option value="oui" selected="selected">Afficher</option>
            <option value="non">Masquer</option>
          </select>
        </td>
        <td><a href="#" title="Éditer le code source de cette page">Éditer</a>&nbsp;&nbsp;<a href="#" title="Visualiser la page sous test sur le site">Voir</a></td>
      </tr>
      <tr  style="background:lightgreen">
        <td><input type="checkbox" name="idStatic[]" value="005" /><input type="hidden" name="staticNum[]" value="005" /></td>
        <td>005</td>
        <td><input title="Définir en tant que page d'accueil" type="checkbox" name="homeStatic[]" value="005" /></td>
        <td><input id="id_005_group" name="005_group" type="text" value="002sous-test" maxlength="100" /></td>
        <td><input id="id_005_name" name="005_name" type="text" value="autre sous test" maxlength="255" /></td>
        <td><input id="id_005_url" name="005_url" type="text" value="autre-sous-test" maxlength="255" /></td>
        <td><select id="id_005_active" name="005_active">
            <option value="1" selected="selected">Oui</option>
            <option value="0">Non</option>
          </select>
        </td>
        <td><input id="id_005_ordre" name="005_ordre" type="text" value="4" size="2" maxlength="3" /></td>
        <td><select id="id_005_menu" name="005_menu">
            <option value="oui" selected="selected">Afficher</option>
            <option value="non">Masquer</option>
          </select>
        </td>
        <td><a href="#" title="Éditer le code source de cette page">Éditer</a>&nbsp;&nbsp;<a href="#" title="Visualiser la page yop sur le site">Voir</a></td>
      </tr>
      <tr  style="background:pink">
        <td><input type="checkbox" name="idStatic[]" value="004" /><input type="hidden" name="staticNum[]" value="004" /></td>
        <td>004</td>
        <td><input title="Définir en tant que page d'accueil" type="checkbox" name="homeStatic[]" value="004" /></td>
        <td><input id="id_004_group" name="004_group" type="text" value="001test" maxlength="100" /></td>
        <td><input id="id_004_name" name="004_name" type="text" value="retest" maxlength="255" /></td>
        <td><input id="id_004_url" name="004_url" type="text" value="retest" maxlength="255" /></td>
        <td><select id="id_004_active" name="004_active">
            <option value="1" selected="selected">Oui</option>
            <option value="0">Non</option>
          </select>
        </td>
        <td><input id="id_004_ordre" name="004_ordre" type="text" value="5" size="2" maxlength="3" /></td>
        <td><select id="id_004_menu" name="004_menu">
            <option value="oui" selected="selected">Afficher</option>
            <option value="non">Masquer</option>
          </select>
        </td>
        <td><a href="#" title="Éditer le code source de cette page">Éditer</a>&nbsp;&nbsp;<a href="#" title="Visualiser la page retest sur le site">Voir</a></td>
      </tr>
      <tr class="new">
        <td colspan="3">Nouvelle page</td>
        <td>
          <input type="hidden" name="staticNum[]" value="006" /><input id="id_006_group" name="006_group" type="text" maxlength="100" />
        </td>
        <td><input id="id_006_name" name="006_name" type="text" maxlength="255" /><input id="id_006_template" name="006_template" type="hidden" value="static.php" /></td>
        <td><input id="id_006_url" name="006_url" type="text" maxlength="255" /></td>
        <td><select id="id_006_active" name="006_active">
            <option value="1">Oui</option>
            <option value="0" selected="selected">Non</option>
          </select>
        </td>
        <td><input id="id_006_ordre" name="006_ordre" type="text" value="6" size="2" maxlength="3" /></td>
        <td><select id="id_006_menu" name="006_menu">
            <option value="oui">Afficher</option>
            <option value="non">Masquer</option>
          </select>
        </td>
        <td>&nbsp;</td>
      </tr>
    </tbody>
  </table>
  </div>
  <p>Résultats</p>
  <ol>
  <li class="alert blue">La page <b>Statique 1</b> s'affiche au menu en premier niveau de façon classique</li>
  <li class="alert blue">La page <b>test</b> s'affiche au menu en premier niveau de façon classique comme un groupe dépliable.</li>
  <li class="alert green">Les deux pages statiques dans le groupe <b><u>002</u>sous-test</b> seront affichées au menu dans le groupe sous-test qui sera lui même affiché comme sous groupe de test (identifiant:<b><u>002</u></b>).</li>
  <li class="alert red">La page statique rattachée au groupe <b><u>001</u>test</b> ne sera pas affichée au menu, car la page <b>statique 1</b> avec l'identifiant <b><u>001</u></b> n'a aucun groupe.</li>
  </ol>
  
  <h2>Configuration de l'affichage</h2>
  <p>L'affichage des sous groupes reprend le format par défaut des groupes de pages statiques. Voir la documentation Officielle <a href="https://wiki.pluxml.org/docs/develop/plxshow.html#staticlist">fonction staticList()</a>.</p>
  <p>Le format des sous groupes est modifiable depuis la page "configuration" du plugin.</p>  