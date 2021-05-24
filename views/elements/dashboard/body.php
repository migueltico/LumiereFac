<div class="col-lg-12 col-md-12 col-sm-12">
    <div class="row">
        <div class=" col-6">
            <div class="card p-5  shadow">
                <canvas id="getMoreSalesPerMonth" style="display: block; width:100%; height: 500px;"></canvas>
            </div>
        </div>
        <div class="col-6">
            <div class="card p-5  shadow">
                <canvas id="getLastWeekSales" style="display: block; width:100%; height: 500px;"></canvas>
            </div>
        </div>
        <?php  
            print_r(session_id());
            echo "<br>";
            print_r(ini_get("session.gc_maxlifetime") /60 /60);
        ?>
    </div>
</div>