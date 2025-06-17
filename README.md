# Symerce

Symerce is a full-stack web application designed as a modern e-commerce solution. The project is under active development and serves as a portfolio piece to showcase professional, production-ready architecture and development practices. The frontend is built with **React** and **TypeScript (TSX)**, while the backend API is developed using **Symfony**.

## Table of Contents

- [Overview](#overview)
- [Tech Stack](#tech-stack)
- [Architecture Highlights](#architecture-highlights)
- [Features](#features)
- [Planned Improvements](#planned-improvements)

## Overview

Symerce is a modular and scalable e-commerce platform built with a clear separation of frontend and backend responsibilities. The primary focus is on designing a robust and extensible backend API using Symfony and modern architectural patterns. The frontend follows modern standards with a responsive, component-based structure using React and TypeScript.

- **Frontend:** A dynamic and interactive UI built with React + TSX, supporting real-time user interactions and intuitive workflows.
- **Backend:** A scalable RESTful API developed in Symfony using clean, layered architecture practices.

## Tech Stack

- **Frontend:**
  - React, TypeScript (TSX), React Router
  - Tailwind CSS
  - Drag & Drop support (e.g. `@dnd-kit/core`)
- **Backend:**
  - Symfony 6.x, Doctrine ORM
  - CQRS (Command Query Responsibility Segregation)
  - DDD (Domain-Driven Design) concepts
  - PHP 8.3
  - MySQL
  - JWT Authentication
- **Development Tools:**
  - Composer (PHP)
  - Node.js & npm/Yarn
  - Docker (local environment)
  - Git (version control)

## Architecture Highlights

The backend follows modern best practices for API development:

- **CQRS Pattern:** Read and write operations are separated, allowing better scalability and testability.
- **Domain-Driven Design (DDD):** Business logic is encapsulated in dedicated domain layers, improving maintainability.
- **Layered Architecture:**
  - Incoming request is transformed into a **DTO** and passed to a **Command**
  - The **CommandHandler** processes the logic (via **Hydrator** or **Assembler** depending on context)
  - Output is mapped back into a **DTO** for API response
- **Test Coverage:** Unit tests are implemented for core application flows and logic validation.

## Features

- Product management interface with drag & drop support for sorting and reordering.
- Dynamic filters and sorting options in the admin panel.
- Interactive UI with real-time updates and modern UX patterns.
- JWT-based authentication and protected API routes.
- Modular codebase ready for future extensions (e.g. payments, checkout, inventory).

## Planned Improvements

- Full implementation of the React frontend including:
  - Public-facing storefront (browsing, product pages, cart, checkout)
  - User authentication and profile management
  - Order history and status tracking
- Expansion of test coverage (unit & integration)
- Advanced role-based access control for the admin panel
- Integration with external services (e.g. payment gateways, shipping APIs)
- Improved CI/CD pipeline and production deployment

---

**Note:** Symerce is currently under active development. The backend API is the primary focus at this stage, with frontend development progressing iteratively.
