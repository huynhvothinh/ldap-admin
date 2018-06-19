/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : ldap

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-06-19 11:30:02
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
  PRIMARY KEY (`BASEDN_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of basedn
-- ----------------------------
INSERT INTO `basedn` VALUES ('1', 'dc=example,dc=com', 'ldap.forumsys.com', 'UID=', '', '[\"OU=chemists\"]', '', '\0', '389', '(objectclass=person)', '(objectclass=groupOfUniqueNames)', '(ou=*)');
INSERT INTO `basedn` VALUES ('3', 'DC=TINHVAN,DC=VN', 'AD-TINHVANVN', 'CN=', null, null, '', '', '636', '(objectclass=person)', '(objectclass=group)', '(|(cn=*)(ou=*))');
INSERT INTO `basedn` VALUES ('7', 'dc=example,dc=com2', 'ldap.forumsys.com', 'UID=', '', '[]', '', '\0', '389', '', '', '');
INSERT INTO `basedn` VALUES ('8', 'dc=example,dc=com3', 'ldap.forumsys.com', 'UID=', '', '[]', '', '\0', '389', '', '', '');

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
  `LDAP_DATA` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`OBJECT_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of objects
-- ----------------------------
INSERT INTO `objects` VALUES ('2', '1', '', 'USER', '', '[]');
INSERT INTO `objects` VALUES ('3', '1', 'HUNGHV', 'USER', '', '');

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
	IN p_organization_filter VARCHAR(255))
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
		ORGANIZATION_FILTER = p_organization_filter
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
-- Procedure structure for `object_add`
-- ----------------------------
DROP PROCEDURE IF EXISTS `object_add`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `object_add`(IN p_base_dn VARCHAR(255),
		IN p_object_code VARCHAR(255),
		IN p_object_type VARCHAR(255),
		IN p_ad_data TINYTEXT,
		IN p_ldap_data TINYTEXT)
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
							LDAP_DATA)
					VALUES(
							@basedn_id,
							p_object_code,
							p_object_type,
							p_ad_data,
							p_ldap_data
					);

			END IF;

		END IF;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `object_edit`
-- ----------------------------
DROP PROCEDURE IF EXISTS `object_edit`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `object_edit`( 
		IN p_object_id INT,
		IN p_ldap_data TINYTEXT)
BEGIN  
		UPDATE objects
		SET
			LDAP_DATA = p_ldap_data
		WHERE OBJECT_ID = p_object_id;  
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `object_get`
-- ----------------------------
DROP PROCEDURE IF EXISTS `object_get`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `object_get`(IN p_base_dn VARCHAR(255),
		IN p_object_code VARCHAR(255),
		IN p_object_type VARCHAR(255))
BEGIN 

		SELECT OBJECT_ID, BASEDN_CODE, OBJECT_CODE, OBJECT_TYPE, AD_DATA, LDAP_DATA
		FROM objects
		INNER JOIN basedn
				ON objects.BASEDN_ID = basedn.BASEDN_ID
		WHERE OBJECT_CODE = p_object_code
				AND OBJECT_TYPE = p_object_type
				AND BASEDN_CODE = p_base_dn
		LIMIT 1;

END
;;
DELIMITER ;