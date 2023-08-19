# mysubStatic
ajoute un niveau aux groupes de pages statique

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
        <td>☐</td>
        <td>001</td>
        <td>☐</td>
        <td></td>
        <td>Statique 1</td>
        <td>statique-1</td>
        <td><select id="id_001_active" name="001_active">
            <option value="1" selected="selected">Oui</option>
            <option value="0">Non</option>
          </select>
        </td>
        <td>1</td>
        <td><select id="id_001_menu" name="001_menu">
            <option value="oui" selected="selected">Afficher</option>
            <option value="non">Masquer</option>
          </select>
        </td>
        <td><a href="#" title="Éditer le code source de cette page">Éditer</a>&nbsp;&nbsp;<a href="#" title="Visualiser la page Statique 1 sur le site">Voir</a></td>
      </tr>
      <tr style="background:rgba(0,0,0,0.1)">
        <td>☐</td>
        <td>002</td>
        <td>☐</td>
        <td>test</td>
        <td>test</td>
        <td>test</td>
        <td><select id="id_002_active" name="002_active">
            <option value="1" selected="selected">Oui</option>
            <option value="0">Non</option>
          </select>
        </td>
        <td>2</td>
        <td><select id="id_002_menu" name="002_menu">
            <option value="oui" selected="selected">Afficher</option>
            <option value="non">Masquer</option>
          </select>
        </td>
        <td><a href="#" title="Éditer le code source de cette page">Éditer</a>&nbsp;&nbsp;<a href="#" title="Visualiser la page test sur le site">Voir</a></td>
      </tr>
      <tr style="background:lightgreen">
        <td>☐</td>
        <td>003</td>
        <td>☐</td>
        <td>002sous-test</td>
        <td>sous test</td>
        <td>sous-test</td>
        <td><select id="id_003_active" name="003_active">
            <option value="1" selected="selected">Oui</option>
            <option value="0">Non</option>
          </select>
        </td>
        <td>3</td>
        <td><select id="id_003_menu" name="003_menu">
            <option value="oui" selected="selected">Afficher</option>
            <option value="non">Masquer</option>
          </select>
        </td>
        <td><a href="#" title="Éditer le code source de cette page">Éditer</a>&nbsp;&nbsp;<a href="#" title="Visualiser la page sous test sur le site">Voir</a></td>
      </tr>
      <tr  style="background:lightgreen">
        <td>☐</td>
        <td>005</td>
        <td>☐</td>
        <td>002sous-test</td>
        <td>autre sous test</td>
        <td>autre-sous-test</td>
        <td><select id="id_005_active" name="005_active">
            <option value="1" selected="selected">Oui</option>
            <option value="0">Non</option>
          </select>
        </td>
        <td>4</td>
        <td><select id="id_005_menu" name="005_menu">
            <option value="oui" selected="selected">Afficher</option>
            <option value="non">Masquer</option>
          </select>
        </td>
        <td><a href="#" title="Éditer le code source de cette page">Éditer</a>&nbsp;&nbsp;<a href="#" title="Visualiser la page yop sur le site">Voir</a></td>
      </tr>
      <tr  style="background:pink">
        <td>☐</td>
        <td>004</td>
        <td>☐</td>
        <td>001test</td>
        <td>retest</td>
        <td>retest</td>
        <td><select id="id_004_active" name="004_active">
            <option value="1" selected="selected">Oui</option>
            <option value="0">Non</option>
          </select>
        </td>
        <td>5</td>
        <td><select id="id_004_menu" name="004_menu">
            <option value="oui" selected="selected">Afficher</option>
            <option value="non">Masquer</option>
          </select>
        </td>
        <td><a href="#" title="Éditer le code source de cette page">Éditer</a>&nbsp;&nbsp;<a href="#" title="Visualiser la page retest sur le site">Voir</a></td>
      </tr>
      <tr class="new">
        <td colspan="3">Nouvelle page</td>
        <td></td>
        <td></td>
        <td></td>
        <td><select id="id_006_active" name="006_active">
            <option value="1">Oui</option>
            <option value="0" selected="selected">Non</option>
          </select>
        </td>
        <td>6</td>
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
  <p>La structure produite ressemblera à:</p> 
  <pre>
* statique 1 ▼ test
               * test
               ▼ sous test
                * sous test
                * autre sous test</pre>
  
  <h2>Configuration de l'affichage</h2>
  <p>L'affichage des sous groupes reprend le format par défaut des groupes de pages statiques. Voir la documentation Officielle <a href="https://wiki.pluxml.org/docs/develop/plxshow.html#staticlist">fonction staticList()</a>.</p>
  <p>Le format des sous groupes est modifiable depuis la page "configuration" du plugin.</p>
