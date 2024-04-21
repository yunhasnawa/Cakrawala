<html>
<head>
    <title>Cakrawala Framework</title>
    <link rel="stylesheet" href="<?php echo \framework\Util::baseUrl('/public/css/style.css'); ?>">
</head>
<body>
<div class="container">
    <div class="card">
        <h1><?php echo $this->getData()['greetings']; ?></h1>
    </div>
</div>
</body>
</html>