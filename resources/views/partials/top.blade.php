<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Integrate Payment Method</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
     <link rel="stylesheet" href="https://www.w3schools.com/html/styles.css"> 
     <script src="https://js.stripe.com/v3/"></script>
     @stack('style')
<style type="text/css">

    .panel-title {

    display: inline;

    font-weight: bold;

    }

    .display-table {

        display: table;

    }

    .display-tr {

        display: table-row;

    }

    .display-td {

        display: table-cell;

        vertical-align: middle;

        width: 61%;

    }

</style>
</head>
<body>