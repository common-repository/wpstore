<select id="selectUserAddress"> 
<option value='0' >Escolha o Endereço</option>  
<?php 
$contAddress = 0;   
$addrCob = get_id_addr_cobranca(); 
foreach ( $userAddress as $address ){
    $contAddress +=1;     
?>
           <option value='<?php echo $address->id; ?>'  <?php if($addrCob==$address->id){ echo "SELECTED"; }; ?>  ><?php echo $address->nomeEndereco; ?></option>   
           
<?php    };  ?>  
<?php if($contAddress==0){ ?>  
<?php    };  ?>        
</select>  

