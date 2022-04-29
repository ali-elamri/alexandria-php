USE alexandria;

/**
 * Reset database;
 */
DROP TABLE IF EXISTS sales;

DROP TABLE IF EXISTS favourites;

DROP TABLE IF EXISTS inventory;

DROP TABLE IF EXISTS books;

DROP TABLE IF EXISTS authors;

DROP TABLE IF EXISTS categories;

DROP TABLE IF EXISTS users;

DROP TABLE IF EXISTS roles;

/**
 * Create tables;
 */
CREATE TABLE roles(
  id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  name VARCHAR(30) NOT NULL
);

CREATE TABLE users(
  id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  firstname VARCHAR(30) NOT NULL,
  lastname VARCHAR(30) NOT NULL,
  email VARCHAR(60) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  role_id INT DEFAULT 1,
  CONSTRAINT fk_user_role FOREIGN KEY (role_id) REFERENCES roles (id)
);

CREATE TABLE categories(
  id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  name VARCHAR(30) NOT NULL
);

CREATE TABLE authors(
  id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  firstname VARCHAR(30) NOT NULL,
  lastname VARCHAR(30) NOT NULL,
  birthdate DATE,
  country VARCHAR(30)
);

CREATE TABLE books(
  id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  title VARCHAR(30) NOT NULL,
  editor VARCHAR(30),
  published_on DATE,
  price FLOAT NOT NULL,
  cover VARCHAR(255),
  category_id INT NOT NULL,
  author_id INT NOT NULL,
  CONSTRAINT fk_book_category FOREIGN KEY (category_id) REFERENCES categories (id),
  CONSTRAINT fk_book_author FOREIGN KEY (author_id) REFERENCES authors (id)
);

CREATE TABLE inventory(
  id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  book_id INT NOT NULL,
  quantity INT DEFAULT 0,
  CONSTRAINT fk_inventory_book FOREIGN KEY (book_id) REFERENCES books (id)
);

CREATE TABLE favourites(
  id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  user_id INT NOT NULL,
  book_id INT NOT NULL,
  CONSTRAINT fk_favourite_user FOREIGN KEY (user_id) REFERENCES users (id),
  CONSTRAINT fk_favourite_book FOREIGN KEY (book_id) REFERENCES books (id)
);

CREATE TABLE sales(
  id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  user_id INT NOT NULL,
  book_id INT NOT NULL,
  quantity INT NOT NULL,
  unit_price INT NOT NULL,
  is_draft BOOLEAN DEFAULT TRUE,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_sale_user FOREIGN KEY (user_id) REFERENCES users (id),
  CONSTRAINT fk_sale_book FOREIGN KEY (book_id) REFERENCES books (id)
);

/**
 * Seed data;
 */
INSERT INTO
  roles(name)
VALUES
  ("user"),
  ("admin");

INSERT INTO
  users(firstname, lastname, email, password, role_id)
VALUES
  (
    "user",
    "user",
    "user@example.com",
    "$2y$10$yoOAVMV1Ns3zroQAtsVCy.jBqKc0KWfw3ErwjvQETGvReMenpJ3Ky",
    1
  ),
  (
    "admin",
    "admin",
    "admin@example.com",
    "$2y$10$yoOAVMV1Ns3zroQAtsVCy.jBqKc0KWfw3ErwjvQETGvReMenpJ3Ky",
    2
  );

INSERT INTO
  authors(firstname, lastname, birthdate, country)
VALUES
  ("Victor", "Hugo", "1802-02-26", "France"),
  ("Stephen", "King", "1999-02-26", "USA");

INSERT INTO
  categories(name)
VALUES
  ("Epic Novel"),
  ("Scary Novel");

INSERT INTO
  books(
    title,
    editor,
    published_on,
    price,
    cover,
    category_id,
    author_id
  )
VALUES
  (
    "Les miserables",
    "Editor 1",
    "1862-01-01",
    100,
    "cover",
    1,
    1
  ),
  (
    "The shining",
    "Editor 2",
    "1991-01-01",
    200,
    "cover",
    2,
    2
  );