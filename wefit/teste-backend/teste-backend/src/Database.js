const mysql = require('mysql');
require('dotenv').config();

class Database {
    constructor() {
        this.connection = mysql.createConnection({
            host: 'localhost',
            user: 'root',
            password: process.env.MYSQLDB_PASSWORD,
            database: process.env.MYSQLDB_DATABASE,
            port: process.env.MYSQLDB_PORT
        });
    }

    connect() {
        this.connection.connect((err) => {
            if (err) {
                console.error('Erro ao conectar ao banco de dados:', err);
                return;
            }
            console.log('Conexão bem-sucedida ao banco de dados MySQL.');
            this.createTableClientes();
        });
    }

    disconnect() {
        process.on('SIGINT', () => {
            this.connection.end((err) => {
                if (err) {
                    console.error('Erro ao desconectar do banco de dados:', err);
                    return;
                }
                console.log('Desconectado do banco de dados MySQL.');
                process.exit();
            });
        });
    }

    createTableClientes() {
        const query = `
            CREATE TABLE IF NOT EXISTS clientes (
                id INT AUTO_INCREMENT PRIMARY KEY,
                pessoa ENUM('fisica', 'juridica') NOT NULL,
                cnpj VARCHAR(20),
                cpf_responsavel VARCHAR(14),
                nome VARCHAR(255) NOT NULL,
                celular VARCHAR(20),
                telefone VARCHAR(20),
                email VARCHAR(255),
                cep VARCHAR(10),
                logradouro VARCHAR(255),
                numero VARCHAR(10),
                complemento VARCHAR(255),
                cidade VARCHAR(100),
                bairro VARCHAR(100),
                estado VARCHAR(100)
            )
        `;
        this.connection.query(query, (err, results) => {
            if (err) {
                console.error('Erro ao criar tabela de clientes:', err);
                this.disconnect();
                return;
            }
            console.log('Tabela de clientes criada ou já existe.');
            this.disconnect();
        });
    }


    createCliente(cliente, callback) {
        const query = 'INSERT INTO clientes SET ?';
        this.connection.query(query, cliente, (err, result) => {
            if (err) {
                console.error('Erro ao inserir cliente:', err);
                callback(err, null);
                return;
            }
            console.log('Cliente inserido com sucesso:', result.insertId);
            callback(null, result.insertId);
            this.disconnect();
        });
    }

    getAllClientes(callback) {
        const query = 'SELECT * FROM clientes';
        this.connection.query(query, (err, results) => {
            if (err) {
                console.error('Erro ao obter clientes:', err);
                callback(err, null);
                return;
            }
            console.log('Clientes obtidos com sucesso:', results);
            callback(null, results);
            this.disconnect();
        });
    }

    getClienteById(id, callback) {
        const query = 'SELECT * FROM clientes WHERE id = ?';
        this.connection.query(query, id, (err, result) => {
            if (err) {
                console.error('Erro ao obter cliente por ID:', err);
                callback(err, null);
                this.disconnect();
                return;
            }
            if (result.length === 0) {
                console.log('Cliente não encontrado');
                callback(null, null);
                this.disconnect();
            } else {
                console.log('Cliente encontrado:', result[0]);
                callback(null, result[0]);
                this.disconnect();
            }
        });
    }

    updateCliente(id, cliente, callback) {
        const query = 'UPDATE clientes SET ? WHERE id = ?';
        this.connection.query(query, [cliente, id], (err, result) => {
            if (err) {
                console.error('Erro ao atualizar cliente:', err);
                callback(err, null);
                this.disconnect();
                return;
            }
            console.log('Cliente atualizado com sucesso:', result.changedRows);
            callback(null, result.changedRows > 0);
            this.disconnect();
        });
    }

    deleteCliente(id, callback) {
        const query = 'DELETE FROM clientes WHERE id = ?';
        this.connection.query(query, id, (err, result) => {
            if (err) {
                console.error('Erro ao excluir cliente:', err);
                callback(err, null);
                this.disconnect();
                return;
            }
            console.log('Cliente excluído com sucesso:', result.affectedRows);
            callback(null, result.affectedRows > 0);
            this.disconnect();
        });
    }
}

module.exports = Database;