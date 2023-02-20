# Recruitment Task 🧑‍💻👩‍💻

### Invoice module with approve and reject system as a part of a bigger enterprise system. Approval module exists and you should use it. 


<table>
<tr>
<td>

- Invoice contains:
  - Invoice number
  - Invoice date
  - Due date
  - Company
    - Name 
    - Street Address
    - City
    - Zip code
    - Phone
  - Billed company
    - Name 
    - Street Address
    - City
    - Zip code
    - Phone
    - Email address
  - Products
    - Name
    - Quantity
    - Unit Price	
    - Total
  - Total price
</td>
<td>
<img src="https://templates.invoicehome.com/invoice-template-us-classic-white-750px.png" style="width: auto"; height:100%" />
</td>
</tr>
</table>

* You should be able to approve or reject each invoice just once (if invoice is approved you cannot reject it and vice versa.

* You can assume that product quantity is integer and only currency is USD.

* Proper seeder is located in Invoice module and it’s named DatabaseSeeder

* In .evn.example proper connection to database is established.

* Using proper DDD structure is preferred (with elements like entity, value object, repository, mapper / proxy, DTO) but not mandatory. Unit tests in plus.

* In this task you must save only invoices so don’t write repositories for every model/ entity.

* Only 3 endpoints are required:
  - Show Invoice data, like in the list above
  - Approve Invoice
  - Reject Invoice

* Docker is in docker catalog and you need only do 
  ```
  docker compose up -d
  ``` 
  to make everything work
