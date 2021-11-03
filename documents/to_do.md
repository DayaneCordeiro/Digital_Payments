# To do itens
### User
- [x] Validar email unique
- [x] Validar cpf unique
- [x] validar todos os campos do user
    - [x] Nome
    - [x] Email
    - [x] cpf
    - [x] cnpj
    - [x] type
- [x] Fazer um hash na senha 
- [x] Refatorar o model do User
- [x] Refatorar o controller do user
    - [x] Tratamento de exceções em todos os métodos
- [x] Limpar arquivos que são chamados, mas não são usados
- [x] Refatorar as rotas do User se for necessário
- [x] mudar a deleção do user para lógica e não física
- [x] toda vez que criar um user, criar junto uma carteira
- [x] Criar metodo de ativação de user
- [x] Criar rota de ativação de user
- [x] Quando inativa um user, tem que inativar a carteira dele também
- [x] criar método de ativação e conectar com wallet

### Transactions
- [x] Inserir passowrd na rota (como confirmação)
- [x] refatorar os models das transactions
- [x] refatorar os controllers das transactions
- [x] refatorar as rotas (se necessário)
- [x] limpar arquivos que são chamados, mas não são usados

- [x] na transaction, verificar se o payer existe e se é user comum
- [x] na transaction, verificar se o payee existe e se é shopkeeper ou common
- [x] quando fizer uma transaction tem que somar o valor na carteira do payee
- [x] quando fizer uma transaction tem que subtrair o valor da carteira do payer
- [x] não deixar transferir dinheiro para si mesmo
- [x] setar um tempo limite para o payer pegar o dinheiro devolta (se a carteira do payee tiver saldo)
- [x] o payee pode devolver uma transaction sempre
- [x] ver se o payer tem dinheiro antes de deixar transferir
- [x] quando cancela o dinheiro tem que voltar para a origem
- [x] quando cancela o dinheiro tem que ser subtraido do destino
- [x] na transaction deixar editar apenas o status
- [x] no ato da transferencia deve consultar o mock de autorização antes de concluir
- [x] no ato de transferencia deve consultar o mock de envio de email
- [x] Verificar se o payer está ativo
- [x] Verificar se o payee está ativo
- [x] Verificar se a carteira do payer existe
- [x] Verificar se a carteira do payee existe

### Wallets
- [x] refatorar os models
- [x] refatorar os controllers
- [x] refatorar as rotas (se necessário)
- [x] limpar arquivos que são chamados, mas não são usados
- [x] quando for criar uma carteira, validar se o user existe antes -- ver se isso será necessário já que a criação da carteira vai estar ligada ao usuário (não vamos mais criar uma carteira sozinha)
- [x] criar método de inativação para conectar com o user
- [x] criar método de ativação para conectar com o user
- [x] criar método de depositar dinheiro

### Project
- [ ] montar documentação da api com apidoc
- [ ] criar os testes com phpUnit
- [ ] subir a aplicação pro dockerhub
- [ ] Criar Read me
- [ ] Limpar o projeto