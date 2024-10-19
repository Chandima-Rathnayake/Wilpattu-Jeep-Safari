CREATE TABLE animals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    details TEXT NOT NULL,
    image_url VARCHAR(255) NOT NULL
);


CREATE TABLE feedback (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  role VARCHAR(255) NOT NULL,
  feedback TEXT NOT NULL,
  rating INT(1) NOT NULL,
  image_url VARCHAR(255) NOT NULL,
  submission_date DATETIME NOT NULL
);


CREATE TABLE admin_users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

