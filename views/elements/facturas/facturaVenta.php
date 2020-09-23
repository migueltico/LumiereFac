<div class="hoja">
    <h2 class='center mt-2'>Tienda Ropa</h2>


    <table class="factable">
        <thead>
            <tr>
                <th>Descripcion</th>
                <th>Cantidad</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php for ($i = 0; $i < 150; $i++) : ?>
                <tr>
                    <td>Lorem ipsum dolor sit.</td>
                    <td><?= $i + 1 ?></td>
                    <td>30,000,000,000.00</td>
                </tr>

            <?php endfor; ?>
        </tbody>
    </table>


</div>
<style>
    .factable {
        width: 442px;
        border: 1px solid red;
        border-collapse: collapse;
        margin-left: 6px;

    }

    .hoja {
        background-color: white;
        width: 445px;
    }

    .factable tbody tr td {
        padding: 5px;
        border-bottom: 1px solid green;
    }
</style>