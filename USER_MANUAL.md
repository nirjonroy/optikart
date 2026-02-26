# Optikart Admin User Manual

This guide explains what can be updated from the backend and how to do it. Menu names match the admin sidebar. If a menu is missing, your account may not have permission to access it.

**Login**
1. Open `https://your-domain.com/admin/login`.
2. Enter your admin email and password.
3. Click `Login`.

**Dashboard**
- Shows quick stats and recent activity.
- Use it to jump to key sections (Orders, Products, Appointments).

**Orders**
1. Go to `Orders`.
2. Choose a status tab: All, Pending, Process, Courier, On Hold, Completed, Cancelled, Return.
3. Click an order to view details.
4. Update status or take action from the order detail page.

**Products**
- `Manage Categories`
  - `Categories`, `Sub Categories`, `Child Categories`.
  - Add, edit, or delete categories.
- `Manage Products`
  - `Brands` to add brand names and logos.
  - `Size` and `Color` to manage attribute options.
  - `Create Product` to add new products.
  - `Products` to edit existing products, prices, images, and stock.
  - `Product Reviews` to moderate reviews.
  - `Product Report` to view product analytics.
  - `Landing Page` (if used) for product landing content.

**Inventory**
1. Go to `Inventory`.
2. Add stock, view stock history, and manage quantities.

**Promotion (Shop Setup)**
- `Flash Sale` and `Flash Sale Product`.
- `Coupon` to create discounts.
- `Free Shipping` to manage free-shipping rules.

**Website Settings**
- `Settings` (General Setting)
  - Update the main company email, phone numbers, address, open hours, and copyright.
- `Contact Us`
  - Update Contact page title, description, phone, email, address, and Google map link.
- `SEO Setup`
  - Update meta title/description and site keywords.
- `Slider`
  - Update homepage hero slides.
  - For each slide you can edit:
    - Heading (title)
    - Subheading (description)
    - Button text
    - Button link (URL)
    - Image
- `Social Link`
  - Add or edit social media links shown in the footer.
- `Footer Images`
  - Update footer image blocks/banners.
- `Testimonial`
  - Manage testimonials shown on the site.

**Pages**
- `Home Page Setting`
  - Manage collection banners, homepage sections, and homepage images.
- `Custom Page`
  - Create new static pages (policy pages, marketing pages, etc.).

**Blogs**
- `Categories` to organize blog posts.
- `Blogs` to add/edit posts and images.
- `Popular Blogs` to feature content.
- `Comments` to moderate blog comments.

**Appointments**
- `Appointment Requests`
  - View bookings and update their status.
- `Appointment Page`
  - Update appointment page hero text, contact phone, contact email, working hours, and address.
- `Services` (if enabled)
  - Update the list of services shown on the appointment form.

**Users**
- `Users`
  - `Block User`
  - `Customer List`
- `Employee list`
  - Manage admin/staff accounts.
- `Role list` and `Permission list`
  - Control what each admin account can access.

**Email Notifications (Contact & Appointment)**
- **Contact form notifications**
  - The admin notification email is taken from **Settings → General Setting → Contact Email**.
  - If the Contact Email field is not visible, ask your developer to enable it or set it in the system settings.
  - The email shown on the Contact page (Contact Us page settings) is for display only.
- **Appointment notifications**
  - Customers receive a confirmation email.
  - Admin copy is sent as **BCC** to the **Mail From address**.
  - Set the Mail From address in **Email Configuration** (or in `.env` if the Email Configuration menu is hidden).

**Email Configuration (SMTP)**
1. Open `Email Configuration` (if visible in the menu).
2. Fill in SMTP host, email, username, password, port, and encryption.
3. Click `Update`.

If you do not see `Email Configuration` in the sidebar, ask your developer to enable the menu or update `.env` mail settings.

**Need Help**
If something is not visible or editable, it is likely a permissions issue. Ask your admin to grant access under `Role list` and `Permission list`.
