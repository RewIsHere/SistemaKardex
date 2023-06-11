<!-- Modal -->
<div class="modal fade" id="edit<?php echo $rowSql['alum_nc']; ?>">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Archivos del Alumno</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <?php
                $edit = mysqli_query($con, "select * from docs_alumno where Id_alumno='" . $rowSql['alum_nc'] . "'");
                $erow = mysqli_fetch_array($edit);
                ?>
                <div class="container-fluid">
                    <form method="POST" action="">
                        <div class="row">

                            <div class="col-lg-2">
                                <label style="position:relative; top:7px;">Liberacion de Creditos:</label>
                            </div>
                            <?php if ($erow['Creditos'] == null) {
                                $var1 = 'NO SE HA SUBIDO AUN';
                                $fecha1 = 'N/A';
                            } else {
                                $var1 = '<a class="btn btn-info"  href="archivos/' . $erow['Creditos'] . '" target="_blank">VER</a>';
                                $fecha1 = $erow['fecha_creditos'];
                            }
                            ?>
                            <div class="col-lg-10">
                                <?php echo $var1 ?>
                            </div>
                            <div class="col-lg-10">
                                FECHA DE ENVIO: <?php echo $fecha1 ?>
                            </div>
                        </div>
                        <hr/>
                        <div style="height:10px;"></div>
                        <div class="row">
                            <div class="col-lg-2">
                                <label style="position:relative; top:7px;">Justificantes:</label>
                            </div>
                            <?php if ($erow['Justificantes'] == null) {
                                $var2 = 'NO SE HA SUBIDO AUN';
                                $fecha2 = 'N/A';
                            } else {
                                $var2 = '<a class="btn btn-info" href="archivos/' . $erow['Justificantes'] . '" target="_blank">VER</a>';
                                $fecha2 = $erow['fecha_justi'];
                            }
                            ?>
                            <div class="col-lg-10">
                                <?php echo $var2 ?>
                            </div>
                            <div class="col-lg-10">
                                FECHA DE ENVIO: <?php echo $fecha2 ?>
                            </div>
                        <hr/>
                        </div>
                        <div style="height:10px;"></div>
                        <div class="row">
                            <div class="col-lg-2">
                                <label style="position:relative; top:7px;">ALTAS Y BAJAS:</label>
                            </div>
                            <?php if ($erow['Altas_y_Bajas'] == null) {
                                $var3 = 'NO SE HA SUBIDO AUN';
                                $fecha3 = 'N/A';
                            } else {
                                $var3 = '<a class="btn btn-info" href="archivos/' . $erow['Altas_y_Bajas'] . '" target="_blank">VER</a>';
                                $fecha3 = $erow['fecha_altas'];
                            }
                            ?>
                            <div class="col-lg-10">
                                <?php echo $var3 ?>
                            </div>
                            <div class="col-lg-10">
                                FECHA DE ENVIO: <?php echo $fecha3 ?>
                            </div>
                        <hr/>
                        </div>
                        <div style="height:10px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->