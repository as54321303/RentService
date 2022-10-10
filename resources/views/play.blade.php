<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Get Id</title>
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>
<body>


    <div class="container text-center mt-5">

        <h1>Click the given link</h1>

        <input type="hidden" name="id_1" value="10" id="id_1">
        <input type="hidden" name="id_2" value="20" id="id_2">
        <button class="btn btn-success mt-3">Click Me</button>
        
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script>

     $('button').click(function(){

        var id_1=$('#id_1').val();
        var id_2=$('#id_2').val();
        // window.location='{{url("play")}}/'+id_1+'/'+id_2;
        window.location=window.location.href+'/'+id_1+'/'+id_2;

     });

</script>

</body>
</html>