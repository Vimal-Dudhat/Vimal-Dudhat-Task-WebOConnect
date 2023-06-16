<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,
						initial-scale=1.0" />
    <title>User's QR Code</title>
    <style>
        h1,
        h3 {
            color: green;
        }

        body,
        header {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>
    <header>
        <h3>Go to Profile Page scan below code</h3>
    </header>
    <main>
        <div id="qrcode"></div>
    </main>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        var url = "{{$url}}";
        var qrcode = new QRCode("qrcode",url);
    </script>
</body>

</html>
