<h1 align="center">
UAS BUSINESS INTELLIGENCE WEBSITE SUPERSTORE SALES
</h1>

<img align="center"><img width="2100" height="700" alt="HEADER GITHUB" src="https://github.com/user-attachments/assets/ae53c7a8-571e-4b2a-a76c-ae5bec100a1e" /></img>

<div align="center">

## Nama Anggota Tim Pengembang

| Nama | NIM |
|------|------|
| Nabila Imtiyaz Agustin | 2409116011 |
| Zahra Aulia Rahmah | 2409116020 |
| Aliyah Azzah Sekedang | 2409116021 |

<br>

Sistem Informasi • Fakultas Teknik • Universitas Mulawarman

</div>

# SerbaSerbi Business Dashboard

Website Business Intelligence berbasis Laravel yang dirancang untuk membantu proses analisis penjualan, monitoring performa bisnis, dan pengambilan keputusan berbasis data menggunakan pendekatan Data Warehouse, ETL, dan Machine Learning (K-Means Clustering).

---

## 📂 Deskripsi Program

**SerbaSerbi Sales Dashboard** merupakan sistem pendukung keputusan (Decision Support System) yang dibangun menggunakan framework Laravel dan MySQL untuk mengolah serta memvisualisasikan data penjualan dari dataset **Global Superstore Sales**.

Sistem ini mengintegrasikan:

- Business Intelligence (BI)
- Data Warehouse (Star Schema)
- ETL (Extract, Transform, Load)
- Dashboard Analytics
- Machine Learning (K-Means Clustering)

Tujuan utama sistem adalah membantu manajemen memahami performa penjualan, profitabilitas, kontribusi produk, serta menghasilkan rekomendasi bisnis berbasis data.

---

## 📂 Fitur Utama

### 1. Dashboard Analytics

Menampilkan ringkasan performa bisnis secara real-time melalui berbagai visualisasi interaktif.

#### KPI Cards

* Total Sales
* Total Orders
* Total Customers
* Total Profit
* Total Quantity Sold

#### Visualisasi

* Sales Trend Analysis
* Profit Trend Analysis
* Category Contribution Analysis
* Sales & Profit Distribution
* Product Segmentation Analysis

---

### 2. Transaction Management

Mengelola data transaksi penjualan yang berasal dari file CSV.

#### Fitur

* Import Data CSV
* Search Transaction
* Transaction History
* Data Validation
* ETL Monitoring

---

### 3. Product Management

Menampilkan katalog produk secara terstruktur.

#### Informasi Produk

* Product ID
* Product Name
* Category
* Sub Category
* Sales
* Profit
* Quantity

---

### 4. Business Reports

Menyediakan laporan analitik yang digunakan sebagai dasar pengambilan keputusan.

#### Analisis yang Disediakan

* Sales Performance Report
* Profit Report
* Category Analysis
* Product Analysis
* Segmentation Report
* Decision Support Recommendations

---

### 5. Machine Learning Segmentation

Menggunakan algoritma **K-Means Clustering** untuk mengelompokkan produk berdasarkan performa penjualan.

#### Cluster

| Segment         | Description                                             |
| --------------- | ------------------------------------------------------- |
| High Value      | Produk dengan sales dan profit tinggi                   |
| Growth          | Produk dengan performa stabil dan berpotensi berkembang |
| Low Performance | Produk dengan sales dan profit rendah                   |

#### Variabel Clustering

* Sales
* Profit

---

## 📂 Dataset

Dataset yang digunakan adalah **Global Superstore Sales Dataset** yang diperoleh dari Kaggle.

### Informasi Dataset

| Attribute | Value            |
| --------- | ---------------- |
| Source    | Kaggle           |
| Format    | CSV              |
| Rows      | 51,290           |
| Columns   | 21               |
| Period    | 2011 - 2014      |
| Countries | 147 Countries    |
| Markets   | 7 Global Markets |

---

## 📂 ETL Process

### 1. Extract

Mengambil data mentah dari file CSV Global Superstore Sales.

### 2. Transform

Tahapan transformasi meliputi:

* Missing Value Handling
* Duplicate Removal
* Date Standardization
* Data Type Conversion
* Data Normalization
* Profit Calculation
* Shipping Analysis

### 3. Load

Memuat data ke dalam Data Warehouse MySQL menggunakan SQLAlchemy.

---

## 📂 Data Warehouse Design

Sistem menggunakan pendekatan **Star Schema**.

### 1. Fact Table

#### a. fact_sales

| Column        |
| ------------- |
| fact_id       |
| order_id      |
| date_key      |
| customer_key  |
| product_key   |
| location_key  |
| ship_mode_key |
| sales         |
| quantity      |
| discount      |
| profit        |
| shipping_cost |

### 2. Dimension Tables

#### a. dim_date

| Column     |
| ---------- |
| date_key   |
| full_date  |
| day_name   |
| month_name |
| quarter    |
| year       |

#### b. dim_customer

| Column        |
| ------------- |
| customer_key  |
| customer_name |
| segment       |

#### c. dim_product

| Column       |
| ------------ |
| product_key  |
| product_id   |
| product_name |
| category     |
| sub_category |

#### d. dim_location

| Column       |
| ------------ |
| location_key |
| state        |
| country      |
| region       |
| market       |

---

## 📂 Dashboard Widgets

### 1. Executive KPI Cards

Menampilkan indikator utama bisnis:

* Total Sales
* Total Profit
* Orders
* Customers
* Quantity Sold

### 2. Monthly Sales Trend

Visualisasi tren penjualan bulanan menggunakan line chart.

Digunakan untuk:

* Monitoring performa tahunan
* Identifikasi seasonal trend
* Analisis pertumbuhan bisnis

### 3. Monthly Profit Trend

Menampilkan perkembangan profit setiap bulan.

Digunakan untuk:

* Evaluasi profitabilitas
* Analisis margin keuntungan

### 4. Category Contribution Chart

Visualisasi kontribusi penjualan berdasarkan kategori produk.

Kategori:

* Furniture
* Office Supplies
* Technology

### 5. Sales & Profit Scatter Plot

Menampilkan distribusi data berdasarkan:

* Sales
* Profit

Digunakan untuk:

* Identifikasi produk unggulan
* Deteksi produk merugi
* Analisis outlier

### 6. Product Segmentation Cards

Menampilkan hasil clustering:

* High Value Segment
* Growth Segment
* Low Performance Segment

### 7. Decision Support Recommendations

Menyediakan rekomendasi otomatis berdasarkan hasil analisis dan segmentasi.

Contoh:

* Fokus promosi pada Growth Segment
* Pertahankan High Value Products
* Evaluasi Low Performance Products

---

## 📂 Teknologi yang Digunakan

<p align="center">
  <img src="https://skillicons.dev/icons?i=laravel,php,mysql,html,css,bootstrap,python,vscode,figma" />
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Pandas-150458?style=for-the-badge&logo=pandas&logoColor=white" />
  <img src="https://img.shields.io/badge/SQLAlchemy-D71F00?style=for-the-badge&logo=sqlalchemy&logoColor=white" />
  <img src="https://img.shields.io/badge/Scikit--Learn-F7931E?style=for-the-badge&logo=scikitlearn&logoColor=white" />
  <img src="https://img.shields.io/badge/K--Means_Clustering-6A1B9A?style=for-the-badge" />
  <img src="https://img.shields.io/badge/Blade_Template-F55247?style=for-the-badge&logo=laravel&logoColor=white" />
  <img src="https://img.shields.io/badge/phpMyAdmin-6C78AF?style=for-the-badge&logo=phpmyadmin&logoColor=white" />
</p>

---

## 📂 Halaman Sistem

### Public Pages
- Homepage, Contact, & Login

### User (Admin) Pages
- Dashboard, Transactions, Products, Reports, & Logout

---

## 📂 Business Intelligence Outcomes

Melalui implementasi sistem ini, pengguna dapat:

* Memantau performa bisnis secara real-time
* Mengidentifikasi produk paling menguntungkan
* Mengetahui tren penjualan tahunan
* Melakukan segmentasi produk secara otomatis
* Mendukung pengambilan keputusan berbasis data
* Mengurangi proses analisis manual

---

<p align="center">
  <img src="https://img.shields.io/badge/Copyright-©%202026%20SerbaSerbi.%20Dashboard%20Kelompok%2019-BD3D5A?style=for-the-badge" />
</p>

<p align="center">
  <strong>© 2026 SerbaSerbi. Dashboard Kelompok 19</strong><br>
  Business Intelligence Dashboard Project<br>
  Information Systems, Faculty of Engineering<br>
  Universitas Mulawarman
</p>

<p align="center">
  This project was developed for academic and educational purposes.<br>
  All rights reserved.
</p>
