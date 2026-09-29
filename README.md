# Coco Cakes

Coco Cakes is a Laravel project for browsing cake products and sending custom cake requests. The project is currently at the Lab Activity 2 stage, with models, migrations, database-backed pages, and role-based access in place.

## Current status

- Visitors can view the home, menu, product details, about, and contact pages.
- Users can register, log in, manage their profile, and submit cake requests.
- The menu and order form now load products from the database.
- Users can add pet profiles and view their submitted cake requests, saved cakes, and pets from My Account.
- Orders use a saved pet profile instead of asking for pet details again.
- Admins have separate Products and Orders pages.
- Admins can view database records and add new products.
- Product removal uses Laravel soft deletes.
- The new forms and admin tables use the existing Coco Cakes design and responsive layout.

## Still to be added

- Editing and deleting products from the admin page.
- Updating an order's status from the admin page.
- More complete automated tests for the product and order features.
