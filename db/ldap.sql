/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : ldap

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-06-27 10:27:15
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `basedn`
-- ----------------------------
DROP TABLE IF EXISTS `basedn`;
CREATE TABLE `basedn` (
  `BASEDN_ID` int(11) NOT NULL AUTO_INCREMENT,
  `BASEDN_CODE` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `HOST` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ACCOUNT_PREFIX` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ACCOUNT_SUFFIX` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ACCOUNT_SUFFIX_ARR` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ACTIVE` bit(1) DEFAULT NULL,
  `SSL` bit(1) DEFAULT NULL,
  `PORT` int(11) DEFAULT NULL,
  `USER_FILTER` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `GROUP_FILTER` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ORGANIZATION_FILTER` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PERMISSIONS` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`BASEDN_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of basedn
-- ----------------------------
INSERT INTO `basedn` VALUES ('1', 'dc=example,dc=com', 'ldap.forumsys.com', 'UID=', '', '[\"OU=mathematicians\",\"OU=scientists\",\"OU=chemists\"]', '', '\0', '389', '(objectclass=person)', '(objectclass=groupOfUniqueNames)', '(ou=*)', '{\"super\":{\"users\":[\"admin1\",\" admin2\",\"admin3\"],\"groups\":[]},\"admin\":{\"users\":[\"euler\"],\"groups\":[]}}');
INSERT INTO `basedn` VALUES ('3', 'DC=TINHVAN,DC=VN', 'AD-TINHVANVN', 'CN=', null, null, '', '', '636', '(objectclass=person)', '(objectclass=group)', '(|(cn=*)(ou=*))', null);

-- ----------------------------
-- Table structure for `fields`
-- ----------------------------
DROP TABLE IF EXISTS `fields`;
CREATE TABLE `fields` (
  `FIELD_ID` int(11) NOT NULL AUTO_INCREMENT,
  `BASEDN_ID` int(11) NOT NULL,
  `TYPE` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `FIELD_CODE` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `FIELD_NAME` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ACTIVE` bit(1) DEFAULT NULL,
  PRIMARY KEY (`FIELD_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of fields
-- ----------------------------
INSERT INTO `fields` VALUES ('16', '1', 'user', 'email', 'Email', '');
INSERT INTO `fields` VALUES ('17', '1', 'user', 'phone', 'Phone', '');
INSERT INTO `fields` VALUES ('18', '1', 'user', 'address', 'Address', '');
INSERT INTO `fields` VALUES ('19', '1', 'user', 'fullname', 'Full name', '');

-- ----------------------------
-- Table structure for `objects`
-- ----------------------------
DROP TABLE IF EXISTS `objects`;
CREATE TABLE `objects` (
  `OBJECT_ID` int(11) NOT NULL AUTO_INCREMENT,
  `BASEDN_ID` int(11) NOT NULL,
  `OBJECT_CODE` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `OBJECT_TYPE` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `AD_DATA` tinytext COLLATE utf8mb4_unicode_ci,
  `CUSTOM_DATA` tinytext COLLATE utf8mb4_unicode_ci,
  `ACTIVE` bit(1) DEFAULT NULL,
  PRIMARY KEY (`OBJECT_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of objects
-- ----------------------------
INSERT INTO `objects` VALUES ('2', '1', '', 'USER', '', '[]', null);
INSERT INTO `objects` VALUES ('3', '1', 'HUNGHV', 'USER', '', '', null);
INSERT INTO `objects` VALUES ('4', '1', 'curie', 'USER', '{\"uid\":{\"count\":1,\"0\":\"curie\"},\"0\":\"uid\",\"objectclass\":{\"count\":4,\"0\":\"inetOrgPerson\",\"1\":\"organizationalPerson\",\"2\":\"person\",\"3\":\"top\"},\"1\":\"objectclass\",\"cn\":{\"count\":1,\"0\":\"Marie Curie\"},\"2\":\"cn\",\"sn\":{\"count\":1,\"0\":\"Curie\"},\"3\":\"sn\",\"mail\":{\"count\":1,', '{\"address\":\"Ha Noi\",\"email\":\"huynhvothinh@gmail.com\",\"phone\":\"982739283\"}', '');
INSERT INTO `objects` VALUES ('5', '1', 'boyle', 'USER', '{\"uid\":{\"count\":1,\"0\":\"boyle\"},\"0\":\"uid\",\"objectclass\":{\"count\":4,\"0\":\"inetOrgPerson\",\"1\":\"organizationalPerson\",\"2\":\"person\",\"3\":\"top\"},\"1\":\"objectclass\",\"cn\":{\"count\":1,\"0\":\"Robert Boyle\"},\"2\":\"cn\",\"sn\":{\"count\":1,\"0\":\"Boyle\"},\"3\":\"sn\",\"mail\":{\"count\":1', '{\"address\":\"Ha Noi\",\"email\":\"huynhvothinh@gmail.com\",\"phone\":\"982739283\"}', '');
INSERT INTO `objects` VALUES ('6', '1', 'einstein', 'USER', '{\"objectclass\":{\"count\":4,\"0\":\"inetOrgPerson\",\"1\":\"organizationalPerson\",\"2\":\"person\",\"3\":\"top\"},\"0\":\"objectclass\",\"cn\":{\"count\":1,\"0\":\"Albert Einstein\"},\"1\":\"cn\",\"sn\":{\"count\":1,\"0\":\"Einstein\"},\"2\":\"sn\",\"uid\":{\"count\":1,\"0\":\"einstein\"},\"3\":\"uid\",\"mail\":{', '', '');
INSERT INTO `objects` VALUES ('7', '1', 'euclid', 'USER', '{\"uid\":{\"count\":1,\"0\":\"euclid\"},\"0\":\"uid\",\"objectclass\":{\"count\":4,\"0\":\"inetOrgPerson\",\"1\":\"organizationalPerson\",\"2\":\"person\",\"3\":\"top\"},\"1\":\"objectclass\",\"cn\":{\"count\":1,\"0\":\"Euclid\"},\"2\":\"cn\",\"sn\":{\"count\":1,\"0\":\"Euclid\"},\"3\":\"sn\",\"mail\":{\"count\":1,\"0\"', '', '');
INSERT INTO `objects` VALUES ('8', '1', 'galieleo', 'USER', '{\"objectclass\":{\"count\":4,\"0\":\"inetOrgPerson\",\"1\":\"organizationalPerson\",\"2\":\"person\",\"3\":\"top\"},\"0\":\"objectclass\",\"cn\":{\"count\":1,\"0\":\"Galileo Galilei\"},\"1\":\"cn\",\"sn\":{\"count\":1,\"0\":\"Galilei\"},\"2\":\"sn\",\"uid\":{\"count\":1,\"0\":\"galieleo\"},\"3\":\"uid\",\"mail\":{\"', '', '');
INSERT INTO `objects` VALUES ('9', '1', 'euler', 'USER', '{\"userpassword\":{\"count\":1,\"0\":\"{sha}W6ph5Mm5Pz8GgiULbPgzG37mj9g=\"},\"0\":\"userpassword\",\"objectclass\":{\"count\":4,\"0\":\"inetOrgPerson\",\"1\":\"organizationalPerson\",\"2\":\"person\",\"3\":\"top\"},\"1\":\"objectclass\",\"uid\":{\"count\":1,\"0\":\"euler\"},\"2\":\"uid\",\"sn\":{\"count\":', '{\"address\":\"Ha Noi\",\"email\":\"huynhvothinh@gmail.com\",\"fullname\":\"Hung Hoang\",\"phone\":\"982739283\"}', '');

-- ----------------------------
-- Procedure structure for `basedn_add`
-- ----------------------------
DROP PROCEDURE IF EXISTS `basedn_add`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `basedn_add`(IN p_base_dn VARCHAR(255))
BEGIN
		IF (p_base_dn IS NOT NULL and p_base_dn != '') THEN

				SET @id = 0;
			
				SELECT BASEDN_ID
				INTO @id
				FROM basedn
				WHERE BASEDN_CODE = p_base_dn;

				IF(@id = 0) THEN 
					
						INSERT INTO basedn (
							BASEDN_CODE
						)
						VALUES (
							p_base_dn
						);
					
				END IF;

		END IF;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `basedn_edit`
-- ----------------------------
DROP PROCEDURE IF EXISTS `basedn_edit`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `basedn_edit`(IN p_base_dn VARCHAR(255),
	IN p_host VARCHAR(255),
	IN p_account_prefix VARCHAR(255),
	IN p_account_suffix VARCHAR(255),
	IN p_account_suffix_arr VARCHAR(1000),
	IN p_active bit(1),
	IN p_ssl BIT(1),
	IN p_port INT(11),
	IN p_user_filter VARCHAR(255),
	IN p_group_filter VARCHAR(255),
	IN p_organization_filter VARCHAR(255), IN p_permissions varchar(1000))
BEGIN  

	UPDATE basedn
	SET 
		`HOST` = p_host,
		ACCOUNT_PREFIX = p_account_prefix,
		ACCOUNT_SUFFIX = p_account_suffix,
		ACCOUNT_SUFFIX_ARR = p_account_suffix_arr,
		ACTIVE = p_active,
		`SSL` = p_ssl,
		`PORT` = p_port,
		USER_FILTER = p_user_filter,
		GROUP_FILTER = p_group_filter,
		ORGANIZATION_FILTER = p_organization_filter,
		PERMISSIONS = p_permissions
	WHERE BASEDN_CODE = p_base_dn;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `basedn_get`
-- ----------------------------
DROP PROCEDURE IF EXISTS `basedn_get`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `basedn_get`(IN p_base_dn VARCHAR(255))
BEGIN  
			
		SELECT * 
		FROM basedn
		WHERE BASEDN_CODE = p_base_dn; 

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `basedn_list`
-- ----------------------------
DROP PROCEDURE IF EXISTS `basedn_list`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `basedn_list`(in p_active bit(1))
BEGIN
	SELECT *
	FROM basedn
	WHERE ACTIVE=p_active ;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `fields_add`
-- ----------------------------
DROP PROCEDURE IF EXISTS `fields_add`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `fields_add`(in p_basedn varchar(255), in p_type varchar(255), 
	in p_field_code VARCHAR(255), in p_field_name varchar(255), in p_active bit)
BEGIN
	set @id = 0;
	set @basedn_id = 0;
	
	SELECT FIELD_ID
	INTO @id 
	FROM fields a
	INNER JOIN basedn b
	on a.BASEDN_ID = b.BASEDN_ID
	WHERE b.BASEDN_CODE = p_basedn
		AND a.TYPE = p_type
		AND a.FIELD_CODE = p_field_code
	LIMIT 1;

	SELECT BASEDN_ID
	INTO @basedn_id
	FROM basedn
	WHERE BASEDN_CODE = p_basedn
	LIMIT 1;

	IF (@id = 0 AND @basedn_id > 0) THEN

		INSERT into fields (
			`fields`.BASEDN_ID,
			`fields`.TYPE,
			`fields`.FIELD_CODE,
			`fields`.FIELD_NAME,
			`fields`.ACTIVE)
		VALUES(
			@basedn_id,
			p_type,
			p_field_code,
			p_field_name,
			p_active);	

		select 1 as STATUS;

	ELSE

		SELECT 0 AS STATUS;

	END if;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `fields_delete`
-- ----------------------------
DROP PROCEDURE IF EXISTS `fields_delete`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `fields_delete`(in p_field_id int)
BEGIN
	DELETE FROM fields  
	WHERE FIELD_ID = p_field_id;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `fields_edit`
-- ----------------------------
DROP PROCEDURE IF EXISTS `fields_edit`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `fields_edit`(in p_field_id int, in p_field_name varchar(255), IN p_active bit)
BEGIN
	UPDATE fields 
	set 
		FIELD_NAME = p_field_name,
		ACTIVE = p_active
	WHERE FIELD_ID = p_field_id;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `fields_get`
-- ----------------------------
DROP PROCEDURE IF EXISTS `fields_get`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `fields_get`(in p_basedn varchar(255), in p_type varchar(255), in p_field_code VARCHAR(255))
BEGIN
	SELECT a.*
	FROM `fields` a
	INNER JOIN basedn b
	on a.BASEDN_ID = b.BASEDN_ID
	WHERE b.BASEDN_CODE = p_basedn
		AND a.TYPE = p_type
		AND a.FIELD_CODE = p_field_code
	LIMIT 1;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `fields_list`
-- ----------------------------
DROP PROCEDURE IF EXISTS `fields_list`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `fields_list`(in p_basedn varchar(255), in p_type varchar(255), in p_active int)
BEGIN
	SELECT a.*
	FROM `fields` a
	INNER JOIN basedn b
	on a.BASEDN_ID = b.BASEDN_ID
	WHERE b.BASEDN_CODE = p_basedn
		AND a.TYPE = p_type
		AND (p_active=-1 or a.ACTIVE = p_active)
	ORDER BY a.ACTIVE DESC, a.FIELD_CODE;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `objects_add`
-- ----------------------------
DROP PROCEDURE IF EXISTS `objects_add`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `objects_add`(IN p_base_dn VARCHAR(255),
		IN p_object_code VARCHAR(255),
		IN p_object_type VARCHAR(255),
		IN p_ad_data TINYTEXT,
		IN p_custom_data TINYTEXT)
BEGIN
		SET @basedn_id = 0;

		SELECT BASEDN_ID
		INTO @basedn_id
		FROM basedn
		WHERE BASEDN_CODE = p_base_dn;

		IF(@basedn_id > 0) THEN 

			SET @object_id = 0;

			SELECT OBJECT_ID
			INTO @object_id
			FROM objects
			WHERE OBJECT_CODE = p_object_code
					AND OBJECT_TYPE = p_object_type
					AND BASEDN_ID = @basedn_id;

			IF(@object_id = 0) THEN 

					INSERT INTO objects(
							BASEDN_ID,
							OBJECT_CODE,
							OBJECT_TYPE,
							AD_DATA,
							CUSTOM_DATA,
							ACTIVE)
					VALUES(
							@basedn_id,
							p_object_code,
							p_object_type,
							p_ad_data,
							p_custom_data,
							1
					);

					select 1 as STATUS;
		
			ELSE

					select 0 as STATUS;

			END IF;

		ELSE

				select 0 as STATUS;

		END IF;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `objects_edit`
-- ----------------------------
DROP PROCEDURE IF EXISTS `objects_edit`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `objects_edit`(IN p_object_id INT,
	IN p_ad_data TINYTEXT,	IN p_custom_data TINYTEXT, in p_active bit)
BEGIN  
		UPDATE objects
		SET
			AD_DATA = p_ad_data,
			CUSTOM_DATA = p_custom_data,
			ACTIVE = p_active
		WHERE OBJECT_ID = p_object_id;  
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `objects_get`
-- ----------------------------
DROP PROCEDURE IF EXISTS `objects_get`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `objects_get`(IN p_base_dn VARCHAR(255),
		IN p_object_code VARCHAR(255),
		IN p_object_type VARCHAR(255))
BEGIN 

		SELECT a.*
		FROM objects A
		INNER JOIN basedn b
				ON a.BASEDN_ID = b.BASEDN_ID
		WHERE OBJECT_CODE = p_object_code
				AND OBJECT_TYPE = p_object_type
				AND BASEDN_CODE = p_base_dn
		LIMIT 1;

END
;;
DELIMITER ;
