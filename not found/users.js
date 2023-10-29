const express = require('express');
const { Client } = require('pg');
const bodyParser = require('body-parser');

const app = express();
app.use(bodyParser.json());

const dbConfig = {
    user: 'postgres',
    host: 'localhost',
    database: 'job-test',
    password: 'root',
    port: 5432,
};

const client = new Client(dbConfig);
client.connect();

// GET Endpoint - Retrieve a list of users
app.get('/users', (req, res) => {
    client.query('SELECT * FROM users', (err, result) => {
        if (err) {
            res.status(500).json({ error: 'Error getting users' });
        } else {
            res.json(result.rows);
        }
    });
});

// POST Endpoint - Create a new user
app.post('/users', (req, res) => {
    const { username, email } = req.body;
    client.query(
        'INSERT INTO users (username, email) VALUES ($1, $2) RETURNING *',
        [username, email],
        (err, result) => {
            if (err) {
                res.status(500).json({ error: 'Error creating user' });
            } else {
                res.status(201).json(result.rows[0]);
            }
        }
    );
});

// PUT Endpoint - Update an existing user
app.put('/users/:user_id', (req, res) => {
    const user_id = req.params.user_id;
    const { username, email } = req.body;
    client.query(
        'UPDATE users SET username = $1, email = $2 WHERE user_id = $3 RETURNING *',
        [username, email, user_id],
        (err, result) => {
            if (err) {
                res.status(500).json({ error: 'Error updating user' });
            } else {
                if (result.rows.length === 0) {
                    res.status(404).json({ error: 'User not found' });
                } else {
                    res.json(result.rows[0]);
                }
            }
        }
    );
});

const PORT = process.env.PORT || 3000;

app.listen(PORT, () => {
    console.log(`Server is listening on port ${PORT}`);
});