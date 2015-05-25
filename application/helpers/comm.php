<?php
defined('SYSPATH') or die('No direct access allowed.');
/**
 * Common helper class.
 *
 */
class comm_Core
{
	private static $number = array(1=>'FYX',2=>'FYD',3=>'FYY');
	private static $base = 5888;
	
	/**
	 * 判断用户有效性
	 */
	public static function validUser()
	{
		session_start();
		if(!isset($_SESSION['uid']))
		{
			echo "<script type=\"text/javascript\">
					alert(\"登录超时\");
					parent.location.href= '" . url::site() . 'solid/admin' . "';
				</script>";
			return false;
			exit();
		}
		else
		{
			if($_SESSION['gid'] < 1)
			{
				echo '未分配用户';
				exit();
			}
			else if($_SESSION['gid'] > 1)
			{
				$uri = new uri();
				$url = $uri->segment(2) . '/' . $uri->segment(3);
				$valid = $notVerify = array('member/','member/index','member/left','member/main','member/top','login/logout'); //不需要校验的模块
				if(!in_array($url,$notVerify)) //如果属于校验的模块
				{
					$powers = self::getPowers();
					$mod = new Mod_Model();
					$id = $mod->getUrlId($url);
					if(in_array($id,$powers))
					{
						return true;
					}
					else
					{
						if(isset($_GET['text']))
						{
							echo '<span style="font-size:14px">对不起，你没有此模块的操作权限</span>';
						}
						else
						{
							echo json_encode(array('success'=>0,'msg'=>"对不起，你没有此模块的操作权限!"));
						}
						exit;
					}
				}
			}
			else //管理员则通过 
			{
				return true;
			}
			return true;
		}
	}
	
	public function getNumber($key,$id)
	{
		$key		= intval($key);
		$number		= self::$number[$key];
		$id			= intval($id);
		return $number.(self::$base+$id);
	}
	
	public static function returnNumber($key)
	{
		$number		= intval(substr($key,2));
		return $number-(self::$base);
	}
	
	/**
	 * 取得用户权限id
	 */
	public static function getPowers()
	{
		$powers = array();
		if($_SESSION['powers'])
		{
			$hide		= Kohana::config('config.hideModel');
			$hideModel	= @$hide[$_SESSION['gid']];
			$powers = explode(',',$_SESSION['powers']);
			if (count($hideModel)>0)
			{
				$result = array_diff($powers, $hideModel);//扣除需要隐藏的id		
			}
			else
			{
				$result	= $powers;
			}
		}
		return array_unique($result);
	}
	
	/**
	 * 复选框选定
	 * @param string $default
	 * @param string $value1
	 * @param string $value2
	 */
	public static function setChecked($default = '',$value1 = '',$value2 = '')
	{
		if($value2 === false) //如果不存在 
		{
			if($default)
				echo 'checked="checked"';
		}
		else
		{
			if($value1 == $value2)
				echo 'checked="checked"';
		}
	}
	
	/**
	 * 文字加星号
	 * @param string $char
	 */
	public static function charForStar($char)
	{
		if ($char)
		{
			return '<span class="req">*</span>'.$char;
		}
	}

	public static function getPinyin($value,$first = 1)
	{
		$value = iconv("utf-8","gbk",$value);
		$convert = array('a'=>'-20319','ai'=>'-20317','an'=>'-20304','ang'=>'-20295','ao'=>'-20292','ba'=>'-20283','bai'=>'-20265','ban'=>'-20257','bang'=>'-20242','bao'=>'-20230','bei'=>'-20051','ben'=>'-20036','beng'=>'-20032','bi'=>'-20026','bian'=>'-20002','biao'=>'-19990','bie'=>'-19986','bin'=>'-19982','bing'=>'-19976','bo'=>'-19805','bu'=>'-19784','ca'=>'-19775','cai'=>'-19774','can'=>'-19763','cang'=>'-19756','cao'=>'-19751','ce'=>'-19746','ceng'=>'-19741','cha'=>'-19739','chai'=>'-19728','chan'=>'-19725','chang'=>'-19715','chao'=>'-19540','che'=>'-19531','chen'=>'-19525','cheng'=>'-19515','chi'=>'-19500','chong'=>'-19484','chou'=>'-19479','chu'=>'-19467','chuai'=>'-19289','chuan'=>'-19288','chuang'=>'-19281','chui'=>'-19275','chun'=>'-19270','chuo'=>'-19263','ci'=>'-19261','cong'=>'-19249','cou'=>'-19243','cu'=>'-19242','cuan'=>'-19238','cui'=>'-19235','cun'=>'-19227','cuo'=>'-19224','da'=>'-19218','dai'=>'-19212','dan'=>'-19038','dang'=>'-19023','dao'=>'-19018','de'=>'-19006','deng'=>'-19003','di'=>'-18996','dian'=>'-18977','diao'=>'-18961','die'=>'-18952','ding'=>'-18783','diu'=>'-18774','dong'=>'-18773','dou'=>'-18763','du'=>'-18756','duan'=>'-18741','dui'=>'-18735','dun'=>'-18731','duo'=>'-18722','e'=>'-18710','en'=>'-18697','er'=>'-18696','fa'=>'-18526','fan'=>'-18518','fang'=>'-18501','fei'=>'-18490','fen'=>'-18478','feng'=>'-18463','fo'=>'-18448','fou'=>'-18447','fu'=>'-18446','ga'=>'-18239','gai'=>'-18237','gan'=>'-18231','gang'=>'-18220','gao'=>'-18211','ge'=>'-18201','gei'=>'-18184','gen'=>'-18183','geng'=>'-18181','gong'=>'-18012','gou'=>'-17997','gu'=>'-17988','gua'=>'-17970','guai'=>'-17964','guan'=>'-17961','guang'=>'-17950','gui'=>'-17947','gun'=>'-17931','guo'=>'-17928','ha'=>'-17922','hai'=>'-17759','han'=>'-17752','hang'=>'-17733','hao'=>'-17730','he'=>'-17721','hei'=>'-17703','hen'=>'-17701','heng'=>'-17697','hong'=>'-17692','hou'=>'-17683','hu'=>'-17676','hua'=>'-17496','huai'=>'-17487','huan'=>'-17482','huang'=>'-17468','hui'=>'-17454','hun'=>'-17433','huo'=>'-17427','ji'=>'-17417','jia'=>'-17202','jian'=>'-17185','jiang'=>'-16983','jiao'=>'-16970','jie'=>'-16942','jin'=>'-16915','jing'=>'-16733','jiong'=>'-16708','jiu'=>'-16706','ju'=>'-16689','juan'=>'-16664','jue'=>'-16657','jun'=>'-16647','ka'=>'-16474','kai'=>'-16470','kan'=>'-16465','kang'=>'-16459','kao'=>'-16452','ke'=>'-16448','ken'=>'-16433','keng'=>'-16429','kong'=>'-16427','kou'=>'-16423','ku'=>'-16419','kua'=>'-16412','kuai'=>'-16407','kuan'=>'-16403','kuang'=>'-16401','kui'=>'-16393','kun'=>'-16220','kuo'=>'-16216','la'=>'-16212','lai'=>'-16205','lan'=>'-16202','lang'=>'-16187','lao'=>'-16180','le'=>'-16171','lei'=>'-16169','leng'=>'-16158','li'=>'-16155','lia'=>'-15959','lian'=>'-15958','liang'=>'-15944','liao'=>'-15933','lie'=>'-15920','lin'=>'-15915','ling'=>'-15903','liu'=>'-15889','long'=>'-15878','lou'=>'-15707','lu'=>'-15701','lv'=>'-15681','luan'=>'-15667','lue'=>'-15661','lun'=>'-15659','luo'=>'-15652','ma'=>'-15640','mai'=>'-15631','man'=>'-15625','mang'=>'-15454','mao'=>'-15448','me'=>'-15436','mei'=>'-15435','men'=>'-15419','meng'=>'-15416','mi'=>'-15408','mian'=>'-15394','miao'=>'-15385','mie'=>'-15377','min'=>'-15375','ming'=>'-15369','miu'=>'-15363','mo'=>'-15362','mou'=>'-15183','mu'=>'-15180','na'=>'-15165','nai'=>'-15158','nan'=>'-15153','nang'=>'-15150','nao'=>'-15149','ne'=>'-15144','nei'=>'-15143','nen'=>'-15141','neng'=>'-15140','ni'=>'-15139','nian'=>'-15128','niang'=>'-15121','niao'=>'-15119','nie'=>'-15117','nin'=>'-15110','ning'=>'-15109','niu'=>'-14941','nong'=>'-14937','nu'=>'-14933','nv'=>'-14930','nuan'=>'-14929','nue'=>'-14928','nuo'=>'-14926','o'=>'-14922','ou'=>'-14921','pa'=>'-14914','pai'=>'-14908','pan'=>'-14902','pang'=>'-14894','pao'=>'-14889','pei'=>'-14882','pen'=>'-14873','peng'=>'-14871','pi'=>'-14857','pian'=>'-14678','piao'=>'-14674','pie'=>'-14670','pin'=>'-14668','ping'=>'-14663','po'=>'-14654','pu'=>'-14645','qi'=>'-14630','qia'=>'-14594','qian'=>'-14429','qiang'=>'-14407','qiao'=>'-14399','qie'=>'-14384','qin'=>'-14379','qing'=>'-14368','qiong'=>'-14355','qiu'=>'-14353','qu'=>'-14345','quan'=>'-14170','que'=>'-14159','qun'=>'-14151','ran'=>'-14149','rang'=>'-14145','rao'=>'-14140','re'=>'-14137','ren'=>'-14135','reng'=>'-14125','ri'=>'-14123','rong'=>'-14122','rou'=>'-14112','ru'=>'-14109','ruan'=>'-14099','rui'=>'-14097','run'=>'-14094','ruo'=>'-14092','sa'=>'-14090','sai'=>'-14087','san'=>'-14083','sang'=>'-13917','sao'=>'-13914','se'=>'-13910','sen'=>'-13907','seng'=>'-13906','sha'=>'-13905','shai'=>'-13896','shan'=>'-13894','shang'=>'-13878','shao'=>'-13870','she'=>'-13859','shen'=>'-13847','sheng'=>'-13831','shi'=>'-13658','shou'=>'-13611','shu'=>'-13601','shua'=>'-13406','shuai'=>'-13404','shuan'=>'-13400','shuang'=>'-13398','shui'=>'-13395','shun'=>'-13391','shuo'=>'-13387','si'=>'-13383','song'=>'-13367','sou'=>'-13359','su'=>'-13356','suan'=>'-13343','sui'=>'-13340','sun'=>'-13329','suo'=>'-13326','ta'=>'-13318','tai'=>'-13147','tan'=>'-13138','tang'=>'-13120','tao'=>'-13107','te'=>'-13096','teng'=>'-13095','ti'=>'-13091','tian'=>'-13076','tiao'=>'-13068','tie'=>'-13063','ting'=>'-13060','tong'=>'-12888','tou'=>'-12875','tu'=>'-12871','tuan'=>'-12860','tui'=>'-12858','tun'=>'-12852','tuo'=>'-12849','wa'=>'-12838','wai'=>'-12831','wan'=>'-12829','wang'=>'-12812','wei'=>'-12802','wen'=>'-12607','weng'=>'-12597','wo'=>'-12594','wu'=>'-12585','xi'=>'-12556','xia'=>'-12359','xian'=>'-12346','xiang'=>'-12320','xiao'=>'-12300','xie'=>'-12120','xin'=>'-12099','xing'=>'-12089','xiong'=>'-12074','xiu'=>'-12067','xu'=>'-12058','xuan'=>'-12039','xue'=>'-11867','xun'=>'-11861','ya'=>'-11847','yan'=>'-11831','yang'=>'-11798','yao'=>'-11781','ye'=>'-11604','yi'=>'-11589','yin'=>'-11536','ying'=>'-11358','yo'=>'-11340','yong'=>'-11339','you'=>'-11324','yu'=>'-11303','yuan'=>'-11097','yue'=>'-11077','yun'=>'-11067','za'=>'-11055','zai'=>'-11052','zan'=>'-11045','zang'=>'-11041','zao'=>'-11038','ze'=>'-11024','zei'=>'-11020','zen'=>'-11019','zeng'=>'-11018','zha'=>'-11014','zhai'=>'-10838','zhan'=>'-10832','zhang'=>'-10815','zhao'=>'-10800','zhe'=>'-10790','zhen'=>'-10780','zheng'=>'-10764','zhi'=>'-10587','zhong'=>'-10544','zhou'=>'-10533','zhu'=>'-10519','zhua'=>'-10331','zhuai'=>'-10329','zhuan'=>'-10328','zhuang'=>'-10322','zhui'=>'-10315','zhun'=>'-10309','zhuo'=>'-10307','zi'=>'-10296','zong'=>'-10281','zou'=>'-10274','zu'=>'-10270','zuan'=>'-10262','zui'=>'-10260','zun'=>'-10256','zuo'=>'-10254');
		$ret = '';
		for($i = 0; $i < strlen($value); $i++)
		{
			$sp = substr($value,$i,2);
			$p = ord(substr($value,$i,1));
			if($p > 160)
			{
				$q = ord(substr($value,++$i,1));
				$p = $p * 256 + $q - 65536;
			}
			if($p > 0 && $p < 160)
				$m = chr($p);
			elseif($p < -20319 || $p > -10247)
			{
				$m = '';
			}
			else
			{
				krsort($convert);
				foreach($convert as $k=>$v)
				{
					if($v <= $p)
					{
						$m = $k;
						break;
					}
				}
			}
			if($first)
				$m = substr($m,0,1);
			$ret .= $m;
		}
		return $ret;
	}

	/**
	 * 文件加锁
	 *
	 * @param  $fp
	 * @param string $lock_level
	 */
	public static function lock($fp,$lock_level = LOCK_EX)
	{
		@flock($fp,$lock_level) or die('Cannot flock filepointer to ' . $lock_level);
	}

	/**
	 * 文件解锁
	 *
	 * @param $fp
	 */
	public static function unlock($fp)
	{
		@flock($fp,LOCK_UN) or die('Cannot Release the Lock');
	}

	/**
	 * 创建多级目录
	 *
	 * @param string $pre
	 * @param string $path
	 * @param string $mode
	 */
	public static function createDirs($path,$mode = 0644)
	{
		$paths = explode('/',$path);
		$pre = '';
		foreach($paths as $p)
		{
			if(!is_dir($pre . $p))
			{
				mkdir($pre . $p,$mode);
			}
			$pre .= $p . '/';
		}
		return $pre;
	}

	/**
	 * 截取utf-8中文字符
	 */
	public function msubstr($str,$start,$length = NULL)
	{
		preg_match_all("/./u",$str,$ar);
		if(func_num_args() >= 3)
		{
			$end = func_get_arg(2);
			return join("",array_slice($ar[0],$start,$end));
		}
		else
		{
			return join("",array_slice($ar[0],$start));
		}
	}

	/**
	 * 
	 * 取得扩展名
	 * @param $name
	 */
	public static function getExt($name)
	{
		$path_parts = pathinfo($name);
		$ext = strtolower($path_parts['extension']);
		return $ext;
	}

	/**
	 * 
	 * 写入文件的操作
	 * @param str $file
	 * @param str $str
	 * @param str $opera
	 */
	public static function operaFile($file,$str = '',$opera = 'w')
	{
		$fp = fopen($file,$opera);
		self::lock($fp);
		fwrite($fp,$str);
		self::unlock($fp);
	}

	/**
	 * 金额数字与汉字转换
	 * 
	 */
	public static function cny($ns)
	{
		static $cnums = array("零","壹","贰","叁","肆","伍","陆","柒","捌","玖"),$cnyunits = array("圆","角","分"),$grees = array("拾","佰","仟","万","拾","佰","仟","亿");
		$ns1 = array();
		$ns2 = array();
		if(strstr($ns,'.')){
			list($ns1,$ns2) = explode(".",$ns,2);
		}else {
			$ns1 = $ns;
		}		
		if($ns2)
		{
			if($ns2[1])
			{
				$ns2 = array($ns2[1],$ns2[0]);
			}
			else
			{
				$ns2 = array($ns2[0]);
			}
		}
		$ret = array_merge($ns2,array(implode("",self::_cny_map_unit(str_split($ns1),$grees)),""));
		$ret = implode("",array_reverse(self::_cny_map_unit($ret,$cnyunits)));
		return str_replace(array_keys($cnums),$cnums,$ret);
	}
	
	/**
	 * 大写金额转换
	 * @param unknown_type $list
	 * @param unknown_type $units
	 */
	public static function _cny_map_unit($list,$units)
	{
		$ul = count($units);
		$xs = array();
		foreach(array_reverse($list) as $x)
		{
			$l = count($xs);
			if($x != "0" || !($l % 4))
				$n = ($x == '0' ? '' : $x) . (@$units[($l - 1) % $ul]);
			else
				$n = @is_numeric($xs[0][0]) ? $x : '';
			array_unshift($xs,$n);
		}
		return $xs;
	}
}