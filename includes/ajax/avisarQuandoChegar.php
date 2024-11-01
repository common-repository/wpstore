<?php

   require("../../../../../wp-load.php");
   $nomeAviso = $_REQUEST['nomeAvisoR'];
   $emailAviso = $_REQUEST['emailAvisoR'];
   $telefoneAviso = $_REQUEST['telAvisoR'];
   $postIDP = $_REQUEST['postIDPR'];
   $variacaoCorP = $_REQUEST['variacaoCorPR'];
   $variacaoTamanhoP = $_REQUEST['variacaoTamanhoPR'];
   gravarSolicitacaoContato($nomeAviso,$emailAviso,$telefoneAviso,$postIDP,$variacaoCorP,$variacaoTamanhoP);
               
?>