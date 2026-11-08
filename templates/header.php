

<?php
$page = $_GET['page'] ?? 'Home';

switch ($page) {
  
    case "category":
        $title = "Categories List";
        break;

    case "product":
        $title = "Product List";
        break;
 

    case "brand":
        $title = "The brand";
        break;    

        case "order":
        $title= "Orders";
        break;
  
    case "customer":
        $title= "Customer";
        break;


   case "weather":
        
          $title = "Weather";
          break;

  
   case "register":
        
          $title = "Register";
          break;


   case "login":
        
          $title = "Login";
          break;

      case "profile":
        
          $title = "Profile";
          break;


      case "users":
        
          $title = "Manage users";
          break;              



      case "contact":
        
          $title = "Contact us";
          break;   


      case "data":
      
         $title ="Create database project";
         break;    




    default:
        $title = "Home";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
   <title><?= $title ?></title>

  <link rel="stylesheet" href="css/menu.css">
  <link rel="stylesheet" href="css/style.css">
 <link rel="stylesheet" href="css/weather.css">
    <link rel="stylesheet" href="css/info.css">
 <link rel="stylesheet" href="css/dataTables.css">
  <link rel="stylesheet" href="css/weather.css">
   <link rel="stylesheet" href="css/brand.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
     <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
              <!-- Fonts -->
<link href="favicon.ico" rel="shortcut icon" type="image/x-icon" />

    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    <script src="https://cdn.tailwindcss.com"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.js"></script>
      <link rel="stylesheet" href=
"https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/login.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



</head>
<body>
