<?php
include("incl/multipage.php");
$title = "Kodstruktur och dokumentation";
include("incl/header.php");
?>
<main>
<article  class="all-browsers">
    <header>
        <h1>Kodstruktur och dokumentation</h1>
        <p class="author">Updaterad <time datetime="2020-10-19 00:57:12">den 19 oktober 2020</time> av Nenad C</p>
    </header>
    <img src="img/katalogstrukturen.png" class="me-left" alt="Kodstruktur kmom10">
    <h2>Kodstrukturen</h2>
    <p>
        Här till vänster finns själva katalogstrukturen illustrerad på en bild.
        Alternativen från huvudmenyn är representerade i rotkatalogen med filnamn som motsvarar namnet i menyn.
        <br/>
        Jag har valt att ha huvudmeny i toppen (navbar) och undermenyer i den vänstra spalten som är en aside-tag
        (koden finns under sidmeny-mappen).
        De olika alternativen i sidmenyerna är dynamiskt genererade utifrån innehållet i tabellerna: Article/Object i databasen.

    </p>
    <p>
        Grundkonfigurationen finns i config.php med inställningarna för felhantering,
        sessioner och två databaser.
        <br/>
        Första databasen är nvm-databasen med vissa mindre justeringar mot originalet.
        <br/>
        Den andra databasen (credentials) är för inloggningsuppgifterna för admin-gränssnittet.
        <br>
        Den största delen av "intelligensen" finns i funktionerna vilka hittas i src/functions.php filen.
        Funktionerna har någorlunda självbeskrivande namn och är relativt bra dokumenterade
        så det borde gå att förstå dess funktionalitet utan större problem.
    </p>
    <p>
        Sidorna är uppbyggda av sidhuvudet, toppmenyn samt vänstermenyn för vägar och artiklar, huvuddelen och sidfoten.
        Man kan säga att det används en sorts multisidkontroll
        där majoritet av statiska sidorna i vänstermenyn hämtas från databasen.
        Trots att det finns en include("incl/multipage.php") med en missvisande filnamn
        i toppen av varje php-fil är det bara en rest från den gamla koden
        och har bara några rader egentligen hade kunnat flyttas in i config-filen i stället.
    </p>
    <p>
        Vad det gäller responsiviteten finns det en del justeringar bl.a. gällande
        bildbredden, gridstorleken för galleri, kolumner, menyer och typsnittsstorleken för sidmenyn samt lite annat.
        <br/>
        Det finns några mindre saker som skulle kunna kompletteras men för det stora hela ser det bra ut både på de som och stora enheterna.
    </p>
    <p>
        Som en rolig grej valde jag att lägga en Mapbox-mapp med markörerna under om-sidan.
        Jag vet att det inte ger extra poäng men jag ville testa Mapbox-funktionaliteten och göra något lite annorlunda.
        Tyvärr grundas det på javaskript så ingen php här inte :)
    </p>
    <img src="img/admin-sida.png" class="me-right" alt="Admin sida">
    <h3>Förbättringspotential</h3>
    <p>
        I skrivande stund är jag inte nöjd med söksidan för den visar resultat i tabellform.
        Jag kanske kommer göra det lite snyggar om jag får tid men generellt skulle sökfunktionen kunnat göras mycket mer användarvänlig.
        <br/>
        Den är för "teknisk" i dag och skulle kunna (också) integreras i sidorna för vägar och artiklar.
    </p>
    <p>
        Även admin-sidorna är lite fyrkantiga och passar mer för någon som kan lite om webb-tekniken.
        Så dessa skulle kunna göras mer användarvänliga också.
    </p>
</article>
</main>

<?php
include("incl/byline.php");
include("incl/footer.php");
?>
