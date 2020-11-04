<?php
$generator = new Picqer\Barcode\BarcodeGeneratorSVG();
//$generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
//$generatorJPG = new Picqer\Barcode\BarcodeGeneratorJPG();
//$generatorHTML = new Picqer\Barcode\BarcodeGeneratorHTML();
$count = 0;
?>
<div class="hoja">

    <div class="row headers">

        <?php foreach ($items as $item) : ?>
            <?php for ($i = 0; $i < (int)$item['cantidad']; $i++) : ?>
                <?php $count = $i ?>
                <div class="col-6 svg_codePritn">
                    <p class="text-center" style="display: flex;justify-content: space-evenly;padding-top:20px"><span>Talla: <?= $item['talla'] ?></span><span>Estilo: <?= $item['estilo'] ?></span></p>

                    <?php echo $generator->getBarcode($item['codigo'], $generator::TYPE_CODE_128, 4, 60); ?>

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
        margin-top: 40px;
        margin-bottom: -0.90rem;
        /* margin-bottom: -13px; */
        padding: 0;
        max-height: 140px;
        /* border-top: 1px dashed gray; */
        page-break-inside: avoid;
        page-break-after: always;
        page-break-before: always;
    }

  

    .hoja {

        padding: 0;
        margin: 0;
        background-color: white;
        padding: 15px;
        width: 100vw;
        /* width: 407px; */
        font-size: 1rem;
        /* width: 445px; */
        font-family: ticketing_regular, cursive;
        justify-content: space-evenly;
    }
    .hoja .headers {

        padding: 0;
        margin-top: -5.5rem;
    }
</style>