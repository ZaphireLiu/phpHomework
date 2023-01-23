<!DOCTYPE Html>
<html>
<head>
    <meta charset="UTF-8">
    <title>post</title>
</head>
<body>
    <table>
        <tr><th>Name</th><th>Value</th></tr>
        <?php 
            foreach ($_POST as $k => $v)
                echo "<tr><td>$k</td><td>$v</td></tr>";
        ?>
    </table>
</body>
</html>