/*
Navicat MySQL Data Transfer

Source Server         : Becnews
Source Server Version : 50621
Source Host           : 10.1.75.91:3306
Source Database       : newsscript

Target Server Type    : MYSQL
Target Server Version : 50621
File Encoding         : 65001

Date: 2016-03-12 12:33:26
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `log`
-- ----------------------------
DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
`logID`  int(11) NOT NULL AUTO_INCREMENT ,
`dateCode`  varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`method`  varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`description`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`dateStamp`  datetime NULL DEFAULT NULL ,
PRIMARY KEY (`logID`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=1

;

-- ----------------------------
-- Records of log
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for `programnews`
-- ----------------------------
DROP TABLE IF EXISTS `programnews`;
CREATE TABLE `programnews` (
`proID`  int(11) NOT NULL AUTO_INCREMENT ,
`proName`  varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`enable`  bit(1) NULL DEFAULT b'1' ,
PRIMARY KEY (`proID`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=7

;

-- ----------------------------
-- Records of programnews
-- ----------------------------
BEGIN;
INSERT INTO `programnews` VALUES ('1', 'ข่าวมื้อเช้า', ''), ('2', 'ข่าวเปรี้ยงเที่ยงตรง', ''), ('3', 'ข่าวต้นชั่วโมง', ''), ('4', 'ข่าวรอบวัน', ''), ('5', 'ข่าวด่วน', ''), ('6', 'ข่าวออนไลน์', '');
COMMIT;

-- ----------------------------
-- Table structure for `rundown`
-- ----------------------------
DROP TABLE IF EXISTS `rundown`;
CREATE TABLE `rundown` (
`runID`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ,
`dateCode`  varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`running`  int(11) NULL DEFAULT NULL ,
`proID`  int(11) NULL DEFAULT NULL ,
`break`  int(11) NULL DEFAULT NULL ,
`dateOnAir`  date NULL DEFAULT NULL ,
`timeOnAir`  time NULL DEFAULT NULL ,
`programTime`  varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`statusID`  int(11) NULL DEFAULT NULL ,
`remark`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`lockRundown`  int(11) NULL DEFAULT 0 ,
`modifyBy`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`modifyDate`  datetime NULL DEFAULT NULL ,
PRIMARY KEY (`runID`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Records of rundown
-- ----------------------------
BEGIN;
INSERT INTO `rundown` VALUES ('2016030100001', '20160301', '1', '3', '3', '2016-03-01', '18:00:00', '70', '1', null, '0', '003711', '2016-03-02 19:44:35'), ('2016030200001', '20160310', '1', '1', '2', '2016-03-10', '07:15:00', '45', '1', null, '1', '003710', '2016-03-10 20:31:51');
COMMIT;

-- ----------------------------
-- Table structure for `rundownitem`
-- ----------------------------
DROP TABLE IF EXISTS `rundownitem`;
CREATE TABLE `rundownitem` (
`runID`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`scID`  varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`seq`  int(11) NOT NULL ,
`title`  varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`duration`  varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0.00' ,
PRIMARY KEY (`runID`, `scID`, `seq`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Records of rundownitem
-- ----------------------------
BEGIN;
INSERT INTO `rundownitem` VALUES ('', 'b_1', '1', 'Break_1', '0.00'), ('', 'b_2', '2', 'Break_2', '0.00'), ('2016030100001', '2016011300001', '6', null, ''), ('2016030100001', '2016020300001', '4', null, ''), ('2016030100001', '2016020500001', '3', null, '1.5'), ('2016030100001', '2016021900001', '1', null, '3.24'), ('2016030100001', '2016022500001', '8', null, '2.31'), ('2016030100001', 'b_1', '2', 'Break_1', '0.00'), ('2016030100001', 'b_2', '5', 'Break_2', '0.00'), ('2016030100001', 'b_3', '7', 'Break_3', '0.00'), ('2016030200001', '2016011300001', '8', null, '2.55'), ('2016030200001', '2016011300002', '5', null, '0'), ('2016030200001', '2016020500001', '1', null, '1.5'), ('2016030200001', '2016021600001', '7', null, '3.7'), ('2016030200001', '2016021900001', '2', null, '3.24'), ('2016030200001', '2016022500001', '4', null, '2.31'), ('2016030200001', 'b_1', '3', 'Break_1', '0.00'), ('2016030200001', 'b_2', '6', 'Break_2', '0.00');
COMMIT;

-- ----------------------------
-- Table structure for `script`
-- ----------------------------
DROP TABLE IF EXISTS `script`;
CREATE TABLE `script` (
`scID`  varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`runID`  int(11) NULL DEFAULT NULL ,
`dateCode`  varchar(9) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`title`  varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`duration`  varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0' ,
`script`  longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`statusID`  tinyint(11) NULL DEFAULT NULL ,
`typeID`  tinyint(4) NULL DEFAULT NULL ,
`createBy`  varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`createDate`  datetime NULL DEFAULT NULL ,
`modifyBy`  varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`modifyDate`  datetime NULL DEFAULT NULL ,
`referTo`  varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`tblID`  int(11) NULL DEFAULT NULL ,
`proID`  int(11) NULL DEFAULT NULL ,
`dateOnAir`  date NULL DEFAULT NULL ,
`timeOnAir`  time NULL DEFAULT NULL ,
PRIMARY KEY (`scID`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Records of script
-- ----------------------------
BEGIN;
INSERT INTO `script` VALUES ('2016011300001', '1', '20160113', 'หุ้นมะกันขึ้นแรง-ทองคำลง', '2.55', '<p>ตลาดหุ้นสหรัฐฯในวันอังคาร(12ม.ค.) พุ่งแรง ท่ามกลางการซื้อขายที่ผันผวน จากแรงช้อนซื้อหุ้นกลุ่มพลังงาน และแรงหนุนของหุ้นแอปเปิลและบริษัทเทคโนโลยีอื่นๆ<br /> <br /> ดาวโจนส์ เพิ่มขึ้น 117.65 จุด (0.72 เปอร์เซ็นต์) ปิดที่ 16.516.22 จุด เอสแอนด์พี เพิ่มขึ้น 15.01 จุด (0.78 เปอร์เซ็นต์) ปิดที่ 1,938.68 จุด แนสแดค เพิ่มขึ้น 47.93 จุด (1.03 เปอร์เซ็นต์) ปิดที่ 4,685.92 จุด</p>\n<p><img src=\"images/[.png\" alt=\"\" />อ่าน<img src=\"images/].png\" alt=\"\" /></p>\n<p><br /> แม้ราคาน้ำมันดิบจะปิดในแดนลบ แต่ดัชนีพลังงานของเอสแอนด์พี500 แกว่งตัวสู่แดนบวกก่อนปิดตลาด และลงเอยด้วยการปิดบวก 0.2 เปอร์เซ็นต์ ขณะที่หุ้นของเอ็กซอนโมบิล ปรับขึ้น 1.6 เปอร์เซ็นต์ และเชฟรอน ปรับขึ้น 1 เปอร์เซนต์</p>\n<p><img src=\"images/[.png\" alt=\"\" />ลงเสียง<img src=\"images/].png\" alt=\"\" /></p>\n<p><br /> นอกจากนี้แล้ววอลล์สตรีทยังได้แรงหนุนกลุ่มเทคโนโลยี โดยเฉพาะแอปเปิลที่ปิดบวก 1.2 เปอร์เซ็นต์ และ อินเทล ที่ปิดบวก 1.9 เปอรเซ็นต์<br /> <br /> ส่วนราคาทองคำในวันอังคาร(12ม.ค.) ปิดลบแรง จากดอลลาร์ที่แข็งค่าขึ้น โดยทองคำตลาดโคเม็กซ์ ลดลง 11 ดอลลาร์ ปิดที่ 1,085.20 ดอลลาร์ต่อออนซ์</p>', '2', '3', '003710', '2016-01-13 10:59:39', '003710', '2016-02-05 19:23:32', null, '3', '2', '2016-01-13', '12:00:00'), ('2016011300002', '2', '20160113', 'อิหร่านควบคุมเรือกองทัพสหรัฐฯ 2 ลำ หลังล่วงละเมิดน่านน้ำ', '0', '<p>กองกำลังพิทักษ์ปฏิบัติอิหร่านเข้ากักเรือของกองทัพเรือสหรัฐฯ 2 ลำและควบคุมตัวลูกเรือ 10 คน หลังจากเรือมีปัญหาเครื่องยนต์ขัดข้องและลอยเข้าไปในน่านน้ำของเตหะราน อย่างไรก็ตาม เจ้าหน้าที่อเมริกาได้รับคำรับประกันจากอิหร่านว่าจะปล่อยตัวพวกเขาอย่างปลอดภัยและทันที</p>\r\n<p><img src=\"images/[.png\" alt=\"\" />เทป<img src=\"images/].png\" alt=\"\" /></p>\r\n<p><br /> ปีเตอร์ คุก โฆษกของเพนตากอนให้สัมภาษณ์ต่อสำนักข่าวเอพีว่า เรือตรวจการณ์ลำน้ำทั้ง 2 ลำกำลังแล่นอยู่ระหว่างคูเวตกับบาห์เรน ก่อนขาดการติดต่อไป<br /> <br /> เจ้าหน้าที่สหรัฐฯ เผยว่า เหตุการณ์นี้เกิดขึ้นใกล้เกาะฟาร์ซี ในอ่าวเปอร์เซีย โดยพวกเขาบอกว่าเรือลำหนึ่งมีปัญหาด้านเครื่องยนต์บางอย่าง จนทำให้แน่นิ่งไปไหนไม่ได้และจากนั้นก็ถูกอิหร่านมาพาไป ทั้งนี้ ลูกเรืออยู่ภายใต้การควบคุมตัวของอิหร่านบนเกาะฟาร์ซีเป็นระยะเวลาหนึ่ง แต่ตอนนี้ไม่เป็นที่แน่ชัดว่าพวกเขาอยู่ที่ไหน</p>\r\n<p><img src=\"images/[.png\" alt=\"\" />อ่าน<img src=\"images/].png\" alt=\"\" /></p>\r\n<p><br /> สำนักข่าวฟาร์สนิวส์รายงานว่า กองทัพเรือของกองกำลังพิทักษ์ปฏิวัติอิหร่าน ควบคุมตัวกองกำลังต่างชาติ 10 นาย เชื่อว่าเป็นชาวอเมริกัน และบอกว่าลูกเรือทั้งหมดล่วงล้ำเข้ามาในน่านน้ำอิหร่าน<br /><br /> นายจอห์น เคร์รี รัฐมนตรีต่างประเทศของสหรัฐฯ ซึ่งหล่อหลอมความสัมพันธ์ส่วนตัวกับนายโมฮัมเมด จาวัด ซารีฟ รัฐมนตรีต่างประเทศอิหร่าน ตลอดช่วงเวลา 3 ปีของการเจรจานิวเคลียร์ ได้ต่อสายตรงถึงนายซารีฟในทันทีเพื่อขอทราบรายละเอียดและคลี่คลายสถานการณ์ ซึ่งนายซารีฟบอกกับนายเคร์รีว่าจะอนุญาตให้ลูกเรือเหล่านั้นเดินทางต่อในทันที<br /> <br /> เหตุการณ์นี้เกิดขึ้นตามหลังกรณีกระทบกระทั่งในช่วงปลายเดือนธันวาคม โดยหนนั้นสหรัฐฯ อ้างว่าอิหร่านทดสอบยิงจรวดเฉียดใกล้เรือบรรทุกเครื่องบินของอเมริกาและเรือรบลำอื่นๆ ที่กำลังแล่นผ่านช่องแคบฮอร์มุซ</p>', '2', '2', '003710', '2016-01-13 11:08:51', '003710', '2016-01-14 20:10:41', null, '1', '1', '2016-01-13', '07:00:00'), ('2016011300003', '3', '20160113', 'สหรัฐฯ เตือน IS อาจยกระดับโจมตีทั่วโลก', '0', '<p>พล.อ.ลอยด์ ออสติน ผู้นำศูนย์บัญชาการกลาง (CENTCOM) ซึ่งควบคุมปฏิบัติการทางทหารของสหรัฐฯ ในภูมิภาคตะวันออกกลาง ชี้ว่า เหตุโจมตีที่เกิดขึ้นทั้งในนครอิสตันบูลและกรุงจาการ์ตาสัปดาห์นี้ แท้ที่จริงสะท้อนให้เห็นว่าไอเอสกำลังอ่อนแอลงเรื่อยๆ</p>\r\n<p><img src=\"images/[.png\" alt=\"\" />ลงเสียง<img src=\"images/].png\" alt=\"\" /></p>\r\n<p>&nbsp;นักรบไอเอสสามารถบุกยึดเมืองสำคัญไว้ได้หลายแห่งทั้งในอิรักและซีเรีย ระหว่างช่วงปี 2014-2015 แต่ระยะหลังๆ เริ่มถูกทวงคืนดินแดนซึ่งพวกเขาประกาศให้เป็น &ldquo;รัฐคอลีฟะห์&rdquo; โดยเฉพาะอย่างยิ่งการสูญเสียเมืองรามาดี (Ramadi) เมืองเอกของจังหวัดอันบาร์คืนให้แก่กองทัพอิรักซึ่งมีสหรัฐฯ หนุนหลังอยู่</p>\r\n<p><img src=\"images/[.png\" alt=\"\" />CG 1 บรรทัด ชื่อ :Anuwat Mateerawat&nbsp;<img src=\"images/].png\" alt=\"\" /></p>\r\n<p>&nbsp;กลุ่มพันธมิตรสหรัฐฯ ได้ส่งเครื่องบินขับไล่ออกไปทำลายโครงสร้างพื้นฐานด้านน้ำมันของไอเอส รวมถึงทิ้งระเบิดใส่ขบวนรถบรรทุกหลายร้อยคันที่พวกเขาใช้ขนน้ำมันดิบผิดกฎหมายไปทั่วซีเรีย และล่าสุดสัปดาห์นี้ยังทิ้งบอมบ์ใส่หน่วยงานการเงินของไอเอสที่เมืองโมซุล (Mosul) ซึ่งว่ากันว่ามีเงินสดถูกเก็บไว้หลายล้านดอลลาร์สหรัฐ</p>', '1', '2', '003710', '2016-01-13 15:07:45', '003710', '2016-01-15 10:52:21', null, '1', '2', '2016-01-13', '12:00:00'), ('2016020300001', '1', '20160203', 'มหาวิทยาลัยขอนแก่นจัดทำคลิปวิดีโอกระตุ้นให้คนไทยตระหนักถึงความสำคัญของโทรศัพท์มือถือ', '2.41', '<p><img src=\"images/[.png\" alt=\"\" />อ่าน<img src=\"images/].png\" alt=\"\" /></p>\n<p>มหาวิทยาลัยขอนแก่นจัดทำคลิปวิดีโอโดยมีแร็พเปอร์ชื่อดัง กอล์ฟ ฟักกลิ้งฮีโร่ มากระตุ้นให้คนไทยตระหนักถึงความสำคัญของโทรศัพท์มือถือที่ไม่ใช่เพียงไว้ใช้แชต แชร์ หรือด่าทอกัน แต่มันสามารถช่วยชีวิตคนข้างๆ คุณที่อาจกำลังเผชิญกับ Stroke หรือโรคหลอดเลือดสมอง โรคหนึ่งที่ทำให้คนไทยเสียชีวิตระดับต้นๆ</p>\n<p><img src=\"images/[.png\" alt=\"\" />ลงเสียง<img src=\"images/].png\" alt=\"\" /></p>\n<p><img src=\"images/[.png\" alt=\"\" />เห็นภาพ...อ่านต่อ<img src=\"images/].png\" alt=\"\" /></p>\n<p> มหาวิทยาลัยขอนแก่น โดยคณะแพทยศาสตร์ และภาคีเครือข่าย ได้ศึกษาวิจัยและหาแนวทางการช่วยเหลือผู้ป่วยกลุ่มนี้อย่างเป็นระบบ เพื่อให้ทันเวลา พร้อมการพัฒนา mobile app เพื่อให้ความรู้ ประเมินเบื้องต้น ให้ข้อมูลโรงพยาบาลที่ดูแลได้ และมีระบบช่วยเหลือผู้ป่วยหนักฉุกเฉิน ร่วมกับศูนย์การแพทย์ฉุกเฉิน</p>\n<p><img src=\"images/[.png\" alt=\"\" />CG 1 บรรทัด ชื่อ :กอล์ฟ ฟักกลิ้งฮีโร่  <img src=\"images/].png\" alt=\"\" /></p>\n<p><span>ทั้งนี้ศิลปินของเราใช้วิธีการแร็พด้วยจังหวะน้ำเสียงจริงจัง เตือนให้ผู้ชมจดจำ 5 สัญญาณเตือนของโรคอัมพาตนี้</span></p>\n<p><img src=\"images/[.png\" alt=\"\" />Add By :Anuwat Mateerawat <img src=\"images/].png\" alt=\"\" /></p>\n<p> </p>\n<p><img src=\"images/[.png\" alt=\"\" />Tel:1669 <img src=\"images/].png\" alt=\"\" /></p>', '3', '2', '003710', '2016-02-03 10:32:09', '003710', '2016-02-15 17:05:41', null, '2', '2', '2016-02-04', '12:30:00'), ('2016020500001', '1', '20160205', 'ไฟไหม้อาคารสูง 10 ชั้น ถนนจันทน์', '1.5', '<p><img src=\"images/[.png\" alt=\"\" />ลงเสียง<img src=\"images/].png\" alt=\"\" /></p>\n<p><span> </span>เมื่อเวลา 10.30 น. สน.บางโพงพาง รับแจ้งเหตุเพลิงไหม้อาคารสูง 10 ชั้น ในซอยถนนจันทน์ 11 แขวงช่องนนทรี เขตยานนาวา ล่าสุดมีรายงานว่ามีผู้เสียชีวิต 1 ราย และอาคารชั้นที่ 7 ได้ถล่มลงมา ขณะนี้เจ้าหน้าที่กำลังดำเพลิงที่โหมไหม้อย่างหนักในชั้นที่ 8-10 โดยเฉพาะชั้น 10 วัสดุเป็นไม้ซึ่งเป็นเชื้อเพลิงอย่างดี</p>', '3', '3', '003710', '2016-02-05 12:44:01', '003710', '2016-02-05 18:35:45', null, '3', '2', '2016-02-05', '12:00:00'), ('2016021500001', '1', '20160215', 'ณเดชน์ ลั่นความรู้สึกที่มีต่อ ญาญ่า สำคัญที่สุด', '3.15', '<p><img src=\"images/[.png\" alt=\"\" />อ่าน<img src=\"images/].png\" alt=\"\" /></p>\r\n<p>เป็นคู่จิ้นที่มีเรื่องให้แฟนคลับฟินกันอยู่เรื่อยๆ ล่าสุดถูกจับผิดว่า ณเดชน์ คูกิมิยะ แอบจับมือ ญาญ่า อุรัสยา เสปอร์บันด์ ในงานวันเกิดแม่แก้ว โดยหนุ่มณเดชน์เปิดใจในงาน แคปเจอร์เป็นคู่ อู้ฮูลุ้นทอง กับเมจิไพเกน โปร5 บอกทำไปไม่รู้ตัว</p>\r\n<p><img src=\"images/[.png\" alt=\"\" />CG 1 บรรทัด ชื่อ :ณเดชน์ คูกิมิยะ <img src=\"images/].png\" alt=\"\" /></p>\r\n<p>ณเดชน์ รับเผลอจับมือ ญาญ่า ในงานวันเกิดแม่แก้วไม่รู้ตัว หยอดหวานนางเอกดังสวยขนาดนี้ไม่อยากอยู่ใกล้ก็แปลก ไม่มีประโยชน์เรียกแฟน ย้ำความรู้สึกสำคัญที่สุด</p>\r\n<p><img src=\"images/[.png\" alt=\"\" />ลงเสียง<img src=\"images/].png\" alt=\"\" /></p>\r\n<p>อันนี้ผมก็ไม่ทราบว่าไปจับกันตอนไหนนะครับ เพราะว่าชวนเขาไปกินข้าวกัน ฉลองให้วันเกิดคุณแม่กัน ก็เลี้ยงข้าวเชิญพี่ๆ มาเชิญญาญ่ามาด้วยครับ รูปนั้นผมยังไม่เห็นด้วยซ้ำนะ(ยิ้ม) จับมือกันจริงไหมก็ไม่แน่ใจเหมือนกัน ผมยังไม่เห็นภาพเหมือนกัน ไหนเปิดสิๆ(ขอดูรูป) นี่ดูกันขนาดนั้นเลยเหรอเนี่ย(หัวเราะ) อาจจะเป็นทีเผลอครับ ธรรมชาติครับ ถ่ายรูปกันแบบธรรมชาติ ไม่รู้ตัวเลยครับมันเผลอกันไปเองครับผม(ยิ้ม) ก็รีบๆ ถ่ายกันครับ ก็น่าจะมีคนแซวเยอะเหมือนกันครับ</p>', '1', '2', '003710', '2016-02-15 17:28:32', '003710', '2016-02-15 17:28:32', null, '2', '3', '2016-02-16', '18:00:00'), ('2016021600001', '1', '20160216', 'เกมเก่านับพันจากยุค Window3.1', '3.7', '<p>เว็บไซต์รวมประวัติศาสตร์ \"Internet Archive\" เปิดกรุเกมเก่ายุควินโดวส์ 3.1 กว่าพันรายการ สามารถดาวน์โหลดมาเล่นได้ทันทีผ่านบราวเซอร์อินเตอร์เน็ต</p>\n<p><img src=\"images/[.png\" alt=\"\" />อ่าน<img src=\"images/].png\" alt=\"\" /></p>\n<p>วินโดวส์ 3.1 เป็นระบบปฏิบัติการคอมพิวเตอร์ 16 บิต ผลงานเก่าแก่ของค่ายไมโครซอฟท์ซึ่งเริ่มวางจำหน่ายครั้งแรกตั้งแต่ปี 1992 ถือเป็นรุ่นพี่ก่อนหน้าของ O.S. ยอดฮิต \"วินโดวส์ 95\" ที่ถูกพัฒนาตามออกมาและแพร่หลายไปทั่วโลกในภายหลัง</p>\n<p>ทาง Internet Archive ได้รวบรวมเกมที่รันบนระบบปฏิบัติการนี้กว่าหนึ่งพันรายการมาอยู่บนหน้าเว็บ สามารถคลิกเข้าไปแล้วเล่นได้ทันทีผ่านซอฟท์แวร์จำลองระบบ (Emulator) ควบคุมด้วยปุ่มคีย์บอร์ดและเมาส์</p>\n<p><img src=\"images/[.png\" alt=\"\" />เห็นภาพ...อ่านต่อ<img src=\"images/].png\" alt=\"\" /></p>\n<p>สำหรับผลงานที่กำลังได้รับความนิยมอยู่ในขณะนี้ก็มีทั้งเกมสกีคลาสสิก WINSKI เกมเศรษฐี Monopoly เกมยิงปกป้องโลก Missile Attack แถมยังมีเกมวางแผนสร้างโลก SimEarth จากผู้สร้างเดียวกับซิมซิตี้ด้วย</p>\n<p><img src=\"images/[.png\" alt=\"\" />อ่าน<img src=\"images/].png\" alt=\"\" /></p>\n<p>ย้อนไปในช่วงต้นปี 2015 ทางเว็บก็เคยเปิดกรุเกมเก่าแบบนี้มาแล้ว โดยครั้งก่อนเป็นเกมบนระบบ DOS ซึ่งก็มีมากกว่าสองพันรายการเลยทีเดียว</p>\n<p><img src=\"images/[.png\" alt=\"\" />Add By :Anuwat Mateerawat<img src=\"images/].png\" alt=\"\" /></p>', '5', '3', '003711', '2016-02-16 12:02:42', '003711', '2016-02-19 18:29:22', null, '5', '1', '2016-02-17', '00:00:00'), ('2016021700001', '1', '20160217', 'เกมเก่านับพันจากยุค Window3.1', '3.7', '<p>เว็บไซต์รวมประวัติศาสตร์ \"Internet Archive\" เปิดกรุเกมเก่ายุควินโดวส์ 3.1 กว่าพันรายการ สามารถดาวน์โหลดมาเล่นได้ทันทีผ่านบราวเซอร์อินเตอร์เน็ต</p>\n<p><img src=\"images/[.png\" alt=\"\" />อ่าน<img src=\"images/].png\" alt=\"\" /></p>\n<p>วินโดวส์ 3.1 เป็นระบบปฏิบัติการคอมพิวเตอร์ 16 บิต ผลงานเก่าแก่ของค่ายไมโครซอฟท์ซึ่งเริ่มวางจำหน่ายครั้งแรกตั้งแต่ปี 1992 ถือเป็นรุ่นพี่ก่อนหน้าของ O.S. ยอดฮิต \"วินโดวส์ 95\" ที่ถูกพัฒนาตามออกมาและแพร่หลายไปทั่วโลกในภายหลัง</p>\n<p>ทาง Internet Archive ได้รวบรวมเกมที่รันบนระบบปฏิบัติการนี้กว่าหนึ่งพันรายการมาอยู่บนหน้าเว็บ สามารถคลิกเข้าไปแล้วเล่นได้ทันทีผ่านซอฟท์แวร์จำลองระบบ (Emulator) ควบคุมด้วยปุ่มคีย์บอร์ดและเมาส์</p>\n<p><img src=\"images/[.png\" alt=\"\" />เห็นภาพ...อ่านต่อ<img src=\"images/].png\" alt=\"\" /></p>\n<p>สำหรับผลงานที่กำลังได้รับความนิยมอยู่ในขณะนี้ก็มีทั้งเกมสกีคลาสสิก WINSKI เกมเศรษฐี Monopoly เกมยิงปกป้องโลก Missile Attack แถมยังมีเกมวางแผนสร้างโลก SimEarth จากผู้สร้างเดียวกับซิมซิตี้ด้วย</p>\n<p><img src=\"images/[.png\" alt=\"\" />อ่าน<img src=\"images/].png\" alt=\"\" /></p>\n<p>ย้อนไปในช่วงต้นปี 2015 ทางเว็บก็เคยเปิดกรุเกมเก่าแบบนี้มาแล้ว โดยครั้งก่อนเป็นเกมบนระบบ DOS ซึ่งก็มีมากกว่าสองพันรายการเลยทีเดียว</p>\n<p><img src=\"images/[.png\" alt=\"\" />Add By :Anuwat Mateerawat<img src=\"images/].png\" alt=\"\" /></p>', '5', '3', '003711', '2016-02-16 12:02:42', '003710', '2016-02-17 20:25:34', null, '5', '1', '2016-02-17', '00:00:00'), ('2016021900001', '1', '20160219', 'รัฐบาลยืนยันรับมือภัยแล้งได้', '3.24', '<p><img src=\"images/[.png\" alt=\"\" />สด<img src=\"images/].png\" alt=\"\" /></p>\n<p><br />รัฐบาลยืนยันว่า น้ำสำรองมีเพียงพอตลอดฤดูแล้ง  แต่ก็ไม่นิ่งนอนใจ เร่งแก้ปัญหาพื้นที่แล้งหนัก โดยเตรียมทำฝนหลวงแล้วทั่วประเทศ  </p>\n<p><img src=\"images/[.png\" alt=\"\" />อ่าน<img src=\"images/].png\" alt=\"\" /></p>\n<p>พลตรี สรรเสริญ แก้วกำเนิด โฆษกประจำสำนักนายกรัฐมนตรี ปฏิเสธ กระแสข่าวน้ำใช้ไม่เพียงพอในช่วงฤดูแล้งนี้ว่า ไม่เป็นความจริง โดยข้อมูลน้ำของกรมชลประทาน ล่าสุด มีปริมาณน้ำใช้การได้ใน 4 เขื่อนหลัก 3,068 ล้านลูกบากศ์เมตร และยืนยันว่ามีน้ำเพื่อการอุปโภคบริโภค และรักษาระบบนิเวศน์ผลักดันน้ำเค็ม ตามลุ่มน้ำเจ้าพระยาเพียงพอไปจนสิ้นฤดูแล้ง</p>\n<p><br />ทั้งนี้แม้ปริมาณน้ำทุกเขื่อนจะเพียงพอตลอดฤดูแล้ง แต่ยอมรับว่าบางพื้นที่เกิดภาวะแล้งจริง ซึ่งรัฐบาลไม่ได้นิ่งนอนใจ โดยประกาศให้เป็นพื้นที่ประสบภัย 46 อำเภอ 12 จังหวัด เพื่อให้สามารถอนุมัติงบประมาณและขอรับการสนับสนุนรถบรรทุกน้ำหรือเครื่องสูบน้ำได้ ขณะเดียวกัน จะออกปฏิบัติการฝนหลวงทั่วประเทศ ตั้งแต่ 1 มีนาคมนี้ ในพื้นที่ จังหวัดเชียงใหม่ พิษณุโลก นครสวรรค์ กาญจนบุรี อุดรธานี นครราชสีมา จันทบุรี ประจวบคีรีขันธ์ และสุราษฎร์ธานี</p>\n<p><br /> </p>', '3', '3', '003710', '2016-02-19 20:42:13', '003710', '2016-02-28 15:37:40', null, '3', '1', '2016-02-28', '06:00:00'), ('2016022300001', '1', '20160223', 'ทดสอบ', '0.6', '<p>&nbsp;</p>\r\n<p><img src=\"images/[.png\" alt=\"\" />CG 1 บรรทัด ประเด็น : <img src=\"images/].png\" alt=\"\" />&nbsp; &nbsp;444444</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p><img src=\"images/[.png\" alt=\"\" />CG 2 บรรทัด ชื่อ : &nbsp; กกกก<br />ตำแหน่ง : <img src=\"images/].png\" alt=\"\" />5555</p>\r\n<p>&nbsp;</p>\r\n<p>กกกกกกก</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>', '1', '3', '003710', '2016-02-23 15:33:00', '003710', '2016-02-23 15:33:00', null, '1', '3', '2016-02-23', '00:00:00'), ('2016022300002', '2', '20160223', 'ทดสอบ', '0.05', '<p>&nbsp;<img src=\"images/[.png\" alt=\"\" />CG 1 บรรทัด ประเด็น : <img src=\"images/].png\" alt=\"\" />&nbsp; &nbsp;444444</p>\r\n<p>&nbsp;<img src=\"images/[.png\" alt=\"\" />CG 2 บรรทัด ชื่อ : &nbsp; กกกก</p>\r\n<p>ตำแหน่ง : <img src=\"images/].png\" alt=\"\" /></p>\r\n<p>5555</p>\r\n<p>กกกกกกก</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>', '1', '3', '003710', '2016-02-23 15:33:00', '003711', '2016-02-24 18:34:32', null, '1', '3', '2016-02-23', '00:00:00'), ('2016022500001', '1', '20160225', 'บาร์ญี่ปุ่นอัดโปรโมชั่นดื่มเบียร์ฟรีตลอดชีพ แค่ 1แสนแยน', '2.31', '<p>สแน็ค อุมัยโบ บาร์ขนาดเล็กแห่งหนึ่งในจังหวัดฟูกุโอกะ เชิญชวนลูกค้าให้ซื้อโปรโมชั่นพิเศษ ดื่มฟรีตลอดชีพ สนนราคา 1แสนเยน โดยลูกค้าสามารถดื่มเบียร์หรือเครื่องดื่มอื่นๆได้แบบไม่จำกัดตลอดชีวิต</p>\n<p><img src=\"images/[.png\" alt=\"\" />อ่าน<img src=\"images/].png\" alt=\"\" /></p>\n<p>ทางร้านโฆษณาว่าเงิน 1แสนเยนอาจดูมากเมื่อต้องจ่ายในคราวเดียว หากแต่เมื่อคิดว่าสามารถดื่มฟรีตลอดชีพแล้ว จะสามารถประหยัดเงินได้ถึงกว่า 7ล้านเยนเลยทีเดียว</p>\n<p><img src=\"images/[.png\" alt=\"\" />เห็นภาพ...อ่านต่อ<img src=\"images/].png\" alt=\"\" /></p>\n<p>เจ้าของบาร์ดังกล่าว ระบุว่า ไอเดียดื่มฟรีตลอดชีพนี้คำนวนจากค่าใช้จ่ายในการดื่มเบียร์ของชาวญี่ปุ่น โดยเฉลี่ยสัปดาห์ละ 2ครั้ง และในแต่ละครั้งจะดื่มราว 1250 เยน ซึ่งเมื่อคำนวนแล้วจะเป็นเงินราว 1หมื่นเยนต่อเดือน หรือ 120,000เยนต่อปี ซึ่งหากคุณเริ่มดื่มตั้งแต่อายุ 20 ปีจนถึง80ปี จะเสียเงินไปกับเครื่องดื่มมากถึง 7 ล้าน2แสนเยน</p>', '2', '3', '003711', '2016-02-25 16:27:24', '003711', '2016-02-25 17:37:06', null, '5', '2', '2016-02-26', '12:00:00'), ('2016022700001', '1', '20160227', 'รัฐบาลยืนยันรับมือภัยแล้งได้', '3.24', '<p><img src=\"images/[.png\" alt=\"\" />สด<img src=\"images/].png\" alt=\"\" /></p>\r\n<p><br />รัฐบาลยืนยันว่า น้ำสำรองมีเพียงพอตลอดฤดูแล้ง &nbsp;แต่ก็ไม่นิ่งนอนใจ เร่งแก้ปัญหาพื้นที่แล้งหนัก โดยเตรียมทำฝนหลวงแล้วทั่วประเทศ &nbsp;</p>\r\n<p><img src=\"images/[.png\" alt=\"\" />อ่าน<img src=\"images/].png\" alt=\"\" /></p>\r\n<p>พลตรี สรรเสริญ แก้วกำเนิด โฆษกประจำสำนักนายกรัฐมนตรี ปฏิเสธ กระแสข่าวน้ำใช้ไม่เพียงพอในช่วงฤดูแล้งนี้ว่า ไม่เป็นความจริง โดยข้อมูลน้ำของกรมชลประทาน ล่าสุด มีปริมาณน้ำใช้การได้ใน 4 เขื่อนหลัก 3,068 ล้านลูกบากศ์เมตร และยืนยันว่ามีน้ำเพื่อการอุปโภคบริโภค และรักษาระบบนิเวศน์ผลักดันน้ำเค็ม ตามลุ่มน้ำเจ้าพระยาเพียงพอไปจนสิ้นฤดูแล้ง</p>\r\n<p><br />ทั้งนี้แม้ปริมาณน้ำทุกเขื่อนจะเพียงพอตลอดฤดูแล้ง แต่ยอมรับว่าบางพื้นที่เกิดภาวะแล้งจริง ซึ่งรัฐบาลไม่ได้นิ่งนอนใจ โดยประกาศให้เป็นพื้นที่ประสบภัย 46 อำเภอ 12 จังหวัด เพื่อให้สามารถอนุมัติงบประมาณและขอรับการสนับสนุนรถบรรทุกน้ำหรือเครื่องสูบน้ำได้ ขณะเดียวกัน จะออกปฏิบัติการฝนหลวงทั่วประเทศ ตั้งแต่ 1 มีนาคมนี้ ในพื้นที่ จังหวัดเชียงใหม่ พิษณุโลก นครสวรรค์ กาญจนบุรี อุดรธานี นครราชสีมา จันทบุรี ประจวบคีรีขันธ์ และสุราษฎร์ธานี</p>\r\n<p><br />&nbsp;</p>', '1', '3', '003710', '2016-02-27 23:48:52', '003710', '2016-02-27 23:48:52', null, '3', '1', '2016-02-28', '06:00:00'), ('2016030600001', '1', '20160306', 'Pokemon Go เปิดทดสอบในญี่ปุ่นปลายเดือนนี้', '3.29', '<p>สตูดิโอ Niantic ประกาศรับสมัครคนเข้าทดสอบเกมสมาร์ตโฟน \"โปเกมอนโก\" (Pokemon Go) โดยจะเริ่มปลายเดือนนี้และยังจำกัดเฉพาะโซนญี่ปุ่นเท่านั้น</p>\n<p><img src=\"images/[.png\" alt=\"\" />อ่าน<img src=\"images/].png\" alt=\"\" /></p>\n<p>ทางผู้พัฒนาได้นิยามผลงานของพวกเขาว่าจะเป็น \"เรียลเวิลด์เกม\" มีโลกจริงเป็นฉากเวที ต้องออกเดินทางไปข้างนอกและพบปะเล่นร่วมกับผู้คนในสถานที่ต่างๆ จึงมีอะไรหลายอย่างที่ต้องทำให้เรียบร้อยแน่นอนก่อน</p>\n<p>พวกเขาจะขอความร่วมมือจากผู้เล่นที่สนใจมาช่วยกันทดสอบ \"ฟิลด์เทสต์\" ลงพื้นที่จริงเพื่อนำข้อมูลกลับไปปรับปรุงคุณภาพของแอพพลิเคชันเกมทีละขั้น เริ่มตั้งแต่ปลายเดือนมีนาคมเป็นต้นไป</p>\n<p>ผู้สนใจจะสามารถเข้าไปลงทะเบียนได้ที่เว็บไซต์อย่างเป็นทางการ โดยมีเงื่อนไขว่าต้องอาศัยอยู่ในประเทศญี่ปุ่น ใช้อุปกรณ์แอนดรอยด์เวอร์ชัน 4.3 ขึ้นไปหรือไอโฟน 5 ขึ้นไป พร้อมกับบัญชีของ Gmail หรือกูเกิล</p>\n<p><img src=\"images/[.png\" alt=\"\" />เห็นภาพ...อ่านต่อ<img src=\"images/].png\" alt=\"\" /></p>\n<p>นอกจากนี้ ข้อมูลการเล่นในช่วงทดสอบจะถูกรีเซ็ตลบทิ้งหมดไม่ส่งต่อไปใช้ตอนเปิดบริการจริง และจะขอความร่วมมือให้ช่วยกันเก็บเนื้อหาในแอพพลิเคชันทดสอบเป็นความลับ ไม่นำไปสปอยล์ต่อคนอื่นที่กำลังเฝ้ารอเวอร์ชันเต็มด้วย</p>', '3', '3', '003711', '2016-03-06 15:24:33', '003711', '2016-03-06 15:38:55', null, '5', '1', '2016-03-07', '08:00:00');
COMMIT;

-- ----------------------------
-- Table structure for `status`
-- ----------------------------
DROP TABLE IF EXISTS `status`;
CREATE TABLE `status` (
`statusID`  int(11) NOT NULL AUTO_INCREMENT ,
`statusName`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
PRIMARY KEY (`statusID`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=6

;

-- ----------------------------
-- Records of status
-- ----------------------------
BEGIN;
INSERT INTO `status` VALUES ('1', 'เขียน'), ('2', 'เรียบร้อย'), ('3', 'บก.เห็นชอบ'), ('4', 'บก.แก้ไข'), ('5', 'บก.เรียบร้อย');
COMMIT;

-- ----------------------------
-- Table structure for `tablenews`
-- ----------------------------
DROP TABLE IF EXISTS `tablenews`;
CREATE TABLE `tablenews` (
`tblID`  int(11) NOT NULL AUTO_INCREMENT ,
`tblName`  varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`enable`  bit(1) NULL DEFAULT b'1' ,
PRIMARY KEY (`tblID`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=11

;

-- ----------------------------
-- Records of tablenews
-- ----------------------------
BEGIN;
INSERT INTO `tablenews` VALUES ('1', 'กลาง', ''), ('2', 'บันเทิง', ''), ('3', 'ภูมิภาค', ''), ('4', 'การเมือง', ''), ('5', 'สังคม', ''), ('6', 'ต่างประเทศ', ''), ('7', 'กีฬา', ''), ('8', 'เศรษฐกิจ', ''), ('9', 'ออนไลน์', ''), ('10', 'PR', '');
COMMIT;

-- ----------------------------
-- Table structure for `typescript`
-- ----------------------------
DROP TABLE IF EXISTS `typescript`;
CREATE TABLE `typescript` (
`typeID`  int(11) NOT NULL AUTO_INCREMENT ,
`typeName`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`enable`  bit(1) NULL DEFAULT b'1' ,
PRIMARY KEY (`typeID`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=5

;

-- ----------------------------
-- Records of typescript
-- ----------------------------
BEGIN;
INSERT INTO `typescript` VALUES ('1', 'สด', ''), ('2', 'เทป', ''), ('3', 'อ่าน', ''), ('4', 'ลงเสียง', '');
COMMIT;

-- ----------------------------
-- Table structure for `typeuser`
-- ----------------------------
DROP TABLE IF EXISTS `typeuser`;
CREATE TABLE `typeuser` (
`tyID`  int(11) NOT NULL AUTO_INCREMENT ,
`tyName`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`enable`  bit(1) NULL DEFAULT b'1' ,
PRIMARY KEY (`tyID`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=4

;

-- ----------------------------
-- Records of typeuser
-- ----------------------------
BEGIN;
INSERT INTO `typeuser` VALUES ('1', 'นักข่าว', ''), ('2', 'บรรณาธิการ', ''), ('3', 'Admin', '');
COMMIT;

-- ----------------------------
-- Table structure for `usr`
-- ----------------------------
DROP TABLE IF EXISTS `usr`;
CREATE TABLE `usr` (
`uid`  int(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT ,
`empID`  varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`fullName`  varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`usrName`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`pwd`  varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'eTZ1UTc5YUpnN0srcEF4YWcySzJDQT09' COMMENT '1234' ,
`createDate`  datetime NULL DEFAULT NULL ,
`lastLogin`  datetime NULL DEFAULT NULL ,
`IPAddress`  varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`enable`  bit(1) NULL DEFAULT b'1' ,
`typeID`  int(11) NULL DEFAULT NULL ,
`tblID`  int(11) NULL DEFAULT NULL ,
`proID`  int(11) NULL DEFAULT NULL ,
`groupMe`  tinyint(1) NULL DEFAULT 1 ,
`groupTable`  tinyint(1) NULL DEFAULT 0 ,
`Approve`  bit(1) NULL DEFAULT b'0' ,
`otherGroup`  bit(1) NULL DEFAULT b'0' ,
`rundown`  int(11) NULL DEFAULT 0 ,
PRIMARY KEY (`uid`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=4

;

-- ----------------------------
-- Records of usr
-- ----------------------------
BEGIN;
INSERT INTO `usr` VALUES ('00000000001', '003710', 'อนุวัฒน์ เมธีระวัฒน์', '003710', 'eTZ1UTc5YUpnN0srcEF4YWcySzJDQT09', '2016-01-05 19:55:58', '2016-03-11 15:19:28', '172.16.24.15', '', '1', '1', '1', '1', '0', '', '', '1'), ('00000000002', '003711', 'วิภาวรรณ คุ้มศิริ', '003711', 'eTZ1UTc5YUpnN0srcEF4YWcySzJDQT09', '2016-01-28 19:55:58', '2016-03-11 19:28:40', '172.16.9.108', '', '3', '2', '2', '2', '2', '', '', '1'), ('00000000003', '003709', 'Tester', '003709', 'eTZ1UTc5YUpnN0srcEF4YWcySzJDQT09', '2016-03-10 19:40:24', null, null, '', '1', '7', '1', '1', '1', '', '', '1');
COMMIT;

-- ----------------------------
-- Table structure for `wire`
-- ----------------------------
DROP TABLE IF EXISTS `wire`;
CREATE TABLE `wire` (
`wID`  varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`dateCode`  varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`title`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`link`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`dateStamp`  datetime NULL DEFAULT NULL ,
PRIMARY KEY (`wID`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Records of wire
-- ----------------------------
BEGIN;
INSERT INTO `wire` VALUES ('35201822', '20160120', 'Helping the village where one in four is disabled', 'http://www.bbc.co.uk/news/magazine-35201822#sa-ns_mchannel=rss&ns_source=PublicRSS20-sa', '2016-01-20 19:30:15'), ('35259124', '20160120', 'Calling time on the robot disco', 'http://www.bbc.co.uk/news/technology-35259124#sa-ns_mchannel=rss&ns_source=PublicRSS20-sa', '2016-01-20 19:30:15'), ('35340528', '20160120', 'Malaysia counts cost of bauxite mining', 'http://www.bbc.co.uk/news/world-asia-35340528#sa-ns_mchannel=rss&ns_source=PublicRSS20-sa', '2016-01-20 19:30:16'), ('35350886', '20160120', 'Are beards good for your health?', 'http://www.bbc.co.uk/news/magazine-35350886#sa-ns_mchannel=rss&ns_source=PublicRSS20-sa', '2016-01-20 19:30:15'), ('35354718', '20160120', 'Student grant protest blocks bridge', 'http://www.bbc.co.uk/news/education-35354718#sa-ns_mchannel=rss&ns_source=PublicRSS20-sa', '2016-01-20 19:30:15'), ('35357506', '20160120', 'Bosses more gloomy on growth - report', 'http://www.bbc.co.uk/news/business-35357506#sa-ns_mchannel=rss&ns_source=PublicRSS20-sa', '2016-01-20 19:30:14'), ('35357623', '20160120', 'VIDEO: DiCaprio attacks corporate greed', 'http://www.bbc.co.uk/news/business-35357623#sa-ns_mchannel=rss&ns_source=PublicRSS20-sa', '2016-01-20 19:30:14'), ('35358925', '20160120', 'Asylum housing doors to be repainted', 'http://www.bbc.co.uk/news/uk-england-tees-35358925#sa-ns_mchannel=rss&ns_source=PublicRSS20-sa', '2016-01-20 19:30:14'), ('35359219', '20160120', 'Shell profits dive ahead of BG vote', 'http://www.bbc.co.uk/news/business-35359219#sa-ns_mchannel=rss&ns_source=PublicRSS20-sa', '2016-01-20 19:30:14'), ('35359324', '20160120', 'VIDEO: CCTV: Car ploughs into service station', 'http://www.bbc.co.uk/news/world-australia-35359324#sa-ns_mchannel=rss&ns_source=PublicRSS20-sa', '2016-01-20 19:30:15'), ('35359689', '20160120', 'Unemployment down but wage growth slows', 'http://www.bbc.co.uk/news/business-35359689#sa-ns_mchannel=rss&ns_source=PublicRSS20-sa', '2016-01-20 19:30:14'), ('35359796', '20160120', 'European shares slump amid oil rout', 'http://www.bbc.co.uk/news/business-35359796#sa-ns_mchannel=rss&ns_source=PublicRSS20-sa', '2016-01-20 19:30:15'), ('35360354', '20160120', 'IS says two Paris attackers were Iraqi', 'http://www.bbc.co.uk/news/world-europe-35360354#sa-ns_mchannel=rss&ns_source=PublicRSS20-sa', '2016-01-20 19:30:15'), ('35360415', '20160120', 'IS destroys ancient monastery in Iraq', 'http://www.bbc.co.uk/news/world-middle-east-35360415#sa-ns_mchannel=rss&ns_source=PublicRSS20-sa', '2016-01-20 19:30:15'), ('374364', '20160120', 'กลุ่มผู้พิการจี้กทม.ติดลิฟท์บีทีเอสสุดอืด1ปีไม่เสร็จตามศาลสั่ง', 'http://www.dailynews.co.th/Content.do?contentId=374364', '2016-01-20 19:30:06'), ('374370', '20160120', 'ติงระบบศึกษาไทยไม่เอื้อพัฒนาวงการศิลปะ', 'http://www.dailynews.co.th/Content.do?contentId=374370', '2016-01-20 19:30:05'), ('374371', '20160120', '“บิ๊กหนุ่ย”ขอดูก่อนปรับโครงสร้างสำนักลูกเสือ', 'http://www.dailynews.co.th/Content.do?contentId=374371', '2016-01-20 19:30:05'), ('44184-news_44184', '20160120', 'ไม่ใช่แค่กาฬสินธุ์!อบจ.อุดรฯ ซื้อผ้าห่มแจกบิ๊กลอต 27ล. เฉลี่ยผืนละ 220 บ.', 'http://www.isranews.org/เรื่องเด่น-สำนักข่าวอิศรา/item/44184-news_44184.html', '2016-01-20 19:30:06'), ('44192-philip_441921', '20160120', 'อสส.ฟ้อง ‘ฟิลลิป มอร์ริส’ ศาลนัดพร้อม25เม.ย.-ผิดจริงปรับ 8 หมื่นล.', 'http://www.isranews.org/เรื่องเด่น-สำนักข่าวอิศรา/item/44192-philip_441921.html', '2016-01-20 19:30:07'), ('44197-buddha_44197', '20160120', 'เปิดปูมสร้างพุทธมณฑลปัตตานี...รัฐยอมถอย-เปลี่ยนชื่อหลังเจอกระแสต้าน', 'http://www.isranews.org/เรื่องเด่น-สำนักข่าวอิศรา/item/44197-buddha_44197.html', '2016-01-20 19:30:06'), ('44199-mtmtmt', '20160120', 'เปิดคำพิพากษาศาล ปค.สูงสุด เบื้องหลัง! มท.คืนเก้าอี้อดีตนายกฯระนอง', 'http://www.isranews.org/เรื่องเด่น-สำนักข่าวอิศรา/item/44199-mtmtmt.html', '2016-01-20 19:30:06'), ('44206-ijij444', '20160120', '4 บ.เครือข่ายคืนภาษีกลุ่ม 2 พันล. ‘อินฟินิตี้-แทงค์กิ้วฯ’ อยู่ใน‘บ้านร้าง’หลังเดียว', 'http://www.isranews.org/เรื่องเด่น-สำนักข่าวอิศรา/item/44206-ijij444.html', '2016-01-20 19:30:06'), ('573703', '20160229', 'ยูวีแรงแค่ไหนก็เอาอยู่! กันแดด Physical สาวผิวแพ้ง่ายปลื้ม!', 'http://www.thairath.co.th/content/573703', '2016-02-29 14:35:11'), ('583604', '20160229', 'ต้านรอยตีนกาอยู่ เหตุเซลล์แบตฯหมด', 'http://www.thairath.co.th/content/583604', '2016-02-29 14:35:06'), ('583839', '20160229', 'สิ้นสุดการรอคอย! ลีโอนาร์โด คว้าออสการ์ บรี นำหญิง Spotlight หนังเยี่ยม', 'http://www.thairath.co.th/content/583839', '2016-02-29 14:35:06'), ('583930', '20160229', 'สคฝ. ยันลดคุ้มครองเงินฝากเหลือ 1 ล้าน ไม่กระทบออมเงิน', 'http://www.thairath.co.th/content/583930', '2016-02-29 14:35:19'), ('583950', '20160229', 'การสร้างความเข้มแข็งของท้องถิ่น', 'http://www.thairath.co.th/content/583950', '2016-02-29 14:35:11'), ('583959', '20160229', 'อุบัติเหตุบนท้องถนน 2 ราย  ชลบุรี-นครนายก เสียชีวิต 2 ศพ ', 'http://www.thairath.co.th/content/583959', '2016-02-29 14:35:06'), ('583965', '20160229', '\"ประวิตร\" ปัดส่งทหารคุกคาม \"ยิ่งลักษณ์\" แจงเพื่อดูแลความสงบ', 'http://www.thairath.co.th/content/583965', '2016-02-29 14:35:07'), ('583978', '20160229', '\"บิ๊กป้อม\" ยันย้ายทหารอย่ามโนเป็น \"บูรพาพยัคฆ์-วงเทวัญ\"', 'http://www.thairath.co.th/content/583978', '2016-02-29 14:35:02'), ('583983', '20160229', 'ข่าวต้นชั่วโมง 12.00 น.', 'http://www.thairath.co.th/content/583983', '2016-02-29 14:35:19'), ('583987', '20160229', 'วอยซ์ทีวี ผนึกมติชน ปรับผังข่าวสู้ศึกดิจิตอล!', 'http://www.thairath.co.th/content/583987', '2016-02-29 14:35:03'), ('583990', '20160229', 'ทำนาไม่ได้ เกษตรกรปลูกแตงโม ‘ตอร์ปิโด’ สู้แล้ง! ผลผลิตดี พ่อค้ารับซื้อถึงที่', 'http://www.thairath.co.th/content/583990', '2016-02-29 14:39:33'), ('583993', '20160229', 'ยอดขายรถยนต์เดือนมกราคม', 'http://www.thairath.co.th/content/583993', '2016-02-29 14:35:02'), ('583996', '20160229', '\"จักรทิพย์\" บินปัตตานี ตรวจจุดคาร์บอมบ์ใกล้ฐาน ตร. คาดแก้แค้น', 'http://www.thairath.co.th/content/583996', '2016-02-29 14:35:12'), ('584000', '20160229', '\"พิสตันส์\" เปิดรังทุบ \"เเร็ปเตอร์ส\" 114-101 เก็บชัย 4 เกมติด', 'http://www.thairath.co.th/content/584000', '2016-02-29 14:39:33'), ('584006', '20160229', 'ข่าวต้นชั่วโมง 13.00 น.', 'http://www.thairath.co.th/content/584006', '2016-02-29 14:35:12'), ('584025', '20160229', 'เตือน! คนกรุงแห่ถ่ายรูป \"ทุ่งหญ้าคา\" ลาดพร้าว ระวังแพ้เกสร-โปรดรักษาความสะอาด', 'http://www.thairath.co.th/content/584025', '2016-02-29 14:38:26'), ('676980', '20160120', 'ATP Tour rejects match-fixing cover-up claim', 'http://rss.cnn.com/c/35494/f/676980/s/4cf629da/sc/13/l/0Ledition0Bcnn0N0C20A160C0A10C180Ctennis0Caustralian0Eopen0Ematch0Efixing0Etennis0Cindex0Bhtml0Deref0Frss0Iasia/story01.htm', '2016-01-20 19:30:25'), ('676981', '20160120', 'Do video games cause violence?', 'http://rss.cnn.com/c/35494/f/676981/s/490f2032/sc/21/l/0Lrss0Bcnn0N0Cc0C354930Cf0C676930A0Cs0C490Af128c0Csc0C210Cl0C0ALmoney0ABcnn0AN0AC20AA150AC0AA80AC170ACtechnology0ACvideo0AEgame0AEviolence0ACindex0ABhtml0ADsection0AFmoney0AInews0AIinternational0Cstory0A10Bhtm/story01.htm', '2016-01-20 19:30:18'), ('676993', '20160120', '10 reasons you have to visit Uruguay', 'http://rss.cnn.com/c/35494/f/676993/s/4cfe7794/sc/35/l/0Ledition0Bcnn0N0C20A160C0A10C20A0Ctravel0Curuguay0Etravel0E10A0Ereasons0Eto0Evisit0Cindex0Bhtml0Deref0Fedition/story01.htm', '2016-01-20 19:30:20'), ('676997', '20160120', 'How Paris attacker helped radicalize French teen', 'http://rss.cnn.com/c/35494/f/676997/s/4cf990c5/sc/13/l/0L0Scnn0N0C20A160C0A10C190Ceurope0Cescaping0Eisis0Eparis0Eattacker0Eradicalized0Eteen0Cindex0Bhtml0Deref0Frss0Iworld/story01.htm', '2016-01-20 19:30:22'), ('9590000006795', '20160120', '\"เฟด\" ลิ่วออสซี เผยไม่บังคับลูกหวดเทนนิสตามพ่อ', 'http://www.manager.co.th/asp-bin/mgrview.aspx?NewsID=9590000006795', '2016-01-20 19:30:08'), ('9590000006799', '20160120', '“ซ้อต่าย” วอนให้เกียรติ “ปอ ทฤษฎี” หยุดเซลฟี-แชร์ภาพศพ', 'http://www.manager.co.th/asp-bin/mgrview.aspx?NewsID=9590000006799', '2016-01-20 19:30:08'), ('9590000006844', '20160120', '\"โอซิล\" ทั้งเก่งทั้งแหวะ!! โชว์สตั๊ดใหม่เดาะหมากฝรั่งอัดกล้องเคี้ยวต่อ (คลิป)', 'http://www.manager.co.th/asp-bin/mgrview.aspx?NewsID=9590000006844', '2016-01-20 19:30:08'), ('9590000006909', '20160120', 'ไพน์เฮิรสท์จัดโปรชั่นวันธรรมดา', 'http://www.manager.co.th/asp-bin/mgrview.aspx?NewsID=9590000006909', '2016-01-20 19:30:07'), ('9590000006927', '20160120', 'ไม่มีเขิน!สมาคมอ้าง\"สมยศ\"วืดชิงนายกบอล', 'http://www.manager.co.th/asp-bin/mgrview.aspx?NewsID=9590000006927', '2016-01-20 19:30:07'), ('9590000006929', '20160120', 'แม่โจ้มีโปรโมชั่นสำหรับคนไทย', 'http://www.manager.co.th/asp-bin/mgrview.aspx?NewsID=9590000006929', '2016-01-20 19:30:07'), ('9590000006961', '20160120', 'รมว.ศธ.กำชับ ตร.เร่งขยายผลจับกุมคดีทุจริตเงิน สกสค.', 'http://www.manager.co.th/asp-bin/mgrview.aspx?NewsID=9590000006961', '2016-01-20 19:30:07'), ('9590000021476', '20160229', 'นายกฯ ย้ำพัฒนา ศก.ประเทศด้วยหลัก ศก.พอเพียง สู่การพัฒนาที่ยั่งยืน', 'http://www.manager.co.th/asp-bin/mgrview.aspx?NewsID=9590000021476', '2016-02-29 14:35:18'), ('9590000021484', '20160229', 'กทม.เผยผู้ค้าปากคลองตลาดจะได้พื้นที่ใหม่ภายใน 1 สัปดาห์นี้', 'http://www.manager.co.th/asp-bin/mgrview.aspx?NewsID=9590000021484', '2016-02-29 14:35:02'), ('9590000021488', '20160229', 'กรธ.หารือปรับแก้ร่าง รธน.หมวดรัฐสภาต่อ ยันคำนึงหลัก ปชต.', 'http://www.manager.co.th/asp-bin/mgrview.aspx?NewsID=9590000021488', '2016-02-29 14:35:24'), ('9590000021492', '20160229', 'จีนมีแนวโน้มปลดคนงานอุตฯ ถ่านหิน 1.8 ล้านคน เพื่อลดต้นทุน', 'http://www.manager.co.th/asp-bin/mgrview.aspx?NewsID=9590000021492', '2016-02-29 14:35:02'), ('9590000021493', '20160229', '\"องอาจ\" เสนอ กรธ.ปรับแก้เรื่ององค์กรปกครองส่วนท้องถิ่น', 'http://www.manager.co.th/asp-bin/mgrview.aspx?NewsID=9590000021493', '2016-02-29 14:35:02'), ('9590000021496', '20160229', 'DSI ประชุมคดีรถยนต์จดประกอบเลี่ยงภาษีวันนี้', 'http://www.manager.co.th/asp-bin/mgrview.aspx?NewsID=9590000021496', '2016-02-29 14:35:24'), ('9590000021502', '20160229', '\"บิ๊กป้อม\" ย้ำ ผบ.เหล่าทัพเร่งแจกจ่ายน้ำเยียวยา ปชช.จากภัยแล้ง', 'http://www.manager.co.th/asp-bin/mgrview.aspx?NewsID=9590000021502', '2016-02-29 14:35:01'), ('9590000021543', '20160229', 'ออมสินเจรจา สกสค.ปล่อยสินเชื่อครู เชื่อลดหนี้เสียได้ถึง 4 หมื่นล้าน', 'http://www.manager.co.th/asp-bin/mgrview.aspx?NewsID=9590000021543', '2016-02-29 14:35:01'), ('9590000021549', '20160229', '\"ประวิตร\" ยันแต่งตั้งโยกย้ายทหารยึดหลักอาวุโส-ความสามารถ', 'http://www.manager.co.th/asp-bin/mgrview.aspx?NewsID=9590000021549', '2016-02-29 14:35:18'), ('9590000021556', '20160229', 'อินโดฯ ตรวจพบไฟป่าสูงสุดบนเกาะสุมาตราถึง 68 จุด', 'http://www.manager.co.th/asp-bin/mgrview.aspx?NewsID=9590000021556', '2016-02-29 14:35:10'), ('Buffett-rails-against-presidential-candidates-who--30280373', '20160229', 'Buffett rails against presidential candidates who talk down economy', 'http://www.nationmultimedia.com/breakingnews/Buffett-rails-against-presidential-candidates-who--30280373.html', '2016-02-29 14:35:08'), ('Cambodians-arrested-for-rape-of-French-women-in-Th-30280439', '20160229', 'Cambodians arrested for rape of French women in Thailand', 'http://www.nationmultimedia.com/breakingnews/Cambodians-arrested-for-rape-of-French-women-in-Th-30280439.html', '2016-02-29 14:35:21'), ('Clinton-wins-South-Carolina-Democratic-primary-US--30280367', '20160229', 'Clinton wins South Carolina Democratic primary: US networks', 'http://www.nationmultimedia.com/breakingnews/Clinton-wins-South-Carolina-Democratic-primary-US--30280367.html', '2016-02-29 14:35:15'), ('EU-team-visits-Thailand-to-assess-fishing-industry-30277217', '20160120', 'EU team visits Thailand to assess fishing industry cleanup', 'http://www.nationmultimedia.com/breakingnews/EU-team-visits-Thailand-to-assess-fishing-industry-30277217.html', '2016-01-20 19:30:08'), ('Govt-urged-to-delay-motorway-project-30280374', '20160229', 'Govt urged to delay motorway project', 'http://www.nationmultimedia.com/breakingnews/Govt-urged-to-delay-motorway-project-30280374.html', '2016-02-29 14:35:22'), ('Koh-Tarutao-park-denies-allowing-resort-to-be-buil-30277306', '20160120', 'Koh Tarutao park denies allowing resort to be built on sea surface', 'http://www.nationmultimedia.com/breakingnews/Koh-Tarutao-park-denies-allowing-resort-to-be-buil-30277306.html', '2016-01-20 19:30:08'), ('Myanmar-nationalists-demonstrate-against-Suu-Kyi-p-30280422', '20160229', 'Myanmar nationalists demonstrate against Suu Kyi presidency bid', 'http://www.nationmultimedia.com/breakingnews/Myanmar-nationalists-demonstrate-against-Suu-Kyi-p-30280422.html', '2016-02-29 14:35:08'), ('Myanmar-spelling-disrupts-Carlsbergs-business-30277313', '20160120', 'Myanmar spelling disrupts Carlsbergâs business', 'http://www.nationmultimedia.com/aec/Myanmar-spelling-disrupts-Carlsbergs-business-30277313.html', '2016-01-20 19:30:08'), ('New-parking-lot-planned-to-ease-traffic-in-Rattana-30277317', '20160120', 'New parking lot planned to ease traffic in Rattanakosin Island', 'http://www.nationmultimedia.com/breakingnews/New-parking-lot-planned-to-ease-traffic-in-Rattana-30277317.html', '2016-01-20 19:30:08'), ('NLA-defends-slow-setup-of-reconciliation-panel-30277329', '20160120', 'NLA defends slow setup of reconciliation panel', 'http://www.nationmultimedia.com/breakingnews/NLA-defends-slow-setup-of-reconciliation-panel-30277329.html', '2016-01-20 19:30:08'), ('Nok-Air-hopes-to-resume-normal-operations-after-Ma-30280380', '20160229', 'Nok Air hopes to resume normal operations after March 10', 'http://www.nationmultimedia.com/breakingnews/Nok-Air-hopes-to-resume-normal-operations-after-Ma-30280380.html', '2016-02-29 14:35:15'), ('Paris-to-launch-electric-moped-rental-system-30280369', '20160229', 'Paris to launch electric moped rental system', 'http://www.nationmultimedia.com/breakingnews/Paris-to-launch-electric-moped-rental-system-30280369.html', '2016-02-29 14:35:15'), ('Philippines-wants-to-ban-Madonna-after-flag-furore-30280379', '20160229', 'Philippines wants to ban Madonna after flag furore', 'http://www.nationmultimedia.com/breakingnews/Philippines-wants-to-ban-Madonna-after-flag-furore-30280379.html', '2016-02-29 14:35:21'), ('Policemen-among-10-injured-in-car-bomb-attack-in-P-30280366', '20160229', 'Policemen among 10 injured in car-bomb attack in Pattani', 'http://www.nationmultimedia.com/breakingnews/Policemen-among-10-injured-in-car-bomb-attack-in-P-30280366.html', '2016-02-29 14:35:22'), ('Spotlight-surprise-winner-for-Best-Picture-30280438', '20160229', '\"Spotlight\" surprise winner for Best Picture', 'http://www.nationmultimedia.com/breakingnews/Spotlight-surprise-winner-for-Best-Picture-30280438.html', '2016-02-29 14:35:07'), ('Supreme-Court-upholds-students-rape-convictions-ag-30277143', '20160120', 'Supreme Court upholds students rape convictions against two teachers', 'http://www.nationmultimedia.com/breakingnews/Supreme-Court-upholds-students-rape-convictions-ag-30277143.html', '2016-01-20 19:30:08'), ('Thai-Russian-security-cooperation-mulled-30280371', '20160229', 'Thai-Russian security cooperation mulled', 'http://www.nationmultimedia.com/breakingnews/Thai-Russian-security-cooperation-mulled-30280371.html', '2016-02-29 14:35:08'), ('TrueVisions-remind-digital-TV-coupon-owners-to-red-30277299', '20160120', 'TrueVisions remind digital TV coupon owners to redeem it', 'http://www.nationmultimedia.com/breakingnews/TrueVisions-remind-digital-TV-coupon-owners-to-red-30277299.html', '2016-01-20 19:30:09');
COMMIT;

-- ----------------------------
-- Auto increment value for `log`
-- ----------------------------
ALTER TABLE `log` AUTO_INCREMENT=1;

-- ----------------------------
-- Auto increment value for `programnews`
-- ----------------------------
ALTER TABLE `programnews` AUTO_INCREMENT=7;

-- ----------------------------
-- Auto increment value for `status`
-- ----------------------------
ALTER TABLE `status` AUTO_INCREMENT=6;

-- ----------------------------
-- Auto increment value for `tablenews`
-- ----------------------------
ALTER TABLE `tablenews` AUTO_INCREMENT=11;

-- ----------------------------
-- Auto increment value for `typescript`
-- ----------------------------
ALTER TABLE `typescript` AUTO_INCREMENT=5;

-- ----------------------------
-- Auto increment value for `typeuser`
-- ----------------------------
ALTER TABLE `typeuser` AUTO_INCREMENT=4;

-- ----------------------------
-- Auto increment value for `usr`
-- ----------------------------
ALTER TABLE `usr` AUTO_INCREMENT=4;
