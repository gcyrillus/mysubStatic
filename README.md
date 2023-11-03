# mysubStatic
ajoute un niveau aux groupes de pages statique

<h2>Configuration d'un sous groupe</h2>
<p>Un nom de groupe de page statique peut-être utilisé comme un groupe parent.</p>
<p>Pour cela, votre nouvelle page statique doit avoir un nom de groupe prefixé avec l'identifiant d'une page statique ayant un  nom de groupe</p>
<p>Par Exemples</p>
<img src="https://github.com/gcyrillus/mySubStatic/blob/V.3.0/img/revisited-group-statiques.png?raw=true">
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
                * page de test 3</pre>
  
  <h2>Configuration et options de l'affichage</h2>
  <h3>configuration</h3>
  <p>Un <b>WIZARD</b> s'affiche à l'activation duu plugin pour vous le présenter et vous suggérer votre premiere configuration.</p>
  <p>Vous pouvez appeler le <b>WIZARD</b> à tout moment depuis la page de configuration du plugin.</p>
  <p>L'affichage des sous groupes reprend le format par défaut des groupes de pages statiques. Voir la documentation Officielle <a href="https://wiki.pluxml.org/docs/develop/plxshow.html#staticlist">fonction staticList()</a>.</p>
  <p>Le format des sous groupes est modifiable depuis la page "configuration" du plugin.</p>
  <h3>options</h3>
  <ol>
    <li>Affichage d'un fil d'ariane pour les pages d'un groupe</li>
    <li>Affichage des liens entre pages de même groupe <sub>(même niveau)</sub></li>
  </ol>
<h3>Options avançées</h3>
<p>Le code généré par le plugin reflete la structure HTML du thème par défaut de PluXml.</p>
<p>Il est tout à fait possible de changer cela à l'aide d'expressions régulieres.</p>
<p>Voici celles utilisées par le plugin, elles sont modifiables et peuvent-être complétées:</p>
<img src="https://github.com/gcyrillus/mySubStatic/blob/V.3.0/img/pregRAZ.png?raw=true">
<p>Vous pouvez les modifier, en ajouter en retirer.</p> 
<p>Pour retrouver la configuration par défaut de ces regex, un clique sur le bouton réinitialisé remet tout en ordre.</p>
<p>Cdt <q>GC</q></p>
