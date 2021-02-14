<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$titulo?></title>
    <script src="/public/js/app.js"></script>
    <link rel="stylesheet" href="/public/css/app.css">
</head>

<body>
    
    <div class='app'>
        
        <h1>¡Hola <b><?=$data->params->nombre_visitante?></b>! Bienvenido al proyecto easy-Router </h1>
        
        <ul>
            <li>Simple</li> 
            <li>Liviano</li> 
            <li>Rapido y</li>
            <li>0 dependencias</li> 
        </ul>

        <h2>Route response method GET</h2>
        <button onclick='getPersona()'>method GET</button>
        <ul id='lista'>
        </ul>

        <a href='https://github.com/esamar'>https://github.com/esamar</a> :)  
        
    </div>
    
    <br>

    <marquee> <?=$miVariable?> </marquee>
    
</body>

</html>