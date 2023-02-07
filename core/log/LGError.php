<?php

namespace LGCore\log;

class  LGError{
	/**
	 * 错误标识
	 * 
	 * @var array
	 */
	public static $RROR_MESSAGES = array(
	    //API级别10001~19999
	    '10001'=>'服务器正在维护，请稍候重试',
	    '10007'=>'key与val不一致',
		'10008'=>'参数值不能为空',
	    '10009'=>'缺少参数',
	    '10010'=>'参数值超出范围',
	    '10011'=>'参数值类型不符',
	    '10020'=>'记录不存在',
	    '10021'=>'记录已存在',
        '10022'=>'Redis服务不可用',
	    '10030'=>'超出限制',
	    '10032'=>'不支持的操作',
	    '10034'=>'内部错误',
	    '10035'=>'未知的Controller',
	    '10036'=>'未知的API',
	    '10039'=>'此版本的客户端已经停止使用。请更新至新版本',
	    '10040'=>'模块错误',
	    '10041'=>'文件类型不符合',
	    '10042'=>'有文件不能删除',
	    '10043'=>'签到失败',
	    '10044'=>'上传文件失败',
	    '10045'=>'密码不一致',
	    '10046'=>'更新失败',
	    '10047'=>'添加失败',
	    '10048'=>'身份证上传失败',
	    '10049'=>'身份证查询请求失败',
	    '10050'=>'身份证验证失败',
	    '10051'=>'身份证号已绑定',
	    '10052'=>'华夏绑定失败',
		'10053'=>'获取列表失败',
		'10054'=>'删除失败',
		'10055'=>'已参与',
		'10056'=>'无法获取奖励',
		'10057'=>'奖励信息不存在',
		'10058'=>'无法助字',
		'10059'=>'助字信息不存在',
		'10060'=>'用户标签存在',
		'10061'=>'手机号不正确',
		'10062'=>'邮箱地址不合法',
		'10063'=>'手机号已存在',
		'10064'=>'邮箱地址已存在',
		'10065'=>'登陆名已存在',

        //权限20001~29999
	    '20010'=>'需要登录',
	    '20021'=>'用户已失效',
	    '20022'=>'邮箱未验证，禁止登录',
	    '20023'=>'验证码没有超时',
	    '20026'=>'用户名或密码错误，请重新登录',
	    '26001'=>'不支持的认证方式',
	    '26003'=>'请传入有效的Access Token',
	    '27001'=>'用户被禁止发送短信',
        '27002'=>'IP白的名单错误',
        '27003'=>'IP黑名单用户',
        '27004'=>'访问超出限制',
	
	    //认证30001~39999
	    '30001'=>'用户名长度不符（1-30个字符）',
	    '30011'=>'密码长度至少为6个字符',
	    '30021'=>'邮箱格式不符合规范',
	    '30022'=>'手机格式不符合规范',

		//外部API接口
		'40001'=>'API接口请求超时',
		'40002'=>'API接口异常',
		'40003'=>'API接口错误',
		'40004'=>'API接口返回数据为空',
	    '41001'=>'API接口请求参数不能为空',
	    
	
	    //业务级别错误70000~89999
	    '70001'=>'商品库存不足',
	    '70002'=>'商品已下架',
	    '70003'=>'商品暂时不可用',
	    '70004'=>'代金劵不可用',
	    '70005'=>'代金券已失效',
	    '70006'=>'代金券不存在',
	    '70007'=>'减免期间不能使用代金券',
	    '70008'=>'促销活动已结束',
	    '70009'=>'促销活动已开始',
	    '70010'=>'收货地址不在配送范围',
	    '70011'=>'业务在该平台不可使用',
	    '70012'=>'用户红包不存在',
	    '70013'=>'红包不存在',
	    '70014'=>'红包已失效',
	    '70015'=>'红包已被使用',
	    '70016'=>'此信息已被推荐',
	
	    //HTTP错误 90000~99999
	    '90405'=>'405 Method not allowed',
	);
	
	public static  $JAVA_ERROR_MESSAGES = array(
		"000000"=>"成功"
		,"999999"=>"后台异常"
		,"100001"=>"用户名或密码错误"
		,"100002"=>"未知异常"
		,"100003"=>"用户不存在"
		,"100004"=>"用户手机号或密码为空"
		,"100005"=>"用户手机号或公司ID为空"
		,"100006"=>"失效的证书"
		,"100007"=>"非法的证书"
		,"100008"=>"token或公司ID为空"
		,"100009"=>"用户id或密码为空"
		,"100010"=>"企业不存在"
		,"100011"=>"部门不存在"
		,"100012"=>"邀请码不存在"
		,"100013"=>"用户已存在"
		,"100014"=>"用户信息为空"
		,"100015"=>"删除失败"
		,"100016"=>"查询条件为空"
		,"100017"=>"查询条件不明确"
		,"100018"=>"企业下不存在用户"
		,"100019"=>"企业id或要查询的类型不能为空"
		,"100020"=>"企业已存在"
		,"100021"=>"企业信息为空"
		,"100022"=>"companyId或type为空"
		,"100023"=>"companyName为空"
		,"100024"=>"厂商不存在"
		,"100025"=>"经销商不存在"
		,"100026"=>"厂商id或经销商id不能为空"
		,"100027"=>"厂商推送失败，有可能是分销系统出错"
		,"100028"=>"经销商推送失败，有可能是分销系统出错"
		,"100029"=>"用户手机号，密码或公司id为空"
		,"100030"=>"厂商不存在"
		,"100031"=>"厂商id或用户id不能为空"
		,"100032"=>"部门信息为空"
		,"100033"=>"部门id为空"
		,"100034"=>"添加部门领导关系失败"
		,"100035"=>"部门领导信息为空"
		,"100036"=>"对应的部门领导用户不存在"
		,"100037"=>"更新部门领导关系失败"
		,"100038"=>"部门领导id为空"
		,"100039"=>"部门领导删除失败"
		,"100040"=>"工作经历id为空"
		,"100041"=>"工作经历不存在"
		,"100042"=>"该企业下不存在此用户"
		,"100043"=>"工作经历为空"
		,"100044"=>"教育经历id为空"
		,"100045"=>"教育经历不存在"
		,"100046"=>"教育经历为空"
		,"100047"=>"该区域下不存在子区域"
		,"100048"=>"parentId为空"
		,"100049"=>"该行业下不存在子行业"
		,"100050"=>"该数据字典不存在"
		,"100051"=>"查询条件typeid为空"
		,"100052"=>"用户id为空"
		,"100053"=>"公共技能标签不存在"
		,"100054"=>"行业id为空"
		,"100055"=>"该行业不存在"
		,"100056"=>"查询范围下限只能为非负整数"
		,"100057"=>"查询范围上限只能为非负整数"
		,"100058"=>"查询范围下限不能大于查询范围上限"
		,"100059"=>"厂商经销商关系已存在"
		,"100060"=>"厂商管理员不存在"
		,"100061"=>"经销商管理员不存在"
		,"100062"=>"厂商管理员推送失败，有可能是分销系统出错"
		,"100063"=>"经销商管理员推送失败，有可能是分销系统出错"
		,"100064"=>"厂商经销商管理员都不存在"
		,"100065"=>"企业id不能为空"
		,"100066"=>"该部门下不存在员工"
		,"100067"=>"要查询的类型不能为空"
		,"100068"=>"用户id或手机号为空"
		,"100069"=>"查询范围下限不能为空"
		,"100070"=>"查询范围上限不能为空"
		,"100071"=>"开始时间不能为空！"
		,"100072"=>"开始时间格式不正确！"
		,"100073"=>"结束时间不能为空！"
		,"100074"=>"结束时间格式不正确！"
		,"100075"=>"用户级别不能为空！"
		,"100076"=>"用户所在企业的顶级部门不能为空！"
		,"100077"=>"电话不能为空！"
		,"100078"=>"国家ID必须是数字！"
		,"100079"=>"省份ID必须是数字！"
		,"100080"=>"城市ID必须是数字！"
		,"100081"=>"查询范围不能为空！"
		,"100082"=>"查询范围必须是数字！"
		,"100083"=>"非企业管理员"
		,"100084"=>"用户所属企业不能为空"
		,"100085"=>"国家ID不能为空"
		,"100086"=>"省份ID不能为空 "
		,"100087"=>"城市ID不能为空"
		,"100088"=>"不能超过200个字符"
		,"100089"=>"不能超过1000个字符"
		,"100090"=>"企业ID错误"
		,"100091"=>"环信注册失败"
		,"100092"=>"顶级部门不存在"
		,"100093"=>"环信修改昵称失败"
		,"100094"=>"appToken验证失败，版本不同"
		,"100095"=>"appToken验证失败，clientKey不存在"
		,"100096"=>"appToken验证失败，原因不明"
		,"100097"=>"token验证失败，clientId为空"
		,"100098"=>"实名认证失败，请重新验证或联系客服人员"
		,"100099"=>"token验证失败，time不能为空"
		,"100100"=>"token验证失败，appVersion不能为空"
		,"100101"=>"token验证失败，reqToken不能为空"
		,"100102"=>"token验证失败，token参数值错误"
		,"100103"=>"token验证失败，Authorization不能为空"
		,"100104"=>"token验证失败，token验证异常"
		,"100105"=>"微信用户不存在"
		,"100106"=>"微信id不能为空"
		,"100107"=>"微信id或者手机号不能为空"
		,"100108"=>"邀请码已用完"
		,"100109"=>"该手机号已绑定微信"
		,"100110"=>"父部门下该部门已存在，创建失败"
		,"100111"=>"该微信已被绑定"
		,"100112"=>"企业扩展对象不存在"
		,"100113"=>"扩展名称已存在，添加失败"
		,"100114"=>"扩展id为空"
		,"100115"=>"厂商经销商关系不存在"
		,"100116"=>"经销商id不能为空"
	    ,"100117"=>"邀请码为空"
	    ,"100118"=>"没有查询到行业数据"
		,"101001"=>"用户没有能操作的公告栏目"
		,"101002"=>"公告ID不能为空"
		,"101003"=>"公告主题不能为空"
		,"101004"=>"公告内容不能为空"
		,"101005"=>"公告栏目ID不能为空"
		,"101006"=>"是否置顶参数不能为空"
		,"101007"=>"是否置顶参数值错误"
		,"101008"=>"公告不存在"
		,"101009"=>"没有符合条件的查询结果"
		,"101010"=>"公告反馈类型不能为空！"
		,"101011"=>"公告反馈内容不能为空！"
		,"101012"=>"非公告创建人不能删除公告"
		,"101013"=>"公告附件标识不能为空！"
		,"101014"=>"公告静态页面路径不能为空"
		,"101015"=>"非公告创建人不能进行置顶操作"
		,"102001"=>"非管理员不能新增/编辑公告栏目！"
		,"102002"=>"公告栏目名称不能为空"
		,"102003"=>"公告栏目负责人不能为空"
		,"102004"=>"公告栏目ID不能为空"
		,"102005"=>"公告栏目不存在"
		,"102006"=>"非管理员不能删除公告栏目！"
		,"102007"=>"非管理员不能查询公告栏目！	"
		,"107001"=>"客户名称不能为空！"
		,"107002"=>"客户状态必须是数字！"
		,"107003"=>"客户性质必须是数字！"
		,"107004"=>"客户类型必须是数字！"
		,"107005"=>"客户来源必须是数字！"
		,"107006"=>"客户规模必须是数字！"
		,"107007"=>"客户级别必须是数字！"
		,"107008"=>"客户名称已存在！"
		,"107009"=>"客户地址个数必须是数字！"
		,"107010"=>"客户地址个数错误！"
		,"107011"=>"客户ID不能为空！"
		,"107012"=>"存在关联信息的客户不能删除"
		,"107013"=>"数据同步失败"
		,"107014"=>"非客户所属人不能删除"
		,"107015"=>"客户不存在！"
		,"108001"=>"客户联系人名称不能为空！"
		,"108002"=>"编辑时联系人创建时间不能为空！"
		,"108003"=>"联系人创建时间格式不正确！"
		,"108004"=>"保存联系人,同步meg失败!"
		,"108005"=>"客户联系人ID不能为空！"
		,"108006"=>"客户联系人不不属于该用户不能删除！"
		,"108007"=>"涉及关联数据删除客户联系人失败！"
		,"108008"=>"客户联系人不存在！"
		,"108009"=>"客户联系人名称重复	"
		,"109001"=>"常用客户类型所属人ID串不能为空！"
		,"109002"=>"类型不能为空！"
		,"109003"=>"类型必须是数字！"
		,"109004"=>"区域编号不能为空"
		,"109005"=>"区域编号重复"
		,"109006"=>"区域名称不能为空"
		,"109007"=>"区域名称重复"
		,"109008"=>"父级区域id不能为空"
		,"109009"=>"此企业下该父级区域不存在"
		,"109010"=>"请确认是否启用"
		,"109011"=>"区域id不能为空"
		,"109012"=>"该区域不存在"
		,"109013"=>"区域下有下级区域，不能删除"
		,"109014"=>"区域下有客户，不能删除"
		,"109015"=>"区域级别不能大于三级	"
		,"111000"=>"合同签约时间不能为空"
		,"111001"=>"合同签约时间格式不正确"
		,"111002"=>"合同主题不能为空"
		,"111003"=>"合同号不能为空"
		,"111004"=>"合同号已存在"
		,"111005"=>"合同签约开始时间不能为空"
		,"111006"=>"合同签约开始时间格式不正确"
		,"111007"=>"合同签约结束时间不能为空"
		,"111008"=>"合同签约结束时间格式不正确"
		,"111009"=>"合同附件个数不能超过5个"
		,"111010"=>"合同附件个数不能为空"
		,"111011"=>"产品个数不能为空"
		,"111012"=>"合同ID不能为空"
		,"111013"=>"合同不存在"
		,"111014"=>"附件不存在"
		,"112000"=>"回款id不能为空"
		,"112001"=>"回款不存在"
		,"112002"=>"回款日期不能为空"
		,"112003"=>"回款日期时间格式不正确"
		,"103001"=>"工作报告ID不能为空"
		,"103002"=>"工作报告主题不能为空"
		,"103003"=>"工作报告开始日期不能为空"
		,"103004"=>"工作报告开始日期格式不正确"
		,"103005"=>"工作报告结束日期不能为空"
		,"103006"=>"工作报告结束日期格式不正确"
		,"103007"=>"操作来源不能为空"
		,"103008"=>"操作来源必须是数字"
		,"103009"=>"操作来源值不存在"
		,"103010"=>"工作报告状态不能为空"
		,"103011"=>"工作报告状态必须是数字"
		,"103012"=>"工作报告状态值不存在"
		,"103013"=>"工作报告类型不能为空"
		,"103014"=>"工作报告类型必须是数字"
		,"103015"=>"工作报告类型值不存在"
		,"103016"=>"日报明细条数不能为空"
		,"103017"=>"日报明细条数必须是数字"
		,"103018"=>"日报明细或者日报语音必须有其一"
		,"103019"=>"工作报告内容不能为空"
		,"103020"=>"工作报告的内容或者工作报告语音必须有其一"
		,"103021"=>"工作报告操作类型不能为空"
		,"103022"=>"工作报告操作类型必须是数字"
		,"103023"=>"工作报告操作类型值不存在"
		,"103024"=>"工作报告已存在"
		,"103025"=>"不能提交晚于当天的日报"
		,"103026"=>"工作报告提交后不能编辑"
		,"103027"=>"工作报告不存在"
		,"103028"=>"审阅人不能为空"
		,"103029"=>"评论内容不能为空"
		,"103030"=>"工作报告或点评人不存在"
		,"103031"=>"工作报告点评失败"
		,"103032"=>"工作报告附件标识不能为空"
		,"103033"=>"工作报告审阅人ID串不能为空"
		,"103034"=>"工作报告ID或开始日期必须有其一"
		,"104001"=>"拜访签到类型不能为空"
		,"104002"=>"拜访签到参数值不正确"
		,"104003"=>"签到日期格式不正确"
		,"104004"=>"是否被拜访记录关联的参数值不正确"
		,"104005"=>"签到开始日期格式不正确"
		,"104006"=>"签到结束日期格式不正确"
		,"104007"=>"签到ID不能为空"
		,"104008"=>"签到不存在"
		,"104009"=>"操作来源不能为空"
		,"104010"=>"操作来源参数值错误"
		,"104011"=>"日期类型不能为空"
		,"104012"=>"日期类型参数值错误"
		,"104013"=>"签到点评内容不能为空"
		,"104014"=>"经度不能为空"
		,"104015"=>"纬度不能为空"
		,"104016"=>"签到数据来源不能为空"
		,"104017"=>"签到类型不能为空"
		,"104018"=>"签到类型参数值错误"
		,"104019"=>"与考勤点偏差的距离参数不能为空"
		,"105001"=>"签到地址序号不能为空"
		,"105002"=>"签到地址名称不能为空"
		,"105003"=>"签到地址不能为空"
		,"105004"=>"签到地址经度不能为空"
		,"105005"=>"签到地址纬度不能为空"
		,"105006"=>"允许偏离距离不能为空"
		,"105007"=>"签到地址ID不能为空"
		,"105008"=>"签到地址不存在"
		,"105009"=>"签到地址下存在签到记录不能删除"
		,"105010"=>"签到类型地址信息ID不能为空"
		,"105011"=>"签到类型地址信息名称不能为空"
		,"105012"=>"用户ID串不能为空"
		,"105013"=>"超出偏差距离后是否允许签到不能为空"
		,"105014"=>"签到类型地址信息序号不能为空"
		,"105015"=>"签到类型地址信息不存在"
		,"105016"=>"操作类型不能为空"
		,"105017"=>"操作类型不存在"
		,"105018"=>"签到地址上班时间不能为空"
		,"105019"=>"签到地址下班时间不能为空"
		,"105020"=>"签到地址上班时间格式不正确"
		,"105021"=>"签到地址下班时间格式不正确"
		,"106001"=>"是否是顶级部门参数不能为空"
		,"106002"=>"是否是顶级部门参数值错误"
		,"101101"=>"业务所属附件参数不能为空"
		,"101102"=>"业务ID不能为空"
		,"101103"=>"附件存储路径不能为空"
		,"101104"=>"附件类型不能为空"
		,"101105"=>"附件名称不能为空"
		,"101106"=>"附件大小不能为空"
		,"101107"=>"附件ID不能为空"
		,"101108"=>"业务所属附件参数值错误"
		,"101201"=>"数据字典类型不能为空"
		,"101202"=>"数据字典类型必须是数字"
		,"101901"=>"商机主题不能超过100个字符"
		,"101902"=>"商机主题不能为空"
		,"101903"=>"客户需求不能超过500个字符"
		,"101904"=>"预计签单日期格式不正确"
		,"101905"=>"预计签单日期不能为空"
		,"101906"=>"报价不能超过13个字符"
		,"101907"=>"预计成交额不能超过13个字符"
		,"101908"=>"备注不能超过500个字符"
		,"101909"=>"商机ID不能为空"
		,"101910"=>"商机不存在"
		,"101911"=>"商机ID串不能为空"
		,"200000"=>"command不存在"
		,"200001"=>"密码类型不存在"
		,"200002"=>"查询的类型不存在"
		,"200000"=>"command不存在"
	);
	
	/**
	 * 
	 * 系统错误类型
	 * @var array
	 */
	public static $ERROR_TYPES = array (                  
        E_ERROR              => 'Error',                  
        E_WARNING            => 'Warning',                  
        E_PARSE              => 'Parsing Error',                  
        E_NOTICE             => 'Notice',                  
        E_CORE_ERROR         => 'Core Error',                  
        E_CORE_WARNING       => 'Core Warning',                  
        E_COMPILE_ERROR      => 'Compile Error',                  
        E_COMPILE_WARNING    => 'Compile Warning',                  
        E_USER_ERROR         => 'User Error',                  
        E_USER_WARNING       => 'User Warning',                  
        E_USER_NOTICE        => 'User Notice',                  
        E_STRICT             => 'Runtime Notice',                  
        E_RECOVERABLE_ERROR  => 'Catchable Fatal Error'                  
    );      
	
	
}
