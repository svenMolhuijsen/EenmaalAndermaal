<?php

 $pagename = 'info';
include("php/core.php");
include("php/layout/header.php");
include("php/layout/breadcrumbs.php");
?>
<main class="row columns">
    <ul class="tabs" id="profieltabs" data-tabs>
        <li class="tabs-title is-active"><a href="#FAQ">FAQ</a></li>
        <li class="tabs-title"><a href="#Contact">Contact</a></li>
        <li class="tabs-title"><a href="#TermsOfService">Terms of Service</a></li>
        <li class="tabs-title"><a href="#About">About</a></li>
    </ul>

    <div class="tabs-content" data-tabs-content="profieltabs" data-active-collapse="true">
        <div class="tabs-panel" id="FAQ">
            <div class="row">
                <h4>Frequently Asked Questions: </h4>
                    <div class = "row columns">
                        <h5 class="columns"><a data-toggle="panelVeiling">Veiling</a></h5>
                        <div class="callout is-hidden columns" id="panelVeiling" data-toggler="is-hidden" data-animate>
                        <h6><strong>Hoe werkt een veiling?</strong></h6>
                        <p> Een veiling op EenmaalAndermaal wordt altijd gestart door een verkoper. Wanneer een veiling is geopend kunnen gebruikers daarop bieden. Diegene die het hoogste bod heeft als de veiling is geëindigd is de winnaar. Deze winnaar krijgt een mailtje toegestuurd met daarin gegevens van de verkoper. Nadat de mail is verzonden is het aan de verkoper en winnaar om afspraken te maken over de transactie en overhandiging. Hier speelt EenmaalAndermaal geen rol in.        </p>
                        <h6><strong>Kan ik zelf een veiling starten?</strong></h6>
                        <p>Als verkoper kan je zelf een veiling aanmaken. Op de homepage is een knop die leidt naar de pagina. Hier kan je alle gegevens die nodig zijn voor een veiling invullen. En jouw veiling naar wens aanpassen. </p>
                        <h6><strong>Hoe weet ik wanneer ik een veiling heb gewonnen?</strong></h6>
                        <p> Wanneer u het winnende bod heeft op een veiling krijgt u een mailtje 	binnen als bevestiging. In dit mailtje zijn ook de contactgegevens van de 	verkoper weergeven.</p>
                        <h6><strong>Moet ik mijn veiling verwijderen als die verlopen is?</strong></h6>
                        <p>Het is niet nodig om uw veiling te verwijderen als de einddatum is overschreden. Uw veiling blijft altijd bestaan, echter kan er uiteraard niet meer geboden worden op uw veiling als die al gesloten is. </p>
                        <h6><strong>Kan ik, als verkoper, de eindtijd van mijn veiling bepalen?</strong></h6>
                        <p>Ja, het is mogelijk om een eindtijd te bepalen van een veiling. Houd er 	rekening mee dat mensen sneller bieden als de einddatum dichtbij is. </p>
                        <h6><strong>Kan ik zien hoe vaak mijn veiling bekeken wordt?</strong></h6>
                        <p> Ja, je kan zien hoe vaak je veiling is bekeken. Op je ‘Profiel’ pagina heb je 	de mogelijkheid om je eigen veilingen te bekijken. </p>
                    </div>
                    </div>
                    <div class = "row columns">
                        <h5 class="columns"><a data-toggle="panelGegevens">Persoonsgegevens</a></h5>
                        <div class="callout is-hidden columns" id="panelGegevens" data-toggler="is-hidden" data-animate>
                        <h6><strong>Hoe kan ik mijn persoonsgegevens wijzigen?</strong></h6>
                        <p>Op de <a href = "profiel.php">Profiel</a> pagina kunt u uw gegevens inzien en wijzigen.</p>
                        <h6><strong>Hoe gaat EenmaalAndermaal om met mijn persoongegevens?</strong></h6>
                        <p>EenmaalAndermaal gaat zeer vertrouwelijk om met uw gegevens. Slechts een beperkte selectie van ons bedrijf heeft toegang tot uw gegevens. Voor meer informatie kunt u onze terms of service lezen of mail naar <a href="mailto:info@EenmaalAndermaal.nl">info@EenmaalAndermaal.nl</a></p>
                    </div>
                    </div>
                    <div class = "row columns">
                        <h5 class="columns"><a data-toggle="panelBieding">Biedingen</a></h5>
                        <div class="callout is-hidden columns" id="panelBieding" data-toggler="is-hidden" data-animate>
                            <h6><strong>Kan ik mijn bod annuleren als de veiling nog loopt?</strong></h6>
                            <p>Als je een bod hebt geplaatst terwijl je het daar toch niet eens mee bent is het helaas niet mogelijk om je bod terug te trekken. Echter zit je nergens aan vast. Je bent niet verplicht om te betalen als je het winnende bod hebt. De transactie gaat in overleg met de verkoper, daar kun je aangeven dat je van gedachten veranderd bent. Denk eraan dat het niet op prijs wordt gesteld.   </p>
                            <h6><strong>Is er een mogelijkheid om een winnend bod af te wijzen omdat ik de prijs te laag vindt?</strong></h6>
                            <p>Er is geen mogelijkheid om op EenmaalAndermaal een bod af te wijzen. Echter kan je wel in overleg met de bieder het bod afwijzen. Als je je product niet onder een bepaalde prijs wilt verkopen kan je een startprijs meegeven. Voor de bieders is het dan niet mogelijk om onder de startprijs te bieden. </p>
                            <h6><strong>Kan ik mijn lopende biedingen zien?</strong></h6>
                            <p>Je kan je lopende biedingen inzien op je <a href ="profiel.php">Profiel</a> pagina.</p>
                        </div>
                    </div>
                    <div class = "row columns">
                        <h5 class="columns"><a data-toggle="panelTransactie">Transacties</a></h5>
                        <div class="callout is-hidden columns" id="panelTransactie" data-toggler="is-hidden" data-animate>
                            <h6><strong>Speelt EenmaalAndermaal ook een rol bij de transactie en verzending van het product?</strong></h6>
                            <p>Nee, EenmaalAndermaal speelt geen rol bij de transactie of verzending van het product. Het is de bedoeling dat koper en verkoper zelf contact zoeken. Echter levert EenmaalAndermaal wel de contactgegevens. </p>
                        </div>
                    </div>
            </div>
        </div>
        <div class="tabs-panel" id="Contact">
            <div class="row">
                <h4>Contact: </h4>
                <p>Heeft u een vraag, opmerking of suggestie? U kunt ten alle tijden mailen naar:<a href ="#"> info@EenmaalAndermaal.nl</a>
                <br>
                Onze klantenservice zit elke dag tussen 8-21 uur voor u klaar.<br>
                Of bezoek onze vestiging:
                <br>
                Heyendaalseweg 98, 4de verdieping
                <br>
                Nijmegen, Gelderland
                </p>
            </div>
        </div>

    <div class="tabs-panel" id="TermsOfService">
        <div class="row columns">
            <h4>Terms of Service: </h4><br>
                <h6><strong>Inleiding</strong></h6>
                <p>Welkom bij EenmaalAndermaal. Door gebruik te maken van de services op de websites van EenmaalAndermaal (<a href="http://iproject34.icasites.nl/">EenmaalAndermaal.nl</a> en andere verwante websites waarop deze overeenkomst wordt weergegeven), ga je akkoord met de volgende voorwaarden van EenmaalAndermaal, inclusief de voorwaarden die via een hyperlink beschikbaar zijn, evenals de algemene regels van de websites van dochterondernemingen van EenmaalAndermaal. Als je in de Europese Unie woont of de hoofdzetel van je bedrijf is er gevestigd, heb je een overeenkomst met EenmaalAndermaal Europe S.à r.l. (Société à responsabilité limitée), 22-24 Boulevard Royal, L-2449 Luxembourg, R.C. B 120781, ondernemingsnummer 114463. Als je in de Verenigde Staten woont of de hoofdzetel van je bedrijf is er gevestigd, heb je een overeenkomst met EenmaalAndermaal Inc., 2145 Hamilton Ave, San Jose, CA 95125, USA. Als je in Canada woont of de hoofdzetel van je bedrijf er is gevestigd, heb je vanaf 1 juli 2017 een overeenkomst met EenmaalAndermaal Canada Limited, 500 King Street West, Suite 200, Toronto, ON M5V 1L9, Canada. Als je in het Verenigd Koninkrijk woont of de hoofdzetel van je bedrijf er is gevestigd, heb je vanaf 1 augustus 2017 een overeenkomst met EenmaalAndermaal (UK) Limited, 5 New Street Square, London, EC4A 3TW, United Kingdom. Als je in een ander land woont of de hoofdzetel van je bedrijf is er gevestigd, heb je een overeenkomst met EenmaalAndermaal International AG, Helvetiastrasse 15/17, CH-3005 Bern. Als je vragen hebt, kun je altijd onze Hulp-pagina’s raadplegen. </p>
                <p>Voordat je lid wordt van EenmaalAndermaal, moet je alle bepalingen en voorwaarden die in deze gebruikersovereenkomst en het privacybeleid staan of waarnaar we verwijzen in deze gebruikersovereenkomst of het privacybeleid, te lezen en te aanvaarden. Wij raden je ten zeerste aan niet alleen deze gebruikersovereenkomst te lezen, maar om ook de informatie die hieraan gelinkt is, te openen en te lezen. Als je niet akkoord gaat met ons beleid of specifieke bepalingen of voorwaarden, kun je onze sites en services niet gebruiken. Door deze gebruikersovereenkomst te aanvaarden, stem je ermee in dat het gebruik van bepaalde EenmaalAndermaal-websites of websites die we beheren, onderworpen kan zijn aan een andere gebruikersovereenkomst en een ander privacybeleid. De overeenkomst die van toepassing is op onze domeinen en subdomeinen is altijd de overeenkomst die wordt weergegeven in de voettekst van een website. </p>
                <p>Deze overeenkomst is van kracht vanaf 13 augustus 2008 voor bestaande gebruikers, en voor nieuwe gebruikers zodra ze deze aanvaard hebben.</p>
                <h6><strong>Gebruik van EenmaalAndermaal </strong></h6>
                <p>Wanneer je gebruikmaakt van EenmaalAndermaal, is het volgende <b>niet toegestaan</b>: </p>
                
                <ul>
                    <li><p>inhoud of objecten in verkeerde rubrieken of gedeeltes van onze sites en services plaatsen; </p></li>
                    <li><p>de wetten, rechten van derden, of ons beleid, zoals het beleid voor Verboden en beperkte objecten schenden; </p></li>
                    <li><p>gebruikmaken van onze sites en services als je geen wettelijk bindende contracten mag aangaan, jonger bent dan 18, of tijdelijk of voor onbepaalde duur bent geschorst wegens misbruik van onze sites; </p></li>
                    <li><p>niet betalen voor objecten die je hebt gekocht, tenzij de verkoper wezenlijke wijzigingen heeft aangebracht in de objectbeschrijving nadat je hebt geboden, er een duidelijke typfout is gemaakt, of je de identiteit van de verkoper niet kunt verifiëren; </p></li>
                    <li><p>objecten die bij je zijn gekocht niet leveren, tenzij de koper zich niet houdt aan de vastgelegde voorwaarden, of je de identiteit van de koper niet kunt verifiëren; </p></li>
                    <li><p>de prijs van een object manipuleren of aanbiedingen van andere gebruikers belemmeren; </p></li>
                    <li><p>onze kostenstructuur, het factureringsproces of kosten verschuldigd aan EenmaalAndermaal omzeilen of manipuleren; </p></li>
                    <li><p>valse, onnauwkeurige, misleidende, lasterlijke of smadelijke inhoud op EenmaalAndermaal plaatsen of persoonlijke gegevens op EenmaalAndermaal zetten; </p></li>
                    <li><p>handelingen uitvoeren die het feedback- of het beoordelingssysteem ondermijnen (zoals het weergeven, importeren of exporteren van feedbackgegevens buiten de sites of deze gebruiken voor doeleinden die niets te maken hebben met EenmaalAndermaal); </p></li>
                    <li><p>je EenmaalAndermaal-account (inclusief feedback) en gebruikersnaam zonder onze toestemming overdragen aan een andere partij; geen veiligheidsmaatregelen treffen om je wachtwoord te beschermen; gebruikmaken van EenmaalAndermaal met de gebruikersnaam of het wachtwoord van iemand anders, of iemand anders toestaan (rechtstreeks of onrechtstreeks) je gebruikersnaam of wachtwoord te gebruiken; </p></li>
                    <li><p>spam, kettingbrieven of piramidespelen versturen of op EenmaalAndermaal plaatsen; </p></li>
                    <li><p>virussen of andere technologieën verspreiden die schade kunnen toebrengen aan EenmaalAndermaal of aan de belangen of eigendom van EenmaalAndermaal-gebruikers; </p></li>
                    <li><p>inhoud van de sites en auteursrechten en handelsmerken van EenmaalAndermaal kopiëren, wijzigen of verspreiden; </p></li>
                    <li><p>informatie over gebruikers verkrijgen of verzamelen, inclusief e-mailadressen, zonder hun toestemming. </p></li>
                </ul>

                <h6><strong>Privacy</strong></h6>
                <p>Zonder je uitdrukkelijke toestemming verkopen of verhuren wij je persoonlijke gegevens niet aan derden voor hun marketingdoeleinden. Wij maken van je gegevens alleen gebruik op de manier die wordt beschreven in het EenmaalAndermaal-privacybeleid. Wij beschouwen de bescherming van de privacy van onze gebruikers als zeer belangrijk. Wij bewaren en verwerken je gegevens op onze computers in de Verenigde Staten. Deze zijn zowel fysiek als technologisch beveiligd. Door in te loggen op je account, kun je de gegevens die je ons verstrekt, oproepen en wijzigen en ervoor kiezen om bepaalde berichten niet te ontvangen. Wij doen beroep op derden om onze privacyregels te verifiëren en te certifiëren. Voor een volledige beschrijving van hoe wij je persoonsgegevens verwerken en beschermen, verwijzen wij naar het EenmaalAndermaal-privacybeleid. Als je bezwaar hebt tegen de daarin beschreven vormen van overdracht of gebruik van je persoonlijke gegevens, vragen wij je onze services niet te gebruiken. </p>
                <h6><strong>Algemeen</strong></h6>
                <p>Indien een bepaling van deze overeenkomst als ongeldig of onafdwingbaar wordt beschouwd, zal dergelijke bepaling niet meer van toepassing zijn, terwijl de resterende bepalingen van kracht blijven. Wij kunnen deze overeenkomst naar eigen goeddunken overdragen mits naleving van de bepalingen aangaande kennisgevingen. Titels zijn alleen ter referentie bedoeld en beperken in geen geval de reikwijdte van het betreffende artikel van deze Gebruikersovereenkomst. Wanneer wij nalaten te handelen naar aanleiding van een schending door jou of anderen, betekent dit niet dat wij ons recht verliezen te handelen naar aanleiding van volgende of gelijkaardige schendingen. Wij kunnen niet garanderen dat wij actie zullen ondernemen tegen alle schendingen van deze overeenkomst. </p>
                <p>Wij kunnen deze overeenkomst te allen tijde aanpassen door de aangepaste voorwaarden op deze site te plaatsen. Tenzij elders anders bepaald, worden alle aangepaste bepalingen 30 dagen nadat ze aanvankelijk zijn geplaatst automatisch van kracht. Wij houden je ook op de hoogte via ons berichtencentrum. Deze overeenkomst kan op geen enkele andere manier worden aangepast dan hiervoor beschreven, tenzij via een geschreven document dat zowel door jou als door ons is ondertekend. Als je niet akkoord gaat met de wijzigingen in ons beleid of in specifieke bepalingen of voorwaarden, kun je de overeenkomst ten alle tijde beëindigen door je account te sluiten. In deze overeenkomst worden alle afspraken en overeenkomsten tussen jou en ons met betrekking tot het voorwerp van de overeenkomst uiteengezet. De volgende onderdelen blijven ook na de beëindiging van deze overeenkomst gehandhaafd: Kosten en services (kosten die je verschuldigd bent voor het gebruik van onze services), Vrijwaring, Inhoudslicentie, Aansprakelijkheid, Schadeloosstelling en Geschillenbeslechting, en alle andere bepalingen die rederlijkerwijs deze Gebruikersovereenkomst dienen te overleven. </p>
            </div>
    </div>

    <div class="tabs-panel" id="About">
        <div class="row columns">
            <h4>About</h4>
            <h6><strong> About EenmaalAndermaal</strong></h6>
            </p>EenmaalAndermaal is een veilingsite waarop gebruikers hun voorwerpen ter verkoop aanbieden en anderen bij opbod die voorwerpen kunnen kopen. Het is opgericht door I-Concepts en ontwikkeld door eerstejaars HAN ICA studenten.</p>
            <h6><strong>About I-Concepts</strong></h6>
            <p>EenmaalAndermaal is een website van het bedrijf I-Concepts. I-Concepts is een nieuwe onderneming opgericht door Anton Mijnder. Anton Mijnder is de directeur van I-Concepts. I-Concepts is een bedrijf dat betrouwbaarheid hoog in het vaandel heeft staan. En wil graag concurreren met andere grote veilingsite’s.</p>
        </div>
    </div>
</main>

<?php
include("php/layout/footer.html")
?>
</body>
</html>
