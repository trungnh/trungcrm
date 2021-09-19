#NOTE:
- Không import bất cứ packages nào trong none_modules (Chỉ import các file trong resources/js). Thay vì vậy, hãy  sử dụng lệnh copy trong webpack.mix.js và thêm tab script trong view layout master. Ly dó:
    + Không tạo ra vendor với size quá lớn
    + Tương thích với các thư viện js bên ngoài, không có trên npm.
    + Có thể sử dụng các packgage trên cdn để thay thế.
