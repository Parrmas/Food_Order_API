# Food_Order_API

A RESTful API for food ordering, including menu browsing, cart management, orders, and payments.
Tech used: Core PHP

---

## Table of Contents

- [Features](#features)  
- [Technologies](#technologies)  
- [API Endpoints](#api-endpoints)  
- [Getting Started](#getting-started)  
- [Configuration](#configuration)  
- [Usage](#usage)  
- [Testing](#testing)  
- [Contributing](#contributing)  
- [License](#license)  

---

## Features

- **Food menu management** (browse all, by category, search, single item)  
- **Cart system** (add, remove, update, clear, view items)  
- **Order system** (place orders, view all or single order, manage order items)  
- **Funds & payments** (add funds, handle payment flow)  
- **Categories** (browse available categories)  
- **User management** (basic class for user logic)  

---

## Technologies

- **Language**: PHP  
- **Server**: Apache / Nginx (with `.htaccess` for routing)  
- **Database**: MySQL (or compatible)  
- **Dependencies**: none (vanilla PHP)  

---

## API Endpoints

### 🛒 Cart
| Method | Endpoint             | Description                     |
|--------|----------------------|---------------------------------|
| POST   | `/cart/addItem.php`  | Add an item to the cart         |
| GET    | `/cart/getCart.php`  | Retrieve current cart           |
| POST   | `/cart/updateItem.php` | Update item quantity/details   |
| POST   | `/cart/removeItem.php` | Remove an item from the cart   |
| POST   | `/cart/clearCart.php`  | Clear the entire cart          |

---

### 📂 Category
| Method | Endpoint               | Description              |
|--------|------------------------|--------------------------|
| GET    | `/category/listAll.php` | List all categories      |

---

### 🍔 Food
| Method | Endpoint                      | Description                          |
|--------|-------------------------------|--------------------------------------|
| GET    | `/food/listAll.php`           | List all food items                  |
| GET    | `/food/listByCategory.php`    | List food items by category          |
| GET    | `/food/listBySearch.php`      | Search food items by keyword         |
| GET    | `/food/listOne.php?id={id}`   | Get details of a specific food item  |

---

### 💳 Fund & Payment
| Method | Endpoint                    | Description            |
|--------|-----------------------------|------------------------|
| POST   | `/fund_payment/addFund.php` | Add funds to account   |

---

### 📦 Orders
| Method | Endpoint                          | Description                         |
|--------|-----------------------------------|-------------------------------------|
| GET    | `/order/listAll.php`              | List all orders                     |
| GET    | `/order/listOne.php?id={id}`      | Get details of a specific order     |
| POST   | `/order/placeOrder.php`           | Place a new order                   |
| GET    | `/order/orderItemHelper.php`      | Manage items inside an order (if applicable) |

---

## Getting Started

### Prerequisites

- PHP >= 7.4  
- MySQL  
- Apache/Nginx with `.htaccess` support enabled  

