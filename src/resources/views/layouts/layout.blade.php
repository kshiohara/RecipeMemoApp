<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RecipeMemoApp</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li>Home</li>
                <li>Search</li>
            </ul>
        </nav>
    </header>
    <main>
        {{ $slot }}
    </main>
    <footer>
        <!-- ... -->
        <p>Copyright ...</p>
    </footer>
</body>
</html>
