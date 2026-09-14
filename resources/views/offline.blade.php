<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ARK RPG — Offline</title>
    <style>
        body {
            margin: 0; min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            background: #0a0a0a; color: #e5e7eb;
            font-family: system-ui, sans-serif; text-align: center; padding: 2rem;
        }
        h1 { color: #00f2ff; font-size: 2rem; margin-bottom: 1rem; }
        p { color: #94a3b8; max-width: 400px; line-height: 1.6; }
        button {
            margin-top: 2rem; padding: 12px 24px;
            background: transparent; color: #00f2ff;
            border: 2px solid #00f2ff; border-radius: 40px;
            cursor: pointer; font-weight: bold; letter-spacing: 2px;
            text-transform: uppercase; font-size: 12px;
        }
        button:hover { background: #00f2ff; color: #000; }
    </style>
</head>
<body>
    <div>
        <h1>📡 Sinal Perdido</h1>
        <p>Você está offline. O ARK continua aqui, aguardando seu retorno ao sinal.</p>
        <button onclick="location.reload()">Tentar Reconectar</button>
    </div>
</body>
</html>