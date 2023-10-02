<?php

/** @var yii\web\View $this */

$this->title = 'Prueba Práctica';
?>
<div class="site-index">

  <div id="map" style="height: 400px;"></div>

  <br>

  <div class="d-grid gap-2 col-6 mx-auto">
    <!--<button id="generate" type="button" class="btn btn-primary">Generar Lista de Coordenadas</button>-->
    <button id="generate" onclick="" class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Generar Lista de Coordenadas</button>
    <div class="nav justify-content-end">
      <div class="nav-item">
        <button class="btn btn-link justify-content-end" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Abrir panel</button>
      </div>
      
    </div>
  </div>



  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasRightLabel">Coordenadas</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Latitud</th>
            <th scope="col">Longitud</th>
          </tr>
        </thead>
        <tbody id="coordinates">
          
        </tbody>
      </table>

      <br>

      <div class="row g-2">
        <label>Distancia entre punto:</label>

        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th scope="col">Puntos</th>
              <th scope="col">Metros</th>
              <th scope="col">Kilometros</th>
            </tr>
          </thead>
          <tbody id="distances">
            
          </tbody>
        </table>
      </div>

    </div>

  </div>

  <script>

  </script>