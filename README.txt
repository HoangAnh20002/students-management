
# Student management

Trang web để quản lí sinh viên

## Cài Đặt

Hướng dẫn cài đặt và chạy dự án.

1. Clone repository:

    git clone https://github.com/HoangAnh20002/students-management.git

2. Di chuyển vào thư mục dự án:

    cd student_management

3. Cài đặt các dependencies:

    composer
    xampp

4. Sao chép tệp `.env` và cấu hình cơ sở dữ liệu:

    cp .env.example .env

    Cập nhật thông tin cấu hình trong tệp `.env`.
    đổi tên cơ sở dữ liệu là students_management

5. Chạy migrations và seed:

    php artisan migrate
    php artisan db:seed

6. Chạy dự án:

    php artisan serve

Truy cập [http://localhost:8000](http://localhost:8000) trong trình duyệt để xem dự án của bạn.

## Sử Dụng


..........
