   Loja Virtual PHP

[![PHP](https://img.shields.io/badge/PHP-7.4%2B-777BB4?style=for-the-badge&logo=php)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-4479A1?style=for-the-badge&logo=mysql)](https://www.mysql.com/)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?style=for-the-badge&logo=bootstrap)](https://getbootstrap.com/)
[![License](https://img.shields.io/badge/License-MIT-yellow?style=for-the-badge)](LICENSE)

Plataforma de e-commerce completa desenvolvida com PHP e MySQL. Inclui carrinho de compras, painel administrativo com CRUD de produtos, sistema de pedidos, autenticação de usuários e gerenciamento de inventário.

  Objetivo

Criar uma solução de e-commerce funcional e profissional, demonstrando boas práticas em desenvolvimento web com PHP tradicional, gerenciamento de banco de dados relacional e segurança de aplicações.

   Funcionalidades

  Cliente
- Catálogo dinâmico de produtos com filtros
-  Sistema de busca e categorização
-  Carrinho de compras com persistência
-  Checkout e processamento de pedidos
-  Autenticação e gerenciamento de conta
-  Histórico de pedidos
-  Sistema de avaliações (opcional)

   Administrador
-  Painel administrativo completo
-  Adicionar novos produtos
-  Editar informações de produtos
-  Deletar produtos
-  Visualizar vendas e pedidos
-  Gerenciar usuários
-  Controle de acesso

   Tecnologias Utilizadas

   Backend
- PHP 7.4+ - Linguagem de programação server-side
- MySQL 5.7+ - Banco de dados relacional
- Session Management - Gerenciamento de sessões de usuário
- PDO - Acesso seguro ao banco de dados

   Frontend
- HTML5 - Estrutura semântica
- CSS3 - Estilização moderna
- Bootstrap 5 - Framework CSS responsivo
- JavaScript - Interatividade no cliente
- jQuery - Manipulação do DOM

   Pré-requisitos

- PHP 7.4+ com extensões: PDO, MySQLi
- MySQL 5.7+ ou MariaDB
- Apache/Nginx com suporte a .htaccess
- Composer (opcional, para gerenciamento de dependências)
- Git para versionamento

   Instalação e Setup

   1. Clonar o Repositório

```bash
git clone https://github.com/FHPBeto/loja-virtual-php.git
cd loja-virtual-php
```

   2. Configurar Banco de Dados

   Criar banco de dados

```bash
mysql -u root -p
```

```sql
CREATE DATABASE loja_virtual CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE loja_virtual;
```

   Importar schema

```bash
mysql -u root -p loja_virtual < database/schema.sql
```

  3. Configurar Variáveis de Ambiente

```bash
cp .env.example .env
```

Editar `.env` com suas credenciais:

```env
DB_HOST=localhost
DB_USER=root
DB_PASSWORD=sua_senha
DB_NAME=loja_virtual
DB_PORT=3306

APP_NAME=Loja Virtual
APP_ENV=development
APP_DEBUG=true
APP_URL=http://localhost

MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USER=seu_email@gmail.com
MAIL_PASSWORD=sua_senha_app
```

  4. Configurar Servidor Web

  Apache (.htaccess)

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]
</IfModule>
```

   Nginx

```nginx
location / {
    if (!-e $request_filename) {
        rewrite ^(.*)$ /index.php?url=$1 break;
    }
}
```

   5. Iniciar Servidor

```bash
# Usando PHP built-in server
php -S localhost:8000

# Ou usar Apache/Nginx
# Acessar: http://localhost/loja-virtual-php
```

  Estrutura do Projeto

```
loja-virtual-php/
├── admin/                      # Painel administrativo
│   ├── adicionar_produto.php
│   ├── editar_produto.php
│   ├── excluir_produto.php
│   ├── login.php
│   ├── logout.php
│   ├── produtos.php
│   └── index.php
├── server/                     # Lógica de backend
│   ├── conexao.php
│   ├── funcoes.php
│   └── validacao.php
├── layouts/                    # Templates compartilhados
│   ├── header.php
│   ├── footer.php
│   └── navbar.php
├── assets/                     # Recursos estáticos
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── script.js
│   └── imgs/
│       └── [imagens dos produtos]
├── database/                   # Banco de dados
│   ├── schema.sql
│   └── seeders.sql
├── .env.example               # Exemplo de variáveis
├── .gitignore
├── .editorconfig
├── index.php                  # Página inicial
├── produtos.php               # Listagem de produtos
├── single_product.php         # Detalhes do produto
├── carrinho.php               # Carrinho de compras
├── checkout.php               # Finalização de compra
├── registrar.php              # Registro de usuário
├── conta.php                  # Conta do usuário
├── README.md
└── LICENSE
```

   Banco de Dados

   Tabelas Principais

usuarios  
```sql
CREATE TABLE usuarios (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  senha VARCHAR(255) NOT NULL,
  telefone VARCHAR(20),
  endereco TEXT,
  cidade VARCHAR(50),
  estado VARCHAR(2),
  cep VARCHAR(10),
  data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

produtos
```sql
CREATE TABLE produtos (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(150) NOT NULL,
  descricao TEXT,
  preco DECIMAL(10, 2) NOT NULL,
  estoque INT NOT NULL DEFAULT 0,
  categoria VARCHAR(50),
  imagem VARCHAR(255),
  ativo BOOLEAN DEFAULT true,
  data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

pedidos
```sql
CREATE TABLE pedidos (
  id INT PRIMARY KEY AUTO_INCREMENT,
  usuario_id INT NOT NULL,
  total DECIMAL(10, 2) NOT NULL,
  status VARCHAR(50) DEFAULT 'pendente',
  data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);
```

itens_pedido
```sql
CREATE TABLE itens_pedido (
  id INT PRIMARY KEY AUTO_INCREMENT,
  pedido_id INT NOT NULL,
  produto_id INT NOT NULL,
  quantidade INT NOT NULL,
  preco_unitario DECIMAL(10, 2) NOT NULL,
  FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
  FOREIGN KEY (produto_id) REFERENCES produtos(id)
);
```

   Segurança

   Implementações

- ✅ Prepared Statements (PDO) contra SQL Injection
- ✅ Password Hashing com `password_hash()`
- ✅ Session Management seguro
- ✅ CSRF Protection
- ✅ Input Validation e Sanitization
- ✅ Output Escaping

   Boas Práticas

```php
// ✅ Usar Prepared Statements
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
$stmt->execute([$email]);

// ✅ Hash de senhas
$senha_hash = password_hash($senha, PASSWORD_BCRYPT);

// ✅ Validar entrada
$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

// ✅ Escapar saída
echo htmlspecialchars($usuario['nome']);
```

  Testando a Aplicação

1. Inicie o servidor: `php -S localhost:8000`
2. Acesse: `http://localhost:8000`
3. Teste as funcionalidades:
   - Registrar novo usuário
   - Navegar pelo catálogo
   - Adicionar produtos ao carrinho
   - Fazer checkout
   - Acessar painel admin (login: admin / senha: admin)
   - Adicionar/editar/deletar produtos

   Troubleshooting

   Erro: "Connection refused"
```bash
# Verificar se MySQL está rodando
sudo systemctl start mysql

# Ou verificar credenciais em .env
```

   Erro: "Call to undefined function"
```bash
# Verificar se extensões PHP estão habilitadas
php -m | grep pdo
```

   Erro: "Permission denied"
```bash
# Ajustar permissões de pastas
chmod -R 755 assets/
chmod -R 777 uploads/
```

   Recursos Úteis

- [Documentação PHP](https://www.php.net/docs.php)
- [Manual MySQL](https://dev.mysql.com/doc/)
- [Bootstrap 5 Docs](https://getbootstrap.com/docs/5.0/)
- [OWASP Security](https://owasp.org/www-project-top-ten/)
- [PHP Security Best Practices](https://www.php.net/manual/en/security.php)

   Contribuindo

Contribuições são bem-vindas! Para contribuir:

1. Faça um fork do repositório
2. Crie uma branch para sua feature (`git checkout -b feature/MinhaFeature`)
3. Commit suas mudanças (`git commit -m 'feat: descrição da mudança'`)
4. Push para a branch (`git push origin feature/MinhaFeature`)
5. Abra um Pull Request

   Licença

Este projeto está licenciado sob a Licença MIT - veja o arquivo [LICENSE](LICENSE) para detalhes.

   Autor

FHPBeto
- GitHub: [@FHPBeto](https://github.com/FHPBeto)
- Email: [seu-email@example.com]

   Suporte

Encontrou um problema? Abra uma [issue](https://github.com/FHPBeto/loja-virtual-php/issues) no repositório.

---

"Desenvolvido como projeto educacional de e-commerce"
