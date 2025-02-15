<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ynet Framework</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <nav>
        <a href="/">Home</a>
        <a href="/about">About</a>
        <a href="/contact">Contact</a>
    </nav>
    
    <div class="container">
        {{content}}
    </div>
    
    <footer>
        <p>&copy; <?php echo date('Y'); ?> Ynet Framework</p>
    </footer>
</body>
</html>

<div class="welcome">
    <h1><?php echo $title; ?></h1>
    <p><?php echo $message; ?></p>
</div>

<div class="about">
    <h1>About Us</h1>
    <p>This is the about page of our application.</p>
</div>