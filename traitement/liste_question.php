<?php 
$error = "";
    If (isset($_POST['submit'])) {
        If( $_POST['nb-qts'] <5) $error = "Le nombre de qustion doit être >= & 5";
         else {
            $data = file_get_contents('fichierJson/parametre.json');
             $newdata= json_decode($data,true);  
             // On ajoute le nouvel élement
                 $newdata[0]['nb-qts']= $_POST['nb-qts'];
                // On réencode en JSON
                $newdata = json_encode($newdata); 
                // // On stocke tout le JSON
                file_put_contents('fichierJson/parametre.json', $newdata);
                // return "Votre question  a bien été enregistrée"; 
           }
    }
 $data = getDatas($file = "Question");
 $nbqts = getDatas($file = "parametre");
?> 
    <div class="les-questions" id="les-questions">
        <div class="nb-quest"> 
            <form action="" method="post" id="form-nb">
                <span class="nb-q_jeu">Nombre de question/jeu</span>
                <input type="number" name="nb-qts" id="nb-qts" value="<?= isset($nbqts['nb-qts']),$nbqts[0]['nb-qts']?>">
                <input type="submit" name="submit" value="OK">
                <span id="errore" style="color:red; display:block; margin-top:5px"><?= !empty($error)? $error:"";?></span>
            </form>
        </div> 

        <div class="affichage-qt" id="affichage-qt">

           <?php  
//affichage 
            
            $pageCourant ='';
            $parPage='';
            if(isset($data))
            {
                $total=sizeof($data);
                $parPage= 5;
                $start= 0;
                $total_page= ceil($total/$parPage); 
                if(isset($_GET['listequ'])){ // Si la variable $_GET['page'] existe...
                    $pageCourant=intval($_GET['listequ']);   

                    if($pageCourant>$total_page){ // Si la valeur de $pageCourant (le numéro de la page) est plus grande que $total_page...
                        $pageCourant=$total_page;
                    }
                }else{ // Sinon
                    $pageCourant=1; // La page actuelle est la n°1    
                } 

                $start= (($pageCourant-1)*$parPage);
                // echo $start;
                //affichage de la liste des joueur
              
               // echo count($data[0]['reponse']);
                    for ($i=$start; $i <$start+$parPage; $i++) {
                     
                        for($j = $i ; $j<=$i ; $j++){
                            if(isset($data[$j])){
                                echo "<h3 class=lq_h3>".($j+1)."  ".$data[$j]['question']."</h3>";
                                if($data[$j]['choix']=='choix_multis'){
                                    for($k = 0; $k<count($data[$j]['reponse']);$k++){
                                        if("on_".$k===$data[$j]['correcte'][$k])
                                          echo "<div><input type =checkbox name=box_$k checked>"."<span>".$data[$j]['reponse'][$k]."</span></div>";
                                        else
                                          echo "<div><input type =checkbox name=box_$k  >"."<span>".$data[$j]['reponse'][$k]."</span></div>";
                                     }
                                }
                                if($data[$j]['choix']=='choix_simple'){
                                    for($k = 0; $k<count($data[$j]['reponse']);$k++){
                                        if("on_".$k===$data[$j]['correcte'][$k])
                                          echo "<div><input type =radio name=on_$j checked>"."<span>".$data[$j]['reponse'][$k]."</span></div>";
                                        else
                                          echo "<div><input type =radio name=on_$j >"."<span>".$data[$j]['reponse'][$k]."</span></div>";
                                     }
                                }elseif($data[$j]['choix']==='choix_text')
                                    echo "<div><textarea disabled>".$data[$j]['reponse'][0]."</textarea><br></div>";
                            }
                         }
                   }          
        ?>
        </div>
        <?php
//pagination
      echo "<div class=\"btn-suiv-prec-q\">";
        if($pageCourant>1){
            $precedent=$pageCourant-1;
            echo'<a class="btn-prec btn-prec-j" href="?page=admin&menu=listequestion&listequ='.$precedent.'">precedent</a>';    
                }  
        if($pageCourant<$total_page){
            $suivant= $pageCourant+1;
             echo'<a class="btn-suiv btn-suiv-j" href="?page=admin&menu=listequestion&listequ='.$suivant.'">suivant</a>';   
                }else   
             echo'<a class="btn-suiv btn-suiv-j" href="#" >suivant</a>';

     echo "</div>";
    }
    ?>  
 
    </div>
    
<script>
    document.getElementById('form-nb').addEventListener('submit',function(e){
        const nbqts= document.getElementById('nb-qts')
        const errore= document.getElementById('errore')
        var err = false
       if(nbqts.value < 5){
           nbqts.style.border= "1px solid red"
           nbqts.style.outline= "none"
           err = true
       }
       if(nbqts.value < 5){
          errore.innerHTML= "Le nombre de qustion doit être >= & 5"
          err = true
       }
       if(nbqts.value ==''){
          errore.innerHTML= "Saisir le nbre question et valider"
          err = true
       }
       nbqts.addEventListener('focus',function(e){
        errore.innerText = ""
       nbqts.innerText = ""
       nbqts.style.border= "1px solid black"
       })
       if(err)
       e.preventDefault();
       return 0
    })
</script>


