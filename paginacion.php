<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paginacion</title>
</head>
<body>
    <?php 
        include('conexion.php');
    ?>
    <h1>Empleados</h1>
    <a href="index.html">Volver</a>
    <div>
        <label for="num_registros">Mostrar: </label>
    </div>
    <div>
        <select name="num_registros" id="num_registros">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
        </select>
    </div>
    <div>
        <label for="num_registros">Registros</label>
    </div>
    <form action="">
        <label for="">Buscar: </label>
        <input type="text" name="campo" id="campo">
    </form>

    <table>
        <thead>
            <th>Num. empleado</th>
            <th>nombres</th>
            <th>apellidos</th>
            <th>sexo</th>
            <th>factura</th>
            <th>calificacion</th>
            <th></th>
            <th></th>
        </thead>
        <tbody id="content">
            
        </tbody>
        <tfooter>

        </tfooter>
    </table>
    <div>
        <div>
            <label id="lbl-total"></label>
        </div>
        <div id="nav-paginacion"></div>
    </div>
    <script>
        let paginaActual = 1;

        getData(paginaActual)
        document.getElementById("campo").addEventListener("keyup", function(){
            getData(1)
        })
        document.getElementById("num_registros").addEventListener("change", function(){
            getData(paginaActual)
        }, false)

        function getData(pagina){
            let input = document.getElementById("campo").value
            let num_registros = document.getElementById("num_registros").value
            let content = document.getElementById("content")

            if(pagina != null){
                paginaActual = pagina
            }

            let url = "laod.php"
            let formaData = new FormData()
            formaData.append('campo', input)
            formaData.append('registros', num_registros)
            formaData.append('pagina', pagina)
             
            fetch(url, {
                method: "POST",
                body: formaData
            }).then(response => response.json())
            .then(data => {
                content.innerHTML = data.data
                document.getElementById("lbl-total").innerHTML = 'Mostrando' +data.totalFiltro +
                ' de ' + data.totalRegistros + ' registros'
                document.getElementById("nav-paginacion").innerHTML = data.paginacion
            }).catch(err => console.log(err))
        }
    </script>
</body>
</html>