<?php    
    session_start();
    //$nombre = $_SESSION['user'];
    $servidor = "localhost";
    $usuarioBD = "root";
    $pwdBD = "";
    $nomBD = "boneteria";    
    $db = mysqli_connect($servidor,$usuarioBD,$pwdBD,$nomBD);
      

    if (!$db) {
        die("La conexión falló: " . mysqli_connect_error());
    } else {
        mysqli_query($db, "SET NAMES 'UTF8'");
    }

    $query = mysqli_query($db, "SELECT nombre, categoria, precio_menudeo, precio_mayoreo, talla, color, imagen FROM productos");  

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <!-- Bootstrap CSS -->
     <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <link rel="stylesheet" href="/css/templates.css">
    <link rel="stylesheet" href="/css/home.css">--> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="css/estilos2.css">
</head>

<body style="background-color: lightpink">
    <!--HEADER-->
    <?php include("./templates/header.php")?>

    <div class="text-center">
            <h1 aling="center"><b><i>PRODUCTOS</i></b></h1>            
            <hr class="my-4">
    </div>


    <div class="container">
        <div class="card-content" style="display:none">
        <?php
        $i = 0;
        while ($row = mysqli_fetch_array($query)) {
        
        ?>
        
            <div class="card">
            <div class="card-image"><img src="<?php echo $row['imagen']?>" alt="Imagen"></div>
                <div class="card-info">
                <h3><?php echo $row['nombre']; ?></h3>
                <h3><?php echo $row['categoria']; ?></h3>
                <h3><?php echo $row['precio_menudeo']; ?></h3>
                <h3><?php echo $row['precio_mayoreo']; ?></h3>
                <h3><?php echo $row['talla']; ?></h3>
                <h3><?php echo $row['color']; ?></h3>
                </div>
       
      

        </div>

                <?php
            echo "<br>";
            }
            ?>

   

<div class="pagination">
        <!--<li class="page-item previous-page disable"><a href="#" class="page-link">Prev</a></li>
            <li class="page-item current-page acttive"><a href="#" class="page-link">1</a></li>
            <li class="page-item dots"><a href="#" class="page-link">...</a></li>
            <li class="page-item current-page"><a href="#" class="page-link">5</a></li>
            <li class="page-item current-page"><a href="#" class="page-link">6</a></li>
            <li class="page-item current-page"><a href="#" class="page-link">10</a></li>
            <li class="page-item next-page"><a href="#" class="page-link">Next</a></li>-->
    </div>
    </div>
            
            </div>
            
            <script type="text/javascript">
        function getPageList(totalPages, page, maxLength){
            function range(start, end){
                return Array.from(Array(end-start+1),(_,i) => i + start);
            }
            var sideWidth = maxLength < 9 ? 1 : 2;
            var leftWidth = (maxLength - sideWidth * 2 - 3) >> 1;
            var rightWidth = (maxLength - sideWidth * 2 - 3) >> 1;

            if(totalPages <= maxLength){
                return range(1, totalPages);
            }

            if(page <= maxLength - sideWidth - 1 - rightWidth){
                return range(1, maxLength - sideWidth - 1).concat(0, range(totalPages - sideWidth + 1, totalPages));
            }

            if(page >= totalPages - sideWidth - 1 - rightWidth) {
                return range(1, sideWidth).concat(0, range(totalPages - sideWidth - 1 - rightWidth - leftWidth, totalPages));
            }
            return range(1, sideWidth).concat(0, range(page - leftWidth, page + rightWidth), 0, range(totalPages - sideWidth + 1, totalPages));
        }
        
        $(function(){
            var numberOfItems = $(".card-content .card").length;
            var limitPerPage = 2; //limite de items por pagina
            var totalPages = Math.ceil(numberOfItems/limitPerPage);
            var paginationSize=7;//elementos de pagina visibles en la paginacion
            var currentPage;

            function showPage(whichPage){
                if(whichPage < 1 || whichPage > totalPages) return false;

                currentPage = whichPage;

                $(".card-content .card").hide().slice((currentPage - 1) * limitPerPage, currentPage * limitPerPage).show();

                $(".pagination li").slice(1, -1).remove();

                getPageList(totalPages, currentPage, paginationSize).forEach(item => {
                     $("<li>").addClass("page-item").addClass(item ? "current-page" : "dots")
                    .toggleClass("active", item === currentPage).append($("<a>").addClass("page-link")
                    .attr({href: "javascript:void(0)"}).text(item || "...")).insertBefore(".next-page");
                });

                $(".previous-page").toggleClass("disable", currentPage === 1);
                $(".next-page").toggleClass("disable", currentPage === totalPages);
            return true;
             }

              $(".pagination").append(
                $("<li>").addClass("page-item").addClass("previous-page").append($("<a>").addClass("page-link").attr({href: "javascript:void(0)"}).text("Prev")),
                $("<li>").addClass("page-item").addClass("next-page").append($("<a>").addClass("page-link").attr({href: "javascript:void(0)"}).text("Next"))
            );

            $(".card-content").show();
            showPage(1);

             $(document).on("click", ".pagination li.current-page:not(.active)", function(){
                return showPage(+$(this).text());
            });

            $(".next-page").on("click", function(){
                return showPage(currentPage + 1);
            });

            $(".previous-page").on("click", function(){
                return showPage(currentPage - 1);
            });
        });
    </script>

 <!--FOOTER-->
 <?php include("./templates/footer.php")?>

 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js" integrity="sha512-RdSPYh1WA6BF0RhpisYJVYkOyTzK4HwofJ3Q7ivt/jkpW6Vc8AurL1R+4AUcvn9IwEKAPm/fk7qFZW3OuiUDeg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</body>

</html>