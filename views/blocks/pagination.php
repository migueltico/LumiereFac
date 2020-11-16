<nav aria-label="Page navigation example">
  <ul class="pagination pagination_inventario">
    <li data-page="<?= ($paginationInfo['previouspage'] == 0 ? 1 : $paginationInfo['previouspage']) ?>" class="page-item paginationInventario <?= ($paginationInfo['previouspage'] == 0 ? 'disabled' :"") ?>"><a class="page-link" href="#">Anterior</a></li>
    <?php for ($i = 0; $i < $paginationInfo['paginacion']['paginas']; $i++) : ?>
      <li data-page="<?= $i + 1 ?>" class="page-item paginationInventario paginationBtn <?= (($i + 1) == $paginationInfo['nowPage'] ? "active" : "") ?>"><a class="page-link" href="#"><?= $i + 1 ?></a></li>
    <?php endfor; ?>
    <li data-page="<?= ($paginationInfo['nextpage'] >= $maxpage ? $maxpage :  $paginationInfo['nextpage']) ?>" class="page-item paginationInventario <?= ($paginationInfo['nextpage'] >= $maxpage ? 'disabled' : "") ?>"><a class="page-link" href="#">Siguiente</a></li>
  </ul>
</nav>