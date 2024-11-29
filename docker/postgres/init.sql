
CREATE TABLE regions (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    duration_days INT NOT NULL
);

CREATE TABLE couriers (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE trips (
    id SERIAL PRIMARY KEY,
    region_id INT NOT NULL,
    courier_id INT NOT NULL,
    departure_date DATE NOT NULL,
    arrival_date DATE NOT NULL,
    FOREIGN KEY (region_id) REFERENCES regions(id),
    FOREIGN KEY (courier_id) REFERENCES couriers(id)
);

INSERT INTO regions (name, duration_days) VALUES
('Санкт-Петербург', 5),
('Уфа', 7),
('Нижний Новгород', 4),
('Владимир', 3),
('Кострома', 6),
('Екатеринбург', 10),
('Ковров', 2),
('Воронеж', 5),
('Самара', 8),
('Астрахань', 12);

INSERT INTO couriers (name) VALUES
('Иван Иванов'),
('Петр Петров'),
('Сергей Сергеев'),
('Алексей Алексеев'),
('Дмитрий Дмитриев'),
('Василий Васильев'),
('Елена Еленова'),
('Мария Марьева'),
('Анна Аннова'),
('Ольга Ольгова');
