SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `student`;
DROP TABLE IF EXISTS `faculty`;
DROP TABLE IF EXISTS `committee`;
DROP TABLE IF EXISTS `match_schedule`;
DROP TABLE IF EXISTS `sport_type`;
DROP TABLE IF EXISTS `color_team`;

SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE color_team (
  color_id INT AUTO_INCREMENT PRIMARY KEY,
  color_name VARCHAR(50) NOT NULL
);
CREATE TABLE sport_type (
  sport_id INT AUTO_INCREMENT PRIMARY KEY,
  sport_name VARCHAR(100) NOT NULL,
  category VARCHAR(50),
  venue_type VARCHAR(50)
);
CREATE TABLE match_schedule (
  match_id INT AUTO_INCREMENT PRIMARY KEY,
  match_date DATE NOT NULL,
  match_no INT,
  sport_id INT,
  category VARCHAR(50),
  round_name VARCHAR(50),
  start_time TIME,
  team1_id INT,
  team2_id INT,
  venue VARCHAR(100),
  result VARCHAR(100),
  note VARCHAR(255),
  FOREIGN KEY (sport_id) REFERENCES sport_type(sport_id),
  FOREIGN KEY (team1_id) REFERENCES color_team(color_id),
  FOREIGN KEY (team2_id) REFERENCES color_team(color_id)
);
CREATE TABLE committee (
  committee_id INT AUTO_INCREMENT PRIMARY KEY,
  committee_name VARCHAR(100),
  role VARCHAR(100),
  contact VARCHAR(100),
  sport_id INT,
  FOREIGN KEY (sport_id) REFERENCES sport_type(sport_id)
);
CREATE TABLE faculty (
  faculty_id INT AUTO_INCREMENT PRIMARY KEY,
  faculty_name VARCHAR(100) NOT NULL,
  color_id INT,
  FOREIGN KEY (color_id) REFERENCES color_team(color_id)
);
CREATE TABLE student (
  student_id VARCHAR(20) PRIMARY KEY,
  student_name VARCHAR(100),
  faculty_id INT,
  color_id INT,
  FOREIGN KEY (faculty_id) REFERENCES faculty(faculty_id),
  FOREIGN KEY (color_id) REFERENCES color_team(color_id)
);
INSERT INTO color_team (color_name)
VALUES
('สีแดง'),
('สีเหลือง'),
('สีเขียว'),
('สีน้ำเงิน');
INSERT INTO sport_type (sport_name, category, venue_type)
VALUES
('บาสเกตบอล', 'ทีมชาย', 'ศูนย์กีฬา'),
('แชร์บอล', 'ทีมหญิง', 'ศูนย์กีฬา'),
('แบดมินตัน', 'เดี่ยว', 'คอร์ทกีฬา');
INSERT INTO match_schedule 
(match_date, match_no, sport_id, category, round_name, start_time, team1_id, team2_id, venue, result, note)
VALUES
('2025-03-21', 1, 1, 'ทีมชาย', 'รอบแรก', '16:00:00', 3, 2, 'ศูนย์กีฬา', 'สีเขียวชนะ 42-36', NULL),
('2025-03-21', 2, 1, 'ทีมชาย', 'รอบแรก', '16:30:00', 4, 1, 'ศูนย์กีฬา', 'สีน้ำเงินชนะ 45-40', NULL),
('2025-03-22', 24, 2, 'ทีมหญิง', 'รอบสอง', '17:00:00', 1, 3, 'ศูนย์กีฬา', 'สีแดงชนะ 2-1 เซต', NULL);

INSERT INTO faculty (faculty_name, color_id) VALUES
('บริหารธุรกิจ',1),
('เภสัชศาสตร์',1),
('หลักสูตรนานาชาติ',1),
('ศิลปศาสตร์',2),
('วิทยาศาสตร์',2),
('วิศวกรรมศาสตร์',2),
('SCA',2),
('พยาบาลศาสตร์', 3),   
('แพทยศาสตร์',3),
('นิติศาสตร์',3),
('รัฐศาสตร์',3),
('นิเทศศาสตร์', 4),   
('เทคโนโลยีสารสนเทศ',4),
('ทัตแพทย์ศาสตร์',4),
('groble',4);
INSERT INTO student (student_id, student_name, faculty_id, color_id) VALUES
('6605100006', 'ปภินวิทย์ เจนใจ', 13, 4);
      