<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History</title>
    <style>
        
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../css/login.css">
</head>

<body class="history-body">
    <?php include 'header.php' ?>
    <main>
        <div class="order-history">
            <div class="order_title">
                <h1>Мои заказы</h1>
            </div>
            
        </div>
                
        <main>
            <template class="order-template">
                <div class="order-card">
                    <div class="left-side-order-card">
                        <p class="event-title"></p>
                        <div>
                            <span class="event-date"></span>
                            <span> | </span>
                            <span class="event-points"></span>
                        </div>
                    </div>
                    <div class="right-side-order-card">
                        <div class="status-badge"></div>
                    </div>
                </div>
            </template>
</body>

</html>