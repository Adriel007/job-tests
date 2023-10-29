# User API Documentation

This documentation outlines the available endpoints and their functionality for the User API.

## GET Endpoint - Retrieve a list of users

- **URL:** `/users`
- **Method:** `GET`
- **Description:** This endpoint retrieves a list of all users from the database.

**Request Parameters:**
- None required.

**Response:**

- **Success (200 OK):** Returns a JSON array containing the list of users. Each user is represented as an object with properties such as username and email.
- **Error (500 Internal Server Error):** If an error occurs while retrieving the users from the database.

## POST Endpoint - Create a new user

- **URL:** `/users`
- **Method:** `POST`
- **Description:** This endpoint allows you to create a new user and store their information in the database.

**Request Parameters:**

- **Request Body (JSON):**
  - `username` (string): The username of the new user.
  - `email` (string): The email address of the new user.

**Response:**

- **Success (201 Created):** Returns a JSON object representing the newly created user. The response includes the `user_id`, `username`, and `email` of the user.
- **Error (500 Internal Server Error):** If an error occurs while creating the user in the database.

## PUT Endpoint - Update an existing user

- **URL:** `/users/:user_id`
- **Method:** `PUT`
- **Description:** This endpoint allows you to update the information of an existing user identified by their `user_id`.

**Request Parameters:**

- **URL Parameters:**
  - `user_id` (integer): The unique identifier of the user you want to update.

**Request Body (JSON):**

- `username` (string): The updated username for the user.
- `email` (string): The updated email address for the user.

**Response:**

- **Success (200 OK):** Returns a JSON object representing the updated user, including their `user_id`, `username`, and `email`.
- **Error (500 Internal Server Error):** If an error occurs while updating the user's information in the database.
- **Error (404 Not Found):** If the specified `user_id` is not found in the database.

Endpoint: GET /user-actions
Description: Retrieve the user action history with optional filters by user ID and page navigation.
Query Parameters:
- userId (number): User ID (required).
- page (number): Page number (optional, default: 1).

Usage example:
- /user-actions?userId=1&page=2

Response:
- Array of user action objects.