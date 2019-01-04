<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Xhprof UI</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-bootgrid/1.3.1/jquery.bootgrid.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-bootgrid/1.3.1/jquery.bootgrid.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#datatable').bootgrid({
                formatters: {
                    "link": function (column, row) {
                        console.log(row);
                        return '<a href="' + row.viewlink + '">View</a>';
                    }
                }
            });
        } );
    </script>
</head>
<body>
    <table id="datatable" class="table table-condensed table-hover table-striped">
        <thead>
            <tr>
                <th data-column-id="time" data-order="desc" data-type="numeric">Time</th>
                <th data-column-id="hash">Hash</th>
                <th data-column-id="url">Request URL</th>
                <th data-column-id="viewlink" data-formatter="link" data-sortable="false">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $i = 0;
        while ($record = $reader->fetchOne($i)) { 
            $i++;
            $row = new KhanhIceTea\Xhprof\Collector\CsvData($record);
        ?>
            <tr>
                <td><?php echo $row->time; ?></td>
                <td><?php echo $row->hash; ?></td>
                <td><?php echo $row->url; ?></td>
                <td><?php echo $url.'&id='.$row->time.'_'.$row->hash; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</body>
</html>