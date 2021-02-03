# Aplicação (service app)
Responsável por configurar toda a parte do php (extensões, composer, etc),
também irá configurar o usuário www-data e root, além de criar o `$user` 
e dar as permissões necessárias à ele.

# Servidor HTTP (service nginx)
Alterar configuração dentro de docker-compose/nginx/airplanebooking.conf.
É uma configuração padrão para o laravel (public/ como entrada)
e também padroniza o caminho dos logs para quando executar o comando
`logs` do composer ele busque no diretório correto.

# Banco de dados (service db)
Apenas necessário alterar o `.env` e restartar seu service para surtir efeito.

Muito importante que a variável `DB_HOST` no `.env` esteja setada como db (nome do service).
