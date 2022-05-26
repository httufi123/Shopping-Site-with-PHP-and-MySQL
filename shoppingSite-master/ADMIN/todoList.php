  <!DOCTYPE html>
<!-- Coding By CodingNepal - youtube.com/codingnepal -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="todoList.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
  <div class="wrapper">
    <header>Yapılacaklar Listesi</header>
    <div class="inputField">
      <input type="text" placeholder="İşinizi ekleyin...">
      <button><i class="fas fa-plus"></i></button>
    </div>
    <ul class="todoList">
      <!-- data are comes from local storage -->
    </ul>
    <div class="footer">
      <span>Şuan önünüzde sizi ekleyen <span class="pendingTasks"></span> yapılacak iş var.</span>
      <button>Hepsini temizle</button>
    </div>
  </div>

  <script src="todoList.js"></script>

</body>
</html>
