# 🏫 Sistema de Gerenciamento de Creche

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![Vue.js](https://img.shields.io/badge/Vue.js-35495E?style=for-the-badge&logo=vue.js&logoColor=4FC08D)](https://vuejs.org/)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com)

Sistema completo para gerenciamento de creches, desenvolvido com Laravel e Vue.js, oferecendo uma solução robusta e intuitiva para administração de instituições de educação infantil.

## 🚀 Funcionalidades

- Gestão de alunos e responsáveis
- Controle de matrículas
- Gestão de turmas e professores
- Controle financeiro
- Relatórios e dashboards
- Sistema de comunicação
- Gestão de documentos
- Controle de frequência

## 📋 Pré-requisitos

- PHP >= 8.1
- Composer
- Node.js >= 16
- MySQL >= 8.0
- NPM ou Yarn

## 🔧 Instalação

1. Clone o repositório:
```bash
git clone https://github.com/seu-usuario/creche_management.git
cd creche_management
```

2. Instale as dependências do PHP:
```bash
composer install
```

3. Instale as dependências do Node.js:
```bash
npm install
```

4. Configure o ambiente:
```bash
cp .env.example .env
php artisan key:generate
```

5. Configure o banco de dados no arquivo `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=creche_management
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

6. Execute as migrações e seeders:
```bash
php artisan migrate --seed
```

7. Compile os assets:
```bash
npm run dev
```

8. Inicie o servidor:
```bash
php artisan serve
```

## 🧪 Testes

Para executar os testes do projeto:

```bash
# Executar todos os testes
php artisan test

# Executar testes específicos
php artisan test --filter=NomeDoTeste

# Executar testes com cobertura
php artisan test --coverage
```

## 📦 Estrutura do Projeto

```
creche_management/
├── app/                # Código fonte principal
├── bootstrap/         # Arquivos de inicialização
├── config/           # Configurações do sistema
├── database/         # Migrações e seeders
├── public/           # Arquivos públicos
├── resources/        # Assets e views
├── routes/           # Definição de rotas
├── storage/          # Arquivos de armazenamento
└── tests/            # Testes automatizados
```

## 🔐 Segurança

- Autenticação via Laravel Sanctum
- Proteção CSRF
- Validação de dados
- Sanitização de inputs
- Controle de acesso baseado em roles

## 🤝 Contribuindo

1. Faça um Fork do projeto
2. Crie uma Branch para sua Feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a Branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📝 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

## 👥 Autores

- **Seu Nome** - *Desenvolvimento* - [seu-usuario](https://github.com/seu-usuario)

## 🙏 Agradecimentos

- Laravel Team
- Vue.js Team
- Tailwind CSS Team
- Todos os contribuidores

---

⭐️ From [Artaxerxes Nazareno](https://github.com/artaxerxesnazareno)
