<?php
// ------------------ บันทึกข้อมูลเมื่อกด submit ------------------
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $conn = mysqli_connect("localhost", "root", "12345", "hukangame");

    if (!$conn) {
        // ใช้ die() เพื่อหยุดการทำงานทันทีหากเชื่อมต่อไม่ได้
        // และควรแสดงข้อความใน HTML ด้านล่างแทนการ echo ที่นี่โดยตรง
        $db_error = "เชื่อมต่อฐานข้อมูลล้มเหลว: " . mysqli_connect_error();
    } else {
        mysqli_set_charset($conn, "utf8");

        $student_id   = $_POST['student_id'];
        $name         = $_POST['name'];
        $color_name   = $_POST['color_team'];
        $faculty_id   = $_POST['faculty_id'];

        // 1. ค้นหา color_id จาก color_name ที่ส่งมาจากฟอร์ม
        $stmt_color = mysqli_prepare($conn, "SELECT color_id FROM color_team WHERE color_name = ?");
        mysqli_stmt_bind_param($stmt_color, "s", $color_name);
        mysqli_stmt_execute($stmt_color);
        $result_color = mysqli_stmt_get_result($stmt_color);
        $color_row = mysqli_fetch_assoc($result_color);
        $color_id = $color_row ? $color_row['color_id'] : null;
        mysqli_stmt_close($stmt_color);

        // 2. ตรวจสอบว่าได้ color_id และ faculty_id ครบถ้วน
        if ($color_id && $faculty_id) {
            // 3. เตรียมคำสั่ง SQL เพื่อบันทึกข้อมูลลงตาราง student
            $sql = "INSERT INTO student (student_id, student_name, faculty_id, color_id) 
                    VALUES (?, ?, ?, ?)
                    ON DUPLICATE KEY UPDATE 
                    student_name = VALUES(student_name), 
                    faculty_id = VALUES(faculty_id), 
                    color_id = VALUES(color_id)";
            
            $stmt_student = mysqli_prepare($conn, $sql);

            // 4. Bind parameters ให้ถูกต้อง (string, string, integer, integer)
            mysqli_stmt_bind_param($stmt_student, "ssii", $student_id, $name, $faculty_id, $color_id);

            // 5. Execute และแสดงผล
            if (mysqli_stmt_execute($stmt_student)) {
                $success_message = "บันทึกข้อมูลสำเร็จ!";
            } else {
                $error_message = "บันทึกข้อมูลล้มเหลว: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt_student);
        } else {
            $error_message = "ข้อมูลสีหรือคณะไม่ถูกต้อง ไม่สามารถบันทึกได้";
        }

        mysqli_close($conn);
    }
}

// ------------------ ดึงข้อมูลสำหรับแสดงผลฟอร์ม ------------------
$sport_id = isset($_GET['sport_id']) ? $_GET['sport_id'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$sport_name = 'ไม่พบข้อมูล';

$colors = [];
$faculties_by_color = [];

// หากยังไม่มี error จากการเชื่อมต่อครั้งแรก ให้เชื่อมต่อเพื่อดึงข้อมูล
if (empty($db_error)) {
    $conn = mysqli_connect("localhost", "root", "12345", "hukangame");
    if (!$conn) {
        $db_error = "เชื่อมต่อฐานข้อมูลล้มเหลว: " . mysqli_connect_error();
    } else {
        mysqli_set_charset($conn, "utf8");

        if ($sport_id) {
            $stmt = mysqli_prepare($conn, "SELECT sport_name FROM sport_type WHERE sport_id = ?");
            mysqli_stmt_bind_param($stmt, "i", $sport_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                $sport_name = $row['sport_name'];
            }
            mysqli_stmt_close($stmt);
        }

        $color_query = "SELECT color_name FROM color_team ORDER BY color_id";
        $color_result = mysqli_query($conn, $color_query);
        if ($color_result) {
            while ($row = mysqli_fetch_assoc($color_result)) {
                $colors[] = $row['color_name'];
            }
        }

        $faculty_query = "SELECT f.faculty_id, f.faculty_name, ct.color_name 
                          FROM faculty f 
                          JOIN color_team ct ON f.color_id = ct.color_id";
        $faculty_result = mysqli_query($conn, $faculty_query);
        if ($faculty_result) {
            while ($row = mysqli_fetch_assoc($faculty_result)) {
                $faculties_by_color[$row['color_name']][] = [
                    'id' => $row['faculty_id'],
                    'name' => $row['faculty_name']
                ];
            }
        }

        mysqli_close($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>หูกวางเกมส์ - สมัครการแข่งขัน</title>
<style>
            body {
                font-family: 'Sarabun', sans-serif; 
                background-image: url('img01.jpg');
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
                margin: 0;
                padding: 20px;
                color: #333;
            }
            .container {
                max-width: 1200px;
                margin: 0 auto;
                background-color: rgba(255, 255, 255, 0.5);
                padding: 20px;
                border-radius: 15px;
                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            }
            h1 {
                text-align: center;
                color: #2c3e50;
                margin-bottom: 20px;
            }
            .color-teams {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 20px;
                margin-bottom: 30px;
            }
            .team-card {
                background-color: #fff;
                border-radius: 10px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                flex: 1;
                min-width: 220px;
                max-width: 250px;
                padding: 15px;
                text-align: left;
                border-top: 5px solid;
            }
            .team-green { border-color: #27ae60; }
            .team-blue { border-color: #2980b9; }
            .team-yellow { border-color: #f1c40f; }
            .team-red { border-color: #c0392b; }

            .team-card h2 {
                margin-top: 0;
                text-align: center;
            }
            .team-green h2 { color: #27ae60; }
            .team-blue h2 { color: #2980b9; }
            .team-yellow h2 { color: #f1c40f; }
            .team-red h2 { color: #c0392b; }

            .team-card ul {
                list-style-type: none;
                padding: 0;
                margin: 0;
            }
            .team-card li {
                padding: 5px 0;
            }
            .button-container {
                text-align: center;
                margin-top: 2em;
            }
            .apply-button {
                color: #fff;
                font-weight: bold;
                text-decoration: none;
                display: inline-block;
                padding: 12px 25px;
                border-radius: 25px;
                background: linear-gradient(45deg, #6366f1, #8b5cf6);
                transition: all 0.3s ease;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            }
            .apply-button:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 12px rgba(0,0,0,0.15);
            }
</style>
</head>

<body>

<div class="container">
    <h1>แบบฟอร์มสมัครการแข่งขัน</h1>

    <?php if (!empty($success_message)): ?>
        <p style='color:green;font-weight:bold;text-align:center;'><?= $success_message ?></p>
    <?php endif; ?>
    <?php if (!empty($error_message)): ?>
        <p style='color:red;text-align:center;'><?= $error_message ?></p>
    <?php endif; ?>
    <?php if (!empty($db_error)): ?>
        <p style='color:red;text-align:center;'><?= $db_error ?></p>
    <?php endif; ?>

    <form action="" method="post">

        รหัสนักศึกษา:
        <input type="text" name="student_id" required><br><br>

        ชื่อ - นามสกุล:
        <input type="text" name="name" required><br><br>

        สี:
        <select id="color_team" name="color_team" required>
            <option value="">-- เลือกสี --</option>
            <?php foreach ($colors as $color): ?>
                <option value="<?= htmlspecialchars($color) ?>">
                    <?= htmlspecialchars($color) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>

        คณะ:
        <select id="faculty_name" name="faculty_id" required>
            <option value="">-- กรุณาเลือกสีก่อน --</option>
        </select>
        <br><br>

        กีฬาที่ต้องการเล่น:
        <input type="text" name="sport_name" value="<?= htmlspecialchars($sport_name) ?>" readonly><br><br>

        ประเภทการแข่งขัน:
        <input type="text" name="sport_type" value="<?= htmlspecialchars($category) ?>" readonly><br><br>

        <input type="hidden" name="sport_id" value="<?= htmlspecialchars($sport_id) ?>">

        <button type="submit">ยืนยันการสมัคร</button>

    </form>
</div>

<script>
const facultiesByColor = <?php echo json_encode($faculties_by_color); ?>;

document.getElementById('color_team').addEventListener('change', function () {
    const selectedColor = this.value;
    const facultySelect = document.getElementById('faculty_name');
    facultySelect.innerHTML = '<option value="">-- เลือกคณะ --</option>';

    if (selectedColor && facultiesByColor[selectedColor]) {
        facultiesByColor[selectedColor].forEach(function (facultyData) {
            let option = document.createElement('option');
            option.value = facultyData.id;      // ใช้ faculty_id เป็น value
            option.textContent = facultyData.name; // ใช้ faculty_name เป็น text ที่แสดง
            facultySelect.appendChild(option);
        });
    }
});
</script>

</body>
</html>
