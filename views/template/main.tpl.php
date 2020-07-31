<?php include_once(self::block('header')) ?>

<body class="">
    <?php include_once(self::block('topbar')) ?>
    <div class="mainContainer">
        <section class="lateral">
            <?php include_once(self::block('lateral_menu')) ?>
        </section>
        <section class="bodyMain container-full">
            <section class="bodyContent" id="bodyContent">
                <?php include(self::element($block[0])) ?>
            </section>
        </section>
    </div>

    <?php //include_once(self::block('allModals')) 
    ?>
    <?php include_once(self::block('footer')) ?>