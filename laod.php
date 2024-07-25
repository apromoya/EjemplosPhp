<?php 
    require('conexion.php');

    $columns = ['identificacion','nombres','apellidos','sexo','factura','calificacion'];
    #$columnswhere = ['identificacion','nombres','apellidos','sexo'];
    #Si uno quiere  sea limitar hasta la condicion borra los campos que no deseas que busque 
    $table = 'clientes';

    $id = 'identificacion';

    $campo = isset($_POST['campo']) ? $con->real_escape_string($_POST['campo']) : null;

    $where = '';
    
    if($campo != null){
        $where = "WHERE (";

        $cont = count($columns);
        for($i = 0; $i < $cont; $i++){
        $where .= $columns[$i] . " LIKE '%". $campo ."%' OR ";            
        }
        $where = substr_replace($where, "", -3);
        $where .= ")";
    }
    #Limit
    $limit = isset($_POST['registros']) ? $con->real_escape_string($_POST['registros']) : 10;
    $pagina = isset($_POST['pagina']) ? $con->real_escape_string($_POST['pagina']) : 0;

    if(!$pagina){
        $inicio = 0;
        $pagina = 1;
    } else {
        $inicio = ($pagina - 1) * $limit;
    }
    $sLimit = "LIMIT $inicio, $limit";

    $sql = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ",$columns) . "
    FROM $table
    $where
    $sLimit";
    $resultados = $con->query($sql);
    $num_rows = $resultados->num_rows;

    #Consulta para total de friltos
    $sqlFiltro = "SELECT FOUND_ROWS()";
    $resFiltro = $con->query($sqlFiltro);
    $row_Filtro = $resFiltro->fetch_array();
    $totalFiltro = $row_Filtro[0];
    #Consulta para total de friltos
    $sqlTotal = "SELECT count($id) FROM $table ";
    $resTotal = $con->query($sqlTotal);
    $row_Total = $resTotal->fetch_array();
    $totalRegistros = $row_Total[0];
    
    #
    $output = [];
    $output['totalRegistros'] = $totalRegistros;
    $output['totalFiltro'] = $totalFiltro;
    $output['data'] = '';
    $output['paginacion'] = '';

    if ($num_rows > 0) {
        while($row = $resultados->fetch_assoc()){
            $output['data'] .= '<tr>';
            $output['data'] .= '<td>'.$row['identificacion'].'</td>';
            $output['data'] .= '<td>'.$row['nombres'].'</td>';
            $output['data'] .= '<td>'.$row['apellidos'].'</td>';
            $output['data'] .= '<td>'.$row['sexo'].'</td>';
            $output['data'] .= '<td>'.$row['factura'].'</td>';
            $output['data'] .= '<td>'.$row['calificacion'].'</td>';
            $output['data'] .= '<td> <a href="">Editar</a></td>';
            $output['data'] .= '<td><a href="">Eliminar</a></td>';
            $output['data'] .= '</tr>';
        }
    } else {
        $output['data'] .= '<tr>';
        $output['data'] .= '<td colspan="7">Sin resultados</td>';
        $output['data'] .= '</tr>';
    }

    if($output['totalRegistros']>0){
        $totalPaginas = ceil($output['totalRegistros'] / $limit);
        $output['paginacion'] .= '<nav>';
        $output['paginacion'] .= '<ul class="pagination">';
        $numeroInicio = 1;
        if(($pagina - 4) > 1){
            $numeroInicio = $pagina - 4;
        }
        $numeroFin = $numeroInicio + 9;
        if($numeroFin > $totalPaginas){
            $numeroFin = $totalPaginas;
        }
        for($i=1; $i <= $totalPaginas; $i++){
            if($pagina == 1){
            $output['paginacion'] .= '<li class="page-item"><a class="page-link active" href="#">'.$i.'</a></li>';
            } else {
            $output['paginacion'] .= '<li class="page-item"><a class="page-link" href="#" onclick="getData('.$i.')">'.$i.'</a></li>';

            }
        }
        $output['paginacion'] .= '</ul>';
        $output['paginacion'] .= '</nav>';
    }
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    ?>