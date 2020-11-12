<?php
include("incl/multipage.php");
$title = "Galleri";
include("incl/header.php");

$directory = "img/150x150";
$images = glob($directory . "/*.jpg");
$nrOfImages = count($images);
$startNr = $_GET['image-page-nr'] ?? 0;
$aTag = '<a href="?image-page-nr=$linkId">$Value</a>';
if ($startNr > 0) {
    $replacement['$linkId'] = $startNr - 9;
    $replacement['$Value'] = 'Föregående';
    $previousItemLink = strtr($aTag, $replacement);
} else {
    $previousItemLink = '<div></div>';
}
if ($startNr + 9 < $nrOfImages) {
    $replacement['$linkId'] = $startNr + 9;
    $replacement['$Value'] = 'Nästa';
    $nextItemLink = strtr($aTag, $replacement);
} else {
    $nextItemLink = '<div></div>';
}
?>
<main>
<article  class="all-browsers">
    <header class="grid">
        <?= $previousItemLink ?>
        <h1>Bildgalleri</h1>
        <?= $nextItemLink ?>
    </header>
    <div class="grid9">
        <?php
        foreach (array_slice($images, $startNr, 9) as $image) {
            $largeImage = 'img/orig/' . basename($image);
            echo <<<IMG
                <div class="div-content">
                    <figure>
                        <a href="$largeImage">
                            <img src="$image" alt="$image">
                        </a>
                        <figcaption>$image</figcaption>
                    </figure>
                </div>
            IMG;
        }
        ?>
    </div>
</article>
</main>

<?php
    include("incl/footer.php");
?>
