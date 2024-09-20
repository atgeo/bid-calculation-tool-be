# bid-calculation-tool-be

## Connecting to the database
Include the following in the .env file:
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=bct
DB_USERNAME=bct_user
DB_PASSWORD=password
```

After building the Docker image and running the container, you can hit the API at http://localhost:9117.

## Run database migrations and seed

After the container is running, execute the following commands:

```
php artisan migrate
php artisan db:seed
```

## API Endpoint: api/calculate-price
The api/calculate-price endpoint is used to calculate fees and the total price based on the vehicle's price and type.

Request Method: POST

Request Body:

- vehiclePrice (float): The price of the vehicle.
- vehicleType (string): The type of vehicle.

Response: The endpoint returns a JSON object containing the calculated fees:

- buyerFee
- sellerFee
- associationFee
- storageFee
- totalPrice
