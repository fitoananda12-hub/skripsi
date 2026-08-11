<!DOCTYPE html>
<html>
<head>
    <title>Test Login Link</title>
</head>
<body>
    <h1>Test Login Navigation</h1>
    <p>Klik link di bawah untuk test navigasi ke halaman login:</p>
    
    <a href="{{ route('login') }}" style="font-size: 24px; color: blue; text-decoration: underline; padding: 20px; display: inline-block;">
        KLIK UNTUK MASUK KE LOGIN PAGE
    </a>
    
    <hr>
    <p>Login URL yang di-generate: <strong>{{ route('login') }}</strong></p>
    <p>Route name: <strong>login</strong></p>
</body>
</html>
