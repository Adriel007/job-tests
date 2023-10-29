import express, { Request, Response } from 'express';
import { Client, QueryResult } from 'pg';
import bodyParser from 'body-parser';

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

// Database connection setup
const setupDatabaseConnection = async () => {
    try {
        // Create a table for user actions if it doesn't exist
        const createTableQuery = `
        CREATE TABLE IF NOT EXISTS user_actions (
          id serial PRIMARY KEY,
          user_id integer,
          action text,
          timestamp timestamp
        );
      `;

        await client.query(createTableQuery);
        console.log('User actions table created or already exists.');

        // You can add more database setup logic here if needed.
    } catch (error) {
        console.error('Error setting up the database:', error);
    }
};


// Data model for user actions history
interface UserAction {
    id: number;
    userId: number;
    action: string;
    timestamp: Date;
}

// Implement an endpoint to retrieve user action history with filters
app.get('/user-actions', async (req: Request, res: Response) => {
    try {
        const userId = parseInt(req.query.userId as string);
        const page = parseInt(req.query.page as string);
        const pageSize = 10; // Page size

        const query = `
      SELECT * FROM user_actions
      WHERE user_id = $1
      ORDER BY timestamp DESC
      LIMIT $2 OFFSET $3;
    `;

        const offset = (page - 1) * pageSize;

        const result: QueryResult = await client.query(query, [userId, pageSize, offset]);
        const userActions: UserAction[] = result.rows;

        res.json(userActions);
    } catch (error) {
        res.status(500).json({ error: 'Error fetching user action history' });
    }
});

// Test the endpoint
app.get('/test-user-actions', async (req: Request, res: Response) => {
    // Example call to test the endpoint
    try {
        const userId = 1; // Replace with the desired user ID
        const page = 1; // Desired page

        const result = await client.query('SELECT * FROM user_actions WHERE user_id = $1', [userId]);
        const totalActions = result.rowCount;

        // Call the user action history endpoint with filtering and pagination
        const response = await client.query(`/user-actions?userId=${userId}&page=${page}`);
        const userActions: UserAction[] = response.rows;

        res.json({ totalActions, userActions });
    } catch (error) {
        res.status(500).json({ error: 'Error testing the endpoint' });
    }
});

// Start the server
const PORT = process.env.PORT || 3000;

app.listen(PORT, () => {
    console.log(`Server is listening on port ${PORT}`);
});

// Call the database connection setup function
setupDatabaseConnection();
