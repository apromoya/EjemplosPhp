<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejemplo Search</title>

    <style>
        table th td{
            border: 1px solid;
        }
        table{
            width: 80%;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <?php 
        include('conexion.php');
    ?>
    <h1>Empleados</h1>
    <a href="index.html">Volver</a>
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
    <script>
        getData()
        document.getElementById("campo").addEventListener("keyup", getData)

        function getData(){
            let input = document.getElementById("campo").value
            let content = document.getElementById("content")
            let url = "load.php"
            let formaData = new FormData()
            formaData.append('campo', input)
             
            fetch(url, {
                method: "POST",
                body: formaData
            }).then(response => response.json())
            .then(data => {
                content.innerHTML = data
            }).catch(err => console.log(err))
        }
    </script>
</body>
</html>