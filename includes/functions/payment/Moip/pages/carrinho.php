<?php


$emailMoip = get_option('emailMoip');        
 
/* */   


$total = getPriceFormat($total);
$total = str_replace(',','',$total);
$total = str_replace('.','',$total);

$formulario .="

<form action='https://www.moip.com.br/PagamentoMoIP.do' name='moip' method='post'  > 
    
  

<input type='hidden' name='id_carteira' value='$emailMoip'>
 
<input type='hidden' name='valor' value='$total'>   

<input type='hidden' name='nome' value='".get_bloginfo('name')." $idPedido '> 

<input type='hidden' name='descricao' value='$descProdutos'> 


<input type='hidden' name='id_transacao' value='$idPedido'>    


<input type='hidden' name='frete' value='1'>   

<input type='hidden' name='peso_compra' value='$pesoTotal'>  
 
<INPUT type='hidden' name='pagador_nome' value='$current_user->user_firstname $current_user->user_lastname'>

<INPUT type='hidden' name='pagador_logradouro' value='$userEndereco'>   

<INPUT type='hidden' name='pagador_numero' value='$userNumero'>   
 
<INPUT type='hidden' name='pagador_complemento' value='$userComplemento'>              
 

<INPUT type='hidden' name='pagador_bairro' value='$userBairro'>      

<INPUT type='hidden' name='pagador_cidade' value='$userCidade'>
<INPUT type='hidden' name='pagador_estado' value='$userEstado'>
<INPUT type='hidden' name='pagador_cep' value='$userCep'> 

<INPUT type='hidden' name='pagador_email' value='$userEmail'>   

<INPUT type='hidden' name='pagador_telefone' value='$userDDD $userTelefone'>  

<INPUT type='hidden' name='pagador_celular' value='$userDDDCelular $userCelular'>  

<INPUT type='hidden' name='pagador_cpf' value='$userCpf'> 

<INPUT type='hidden' name='pagador_sexo' value='$userSexo'>   
 
<INPUT type='hidden' name='pagador_data_nascimento' value='$userNascimento'> 

<INPUT type='hidden' name='notify_url' value='".get_bloginfo('url')."/?cdp=$idPedido'> 
  
 <input type='image' name='submit' src='https://static.moip.com.br/imgs/buttons/bt_pagar_c01_e04.png' alt='Pagar com Moip' border='0' />


</form>
";  

 
?>
 