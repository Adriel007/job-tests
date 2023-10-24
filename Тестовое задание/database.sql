-- Crie o banco de dados "job-test" se ainda não existir
CREATE DATABASE job_test;

-- Use o banco de dados "job-test"
\c job_test;

-- Crie a tabela "users" para o serviço de usuários
CREATE TABLE users (
    user_id SERIAL PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    created_at TIMESTAMPTZ DEFAULT NOW()
);

-- Crie a tabela "user_actions" para o histórico de ações com usuários
CREATE TABLE user_actions (
    action_id SERIAL PRIMARY KEY,
    user_id INT REFERENCES users(user_id),
    action_type VARCHAR(50) NOT NULL,
    action_description TEXT,
    created_at TIMESTAMPTZ DEFAULT NOW()
);

-- Insira alguns exemplos de dados na tabela "users"
INSERT INTO users (username, email) VALUES
    ('user1', 'user1@example.com'),
    ('user2', 'user2@example.com'),
    ('user3', 'user3@example.com');

-- Insira alguns exemplos de dados na tabela "user_actions"
INSERT INTO user_actions (user_id, action_type, action_description) VALUES
    (1, 'CREATE', 'User 1 created.'),
    (2, 'CREATE', 'User 2 created.'),
    (1, 'UPDATE', 'User 1 updated information.');

-- Exemplo de consulta para obter o histórico de ações de um usuário específico
SELECT * FROM user_actions WHERE user_id = 1;
