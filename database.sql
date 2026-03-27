CREATE DATABASE IF NOT EXISTS feedback_portal;
USE feedback_portal;

CREATE TABLE complaints (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    tracking_id     VARCHAR(20)   NOT NULL UNIQUE,
    full_name       VARCHAR(100)  NOT NULL,
    email           VARCHAR(150)  NOT NULL,
    phone           VARCHAR(20)   NOT NULL,
    category        VARCHAR(50)   NOT NULL,
    subject         VARCHAR(200)  NOT NULL,
    message         TEXT          NOT NULL,
    priority        ENUM('low','medium','high') DEFAULT 'medium',
    attachment      VARCHAR(255)  DEFAULT NULL,
    status          ENUM('pending','in_progress','resolved','closed') DEFAULT 'pending',
    admin_remarks   TEXT          DEFAULT NULL,
    created_at      DATETIME      DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME      DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE admin_users (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    username    VARCHAR(50)  NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,
    full_name   VARCHAR(100) NOT NULL,
    created_at  DATETIME     DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO admin_users (username, password, full_name)
VALUES ('admin', '$2y$10$8K1p/a0dL1LXMIgZ5yXgC.WjF7hHHVp0H0cLqp5Feze1DIVOqKfS2', 'System Admin');
