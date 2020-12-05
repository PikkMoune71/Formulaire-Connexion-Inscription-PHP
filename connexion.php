<!-- Création du "Container" permettant la connexxion -->
<div class="header">
    <main>
        <br/>
        <section class="connect-container">
            <div class="connexion-login">
                <h1>Connexion</h1>
                <form method="POST">
                    <div class="formulaire-lname">
                        <input type="text" name="lpseudo" autocomplete="off" required/>
                        <label for="lpseudo" class="label-name">
                            <span class="lpseudo-name">Pseudo *</span>
                        </label>
                    </div>
                    <div class="formulaire-lpassword">
                        <input type="password" name="lpassword" minlength="8" autocomplete="off" required/>
                        <label for="lpassword" class="label-name">
                            <span class="lpseudo-name">Mot de Passe *</span>
                        </label>
                    </div>
                    <input class="btnco" type="submit" value="Connexion" name="formlogin" id="formlogin">
                </form>
                <p>Vous n'avez pas de compte ? <a class="create-account" href="signup.php">Créer un compte</a></p>
                <?php
                if(isset($_POST['formlogin'])) 
                {
                    extract($_POST);

                    include 'database.php';
                    global $db;

                    if(!empty($lpseudo) && !empty($lpassword)) 
                    {
                        $q = $db->prepare("SELECT * FROM utilisateur WHERE Pseudo = '$lpseudo'");
                        $q->execute(['Pseudo' => $lpseudo]);
                        $result = $q->fetch();

                        
                        if($result == true) 
                        {                                
                            //Le compte existe bien 
                            $hashpassword = $result['Mdp'];
                        
                            if(password_verify($lpassword, $result['Mdp'])) {
                                session_start();
                                $_SESSION['Pseudo'] = $result['Pseudo'];
                                $_SESSION['Mdp'] = $result['Mdp'];
                                $_SESSION['IdUti'] = $result['IdUti'];
                                $_SESSION['NumRole'] = $result['NumRole'];

                                header('Location: ../Index.php?id='.$_SESSION['IdUti']);
                                exit();
                            } else {
                                echo '<h2>Mot de passe Inccorect.</h2>';
                            }
                        } else {
                            echo '<h2>' .$lpseudo. ' n\'existe pas.</h2>';
                        }
                    } else {
                        echo '<h2>Champs Incomplets</h2>';
                    }
                }
                ?>
            </div>
        </section>
    </main>
</div>