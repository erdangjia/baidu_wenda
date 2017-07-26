-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--d-- Generation Time: 2016-04-13 05:43:00
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `demo`
--

-- --------------------------------------------------------

--
-- 表的结构 `sucai_comment`
--

CREATE TABLE IF NOT EXISTS `sucai_comment` (
  `mtype` tinyint(1) NOT NULL,
  `content` text NOT NULL,
  `addtime` int(10) NOT NULL,
  PRIMARY KEY (`d`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5560 ;

--
-- 转存表中的数据 `sucai_comment`
--

INSERT INTO `sucai_comment` (`id`, `uid`, `touid`, `pid_sub`, `tid`, `pid`, `mtype`, `content`, `addtime`) VALUES
(1, 5, 0, 0, 1, 0, 1, '赞！！！！太喜欢这个网站！', 1427128877),
(2, 5, 0, 0, 1, 0, 1, '模板小清新风格，谢谢分享，非常安逸！', 1427129392),
(3, 2, 0, 0, 1, 0, 1, '连着几天在这网站看文章学习，这网站真是太赞啦！\n有演示，有源码，还有详细的解析！\n关键是，每个例子都如此使用，可以即学即用！\n感谢站长！', 1427261231),
(4, 13, 0, 0, 1, 0, 1, '效果很帅！！！', 1427499759),
(5, 16, 0, 0, 1, 0, 1, '很好看<img alt=''坏笑'' src=''http://www.erdangjiade.com/Public/emot/10.gif''>', 1427676992),
(6, 5, 0, 0, 1, 0, 1, '你的后台好像也有这种效果，bootstrap很强大<img alt=''呵呵'' src=''http://www.erdangjiade.com/Public/emot/11.gif''>', 1428543245),
(7, 5, 0, 0, 1, 0, 1, '网站模板少了呢，请官网多更新些……', 1428543356),
(8, 2, 0, 0, 1, 0, 1, '感谢分享！~<img alt=''微笑'' src=''http://www.erdangjiade.com/Public/emot/18.gif''>', 1428594835),
(9, 30, 0, 0, 1, 0, 1, '感谢，实在是强大，立马学习', 1428632423),
(10, 39, 0, 0, 1, 0, 1, '很好看的模版', 1428819903),
(5559, 1, 2, 0, 1, 0, 0, '呜呜呜<img alt=\\''大囧\\'' src=\\''/comment/Public/emot/25.gif\\''>亲亲亲亲亲', 1460518809),
(5558, 1, 2, 0, 1, 0, 0, '亲亲亲亲亲亲', 1460518754),
(5557, 1, 2, 0, 1, 0, 0, '事实上是事实', 1460518732),
(5556, 1, 2, 0, 1, 0, 0, '请问蔷薇蔷薇蔷薇蔷薇蔷薇蔷薇蔷薇蔷薇蔷薇', 1460518724),
(5555, 1, 2, 0, 1, 0, 0, '完完全全我', 1460518170),
(5553, 1, 2, 0, 1, 0, 0, 'uuuuuuuuuu', 1460517317),
(5554, 1, 2, 0, 1, 0, 0, '<img alt=\\''色\\'' src=\\''/comment/Public/emot/14.gif\\''><img alt=\\''希望\\'' src=\\''/comment/Public/emot/16.gif\\''>ssssssssssss', 1460517504),
(5552, 1, 2, 0, 1, 0, 0, 'qqqqqqqqqq', 1460517309),
(5551, 1, 2, 0, 1, 0, 0, 'yuyuyuyuyuyuyuyu', 1460517281),
(5550, 1, 2, 0, 1, 0, 0, 'qqqqqqqqqqqqqqqqqq', 1460516909),
(5549, 1, 2, 0, 1, 0, 0, 'yuyuyuyuyuyu', 1460516835);

-- --------------------------------------------------------

--
-- 表的结构 `sucai_emot`
--

CREATE TABLE IF NOT EXISTS `sucai_emot` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=85 ;

--
-- 转存表中的数据 `sucai_emot`
--

INSERT INTO `sucai_emot` (`id`, `name`) VALUES
(1, '糗大了'),
(2, '示爱'),
(3, '晕'),
(4, '酷'),
(5, '流泪'),
(6, '饿了'),
(7, '闭嘴'),
(8, '做鬼脸'),
(9, '馋'),
(10, '坏笑'),
(11, '抓狂'),
(12, '呵呵'),
(13, '淡定'),
(14, '冷汗'),
(15, '色'),
(16, '惊讶'),
(17, '希望'),
(18, '伤心'),
(19, '微笑'),
(20, '惊吓'),
(21, '哈哈'),
(22, '吃饭'),
(23, '观察'),
(24, '高兴'),
(25, '皱眉'),
(26, '大囧'),
(27, '邪恶'),
(28, '锁眉'),
(29, '惊喜'),
(30, '小怒'),
(31, '无语'),
(32, '傻笑'),
(33, '黑线'),
(34, '喜极而泣'),
(35, '口水'),
(36, '不说话'),
(37, '抽烟'),
(38, '汗'),
(39, '尴尬'),
(40, '小眼睛'),
(41, '龇牙'),
(42, '亲亲'),
(43, '哭泣'),
(44, '大吃一惊'),
(45, '狂汗'),
(46, '不高兴'),
(47, '得意'),
(48, '阴脸'),
(49, '装大款'),
(50, '吐舌'),
(51, '暗地观察'),
(52, '吐血'),
(53, '脸红'),
(54, '肿包'),
(55, '抠鼻'),
(56, '赞一个'),
(57, '中指'),
(58, '期待'),
(59, '倒地'),
(60, '火冒三丈'),
(61, '吐'),
(62, '喷水'),
(63, '喷血'),
(64, '蜡烛'),
(65, '想一想'),
(66, '认真听讲'),
(67, '不好意思'),
(68, '欢呼'),
(69, '便便'),
(70, '鼓掌'),
(71, '深思'),
(72, '害羞'),
(73, '苦恼'),
(74, '长草'),
(75, '无所谓'),
(76, '咽气'),
(77, '投降'),
(78, '没看见'),
(79, '击掌'),
(80, '献黄瓜'),
(81, '献花'),
(82, '撞墙'),
(83, '中刀'),
(84, '中枪');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
