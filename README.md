# Symfony Test Work - 28.11
## 🌐 **Доступ к проекту**

После запуска докер образа основная страница будет доступна по адресу:  

🔗 **[http://localhost:8080/](http://localhost:8080/)**  

---

## 🛠 **Доступ к базе данных (PgAdmin)**

Для работы с базой данных через PgAdmin используйте следующие данные:  

- **Электронная почта:** `admin@admin.com`  
- **Пароль:** `admin`  

### Настройки сервера PostgreSQL:  
- **Имя сервера:** `postgres`  
- **Порт:** `5432`  
- **Служебная база данных:** `symfony_couriers`  
- **Имя пользователя:** `user`  
- **Пароль:** `password`  

---

## 🗃 **Работа с фикстурами**

Для заполнения базы данных используйте следующие команды:  

1. **Добавить курьеров и регионы:**  
   ```bash
   php bin/console doctrine:fixtures:load --group=AutoFillFixtures
2. **Заполнить поездки за 3 месяца:**  
   ```bash
   php bin/console doctrine:fixtures:load --append --group=AppFixtures
