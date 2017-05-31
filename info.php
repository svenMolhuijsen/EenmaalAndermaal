<?php
/**
 * Created by PhpStorm.
 * User: Lukev
 * Date: 31-5-2017
 * Time: 13:21
 */
include("php/core.php");
include("php/layout/header.php");
?>
<main class="row columns">
    <ul class="tabs" id="profieltabs" data-tabs>
        <li class="tabs-title is-active"><a href="#FAQ">FAQ</a></li>
        <li class="tabs-title"><a href="#Contact">Contact</a></li>
        <li class="tabs-title"><a href="#TermsOfService">Terms of Service</a></li>
    </ul>

    <div class="tabs-content" data-tabs-content="profieltabs" data-active-collapse="true">
        <div class="tabs-panel" id="FAQ">
            <div class="row">
                <h4>Frequently Asked Questions: </h4>
                    <div class = "row columns">
                        <h5 class="columns"><a data-toggle="panelVeiling">Veiling</a></h5>
                        <div class="callout is-hidden columns" id="panelVeiling" data-toggler="is-hidden" data-animate>
                        <p class="columns">Hoe werkt een veiling?</p>
                        <p class="columns" style="color: #f2552c"> Een veiling op EenmaalAndermaal wordt altijd gestart door een verkoper. Wanneer een veiling is geopend kunnen gebruikers daarop bieden. Diegene die het hoogste bod heeft als de veiling is geëindigd is de winnaar. Deze winnaar krijgt een mailtje toegestuurd met daarin gegevens van de verkoper. Nadat de mail is verzonden is het aan de verkoper en winnaar om afspraken te maken over de transactie en overhandiging. Hier speelt EenmaalAndermaal geen rol in.        </p>
                        <p class="columns">Kan ik zelf een veiling starten?</p>
                        <p class="columns" style="color: #f2552c">Als verkoper kan je zelf een veiling aanmaken. Op de homepage is een knop die lijdt naar de pagina. Hier kan je alle gegevens die nodig zijn voor een veiling invullen. En jouw veiling naar wens aanpassen. </p>
                        <p class="columns">Hoe weet ik wanneer ik een veiling heb gewonnen?</p>
                        <p class="columns" style="color: #f2552c"> Wanneer u het winnende bod heeft op een veiling krijgt u een mailtje 	binnen als bevestiging. In dit mailtje zijn ook de contactgegevens van de 	verkoper weergeven.</p>
                        <p class="columns">Moet ik mijn veiling verwijderen als die verlopen is?</p>
                        <p class="columns" style="color: #f2552c">Het is niet nodig om uw veiling te verwijderen als de einddatum is overschreden. Uw veiling blijft altijd bestaan, echter kan er uiteraard niet meer geboden worden op uw veiling als die al gesloten is. </p>
                        <p class="columns">Kan ik, als verkoper, de eindtijd van mijn veiling bepalen?</p>
                        <p class="columns" style="color: #f2552c">Ja, het is mogelijk om een eindtijd te bepalen van een veiling. Houd er 	rekening mee dat mensen sneller bieden als de einddatum dichtbij is. </p>
                        <p class="columns">Kan ik zien hoe vaak mijn veiling bekeken wordt?</p>
                        <p class="columns" style="color: #f2552c"> Ja, je kan zien hoe vaak je veiling is bekeken. Op je ‘Profiel’ pagina heb je 	de mogelijkheid om je eigen veilingen te bekijken. </p>
                    </div>
                    </div>
                    <div class = "row columns">
                        <h5 class="columns"><a data-toggle="panelGegevens">Persoonsgegevens</a></h5>
                        <div class="callout is-hidden columns" id="panelGegevens" data-toggler="is-hidden" data-animate>
                        <p class="columns">Hoe kan ik mijn persoonsgegevens wijzigen?</p>
                        <p class="columns" style="color: #f2552c">Op de <a href = profiel.php" style="color: #0a0a0a;" >Profiel</a> pagina kunt u uw gegevens inzien en wijzigen. </p>
                        <p class="columns">Hoe gaat EenmaalAndermaal om met mijn persoongegevens?</p>
                        <p class="columns" style="color: #f2552c">EenmaalAndermaal gaat zeer vertrouwelijk om met uw gegevens. 		Slechts een beperkte selectie van ons bedrijf heeft toegang tot uw 		gegevens. Voor meer informatie kunt u onze terms of service lezen of 	mail naar  EenmaalAndermaal@klantenservice.nl </p>
                    </div>
                    </div>
                    <div class = "row columns">
                        <h5 class="columns"><a data-toggle="panelBieding">Biedingen</a></h5>
                        <div class="callout is-hidden columns" id="panelBieding" data-toggler="is-hidden" data-animate>
                        <p class="columns">Kan ik mijn bod annuleren als de veiling nog loopt?</p>
                        <p class="columns" style="color: #f2552c">Als je een bod hebt geplaatst terwijl je het daar toch niet eens mee bent is het helaas niet mogelijk om je bod terug te trekken. Echter zit je nergens aan vast. Je bent niet verplicht om te betalen als je het winnende bod hebt. De transactie gaat in overleg met de verkoper, daar kun je aangeven dat je van gedachten veranderd bent. Denk eraan dat het niet op prijs wordt gesteld.   </p>
                        <p class="columns">Is er een mogelijkheid om een winnend bod af te wijzen omdat ik de prijs te laag vindt?</p>
                        <p class="columns" style="color: #f2552c">Er is geen mogelijkheid om op EenmaalAndermaal een bod af te wijzen. 	Echter kan je wel in overleg met de bieder het bod afwijzen. Als je je		product niet onder een bepaalde prijs wilt verkopen kan je een startprijs 	meegeven. Voor de bieders is het dan niet mogelijk om onder de 		startprijs te bieden. </p>
                        <p class="columns">Kan ik mijn lopende biedingen zien?	</p>
                        <p class="columns" style="color: #f2552c"> Je kan je lopende biedingen inzien op je <a href = profiel.php" style="color: #0a0a0a;" >Profiel</a> pagina.	</p>
                    </div>
                    </div>
                    <div class = "row columns">
                        <h5 class="columns"><a data-toggle="panelTransactie">Transacties</a></h5>
                        <div class="callout is-hidden columns" id="panelTransactie" data-toggler="is-hidden" data-animate>
                        <p class="columns">Speelt EenmaalAndermaal ook een rol bij de transactie en verzending 	van het product? </p>
                        <p class="columns" style="color: #f2552c">Nee, EenmaalAndermaal speelt geen rol bij de transactie of 			verzending van het product. Het is de bedoeling dat koper en 			verkoper zelf contact zoeken. Echter levert EenmaalAndermaal wel 		de contactgegevens. </p>
                    </div>
                    </div>
            </div>
        </div>
        <div class="tabs-panel" id="Contact">
                <div class="row">
                    <h4 class="columns">Contact: </h4>
                        <p class="columns">Heeft u een vraag, opmerking of suggestie? U kunt ten alle tijden mailen naar:
                            <a href =# style="color:#f2552c;"> EenmaalAndermaal@klantenservice.nl</a>
                            <br>
                            Onze klantenservice zit elke dag tussen 8-21 uur voor u klaar.
                        </p>
                        <p class="columns">
                            Of bezoek onze vestiging:
                            <br>
                            Heyendaal 98, 4de verdieping
                            <br>
                            Nijmegen, Gelderland


                        </p>
                </div>
            </div>

    <div class="tabs-panel" id="TermsOfService">
        <div class="row">
            <h4 class="columns" style="color: #f2552c">Terms of Service: </h4>
                <p class="columns">Op deze pagina vindt u de algemene voorwaarden van www.eenmaalandermaal.nl, zoals deze beschikbaar is gesteld door EenmaalAndermaal. In deze algemene voorwaarden geven wij aan onder welk voorbehoud wij de informatie op onze website aan u bieden. </p>
                <h6 class="columns"><strong> Intellectueel eigendom</strong></h6>
            <p class="columns"> Het gebruik van de informatie op deze website is gratis zolang u deze informatie niet kopieert, verspreidt of op een andere manier gebruikt of misbruikt. U mag de informatie op deze website alleen hergebruiken volgens de regelingen van het dwingend recht. </p>
            <p class="columns">Zonder uitdrukkelijke schriftelijke toestemming van EenmaalAndermaal is het niet toegestaan tekst, fotomateriaal of andere materialen op deze website te hergebruiken. Het intellectueel eigendom berust bij EenmaalAndermaal. </p>
             <h6 class="columns"><strong> Indien van toepassing:</strong></h6>
            <p class="columns"> Voor de prijzen die op onze website staan, geldt dat wij streven naar een zo zorgvuldig mogelijke weergave van de realiteit en de bedoelde prijzen. Fouten die daarbij ontstaan en herkenbaar zijn als programmeer dan wel typefouten, vormen nooit een aanleiding om een contract dan wel overeenkomst met EenmaalAndermaal te mogen claimen of te veronderstellen.</p>
            <p class="columns"> EenmaalAndermaal streeft naar een zo actueel mogelijke website. Mocht ondanks deze inspanningen de informatie van de inhoud op deze website onvolledig en of onjuist zijn, dan kunnen wij daarvoor geen aansprakelijkheid aanvaarden.</p>
            <p class="columns"> De informatie en/of producten op deze website worden aangeboden zonder enige vorm van garantie en/of aanspraak op juistheid. Wij behouden ons het recht voor om deze materialen te wijzigen, te verwijderen of opnieuw te plaatsen zonder enige voorafgaande mededeling. EenmaalAndermaal aanvaardt geen aansprakelijkheid voor enige informatie die op websites staan waarnaar wij via hyperlinks verwijzen.</p>
            <h6 class="columns"><strong> Wijzigingen</strong></h6>
            <p class="columns"> Mochten deze algemene voorwaarden wijzigen, dan vindt u de meest recente versie van de disclaimer van www.eenmaalandermaal.nl op deze pagina.</p>

        </div>
    </div>
    </div>
</main>




<?php
include("php/layout/footer.html")
?>
</body>
</html>
