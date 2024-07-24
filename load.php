<?php 
    require('conexion.php');

    $columns = ['identificacion','nombres','apellidos','sexo','factura','calificacion'];
    #$columnswhere = ['identificacion','nombres','apellidos','sexo'];
    #Si uno quiere  sea limitar hasta la condicion borra los campos que no deseas que busque 
    $table = 'clientes';

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

    $sql = "SELECT " . implode(", ",$columns) . "
    FROM $table
    $where";
    $resultados = $con->query($sql);
    $num_rows = $resultados->num_rows;
    
    $html = '';

    if ($num_rows > 0) {
        while($row = $resultados->fetch_assoc()){
            $html .= '<tr>';
            $html .= '<td>'.$row['identificacion'].'</td>';
            $html .= '<td>'.$row['nombres'].'</td>';
            $html .= '<td>'.$row['apellidos'].'</td>';
            $html .= '<td>'.$row['sexo'].'</td>';
            $html .= '<td>'.$row['factura'].'</td>';
            $html .= '<td>'.$row['calificacion'].'</td>';
            $html .= '<td> <a href="">Editar</a></td>';
            $html .= '<td><a href="">Eliminar</a></td>';
            $html .= '</tr>';
        }
    } else {
        $html .= '<tr>';
        $html .= '<td colspan="7">Sin resultados</td>';
        $html .= '</tr>';
    }
    echo json_encode($html, JSON_UNESCAPED_UNICODE);
    ?>