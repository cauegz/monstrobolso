# monstrobolso
Trabalho final do terceiro ano do ensino médio integrado ao técnico em desenvolvimento de sistemas
## Organização:

### O jogo se passa se passa em Manaus
- O pokMart será no mercado público de Manaus: Mercado Municipal Adolpho Lisboa
- Escolher 3 pontos para ser os ginásios
    - Teatro de Manaus
    - Casas Ribeirinhos
    - Rio Negro

## Portas/localhost
- o sistema agora está rodando na porta 80 (padrão do http), entao agora para acessar o sistema, depois de dar `docker compose up -d`, se acessa `http://localhost`
- API - porta 8080
- frontend - porta 80

## Comandos:
- pega os containeirs do docker-compose.yml - roda banco e php: docker compose up -d 
- desliga: docker compose down
- apagar dados banco: docker compose down -v
- abrir o terminal do postgre: docker exec -it postgres psql -U postgres -d monstrobolso