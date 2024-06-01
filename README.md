# Processar um arquivo CSV com mais de 1 milhão de linhas (Big File CSV)

Este projeto apresenta uma forma simples de processar um arquivo grande com milhões de registros.

Para isso é utilizado processos assíncronos, basicamento ao realizar uma requisição para rota /api/upload o arquivo é salvo e processado em segundo plano, tudo a partir do controller UploadController.

### Ponto de melhorias

1. Melhorar os testes realizados, pois foram feitos testes mais superficiais, como por exemplo verificar se os arquivos lidos estão sendo fechados.
2. Realizar um tratamento de erro para quando um job falhar
3. Enviar emails e criar boletos
4. Adicioanr uma middleware para autenticação da api, poderia ser um JWT ou OAuth2

#### Como executar

```
docker compose up -d
```

### cURL para upload

```
curl --location 'http://localhost:8000/api/upload' \
--form 'file=@"input.csv"'
```

O arquivo utilizado para o teste esta no diretório /test-files/index.csv
test-files/input.csv
