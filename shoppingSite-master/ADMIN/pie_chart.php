<?php
$connect = mysqli_connect("localhost", "root", "", "lastikbank");
$query = "SELECT category_list_id, count(*) as number FROM adword_list GROUP BY category_list_id";
$result = mysqli_query($connect, $query);
?>
<!DOCTYPE html>
<html>

<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Kategoriler', 'Number'],
                <?php
                while ($row = mysqli_fetch_array($result)) {
                    $category = $row["category_list_id"];
                    $deger = "";
                    if ($category == 1) {
                        $deger = "Lastik";
                    } else if ($category == 2) {
                        $deger = "Akü";
                    } else if ($category == 3) {
                        $deger = "Jant";
                    }
                    echo "['" . $deger . "', " . $row["number"] . "],";
                }
                ?>
            ]);
            var options = {
                pieHole: 0.4
            };
            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(data, options);
        }
    </script>
    <style>
        #piechart {
            padding-left:20px;
            min-height: 400px;
        }
    </style>
</head>


<body>
    <div align="">
        <p></p>
        <div id="piechart"></div>
        <p><small></small></p>
    </div>
</body>

</html>