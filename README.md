<h1 align="center">Digital Payments 💰</h1>

![Badge](https://img.shields.io/github/forks/DayaneCordeiro/Digital_Payments?style=social)&nbsp;&nbsp;&nbsp;
![Badge](https://img.shields.io/github/stars/DayaneCordeiro/Digital_Payments?style=social)&nbsp;&nbsp;&nbsp;
![Badge](https://img.shields.io/github/license/DayaneCordeiro/Digital_Payments?style=social)<br>

![Badge](https://img.shields.io/badge/PHP-8.0.3-blue)
![Badge](https://img.shields.io/badge/Docker-20.10.8-blue)
![Badge](https://img.shields.io/badge/Laravel-8.68.0-critical)
![Badge](https://img.shields.io/badge/MySQL-5.7.22-important)
![Badge](https://img.shields.io/badge/Composer-2.1.6-yellowgreen)
![Badge](https://img.shields.io/badge/PHPUnit-9.5.10-sucess)

![Badge](https://img.shields.io/badge/PHPMyAdmin-colocar_versão-orange)
![Badge](https://img.shields.io/badge/Nginx-colocar_versão-sucess)
![Badge](https://img.shields.io/badge/Apidoc-colocar_versão-blue)
![Badge](https://img.shields.io/badge/Redis-colocar_versão-red)
![Badge](https://img.shields.io/badge/MailHog-colocar_versão-success)
![Badge](https://img.shields.io/badge/Carbon-colocar_versão-success)

<h1>Desenvolvimento de uma aplicação com ênfase em pagamentos digitais.</h1>

<p align="center">
    <a href="#about">Sobre</a> •
    <a href="#pre-requirements">Pré requerimentos</a> • 
    <a href="#how-to-use">Como usar</a> • 
    <a href="#software-configs">Configurações do Software</a> •
    <a href="#businnes-rulers">Regras de negócio aplicadas</a> •
    <a href="#enhancements">Melhorias propostas para as próximas versões</a> •
    <a href="#technologies">Tecnologias</a> •
    <a href="#author">Autora</a>
</p>

<h4 align="center"> 
	🚧 Project in development 🚧<br>
    App version: 1.0
</h4>

<div id="about">
<h1>Sobre</h1>
<h3>Description</h3>
<div align="justify">
<li>Os tempos de pandemia trouxeram à tona um fato que as pessoas mais inovadoras já haviam se atentado há muito tempo, a necessidade de simplificar os processos que realizamos no nosso dia a dia. Uma das coisas mais burocráticas ainda nos dias de hoje é lidar com questões bancárias. Além dessa burocracia de utilizar as funções dos bancos físicos, ainda existe a questão da cobrança de diversas taxas de serviço.</li><br>
<li>A partir dessa necessidade, surgiram os serviços de pagamentos online. Com o objetivo principal de facilitar a vida dos usuários, poupando aquele tempo que era perdido nas filas, removendo diversas taxas e agilizando todos os processos através de poucos cliques.</li><br>
<li>Tendo tudo isso em mente, neste projeto foi desenvolvida uma API Restful, baseada no framework Laravel versão: <b style="color: red;">x.x.x</b> com a finalidade de abstrair de forma mais simplificada a lógica de uma aplicação de pagamentos digital. Foram abordados apenas alguns dos serviços oferecidos por esse tipo de plataforma, sendo o foco principal a transferência de dinheiro entre usuários comuns e lojistas.</li>
</div>

<h3>Ferramentas utilizadas</h3>
<div align="justify"> 
<li><b>Sistema operacional: </b>Windows 10 Professional</li>
<li><b>IDE: </b>Visual Studio Code versão: <b style="color:red">x.x.x</b></li>
<li><b>Docker: </b>Desktop versão: <b style="color:red">x.x.x</b></lv>
<li><b>SGDB: </b>PhpMyAdmin web versão: <b style="color:red">x.x.x</b></li>
<li><b>Máquina utilizada: </b>Dell Inspiron modelo: <b style="color:red">x.x.x</b></li>
<li><b>Processador: </b>Intel Core I7 geração: <b style="color:red">x.x.x</b></li>
</div>

<div id="pre-requirements">
<h1>Pré requerimentos</h1>
<div align="justify">
<li>Para executar o projeto é necessário ter o docker instalado na máquina e baixar a imagem disponibilizada no site dockerhub, link: <b style="color:red">Inserir o link aqui</b></li>
<li>Após a realização do download e instalação da imagem, estarão disponíveis seis containers:</li>
<ul>
<li><b>Container app:</b> Contém a imagem do PHP</li>
<li><b>Container mysql:</b> Contém a imagem do MySQL</li>
<li><b>Container nginx:</b> Contém a imagem de uma versão leve do servidor Nginx para execução local da aplicação.</li>
<li><b>Container phhmyadmin:</b> Contém a imagem do SGDB.</li>
<li><b>Container redis:</b> Contém a imagem do Redis para manipulação de cache.</li>
<li><b>Container mailhog:</b> Contém a imagem do MailHog para serviço de correio local.</li>
</ul>
</div>
</div>

<div id="how-to-use">
    <h1>Como usar</h1>
To do </div>

<div id="software-configs">
<h1>Configurações do Software</h1>
<div align="justify">
<li>O software foi construído com a arquitetura de uso padrão do Laravel, MVC (Model, View e Controller). Tendo os principais controllers dentro da pasta de versionamento da API (v1). E um controller com funções de validação reutilizadas em outros controllers.</li>
<li>Foi utilizado um sistema de roteamento, com algumas funções nativas do Laravel e outras incluídas sob demanda do projeto. O Laravel possui cinco tipos de rotas padrão (index, show, store, destroy e update) acessadas através da função `Route::apiResource();` nem todas foram necessárias no projeto visto as regras de negócio aplicadas.</li>
<li>Para manipulação simplificada das datas, foi utilizada a extensão Carbon.</li>
</div>
</div>

<div id="businnes-rulers">
<h1>Regras de negócio aplicadas</h1>
<div align="justify">
<li>Apenas usuários comuns podem fazer transferência de dinheiro.</li>
<li>Usuários comuns e lojistas podem receber transferências de dinheiro.</li>
<li>A criação de um usuário, cria também sua carteira (que é onde fica seu saldo).</li>
<li>A exclusão de um usuário é apenas lógica e afeta também sua carteira, ou seja, o usuário e sua carteira são inativados.</li>
<li>A ativação de um usuário afeta também sua carteira, ou seja, ambos são ativos.</li>
<li>O método de cancelamento de transações foi criado com o intuído de apenas pessoal interno ter acesso, mas depende do saldo da carteira do recebedor.</li>
<li>O método de cancelamento de transação por usuário permite que o recebedor ou pagador cancelem a transação e retornem o dinheiro à sua origem.</li>
<li>A transação precisa ser aprovada por um serviço externo, caso contrário, ela recebe o status "not-approved" e o valor não é enviado.</li>
<li>O recebedor precisa receber notificação quando a transação é realizada, caso ocntrário, a transação não é aprovada.</li>
<li>Um recebedor sempre pode cancelar a transação, retornando assim, o valor à sua origem.</li>
<li>Um pagador tem uma tolerância de cinco minutos para cancelar uma transação, contanto que ainda haja saldo na carteira do recebedor. Sendo esse tempo passado, é necessário entrar em contato com o pessoal interno do aplicativo.</li>
<li>Caso a transação seja aprovada pelo serviço externo e a notificação seja enviada ao recebedor, o valor é transferido.</li>
</div>
</div>

<div id="enhancements">
<h1>Melhorias propostas para as próximas versões</h1>
<div align="justify">
<li>Autenticação da API.</li>
<li>Criação de logs para os controllers.</li>
<li>Reaproveitamento das validações e modularização em formato de resources.</li>
</div>
</div>

<div id="technologies">
    <h1>Tecnologias</h1>
 
 The following tools were used in the construction of the project:

- [PHP](https://www.php.net/)
- [MySQL](https://www.mysql.com/)
- [Apidoc](https://apidocjs.com/)
- [Composer](insert_link_here)
- [Docker](insert_link_here)
- [Laravel](insert_link_here)
- [PhpUnit](insert_link_here)
</div>

<div id="autho">
    <h1>Autora</h1>
    <a href="https://github.com/DayaneCordeiro">
        <img style="border-radius: 50%;" src="https://avatars.githubusercontent.com/u/50596100?v=4" width="150px;" alt=""/>
        <br />
        <sub><b>Dayane Cordeiro</b></sub>
    </a>

Made with ❤️ by Dayane Cordeiro!

✔ Computer Engineering student at PUC Minas<br>
✔ PHP Developer<br>
✔ Passionate about software development, computer architecture and learning.<br>

[![Linkedin Badge](https://img.shields.io/badge/-Dayane-blue?style=flat-square&logo=Linkedin&logoColor=white&link=https://www.linkedin.com/in/dayane-cordeiro-1b761318b/)](https://www.linkedin.com/in/dayane-cordeiro-1b761318b/)
[![Gmail Badge](https://img.shields.io/badge/-dayane.cordeirogs@gmail.com-c14438?style=flat-square&logo=Gmail&logoColor=white&link=mailto:dayane.cordeirogs@gmail.com)](mailto:dayane.cordeirogs@gmail.com)

</div>
