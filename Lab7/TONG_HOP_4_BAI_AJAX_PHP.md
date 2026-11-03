# TỔNG HỢP 4 BÀI THỰC HÀNH AJAX – PHP – MYSQL

> Tài liệu được tổng hợp theo thứ tự Bài 1 → Bài 4 từ bốn file PDF được cung cấp. Các đoạn mã nằm trong ảnh chụp ở tài liệu gốc được chép lại thành mã có thể sao chép. Một số cú pháp trong bài gốc có thể chưa phù hợp cho ứng dụng thực tế; phần dưới ưu tiên bám sát bài học, không mặc định là mã an toàn để triển khai production.

## Mục lục

1. [Bài 1 – In danh sách sinh viên theo từng lớp](#bài-1--in-danh-sách-sinh-viên-theo-từng-lớp)
2. [Bài 2 – Hướng đối tượng với PHP](#bài-2--hướng-đối-tượng-với-php)
3. [Bài 3 – Tìm kiếm tên học phần](#bài-3--tìm-kiếm-tên-học-phần)
4. [Bài 4 – Đăng nhập Ajax](#bài-4--đăng-nhập-ajax)

---

# Bài 1 – In danh sách sinh viên theo từng lớp

**Mục tiêu:** Sử dụng bảng `sinhvien` trong CSDL `udn`. Tệp `danhsach.php` tạo select box chọn lớp và nhận bảng từ server. Tệp `ds.php` nhận lớp, truy vấn CSDL rồi trả về HTML; bảng được hiển thị trong `<div id="ds">`. Hàm JavaScript `sendajax()` đặt trong tệp PHP.

## Bước 1. Thiết kế cơ sở dữ liệu `udn`

Dùng bảng `sinhvien` của CSDL `udn` (dữ liệu mẫu nằm trong hình minh họa PDF; file SQL riêng không được đính kèm).

Tạo thư mục `inc`, trong đó tạo tệp `connect.inc`:

### `inc/connect.inc`

```php
<?php
$server=$_SERVER['SERVER_NAME'];
$user="root";
$pass="";
$db="udn";
$con=mysqli_connect($server,$user,$pass,$db);
mysqli_query($con,"set names 'utf8'");
?>
```

## Bước 2. Tạo `ds.php`

```php
<?php
include("inc/connect.inc");
$lop=$_GET['lop'];

$sql="Select * from sinhvien where lop='{$lop}'";
$rs=mysqli_query($con,$sql);
$str="<table>
    <tr class=hd>
        <td>TT</td>
        <td>Mã số</td>
        <td>Họ tên</td>
        <td>Địa chỉ</td>
    </tr>";
$tt=1;
while($row=mysqli_fetch_array($rs)){
    $str.="<tr>
        <td>{$tt}</td>
        <td>{$row['masv']}</td>
        <td>{$row['hoten']}</td>
        <td>{$row['diachi']}</td>
    </tr>";
    $tt++;
}
$str.="</table>";

echo $str;
?>
```

## Bước 3. Tạo `danhsach.php`

```php
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ajax- Danh sách lớp</title>
    <link href="style/style.css" type="text/css" rel="stylesheet"></link>
    <style>
        body{font-size:11pt}
        div{padding: 3px 5px;font:normal 13pt Arial;}
        table{background-color:#eaeaea;}
        td{font:normal 11pt Arial}
        .hd{background-color:navy; color:white}
    </style>
    <script>
        function sendajax(){
            lop=document.getElementById("lop").value;
            objds=document.getElementById("ds");
            xml=new XMLHttpRequest();
            xml.onreadystatechange=function(){
                if(xml.readyState==4){
                    objds.innerHTML=xml.responseText;
                }
            }
            url="ds.php?lop="+lop;
            xml.open("GET",url,"false");
            xml.send();
        }
    </script>
</head>
<body>
<h3>In danh sách theo từng lớp</h3>
<?php
include("inc/connect.inc");

function initClass($conn){
    $sql="Select distinct lop from sinhvien";
    $rs=mysqli_query($conn,$sql);
    $str="Chọn lớp: <select id=lop onChange='sendajax();'>";
    while($row=mysqli_fetch_array($rs)){
        $str.="<option value={$row['lop']}>{$row['lop']}</option>";
    }
    $str.="</select>";
    echo $str;
}

initClass($con);
?>
<hr>
<div id=ds>Danh sách</div>
</body>
</html>
```

---

# Bài 2 – Hướng đối tượng với PHP

**Mục tiêu:** OOP with PHP – chọn `Giáo viên`, `Sinh viên`, `Học phần` từ select box, dùng Ajax để lấy bảng dữ liệu tương ứng.

## Bước 1. Tạo cơ sở dữ liệu `udn`

Theo PDF: CSDL `udn` đã gửi ở Lab 10 (không có file SQL riêng trong các tệp hiện tại).

## Bước 2. Tạo `database.class.php`

```php
<?php
class Dao{
    private $con;
    function __construct($user,$pass,$db)
    {
        $host=$_SERVER['SERVER_NAME'];
        $this->con=mysqli_connect($host,$user,$pass,$db);
    }
    public function query($sql){
        mysqli_query($this->con,"set names 'utf8'");
        $rs=mysqli_query($this->con,$sql);
        return $rs;
    }
    function table($sql,$header){
        $rs=$this->query($sql);
        $fieldinfo=mysqli_fetch_fields($rs);
        $str="<table><tr>";
        foreach ($fieldinfo as $val){
            $name=$val->name;
            $str.="<th>".$name."</th>";
        }
        $str.="</tr>";
        /* Đưa dữ liệu trong recordset vào table */
        while($r=mysqli_fetch_array($rs)){
            $str.="<tr>";
            foreach ($fieldinfo as $val){
                $name=$val->name;
                $str.="<td>".$r[$name]."</td>";
            }
            $str.="</tr>";
        }
        $str.="</table>";
        echo "<h3>{$header}</h3>";
        echo $str;
    }
}
?>
```

## Bước 3. Tạo `index.php`

> Trong ảnh chụp ví dụ, tệp giao diện xuất hiện dưới tên `index.html`; phần hướng dẫn lại ghi `index.php`. Nội dung trang như sau.

```html
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>OOP with PHP</title>
<link href="style.css" rel="stylesheet"></link>
<script>
function ajax(){
    var obj=document.getElementById("info");
    obj.style.display="block";
    value=document.getElementById("chon").value;
    var xml=new XMLHttpRequest();
    xml.onreadystatechange=function(){
        if(xml.readyState==4){
            obj.innerHTML=xml.responseText;
        }
    }
    url="showTable.php?chon="+value;
    xml.open("GET",url,false);
    xml.send();
}
</script>
</head>
<body>
<h1>OOP with PHP</h1>
<select id="chon" onChange="ajax();">
    <option value="">-->-Chọn-<--</option>
    <option value="giaovien">Giáo viên</option>
    <option value="sinhvien">Sinh viên</option>
    <option value="hocphan">Học phần</option>
</select>
<hr>
<div id="info" style="display:none;"></div>
</body>
</html>
```

## Bước 4. Tạo `showTable.php`

```php
<?php
$op=$_GET["chon"];
if($op!=""){
    include("database.class.php");
    $dao=new Dao("root","","udn");
    $sql="select * from {$op}";
    $header="DANH SÁCH {$op}";
    $dao->table($sql,$header);
}
?>
```

**Lưu ý:** Trong tài liệu, có tham chiếu `style.css` nhưng không cung cấp mã CSS tương ứng. Truy vấn bảng động theo `$_GET["chon"]` chỉ phù hợp minh họa; khi làm dự án thật nên kiểm tra danh sách bảng cho phép.

---

# Bài 3 – Tìm kiếm tên học phần

**Mục tiêu:** Live Search bằng PHP và AJAX. Khi nhập một phần tên học phần, giao diện đề xuất các tên bắt đầu bằng chuỗi đã nhập.

## Bước 1. Tạo cơ sở dữ liệu `udn`

Dùng bảng `hocphan` với trường `tenhp`.

## Bước 2. Tạo `index.php`

```html
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Chức năng Live Search bằng PHP và AJAX</title>
<style type="text/css">
    body{
        font-family: Arial, sans-serif;
    }
    /* CSS cho search box */
    .search-box{
        width: 300px;
        position: relative;
        display: inline-block;
        font-size: 14px;
    }
    .search-box input[type="text"]{
        height: 32px;
        padding: 5px 10px;
        border: 1px solid #CCCCCC;
        font-size: 14px;
    }
    .result{
        position: absolute;
        z-index: 999;
        top: 100%;
        left: 0;
    }
    .search-box input[type="text"], .result{
        width: 100%;
        box-sizing: border-box;
    }
    /* CSS cho kết quả */
    .result p{
        margin: 0;
        padding: 7px 10px;
        border: 1px solid #CCCCCC;
        border-top: none;
        cursor: pointer;
    }
    .result p:hover{
        background: #f2f2f2;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('.search-box input[type="text"]').on("keyup input", function(){
        /* Lấy giá trị đầu vào khi có thay đổi */
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if(inputVal.length){
            $.get("backend-search.php", {term: inputVal}).done(function(data){
                // Hiển thị dữ liệu trả về trong trình duyệt
                resultDropdown.html(data);
            });
        } else{
            resultDropdown.empty();
        }
    });
    // Thiết lập giá trị đầu vào khi click vào result
    $(document).on("click", ".result p", function(){
        $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
        $(this).parent(".result").empty();
    });
});
</script>
</head>
<body>
    <div class="search-box">
        <input type="text" autocomplete="off" placeholder="Search tên học phần..." />
        <div class="result"></div>
    </div>
</body>
</html>
```

## Bước 3. Tạo `backend-search.php`

```php
<?php
/* Cố gắng kết nối đến MySQL server. Giả sử bạn đang chạy MySQL server mặc định (user là 'root' và không có mật khẩu) */
$link = mysqli_connect("localhost", "root", "", "udn");

// Kiểm tra kết nối
if($link === false){
    die("ERROR: Không thể kết nối. " . mysqli_connect_error());
}

if(isset($_REQUEST["term"])){
    // Chuẩn bị câu lệnh SQL SELECT
    $sql = "SELECT * FROM hocphan WHERE tenhp LIKE ?";

    if($stmt = mysqli_prepare($link, $sql)){
        // Liên kết biến đến câu lệnh đã chuẩn bị như là tham số
        mysqli_stmt_bind_param($stmt, "s", $param_term);

        // Thiết lập các tham số
        $param_term = $_REQUEST["term"] . '%';

        // Cố gắng thực thi câu lệnh đã chuẩn bị
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);

            // Kiểm tra số lượng row trong kết quả
            if(mysqli_num_rows($result) > 0){
                // Tìm nạp các hàng kết quả dưới dạng mảng kết hợp
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    echo "<p>" . $row["tenhp"] . "</p>";
                }
            } else{
                echo "<p>Không tìm thấy kết quả nào</p>";
            }
        } else{
            echo "ERROR: Không thể thực thi câu lệnh $sql. " . mysqli_error($link);
        }
    }

    // Đóng câu lệnh
    mysqli_stmt_close($stmt);
}

// Đóng kết nối
mysqli_close($link);
?>
```

---

# Bài 4 – Đăng nhập Ajax

**Mục tiêu:** Xây dựng form đăng nhập sử dụng jQuery AJAX, PHP, MySQL và session.

## Bước 1. Tạo cơ sở dữ liệu `udn`

Theo tài liệu gốc: `udn.sql` (không được gửi kèm riêng).

## Bước 2. Tạo `connect.php`

```php
<?php
$server=$_SERVER['SERVER_NAME'];
$user="root";
$pass="";
$db="udn";
$con=mysqli_connect($server,$user,$pass,$db);
mysqli_query($con,"set names 'utf8'");
?>
```

## Bước 3. Tạo `check.php`

> Đoạn này được chép lại từ ảnh mã nguồn trang 2 của PDF. Phần đăng nhập mẫu truy vấn trực tiếp thông tin từ URL; không nên sử dụng nguyên trạng trong sản phẩm thực tế.

```php
<meta charset=utf-8>
<?php
session_start();
include("connect.php");
$us=$_GET['user'];
$pw=$_GET['pass'];

$sql="select * from sinhvien where masv='{$us}'
      and matkhau='{$pw}'";
mysqli_query($con,"SET NAMES 'utf8'");
$rs=mysqli_query($con,$sql);
if(mysqli_num_rows($rs)>0){
    $row=mysqli_fetch_array($rs);
    $_SESSION['code']=$row['masv'];
    $_SESSION['info']=$us." -- ".$row['hoten']." - ".$row['lop'];
    echo $us." - ".$row['hoten']."&nbsp;&nbsp;<a href=QLSV.php>Next</a>";
} else {
    echo "Bạn nhập thông tin sai!";
}
mysqli_free_result($rs);
mysqli_close($con);
?>
```

## Bước 4. Tạo `login.html`

```html
<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<meta charset=utf-8>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $("#sm").click(function(event){
        $.get(
            "check.php",
            {user:$("#us").val(),pass:$("#pw").val()},
            function(data){
                $('#nt').css("display","block");
                $("#nt").slideDown("slow");
                $("#nt").html(data);
            }
        );
    });
});
</script>
<style>
    body{margin: 80px 200px;
         font:normal 14pt Arial;
         color:navy;}
    input{border:solid 1px silver;
          padding:3px;
          font:normal 14pt Arial;
          color:blue;padding: 3px 5px}
    fieldset{border:solid 2px green;
             border-radius:8px;
             width:335px;
             background-color:#DAFEF3;}
    div{width:335px;
        border:solid 1px silver;
        padding: 10px 15px;
        font:normal 14pt Arial;
        color:green;
        background-color:yellow;
        box-shadow: 2px 2px black;}
    legend{color:red}
    input[type=button]{float:right;padding:5px 10px}
</style>
</head>
<body>
<fieldset>
    <img src='images/dhdn.gif' />
    <hr>
    <legend><b>LOGIN</b></legend>
    <table>
        <tr>
            <td style="width:30%">User name</td>
            <td style="width:70%">
                <input type=text id=us onFocus="empty();">
            </td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type=password id=pw></td>
        </tr>
        <tr>
            <td colspan=2>
                <br>
                <!--input id=sm type=button value=Submit onClick="ajax();"-->
                <input id=sm type=button value=Submit>
            </td>
        </tr>
    </table>
</fieldset>
<br>
<div id=nt style='display:none;'>Notice:</div>
</body>
</html>
```

**Lưu ý về tài liệu gốc:** Có tham chiếu ảnh `images/dhdn.gif` và trang `QLSV.php`, nhưng các tệp đó không nằm trong 4 PDF. Thuộc tính `onFocus="empty();"` cũng không có định nghĩa hàm `empty()` đi kèm. Ví dụ dùng phương thức GET để gửi mật khẩu và so sánh mật khẩu trực tiếp trong SQL là không an toàn; khi triển khai thực tế cần dùng POST, prepared statements và `password_hash()`/`password_verify()`.

---

## Danh sách tài liệu nguồn

- `BAI 1. DANH SACH.pdf` – 5 trang.
- `BAI 2. HUONG DOI TUONG.pdf` – 4 trang.
- `BAI 3. TIM KIEM.pdf` – 5 trang.
- `Bài 4. Login. docx.pdf` – 5 trang.

**Ghi chú:** Đây là bản Markdown chuyển nội dung hướng dẫn và mã nguồn từ PDF, không bao gồm ảnh chụp giao diện và ảnh màn hình. Một số đoạn mã trong ảnh được chép lại thủ công nên có thể khác về cách thụt lề, dấu cách hoặc một số ký tự khó đọc so với bản gốc.
