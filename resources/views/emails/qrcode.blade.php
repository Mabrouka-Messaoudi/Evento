<!DOCTYPE html>
<html>
<head>
    <title>Votre QR Code pour l'événement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            border: 1px solid #e2e2e2;
            padding: 30px;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        h1 {
            color: #2c3e50;
        }
        p {
            font-size: 16px;
        }
        .footer {
            margin-top: 40px;
            font-size: 12px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Merci pour votre participation !</h1>
        <p>Nous sommes ravis de vous confirmer votre inscription à l'événement <strong>{{ $eventTitle ?? 'notre événement' }}</strong>.</p>

        <p>Votre QR code personnel est joint à ce message. Veuillez le conserver précieusement, il vous sera demandé lors de l'entrée à l'événement.</p>

        <p>Si vous avez la moindre question, n'hésitez pas à nous contacter.</p>

        <p>Au plaisir de vous voir bientôt !</p>


    </div>
</body>
</html>
