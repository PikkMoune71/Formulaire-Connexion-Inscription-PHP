<!-- Création du "Container" permettant l'inscription -->
<div class="header">
    <main>
        <br/>
        <section class="register-container">
            <div class="inscription-register">
                <h1>Enregistre un compte</h1>
                <form  method="post">
                <div class="forms-top">
                    <input class="inscription" type="text" id="pseudo" name="pseudo" maxlength="15" required placeholder="Votre Pseudo (15 caractères max)" >
                    <input class="inscription" type="text" id="nom" name="nom" required placeholder="Votre Nom" >

                    <input class="inscription" type="text" id="prenom" name="prenom" required placeholder="Votre Prénom" >

                    <input class="inscription" type="email" id="email" name="email" minlength="8" required placeholder="Votre Email">
                    <input class="inscription" type="text" id="adresse" name="adresse" required placeholder="Votre adresse" >

                    <input class="inscription" type="text" id="cp" name="cp" required placeholder="Code Postale" >
                    <input class="inscription" type="text" id="ville" name="ville" required placeholder="Ville" >
                    <input class="inscription" type="tel" id="tel" name="tel" required placeholder="N°téléphone" >

                    <input class="inscription" type="password" id="password" name="passwords" minlength="8" required placeholder="Votre mot de passe (8 caractères min)">
                    <input class="inscription" type="password" id="cpassword" name="cpassword" minlength="8" required placeholder="Comfirmer votre mot de passe (8 caractères min)">
                    <br />
                    <input type='checkbox' name='case' class="general-condition" value='on' required> J'ai lu et j'accepte <a target="_blank" href="#">les conditions générales d'utilisation</a>  
                    
                    <input class="create" name="submit" type="submit" value="Créer votre compte">
                    

                    <p>Vous avez déjà un compte ? <a class="log-account" href="login.php">Se connecter</a></p>
                </div>
            </form>
            <?php
            // Extraction du formulaire d'inscription avce la méthode $_POST
            if(isset($_POST['submit'])){
                
                extract($_POST);
        
                //Cryptage du mot de passe en hashpass
                if(!empty($passwords) && !empty($cpassword) && !empty($email)) {
                    if($passwords == $cpassword) {
                        $options = [
                            'cost' => 12,
                        ];
                
                        $hashpass = password_hash($passwords, PASSWORD_BCRYPT, $options);
                
                        //BDD
                        include 'database.php';
                        global $db;
                
                        //Prépartion de la requête 
                        $c = $db->prepare("SELECT Mail FROM utilisateur WHERE Mail= '$email'");
                        $c->execute(['Mail' => $email]);
                        $result = $c->rowCount();
                
                        if($result == 0) {
                            $q = $db->prepare("INSERT INTO utilisateur(NumRole, Nom, Prenom, Mdp, Mail, Tel, Adresse, CP, Ville, Pseudo) VALUES(0, '$nom','$prenom','$hashpass','$email','$tel','$adresse','$cp','$ville','$pseudo')");
                            $q->execute([
                            'Mail' => $email,
                            'Mdp' => $hashpass
                            ]);
                            echo '<div class="">';
                            echo '<h1 class="">Inscription validée !</h1>';
                            echo '</div>';
                        } else {
                            echo '<div class="">';
                            echo '<h1 class="">Email déjà utilisé.</h1>';
                            echo '</div>';
                        }
                    }
                }
            }
            ?>
            </div>
        </section>
    </main>
</div>
