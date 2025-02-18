<?php
$generator = new Picqer\Barcode\BarcodeGeneratorSVG();

use config\helper as h;
//$generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
//$generatorJPG = new Picqer\Barcode\BarcodeGeneratorJPG();
//$generatorHTML = new Picqer\Barcode\BarcodeGeneratorHTML();
$count = 0;
?>
<div class="hoja">
    <div class="row headers">
        <?php foreach ($items as $item) : ?>
            <?php $ticketAmount = $item['cantidad']; ?>
            <?php for ($i = 0; $i < (int)$ticketAmount; $i++) : ?>
                <?php $count = $i ?>
                <div class="col-3 svg_codePritn">
                    <p class="text-center" style="display: flex;justify-content: space-evenly;padding-top:0.847rem;font-size:1.2rem"><span>(<?= $item['talla'] ?>)</span> <span> ₡<?= $item['precio'] ?></span></p>
                    <?php echo $generator->getBarcode($item['codigo'], $generator::TYPE_CODE_128, 2, 50); ?>
                    <p class="text-center" style="display: flex;justify-content: center;font-size:1.1rem"><?= h::shorter($item['estilo'], 25) ?></span></p>
                </div>
            <?php endfor; ?>
        <?php endforeach; ?>
    </div>
</div>

<style>
    .svg_codePritn svg {
        width: 100%;
    }

    .svg_codePritn {
        display: flex;
        flex-direction: column;
        margin-top: 0px;
        margin-bottom: 0rem;
        padding: 0;
        max-height: 130px;
        page-break-inside: avoid;
    }

    .hoja {
        padding: 0;
        margin: 0;
        background-color: white;
        padding: 15px;
        width: 100vw;
        font-size: 1rem;
        font-family: ticketing_regular, cursive;
        justify-content: space-evenly;
    }

    .hoja .headers {
        padding: 0;
        margin-top: 0rem;
        display: flex;
        flex-wrap: wrap;
    }
</style>
