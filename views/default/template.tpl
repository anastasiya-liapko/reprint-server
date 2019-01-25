<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>{$pageTitle}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="" type="image/png">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700,900&amp;subset=cyrillic" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
    
        <link rel="stylesheet" href="assets/css/nice-select.css">
    
        <link rel="stylesheet" href="assets/css/fonts.css">
        <link rel="stylesheet" href="assets/css/style.min.css">
    </head>
    <body>
        {include file="$header"}

            {if $body}
                {include file="$body"}
            {/if}

        {include file="$footer"}
    </body>
</html>