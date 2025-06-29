# Create Employee Microservice

This microservice handles the registration of new employees in the ToyShop platform. It is built using PHP with Slim Framework and communicates using JSON-RPC.

## Technologies Used

- PHP >= 8.0
- Slim Framework
- MySQL
- JSON-RPC
- Docker
- GitHub Actions

## Getting Started

### Prerequisites

- PHP >= 8.0
- Composer
- MySQL

### Installation

```bash
git clone https://github.com/andrespaida/create_employee.git
cd create_employee
composer install
```

### Environment Variables

Create a `.env` file in the root directory with the following content:

```env
DB_HOST=your_mysql_host
DB_PORT=3306
DB_USER=your_mysql_user
DB_PASSWORD=your_mysql_password
DB_NAME=your_mysql_database
```

### Running the Service

```bash
php -S localhost:8000 -t public
```

The service will be running at `http://localhost:8000`.

## Available Endpoint

### POST `/`

Handles JSON-RPC requests. To create a new employee, use the following payload:

#### Request body (JSON):

```json
{
  "jsonrpc": "2.0",
  "method": "createEmployee",
  "params": {
    "name": "John Doe",
    "email": "john@example.com",
    "position": "Manager"
  },
  "id": 1
}
```

#### Response:

```json
{
  "jsonrpc": "2.0",
  "result": {
    "message": "Employee created successfully"
  },
  "id": 1
}
```

## Docker

To build and run the service using Docker:

```bash
docker build -t create-employee .
docker run -p 8000:8000 --env-file .env create-employee
```

## GitHub Actions Deployment

This project includes a GitHub Actions workflow for automatic deployment to an EC2 instance. Configure the following secrets in your GitHub repository:

- `EC2_HOST`
- `EC2_USERNAME`
- `EC2_KEY`
- `EC2_PORT` (optional)

## License

This project is licensed under the MIT License.