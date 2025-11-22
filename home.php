<html>
    <head>
        <meta charset="utf-8">
        <title>หูกวางเกมส์</title>
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
            <h1>หูกวางเกมส์</h1>
            
            <div class="color-teams">
                <div class="team-card team-green">
                    <h2>สีเขียว</h2>
                    <ul><li>พยาบาลศาสตร์</li><li>แพทยศาสตร์</li><li>นิติศาสตร์</li><li>รัฐศาสตร์</li></ul>
                </div>
                <div class="team-card team-blue">
                    <h2>สีน้ำเงิน</h2>
                    <ul><li>นิเทศศาสตร์</li><li>เทคโนโลยีสารสนเทศ</li><li>ทัตแพทย์ศาสตร์</li><li>groble</li></ul>
                </div>
                <div class="team-card team-yellow">
                    <h2>สีเหลือง</h2>
                    <ul><li>ศิลปศาสตร์</li><li>วิทยาศาสตร์</li><li>วิศวกรรมศาสตร์</li><li>SCA</li></ul>
                </div>
                <div class="team-card team-red">
                    <h2>สีแดง</h2>
                    <ul><li>บริหารธุรกิจ</li><li>เภสัชศาสตร์</li><li>หลักสูตรนานาชาติ</li></ul>
                </div>
            </div>

            <div class="button-container">
                <a href="sport.php" class="apply-button">
                สมัครการแข่งขัน
                </a>
            </div>
        </div>
    </body>
</html>
