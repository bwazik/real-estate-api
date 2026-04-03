# Real Estate API Documentation (React Frontend)

Welcome to the Flomax Real Estate API! This is a Laravel 13 backend designed to provide structured, secure, and fast data to your React application.

---

## 1. 🚀 Full API Documentation (Highly Recommended)
While this document covers the basics, our full, interactive API documentation is generated automatically. 

**With the server running, visit:**
👉 **[http://127.0.0.1:8000/docs/api](http://127.0.0.1:8000/docs/api)**

This documentation page lists **all** available endpoints, required parameters, and example responses. It is the best place to start when you need to understand how to interact with the API.

---

## 2. Project Overview
This API provides all the data needed for a professional real estate website. It includes property listings, search/filtering, user authentication, and a dynamic content management system (CMS) for landing page texts and images.

---

## 3. How to Run Locally
Follow these steps to set up the backend on your machine:

1.  **Clone the repository:** `git clone <repository-url>`
2.  **Install dependencies:** `composer install`
3.  **Setup environment:** `cp .env.example .env` (Update DB settings in `.env`)
4.  **Generate key:** `php artisan key:generate`
5.  **Database & Seeders:** `php artisan migrate --seed`
6.  **Storage Link:** `php artisan storage:link` (Crucial for image access)
7.  **Run server:** `php artisan serve`

---

## 4. Base URL
- **Local:** `http://127.0.0.1:8000/api/v1`

---

## 5. API Structure & Routes
- **Public:** No authentication required. Used for listing properties, filters, and page content.
- **Protected:** Requires a Bearer token in the `Authorization` header. Required for admin actions (adding/editing properties, updating CMS content).

---

## 6. Authentication
To access admin routes:
1.  **Login:** POST `/api/v1/login` with `email` and `password`.
2.  **Get Token:** The response will contain a `token`.
3.  **Use Token:** Add this header to all subsequent requests:
    `Authorization: Bearer <YOUR_TOKEN>`

---

## 7. Important Notes
- **Identifiers:** We use `slug` or `uuid` for public identification. **Never** use numeric `id` in your UI or URLs.
- **Consistent Responses:** Every API response follows this schema:
  ```json
  {
    "success": true,
    "message": "...",
    "data": { ... },
    "meta": { ... },
    "errors": null
  }
  ```

---

## 8. Image Uploads
- **Storage:** Images are stored in `storage/app/public/site/`.
- **Public URL:** You must run `php artisan storage:link` so images are accessible via `http://<your-url>/storage/site/<filename>`.

### Uploading Images (Use `FormData`)
For all image uploads, send a `multipart/form-data` request to `PUT /api/v1/site-content`.

#### Hero Slider (Multiple):
- `key`: "hero_slider"
- `files[]`: [file1, file2]

#### About Image (Single):
- `key`: "about_image"
- `file`: [single_image]

---

## 9. Key Endpoints

### Get Content
- **Hero:** `GET /api/v1/site-content/hero`
- **About:** `GET /api/v1/site-content/about`

### Properties
- **List:** `GET /api/v1/properties?per_page=15&city_slug=cairo`
- **Detail:** `GET /api/v1/properties/the-slug-name`

---

## 10. Common Issues
- **403 Unauthorized:** You are likely missing the `Bearer` token in the header.
- **422 Validation:** Check the `errors` field in the response.
- **Images not loading:** Ensure you have run `php artisan storage:link`.
