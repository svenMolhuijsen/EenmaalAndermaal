<div class="signin-register-modal row-expanded"> <!-- this is the entire modal form, including the background -->
    <div class="container small-10 medium-5 small-centered column"> <!-- this is the container wrapper -->
        <div class="switcher row">
            <div class="small-6 column signin active"><a href="#">Inloggen</a></div>
            <div class="small-6 column register"><a href="#">Nieuw account</a></div>
        </div>

        <!-- log in form -->
        <div id="login">
            <form id="loginForm" class="form small-12 column">
                <label class="email" for="signin-email">E-mail</label>
                <input class="full-width has-padding has-border" id="signin-email" type="email" placeholder="a@b.com">

                <!-- Password -->
                <label class=" password" for="signin-password">Password</label>
                <input class="full-width has-padding has-border" id="signin-password" type="password"
                       placeholder="*******" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$">
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
                        <input id="register-first-name" type="text" placeholder="John" pattern="[a-zA-Z]+" required>
                    </div>

                    <!-- Achternaam-->
                    <div class="small-6 column">
                        <label class="register-last-name" for="register-last-name">Achternaam</label>
                        <input id="register-last-name" type="text" placeholder="Doe" pattern="[a-zA-Z]+" required>
                    </div>
                </div>

                <!-- Geboortedatum -->
                <label class="register-birth-date" for="register-birth-date">Geboortedatum</label>
                <input id="register-birth-date" type="date" value="2017-01-01" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" required>

                <div class="row">

                    <!-- Straatnaam -->
                    <div class="small-4 column">
                        <label class="register-streetname" for="register-streetname">Straatnaam</label>
                        <input id="register-streetname" type="text" placeholder="Lindenlaan" pattern="[a-zA-Z]+" required>
                    </div>

                    <!-- Huisnummer -->
                    <div class="small-2 column">
                        <label class="register-nr" for="register-nr">Huisnummer</label>
                        <input id="register-no" type="number" placeholder="1" min="1" pattern="[0-9]+" required>
                    </div>

                    <!-- Postcode -->
                    <div class="small-2 column">
                        <label class="register-zip" for="register-zip">Postcode</label>
                        <input id="register-zip" type="text" placeholder="1234 AB" pattern="[1-9][0-9]{3}\s?[a-zA-Z]{2}" required>
                    </div>

                    <!-- Plaatsnaam -->
                    <div class="small-4 column">
                        <label class="register-city" for="register-city">Plaatsnaam</label>
                        <input id="register-city" type="text" placeholder="Doe" pattern="[a-zA-Z]+" required>
                    </div>
                </div>

                <div class="row">

                    <!-- Land -->
                    <div class="small-6 column">
                        <label class="register-country" for="register-country">Land</label>
                        <select name="Land" id="register-country" required>
                            <option value="NL">Nederland</option>
                            <option value="BE">België/Belgique</option>
                            <option value="DE">Deutschland</option>
                        </select>
                    </div>

                    <!-- Telefoonnummer -->
                    <div class="small-6 column">
                        <label class="register-tel" for="register-tel">Telefoonnr</label>
                        <input id="register-tel" type="text" placeholder="+31012345678" pattern="[\+][0-9()]+" required>
                    </div>
                </div>

                <!-- Email-->
                <label class="register-email" for="register-email">E-mail</label>
                <input id="register-email" type="email" placeholder="a@b.com" required>

                <!-- Wachtwoord-->
                <label class=" password" for="register-password">Wachtwoord</label>
                <input id="register-password" type="password" placeholder="*******"
                pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" required>

                <!-- Wachtwoord herhalen-->
                <label class=" password" for="register-repeat-password">Herhaal wachtwoord</label>
                <input id="register-repeat-password" type="password"
                placeholder="*******" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" required>
                <br>

                <input class="button float-right" type="submit" value="Registreer" rel="registerForm">
            </form>
        </div>

        <!-- Reset password form -->
        <div id="reset">
            <form id="resetForm" class="form small-12 column">
                <br>
                <p>Voer je mail in en we zullen een herstellink toesturen</p>

                <!-- Email-->
                <label class="reset-email" for="reset-email">E-mail</label>
                <input id="reset-email" type="email" placeholder="wachtwoord@vergeten.com" required>
                <br>

                <input class="button float-right" type="submit" value="Verstuur">
            </form>
        </div>
    </div> <!-- user-modal-container -->
</div>