<?php
/**
 * @project thuattoanquyhoachdong
 * @author  Tra Pham
 * @email   trapham24065@gmail.com
 * @date    2/14/2025
 * @time    6:18 PM
 **/
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tính Số Lượng Gà Ít Nhất</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Tính Số Lượng Gà Ít Nhất</h2>
    <form id="chicken-form">
        <div class="mb-3">
            <label for="X" class="form-label">Số lượng gà (X):</label>
            <input type="number" class="form-control" id="X" name="X" placeholder="Nhập số lượng gà" required>
        </div>

        <div class="mb-3">
            <label for="weights" class="form-label">Khối lượng từng con gà (cách nhau bằng dấu phẩy):</label>
            <input type="text" class="form-control" id="weights" name="weights" placeholder="Ví dụ: 3, 1, 4, 2, 5" required>
        </div>

        <div class="mb-3">
            <label for="S" class="form-label">Tổng khối lượng cần đạt (S):</label>
            <input  type="number"  step="0.01" class="form-control" id="S" name="S" placeholder="Nhập tổng khối lượng" required>
        </div>

        <button type="submit" class="btn btn-primary">Tính Toán</button>
        <button type="reset" class="btn btn-secondary">Nhập lại</button>
    </form>

    <div class="container mt-4" >
        <h2 class="text-center">Kết Quả Tính Toán</h2>
        <div id="result">
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Event when the user submits the form
        $('#chicken-form').on('submit', function(event) {
            event.preventDefault();
            var values = $(this).serialize();

            // Send AJAX request to process.php file
            $.ajax({
                url: 'process.php',
                type: 'POST',
                data: values,
                dataType: 'json',
                success: function(response) {

                    $('#result').html('');

                    if (response.error) {
                        $('#result').html('<div class="alert alert-danger">' + response.error + '</div>');
                    } else {

                        if (response.result == -1) {
                            $('#result').html('<div class="alert alert-info">Không thể đạt được tổng khối lượng ' + response.S + '.</div>');
                        } else {
                            $('#result').html('<div class="alert alert-success">Số lượng gà ít nhất cần chọn: ' + response.result + '</div>');
                        }
                    }
                },
                error: function() {
                    $('#result').html('<div class="alert alert-danger">Có lỗi xảy ra khi xử lý yêu cầu.</div>');
                }
            });
        });
    });
</script>
</body>
</html>


