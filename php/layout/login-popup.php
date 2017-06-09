<div class="signin-register-modal row-expanded"> <!-- this is the entire modal form, including the background -->
    <div class="container small-10 medium-5 small-centered column"> <!-- this is the container wrapper -->
        <div class="switcher row">
            <div class="small-6 column signin active"><a href="#">Inloggen</a></div>
            <div class="small-6 column register"><a href="#">Nieuw account</a></div>
        </div>

        <!-- log in form -->
        <div id="login">
            <form id="loginForm" class="form small-12 column">
                <label class="signin-username" for="signin-username">Gebruikersnaam</label>
                <input class="full-width has-padding has-border signin-username" name="email" id="signin-username" type="text" placeholder="xX_JoHn.DoE1337_Xx" required>

                <!-- Password -->
                <label class="signin-password" for="signin-password">Password</label>
                <input class="full-width has-padding has-border signin-password" id="signin-password" name="password" type="password"
                       placeholder="*******" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" required>
                <br>
                <button class="button hollow float-left reset">Wachtwoord vergeten?</button>
                <input class="button float-right" type="submit" value="Login">
            </form>
        </div>

        <!-- sign up form -->
        <div id="register">
            <form id="registerForm" class="form small-12 column">
                <div class="row">
                    <!-- Voornaam -->
                    <div class="small-6 column">
                        <label class="register-first-name" for="register-first-name">Voornaam</label>
                        <input id="register-first-name" name="voornaam" type="text" placeholder="John" pattern="[a-zA-Z-' ]+">
                    </div>

                    <!-- Achternaam-->
                    <div class="small-6 column">
                        <label class="register-last-name" for="register-last-name">Achternaam</label>
                        <input id="register-last-name" name="achternaam" type="text" placeholder="Doe" pattern="[a-zA-Z-' ]+">
                    </div>
                </div>

                <!-- Geboortedatum -->
                <label class="register-birth-date" for="register-birth-date">Geboortedatum</label>
                <input id="register-birth-date" name="gebdate" type="date" placeholder="2017-01-01" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" />

                <div class="row">

                    <!-- Straatnaam -->
                    <div class="small-4 column">
                        <label class="register-streetname" for="register-streetname">Straatnaam</label>
                        <input id="register-streetname" name="straatnaam" type="text" placeholder="Lindenlaan" pattern="[a-zA-Z-' ]+">
                    </div>

                    <!-- Huisnummer -->
                    <div class="small-4 column">
                        <label class="register-no" for="register-no">Huisnummer</label>
                        <input id="register-no" name="huisnummer" type="text" placeholder="1" pattern="^[1-9][0-9]*[a-zA-Z]?">
                    </div>

                    <!-- Postcode -->
                    <div class="small-4 column">
                        <label class="register-zip" for="register-zip">Postcode</label>
                        <input id="register-zip" name="postcode" type="text" placeholder="1234 AB" pattern="^[1-9][0-9]*[a-zA-z- ]*">
                    </div>

                </div>
                <div class="row">

                    <!-- Land -->
                    <div class="small-6 column">
                        <label class="register-country" for="register-country">Land</label>
                        <select name="land" id="register-country" required>
                            <option selected disabled value="">Kies een land</option>
                            <?php
                            //Haal alle landen uit de databse
                            $landen = executeQuery("SELECT * FROM landen");
                            if ($landen['code'] == 0) {
                                foreach ($landen['data'] as $land) {
                                    echo('<option value="'.$land['gba_code'].'">'.$land['land'].'</option>');
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Provincie -->
                    <div class="small-6 column">
                        <label class="register-province" for="register-province">Provincie</label>
                        <input id="register-province" name="provincie" type="text" placeholder="Noord-Brabant" pattern="[a-zA-Z-]+">
                    </div>
                </div>

                <div class="row">

                    <!-- Plaatsnaam -->
                    <div class="small-6 column">
                        <label class="register-city" for="register-city">Plaatsnaam</label>
                        <input id="register-city" name="plaats" type="text" placeholder="Deurne" pattern="[a-zA-Z- ]+">
                    </div>

                    <!-- Telefoonnummer -->
                    <div class="small-6 column">
                        <label class="register-tel" for="register-tel">Telefoonnr</label>
                        <input id="register-tel" name="tel" type="text" placeholder="+31012345678" pattern="^\+?[0-9() ]+">
                    </div>
                </div>

                <!-- Gebruikersnaam -->
                <label class="register-username" for="register-email">Gebruikersnaam</label>
                <input id="register-username" type="text" name="gebruikersnaam" placeholder="xX_JoHn.DoE1337_Xx" required>

                <!-- Wachtwoord-->
                <label class="password" for="register-password">Wachtwoord</label>
                <input id="register-password" name="register-password" type="password" placeholder="*******"
                pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" required>
                <label id="passwordWarning">Minimaal 1 letter, hoofdletter en cijfer.</label>

                <!-- Wachtwoord herhalen-->
                <label class="password" for="register-repeat-password">Herhaal wachtwoord</label>
                <input id="register-repeat-password" name="repeat-password" type="password"
                placeholder="*******" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" required>
                <br>

                <input id="registreer" class="button float-right" type="submit" value="Registreer">
            </form>
        </div>

        <!-- Reset password form -->
        <div id="reset">
            <form id="resetForm" class="form small-12 column">
                <br>
                <p>Voer je gebruikersnaam in en we zullen een herstellink toesturen</p>

                <!-- Email-->
                <label class="reset-username" for="reset-username">Gebruikersnaam</label>
                <input id="reset-username" type="text" placeholder="xX_JoHn.DoE1337_Xx" required>
                <br>

                <input class="button float-right" type="submit" value="Verstuur" id="resetPassword">
            </form>
        </div>
    </div> <!-- user-modal-container -->
</div>