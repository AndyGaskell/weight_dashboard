<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Weight Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
 

    <script>
    function record_it() {
        
        var weight_value = document.getElementById("weight").value;
        var date_value = document.getElementById("date").value;
        var xhttp = new XMLHttpRequest();
        xhttp.open("GET", "handler.php?weight=" + weight_value + "&date=" + date_value, false);
        xhttp.send();
        document.getElementById("response_place").innerHTML = xhttp.responseText; 
    }
    </script>

</head>
  <body>

    
    <div class="container text-center">
        <div class="row align-items-start">
            <div class="col">
                <h1>Weight Dashboard</h1>
            </div>
        </div>
    </div>

    <hr/>

    <div class="container text-left">
        <div class="row align-items-start">
            <div class="col">



                <div class="mb-3">
                    <label for="weight" class="form-label">Weight:</label>
                    <input type="number" id="weight" name="weight" min="40" max="200" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Date:</label>
                    <input type="date" id="date" name="date" value="<?php echo date("Y-m-d")?>" class="form-control" />
                </div>
                <button type="submit" class="btn btn-primary" onclick="record_it()">Record it</button>

                <div id="response_place"></div>


            </div>
            <div class="col">
                One of three columns
            </div>
            <div class="col">
                One of three columns
            </div>
        </div>
    </div>

    <hr/>

    <div class="container">
        <div class="row align-items-start">
            <div class="col text-left">
                One of three columns
            </div>
            <div class="col text-center">
                One of three columns
            </div>
            <div class="col text-right">
                One of three columns
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>


