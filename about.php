<?php
include("incl/multipage.php");
$title = "Om webbsidan";
include("incl/headerMB.php");
?>

<main>
<article  class="all-browsers">
    <header>
        <h1>Om webbsidan och dess skapare</h1>
    </header>
    <h2>Om hemsidan</h2>
    <p>
        Denna sida är Nättraby Vägmuseums ansikte utåt på Internet.
        Här finns information, bilder och kartor på Sveriges
        och världens första friluftsmuseum för vägarnas historia på land, räls, vatten och is.
    </p>
    <p>
        I denna presentation beskrivs allt från den 1000-åriga stigen,
        via 1600-talets milstolpar och 30-talets gatstensbelagda landsvägar,
        till dagens asfaltbelagda motorväg.
        Plus förstås järnvägen, vattenvägen, isvägen. broarna och Sveriges två(!) högertrafikomläggningar.
    </p>
    <p>
        Via kartor och GPS-koordinater hittar besökarna lätt fram till de 14 olika utvalda vägmiljöer som utgör Nättraby Vägmuseum.

        Digitala informationen om Nättraby Vägmusem kompletteras i framtiden av fysiska utställningspaviljonger och informationsskyltar i Nättraby
        som ligger vid E22 en mil väster om Karlskrona i Blekinge.
    </p>
    <h2>Objektens placering på kartan</h2>
    <div id='map' style='width: 1000px; height: 600px;'></div>
    <script>
        function mapBox(gps, place) {
            let str = '<h4>' + place + '</h4>';
            var gps2 = [gps[0], gps[1] + 0.001];
            var popup = new mapboxgl.Popup({ closeOnClick: false })
                .setLngLat(gps2)
                .setHTML(str)
                .addTo(map);
            var marker = new mapboxgl.Marker().setLngLat(gps).addTo(map);
        }
        mapboxgl.accessToken = 'pk.eyJ1IjoiY25lc2tvIiwiYSI6ImNrZTUxY3VmczB5anoyem9iMDIzeXFkcm0ifQ.XIZBlYHByGi4UOasxsFieQ';
        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v9',
            center: [15.54172, 56.20526], // starting position,
            zoom: 12 // starting zoom
        });

        // 01 Hålvägen
        var gps = [15.54876, 56.2];
        let place = '01 Hålvägen';
        mapBox(gps, place);

        // 02 Via Regia
        gps = [15.58454, 56.21926];
        place = '02 Via Regia';
        mapBox(gps, place);

        // 03 Värendsvägen N56.21438° E15.53978°
        gps = [15.53978, 56.21438];
        place = '03 Värendsvägen';
        mapBox(gps, place);

        // 04 Skillinge GPS N56.20001° E15.49665° (P-plats N56.19976° E15.49909°)
        gps = [15.49665, 56.20001];
        place = '04 Skillinge';
        mapBox(gps, place);

        // 05 Milstolparna GPS N56.20673° E15.52965°
        gps = [15.52965, 56.20673];
        place = '05 Milstolparna';
        mapBox(gps, place);

        // 06 Ryttarliden GPS N56.21278° E15.56390°
        gps = [15.56390, 56.21278];
        place = '06 Ryttarliden';
        mapBox(gps, place);

        // 07 Riks 4 GPS N56.20795° E15.52915°
        gps = [15.52915, 56.20795];
        place = '07 Riks 4';
        mapBox(gps, place);

        // 08 E22 GPS N56.20783° E15.53065°
        gps = [15.53065, 56.20783];
        place = '08 E22';
        mapBox(gps, place);

        // 08 E22 GPS N56.20783° E15.53065°
        gps = [15.53065, 56.20783];
        place = '08 E22';
        mapBox(gps, place);

        // 09 Cykelvägen GPS N56.20526° E15.54172°
        gps = [15.54172, 56.20526];
        place = '09 Cykelvägen';
        mapBox(gps, place);

        // 10 Kustbanan GPS N56.21145° E15.53007°
        gps = [15.53007, 56.21145];
        place = '10 Kustbanan';
        mapBox(gps, place);

        // 11 Krösnabanan GPS N56.19389° E15.53725°
        gps = [15.53725, 56.19389];
        place = '11 Krösnabanan';
        mapBox(gps, place);

        // 12 Nättrabyån GPS N56.20114° E15.53649°
        gps = [15.53649, 56.20114];
        place = '12 Nättrabyån';
        mapBox(gps, place);

        // 13 Isvägen GPS N56.19301° E15.55054°
        gps = [15.55054, 56.19301];
        place = '13 Isvägen';
        mapBox(gps, place);

        // 14 Stenbron GPS N56.20783° E15.53065°
        gps = [15.53065, 56.20783];
        place = '14 Stenbron';
        mapBox(gps, place);
    </script>
    <h2>Om skaparen av sidan</h2>
    <p>
        Mitt namn är Nenad Cuturic och jag läser första året av webbprogrammering på BTH.
        <br/>
        Jag skapade denna hemsidan som ett <slut></slut>projekt
        <strong> Nättraby vägmuseum, PA1439 H20 lp1 Webbteknologier (htmlphp)</strong>
        <br/>
        <a href="dokumentation.php">Kodstruktur och dokumentation</a>
    </p>
</article>
</main>

<?php
include("incl/byline.php");
include("incl/footer.php");
?>
