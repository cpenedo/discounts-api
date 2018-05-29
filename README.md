# Discounts-api

Small (micro)service that calculates discounts for orders.

# EndPoints

  - /api/discount/order (creates a new order)
  - /api/discount/discount (creates a new discount)
  - /api/discount/customer (creates a new customer)
  - /api/discount/customers (create multiple customers)
  - /api/discount/product (creates a new product)
  - /api/discount/products (create multiple products)
  - /api/discount/category (creates a new category)
  - /api/discount/categories (create multiple categories)

### Usage

Run migrations:

```sh
$ php artisan migrate
```

Run seeder:
```sh
$ php artisan db:seed
```

Run tests:
```sh
$ vendor/bin/phpunit
```

**New Order**
----
  Returns json data about a new order and applyed discounts.

* **URL**

  /api/discounts/order

* **Method:**

  `POST`
  
*  **Sample Call**

```javascript
{
  "id": "1",
  "customer-id": "1",
  "items": [
    {
      "product-id": "B102",
      "quantity": "10",
      "unit-price": "4.99",
      "total": "49.90"
    }
  ],
  "total": "49.90"
}
  ```
  
  **New Discount**
----
  Returns json data about the new record validation data.

* **URL**

  /api/discounts/discount

* **Method:**

  `POST`
  
*  **Sample Call**

```javascript
{
    "name": "10% Total Discount",
    "description": "A customer who has already bought for over € 1000, gets a discount of 10% on the whole order.",
    "minimum_customer_revenue": "1000",
    "total_order_discount_percent": "10",
    "category_id": null,
    "multiple_products_same_category": null,
    "free_category_products": null,
    "minimum_quantity_same_category": null,
    "cheapest_product_discount_percent": null
}
  ```

  **New Customer**
----
  Returns json data about the new record validation data.

* **URL**

  /api/discounts/customer

* **Method:**

  `POST`
  
*  **Sample Call**

```javascript
{
    "id": "1",
    "name": "Coca Cola",
    "since": "2014-06-28",
    "revenue": "492.12"
}
  ```
  
  **New Customers**
----
  Returns json data about the new records validation data.

* **URL**

  /api/discounts/customers

* **Method:**

  `POST`
  
*  **Sample Call**

```javascript
[
  {
    "id": "1",
    "name": "Coca Cola",
    "since": "2014-06-28",
    "revenue": "492.12"
  },
  {
    "id": "2",
    "name": "Teamleader",
    "since": "2015-01-15",
    "revenue": "1505.95"
  },
  {
    "id": "3",
    "name": "Jeroen De Wit",
    "since": "2016-02-11",
    "revenue": "0.00"
  }
]
  ```
  
  **New Product**
----
  Returns json data about the new record validation data.

* **URL**

  /api/discounts/product

* **Method:**

  `POST`
  
*  **Sample Call**

```javascript
{
    "id": "A101",
    "description": "Screwdriver",
    "category": "1",
    "price": "9.75"
}
  ```

  **New Products**
----
  Returns json data about the new records validation data.

* **URL**

  /api/discounts/products

* **Method:**

  `POST`
  
*  **Sample Call**

```javascript
[
  {
    "id": "A101",
    "description": "Screwdriver",
    "category": "1",
    "price": "9.75"
  },
  {
    "id": "A102",
    "description": "Electric screwdriver",
    "category": "1",
    "price": "49.50"
  }
]
  ```

  **New Category**
----
  Returns json data about the new record validation data.

* **URL**

  /api/discounts/category

* **Method:**

  `POST`
  
*  **Sample Call**

```javascript
{
    "id": "1",
    "name": "Tools"
}
  ```

  **New Categories**
----
  Returns json data about the new records validation data.

* **URL**

  /api/discounts/categories

* **Method:**

  `POST`
  
*  **Sample Call**

```javascript
[
    {
        "id": "1",
        "name": "Tools"
    },
    {
        "id": "2",
        "name": "Switches"
    },
]
  ```
