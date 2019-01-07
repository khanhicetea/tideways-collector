<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Xhprof UI</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-bootgrid/1.3.1/jquery.bootgrid.min.css">
    <style>
        .table > thead > tr > th:first-child {
            width: 50%;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-bootgrid/1.3.1/jquery.bootgrid.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#datatable1').bootgrid({
                rowCount: [20, 50, 100, 200, -1],
            });
            $('#datatable2').bootgrid({
                rowCount: [20, 50, 100, 200, -1],
            });
            $('#datatable3').bootgrid({
                rowCount: [20, 50, 100, 200, -1],
            });
        } );
    </script>
</head>
<body>
    <h2>Callstacks</h2>
    <table id="datatable1" class="table table-condensed table-hover table-striped">
        <thead>
            <tr>
                <th data-column-id="callstack" data-searchable="true">Callstack</th>
                <?php foreach ($headers as $header) { ?>
                <th data-column-id="<?php echo $header; ?>" data-type="numeric"><?php echo $header; ?></th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($record as $callstack => $values) {
            $to = explode('==>', $callstack)[1] ?? 'main';
            ?>
            <tr>
                <td><?php echo $callstack; ?></td>
                <?php foreach ($headers as $header) { ?>
                <td><?php echo $values[$header]; ?></td>
                <?php } ?>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <h2>Calls</h2>
    <table id="datatable2" class="table table-condensed table-hover table-striped">
        <thead>
            <tr>
                <th data-column-id="call" data-searchable="true">Call</th>
                <?php foreach ($headers as $header) { ?>
                <th data-column-id="<?php echo $header; ?>" data-type="numeric"><?php echo $header; ?></th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($calls as $name => $values) { ?>
            <tr>
                <td><?php echo $name; ?></td>
                <?php foreach ($headers as $header) { ?>
                <td><?php echo $values[$header]; ?></td>
                <?php } ?>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <h2>Callers</h2>
    <table id="datatable3" class="table table-condensed table-hover table-striped">
        <thead>
            <tr>
                <th data-column-id="caller" data-searchable="true">Caller</th>
                <?php foreach ($caller_headers as $header) { ?>
                <th data-column-id="<?php echo $header; ?>" data-type="numeric"><?php echo $header; ?></th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($callers as $name => $values) { ?>
            <tr>
                <td><?php echo $name; ?></td>
                <?php foreach ($caller_headers as $header) { ?>
                <td><?php echo $values[$header]; ?></td>
                <?php } ?>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</body>
</html>