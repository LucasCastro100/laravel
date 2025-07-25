<!DOCTYPE html>
<html>
<head>
    <title>Email de Contato (CONVITE)</title>
</head>
<body>
<h1>Dados do Usuário!</h1>
<p><strong>Nome:</strong> {{ $detalhes['name'] }}</p>
<p><strong>Empresa:</strong> {{ $detalhes['enterprise'] }}</p>
<p><strong>Cnpj:</strong> {{ $detalhes['document'] }}</p>
<p><strong>E-mail:</strong> {{ $detalhes['email'] }}</p>
<p><strong>WhatsApp:</strong> {{ $detalhes['whats'] }}</p>
<p><strong>Onde conheceu a plataforma:</strong> {{ $detalhes['indication'] }}</p>
</body>
</html>
