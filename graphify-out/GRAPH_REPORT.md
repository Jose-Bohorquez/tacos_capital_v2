# Graph Report - tacoscapital.online  (2026-09-28)

## Corpus Check
- cluster-only mode — file stats not available

## Summary
- 221 nodes · 249 edges · 65 communities (8 shown, 5 thin omitted)
- Extraction: 72% EXTRACTED · 28% INFERRED · 0% AMBIGUOUS · INFERRED: 70 edges (avg confidence: 0.85)
- Token cost: 0 input · 0 output

## Community Hubs (Navigation)
- Session
- Controller
- AdminProductController
- Request
- Product
- Model
- ProductImage
- helpers.php
- db_functions.php
- db.php
- Router
- schema.sql
- View

## God Nodes (most connected - your core abstractions)
1. `Product` - 27 edges
2. `Session` - 19 edges
3. `ProductImage` - 15 edges
4. `AdminProductController` - 13 edges
5. `AuthMiddleware` - 13 edges
6. `Controller` - 11 edges
7. `Env` - 10 edges
8. `CsrfMiddleware` - 10 edges
9. `Auth` - 8 edges
10. `Category` - 8 edges

## Surprising Connections (you probably didn't know these)
- `whatsapp_link()` --calls--> `Env`  [INFERRED]
  app/Core/helpers.php → app/Core/Env.php
- `csrf_token()` --calls--> `Session`  [INFERRED]
  app/Core/helpers.php → app/Core/Session.php
- `AdminAuthController` --inherits--> `Controller`  [EXTRACTED]
  app/Controllers/Admin/AdminAuthController.php → app/Core/Controller.php
- `Admin` --inherits--> `Model`  [EXTRACTED]
  app/Models/Admin.php → app/Core/Model.php
- `AdminProductController` --inherits--> `Controller`  [EXTRACTED]
  app/Controllers/Admin/AdminProductController.php → app/Core/Controller.php

## Import Cycles
- None detected.

## Communities (65 total, 5 thin omitted)

### Community 0 - "Session"
Cohesion: 0.10
Nodes (4): AdminAuthController, Auth, Session, Admin

### Community 1 - "Controller"
Cohesion: 0.10
Nodes (7): AdminDashboardController, ContactController, HomeController, ProductController, SitemapController, Controller, Env

### Community 2 - "AdminProductController"
Cohesion: 0.18
Nodes (4): AdminProductController, AuthMiddleware, CsrfMiddleware, Category

### Community 3 - "Request"
Cohesion: 0.14
Nodes (4): Request, generarSlug(), parsearInfoTxt(), PDO

### Community 5 - "Model"
Cohesion: 0.17
Nodes (5): Database, PDO, Model, PDO, LegacyRedirect

### Community 7 - "helpers.php"
Cohesion: 0.33
Nodes (6): csrf_field(), csrf_token(), csrf_verify(), e(), old(), whatsapp_link()

### Community 8 - "db_functions.php"
Cohesion: 0.31
Nodes (5): crearProducto(), guardarProducto(), obtenerProductoPorId(), obtenerProductos(), sanitizarNombreCarpeta()

### Community 11 - "schema.sql"
Cohesion: 0.50
Nodes (4): admins, legacy_slug_map, product_images, products

## Knowledge Gaps
- **2 isolated node(s):** `admins`, `legacy_slug_map`
  These have ≤1 connection - possible missing edges or undocumented components. (Counts symbols only; 126 node(s) total have ≤1 connection when file, concept and rationale nodes are included.)
- **5 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `Product` connect `Product` to `Controller`, `AdminProductController`, `Model`, `ProductImage`?**
  _High betweenness centrality (0.142) - this node is a cross-community bridge._
- **Why does `Env` connect `Controller` to `Request`, `Model`, `helpers.php`?**
  _High betweenness centrality (0.095) - this node is a cross-community bridge._
- **Why does `Session` connect `Session` to `AdminProductController`, `ProductImage`, `helpers.php`?**
  _High betweenness centrality (0.071) - this node is a cross-community bridge._
- **Are the 13 inferred relationships involving `Product` (e.g. with `.index()` and `.destroy()`) actually correct?**
  _`Product` has 13 INFERRED edges - model-reasoned connections that need verification._
- **Are the 11 inferred relationships involving `Session` (e.g. with `.login()` and `.destroy()`) actually correct?**
  _`Session` has 11 INFERRED edges - model-reasoned connections that need verification._
- **Are the 5 inferred relationships involving `ProductImage` (e.g. with `.destroy()` and `.destroyImage()`) actually correct?**
  _`ProductImage` has 5 INFERRED edges - model-reasoned connections that need verification._
- **Are the 11 inferred relationships involving `AuthMiddleware` (e.g. with `.index()` and `.create()`) actually correct?**
  _`AuthMiddleware` has 11 INFERRED edges - model-reasoned connections that need verification._