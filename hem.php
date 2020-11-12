<?php
include("incl/multipage.php");
$title = "Hemsida";
include("incl/header.php");
$dsn = $databases[$_SESSION['database']];
$db = connectToDatabase($dsn);
?>
<main>
    <article  class="all-browsers">
        <header>
            <h1>Välkommen till Nättraby Vägmuseum</h1>
        </header>
        <blockquote class="otro-blockquote">
            Världens första friluftsmuseum för vägarnas historia på land, räls, vatten och is.
        </blockquote>
        <div class="content-left">
            GPS N56.20783° E15.53065°
            <figure>
                <img src="img/500/14_stenbron.jpg" alt="Stenbron">
                <figcaption>
                    Kustvägens tvåvalviga stenbro över Nättrabyån uppfördes i början av 1800-talet
                    (exakt årtal saknas) då den ersatte en träbro på samma plats.
                    Stenbron togs ur bruk 1934 då biltrafiken hunnit bli för omfattande.
                    Idag är bron klassad som kulturminne och skyddad enligt lag.
                    Foto: Peter Öjerskog, 2008.
                </figcaption>
            </figure>
        </div>
    </article>
    <article  class="all-browsers wide-padding">
        <header>
            <h1>Historia</h1>
        </header>
        <p>Nättraby Hembygdsförening i Blekinge har tillsammans med intressenter skapat Nättraby Vägmuseum – världens första friluftsmuseum för vägarnas historia på land, räls, vatten och is.</p>
        <p>I Nättraby väster om Karlskrona finns nämligen en unik koncentration av gamla och nya landvägar, järnvägar och segelbara Nättrabyån.</p>
        <p>Redan 1995 kläckte journalisten Peter Öjerskog från Karlskrona idén om ett vägmuseum i det fria i Nättraby. Förslaget mottogs positivt men det omfattande arbetet med att göra Karlskrona till marint världsarv kom emellan.</p>
        <p>2006 kontaktade Nättraby Hembygdsförening med ordförande Ingegerd Holm i spetsen återigen Peter Öjerskog. En styrgrupp och en referensgrupp bildades för Nättraby Vägmuseum. Huvudintressenter är Nättraby Hembygdsförening, Karlskrona kommun, Vägverket, länsstyrelsen i Blekinge och Blekinge Museum.</p>
        <p>Nättraby Vägmuseum är ett friluftsmuseum där befintliga vägmiljöer används. Den informella rastplatsen vid E22 avfart 61 till Nättraby används som centralplats för vägmuseet.</p>
        <p>Nättraby Vägmuseum består av 14 utvalda vägmiljöer i Nättraby socken. Vägmiljöerna är:</p>
        <ul>
            <li>01 Hålvägen – stigen</li>
            <li>02 Via Regia – landsvägen</li>
            <li>03 Värendsvägen – handelsvägen</li>
            <li>04 Skillinge – övergivna vägen</li>
            <li>05 Milstolparna – vägmärkena</li>
            <li>06 Ryttarliden – namnminnet</li>
            <li>07 Riks 4 – gatstensvägen</li>
            <li>08 E22 – motorvägen</li>
            <li>09 Cykelvägen – bilfria vägen</li>
            <li>10 Kustbanan – järnvägen</li>
            <li>11 Krösnabanan – smalspåret</li>
            <li>12 Nättrabyån – vattenvägen</li>
            <li>13 Isvägen – vintervägen</li>
            <li>14 Stenbron – vägen över vatten</li>
        </ul>
        <p>Även om Blekinge alltid betraktats som ett randområde av först Danmark och från 1658 Sverige så låg landskapet välbekant mitt vid sjövägen mellan danernas och svearnas centralområden. Den 2500-åriga kustlandsvägen genom Blekinge har också alltid varit viktig för handel, kyrkan och militären.</p>
        <p>Stigar och vägar, vattenvägar och vintervägar har funnits lika länge som människan. Ända fram till 1500-talet fanns egentligen bara stigar på land i Skandinavien. Först Christian IV och sedan Karl XI beordrade att Blekinges kuststig skulle breddas till vagnväg.</p>
        <p>Ända fram till järnvägens revolution under andra halvan av 1800-talet var det faktiskt sjövägarna och vintervägarna som dominerade. Med bilens och motorcykelns intåg på 1900-talet utvecklades landvägarna mer än under hela sin tidigare historia.</p>
        <p>Information om Nättraby Vägmuseum finns än så länge enbart digitalt på sajten http://www.nattrabyvagmuseum.se. Där finns också GPS-koordinater angivna till de 14 utvalda vägmiljöerna. Men arbete pågår nu med att också skapa ett fysiskt vägmuseum med informationsskyltar på plats.</p>
        <p>Vägverket Region Sydöst har bekostat en nytänkande förslagskiss på paviljonger, skyltar och parkering för Nättraby Vägmuseum som utarbetats av landskapsarkitekt Peter Bergholm, och som förhoppningsvis ska bli verklighet i framtiden.</p>
        <p>Infoskyltar sätts upp vid de 14 utvalda vägmiljöerna. Fyra informationspaviljonger byggs på den nu informella rastplatsen vid stenbron, som stängs av för fordon. En parkeringsplats byggs öster om Ekbergska huset, som ägs av Nättraby Hembygdsförening.</p>
        <p>Besökarna går via en nyanlagd gångväg längs Gamla Landsvägen förbi Ekbergska huset och över den magnifika stenvalvsbron över Nättrabyån för att nå paviljongerna. En perfekt entré för fysiska Nättraby Vägmuseum!</p>
    </article>
</main>

<?php
    include("incl/footer.php");
?>
