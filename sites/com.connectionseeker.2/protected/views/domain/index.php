<?php
$this->breadcrumbs=array(
	'Domains'=>array('index'),
	'Manage',
);

$mailvisible = false;

//Yii::app()->request->getQuery this return the $_GET. Yii::app()->request->getPost this return the $_POST 
if (Yii::app()->request->getParam("touched") == true) {
    if ($_REQUEST["Domain"]["touched_status"] == 6 || !empty($_REQUEST["Domain"]["domain"]) 
                                                   || !empty($_REQUEST["Domain"]["id"])) {
        $dataProvider = $model->search();
    } else {
        $dataProvider = $model->touched()->search();
    }
    $mailvisible = true;
    $h1title = "Outreach List";
} else {
    $dataProvider = $model->search();
    $h1title = "Manage Domains";
}

$types = Types::model()->actived()->bytype(array("site","outreach","category","technorati","awis"))->findAll();
$gtps = CHtml::listData($types, 'refid', 'typename', 'type');

$stypes = $gtps['site'] ? $gtps['site'] : array();
$otypes = $gtps['outreach'] ? $gtps['outreach'] : array();
$categories = $gtps['category'] ? $gtps['category'] : array();
$technoraties = $gtps['technorati'] ? $gtps['technorati'] : array();
$awises = $gtps['awis'] ? $gtps['awis'] : array();

//$stypestr = CVarDumper::DumpAsString($stypes);
$stypestr = Utils::array2String(array("" => '[Site Type]') + $stypes);
$otypestr = Utils::array2String(array("" => '[Outreach Type]') + $otypes);
$categorystr = Utils::array2String(array("" => '[Category]') + $categories);
$technoratistr = Utils::array2String(array("" => '[Technorati Category]') + $technoraties);
$awisstr = Utils::array2String(array("" => '[AWIS Category]') + $awises);

$touchedstatus = Domain::$status;
$statusstr = Utils::array2String($touchedstatus);
//echo $statusstr;

$cs=Yii::app()->clientScript;
$cs->registerCoreScript( 'jquery.ui' );
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/xheditor/xheditor-1.1.12-en.min.js', CClientScript::POS_HEAD);

$cs->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('domain-grid', {
		data: $(this).serialize()
	});
	return false;
});
");


function fmtCategory($cats) {
    if ($cats) {
        $_tmps = explode("|", $cats);
        array_pop($_tmps);
        array_shift($_tmps);
        return $cats = $_tmps;
    } else {
        return array();
    }
}

function fmtSemrush($semor) {
    if ($semor > 0 ) {
        echo "Yes";
    } elseif ($semor < 0)  {
        echo "No";
    } else {
        echo "";
    }
}

$isadmin = 0;
$roles = Yii::app()->authManager->getRoles(Yii::app()->user->id);
if(isset($roles['Admin'])){
    $isadmin = 1;//true
}

$semrushes = array(
    "0" => "Pending",
    "1" => "Yes",
    "-1" => "No",
);

//http://www.internetworldstats.com/list2.htm
//http://www.paladinsoftware.com/Generic/countries.htm
$countries = array("AF"=>"Afghanistan",
"AL"=>"Albania",
"DZ"=>"Algeria",
"AS"=>"American Samoa",
"AD"=>"Andorra",
"AO"=>"Angola",
"AI"=>"Anguilla",
"AQ"=>"Antarctica",
"AG"=>"Antigua and Barbuda",
"AR"=>"Argentina",
"AM"=>"Armenia",
"AW"=>"Aruba",
"AU"=>"Australia",
"AT"=>"Austria",
"AZ"=>"Azerbaijan",
"BS"=>"Bahamas",
"BH"=>"Bahrain",
"BD"=>"Bangladesh",
"BB"=>"Barbados",
"BY"=>"Belarus",
"BE"=>"Belgium",
"BZ"=>"Belize",
"BJ"=>"Benin",
"BM"=>"Bermuda",
"BT"=>"Bhutan",
"BO"=>"Bolivia",
"BA"=>"Bosnia and Herzegovina",
"BW"=>"Botswana",
"BV"=>"Bouvet Island",
"BR"=>"Brazil",
"IO"=>"British Indian Ocean Territory",
"BN"=>"Brunei Darussalam",
"BG"=>"Bulgaria",
"BF"=>"Burkina Faso",
"BI"=>"Burundi",
"KH"=>"Cambodia",
"CM"=>"Cameroon",
"CA"=>"Canada",
"CV"=>"Cape Verde",
"KY"=>"Cayman Island CF Central African Republic",
"TD"=>"Chad",
"CL"=>"Chile",
"CN"=>"China",
"CX"=>"Christmas Island",
"CC"=>"Cocos (Keeling Islands)",
"CO"=>"Colombia",
"KM"=>"Comoros",
"CG"=>"Congo",
"CK"=>"Cook Islands",
"CR"=>"Costa Rica",
"CI"=>"Cote D'Ivoire (Ivory Coast)",
"HR"=>"Croatia (Hrvatska)",
"CU"=>"Cuba",
"CY"=>"Cyprus",
"CZ"=>"Czech Republic",
"DK"=>"Denmark",
"DJ"=>"Djibouti",
"DM"=>"Dominica",
"DO"=>"Dominican Republic",
"TP"=>"East Timor",
"EC"=>"Ecuador",
"EG"=>"Egypt",
"SV"=>"El Salvador",
"GQ"=>"Equatorial Guinea",
"ER"=>"Eritrea",
"EE"=>"Estonia",
"ET"=>"Ethiopia",
"FK"=>"Falkland Islands (Malvinas)",
"FO"=>"Faroe Islands",
"FJ"=>"Fiji",
"FI"=>"Finland",
"FR"=>"France",
"FX"=>"France, Metropolitan",
"GF"=>"French Guiana",
"PF"=>"French Polynesia",
"TF"=>"French Southern Territories",
"GA"=>"Gabon",
"GM"=>"Gambia",
"GE"=>"Georgia",
"DE"=>"Germany",
"GH"=>"Ghana",
"GI"=>"Gibraltar",
"GR"=>"Greece",
"GL"=>"Greenland",
"GD"=>"Grenada",
"GP"=>"Guadeloupe",
"GU"=>"Guam",
"GT"=>"Guatemala",
"GN"=>"Guinea",
"GW"=>"Guinea-Bissau",
"GY"=>"Guyana",
"HT"=>"Haiti",
"HM"=>"Heard and McDonald Islands",
"HN"=>"Honduras",
"HK"=>"Hong Kong",
"HU"=>"Hungary",
"IS"=>"Iceland",
"IN"=>"India",
"ID"=>"Indonesia",
"IR"=>"Iran",
"IQ"=>"Iraq",
"IE"=>"Ireland",
"IL"=>"Israel",
"IT"=>"Italy",
"JM"=>"Jamaica",
"JP"=>"Japan",
"JO"=>"Jordan",
"KZ"=>"Kazakhstan",
"KE"=>"Kenya",
"KI"=>"Kiribati",
"KP"=>"Korea (North)",
"KR"=>"Korea (South)",
"KW"=>"Kuwait",
"KG"=>"Kyrgyzstan",
"LA"=>"Laos",
"LV"=>"Latvia",
"LB"=>"Lebanon",
"LS"=>"Lesotho",
"LR"=>"Liberia",
"LY"=>"Libya",
"LI"=>"Liechtenstein",
"LT"=>"Lithuania",
"LU"=>"Luxembourg",
"MO"=>"Macau",
"MK"=>"Macedonia",
"MG"=>"Madagascar",
"MW"=>"Malawi",
"MY"=>"Malaysia",
"MV"=>"Maldives",
"ML"=>"Mali",
"MT"=>"Malta",
"MH"=>"Marshall Islands",
"MQ"=>"Martinique",
"MR"=>"Mauritania",
"MU"=>"Mauritius",
"YT"=>"Mayotte",
"MX"=>"Mexico",
"FM"=>"Micronesia",
"MD"=>"Moldova",
"MC"=>"Monaco",
"MN"=>"Mongolia",
"MS"=>"Montserrat",
"MA"=>"Morocco",
"MZ"=>"Mozambique",
"MM"=>"Myanmar",
"NA"=>"Namibia",
"NR"=>"Nauru",
"NP"=>"Nepal",
"NL"=>"Netherlands",
"AN"=>"Netherlands Antilles",
"NC"=>"New Caledonia",
"NZ"=>"New Zealand",
"NI"=>"Nicaragua",
"NE"=>"Niger",
"NG"=>"Nigeria",
"NU"=>"Niue",
"NF"=>"Norfolk Island",
"MP"=>"Northern Mariana Islands",
"NO"=>"Norway",
"OM"=>"Oman",
"PK"=>"Pakistan",
"PW"=>"Palau",
"PA"=>"Panama",
"PG"=>"Papua New Guinea",
"PY"=>"Paraguay",
"PE"=>"Peru",
"PH"=>"Philippines",
"PN"=>"Pitcairn",
"PL"=>"Poland",
"PT"=>"Portugal",
"PR"=>"Puerto Rico",
"QA"=>"Qatar",
"RE"=>"Reunion",
"RO"=>"Romania",
"RU"=>"Russian Federation",
"RW"=>"Rwanda",
"KN"=>"Saint Kitts and Nevis",
"LC"=>"Saint Lucia",
"VC"=>"Saint Vincent and The Grenadines",
"WS"=>"Samoa",
"SM"=>"San Marino",
"ST"=>"Sao Tome and Principe",
"SA"=>"Saudi Arabia",
"SN"=>"Senegal",
"SC"=>"Seychelles",
"SL"=>"Sierra Leone",
"SG"=>"Singapore",
"SK"=>"Slovak Republic",
"SI"=>"Slovenia",
"SB"=>"Solomon Islands",
"SO"=>"Somalia",
"ZA"=>"South Africa",
"GS"=>"S. Georgia and S. Sandwich Isls.",
"ES"=>"Spain",
"LK"=>"Sri Lanka",
"SH"=>"St. Helena",
"PM"=>"St. Pierre and Miquelon",
"SD"=>"Sudan",
"SR"=>"Suriname",
"SJ"=>"Svalbard and Jan Mayen Islands",
"SZ"=>"Swaziland",
"SE"=>"Sweden",
"CH"=>"Switzerland",
"SY"=>"Syria",
"TW"=>"Taiwan",
"TJ"=>"Tajikistan",
"TZ"=>"Tanzania",
"TH"=>"Thailand",
"TG"=>"Togo",
"TK"=>"Tokelau",
"TO"=>"Tonga",
"TT"=>"Trinidad and Tobago",
"TN"=>"Tunisia",
"TR"=>"Turkey",
"TM"=>"Turkmenistan",
"TC"=>"Turks and Caicos Islands",
"TV"=>"Tuvalu",
"UG"=>"Uganda",
"UA"=>"Ukraine",
"AE"=>"United Arab Emirates",
"UK"=>"United Kingdom",
"US"=>"United States",
"UM"=>"US Minor Outlying Islands",
"UY"=>"Uruguay",
"UZ"=>"Uzbekistan",
"VU"=>"Vanuatu",
"VA"=>"Vatican City State (Holy See)",
"VE"=>"Venezuela",
"VN"=>"Viet Nam",
"VG"=>"Virgin Islands (British)",
"VI"=>"Virgin Islands (US)",
"WF"=>"Wallis and Futuna Islands",
"EH"=>"Western Sahara",
"YE"=>"Yemen",
"YU"=>"Yugoslavia",
"ZR"=>"Zaire",
"ZM"=>"Zambia",
"ZW"=>"Zimbabwe",);
?>


<div class="form">
    <div style="float:left;width:630px;"><h1><?php echo $h1title;?></h1></div>
    <div id="processing" style="float:left;width:220px;">&nbsp;</div>
    <?php if ($mailvisible) { /* ?>
	<div class="row buttons">
		<?php echo CHtml::ajaxSubmitButton("Send Queued Email", Yii::app()->createUrl('email/send'),
        array('type'=>'POST',
        'data'=>'actiontype=sendall',
        'dataType'=>'json',
        'success' => 'function(data){$("#processing").html(data.message)}')); ?>
	</div>
    <?php */ }?>
    <div class="clear"></div>
</div>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<!-- search-form -->
<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
	'touchedstatus'=>$touchedstatus,
	'stypes'=>$stypes,
	'otypes'=>$otypes,
	'categories'=>$categories,
	'countries'=>$countries,
	'semrushes'=>$semrushes,
)); ?>
</div><!-- search-form -->

<div style="clear:both"></div>
<?php $this->widget('application.extensions.lkgrid.LinkmeGridView', array(
	'id'=>'domain-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
    'selectableRows' => '2',
	'columns'=>array(
		'id',
        /*array(
            'id'=>'ids',
            'class'=>'CCheckBoxColumn',
        ),*/
		/*'domain',*/
		array(
			'name' => 'domain',
			'type' => 'raw',
            'value' => 'CHtml::link(CHtml::encode($data->domain),"http://www.".$data->domain, array("target"=>"_blank"))',
		),
		//'stype',
        array(
            'name' => 'stype',
            'type' => 'raw',
            //'value' => 'CHtml::dropDownList("stype", $data->stype, '.$stypestr.', array("onchange"=>"updateType(this);"))',
            'value' => 'CHtml::dropDownList("stype", $data->stype, '.$stypestr.')',
            'filter' => $stypes,
        ),
        /*
        array(
            'name' => 'googlepr',
            'type' => 'raw',
            //'value' => 'CHtml::textField("googlepr[]", $data->googlepr)',
            'value' => '$data->googlepr',
            'htmlOptions'=>array('width'=>'30px'),
        ),
        */
        array(
            'name' => 'alexarank',
            'type' => 'raw',
            //'value' => 'CHtml::textField("alexarank[]", number_format($data->alexarank))',
            'value' => '$data->alexarank',
            'value'=>'number_format($data->alexarank)',
        ),
        array(
            'header' => 'Moz Rank',
            //##'name' => 'rsummary.mozrank',//we can use this one also
            'name' => 'mozrank',
            'type' => 'raw',
            //'value' => 'CHtml::textField("mozrank[]", $data->rsummary->mozrank)',
            'value' => 'round($data->rsummary->mozrank)',
            'visible' => isVisible('mozrank', $dparr),
        ),
        /*
        array(
            'name' => 'rsummary.mozauthority',
            'type' => 'raw',
            //'value' => 'CHtml::textField("mozauthority[]", $data->rsummary->mozauthority)',
            'value' => 'round($data->rsummary->mozauthority)',
            'visible' => isVisible('mozauthority', $dparr),
        ),
        */
        array(
            'name' => 'semrushor',
            'header' => "SEM",
            'type' => 'raw',
            'value' => 'fmtSemrush($data->rsummary->semrushor)',
            //'value' => 'round($data->rsummary->semrushor)',
            'visible' => isVisible('semrushor', $dparr),
            'filter' => $semrushes,
        ),
		//'googlepr',
		//'otype',

        /*
        array(
            'name' => 'otype',
            'type' => 'raw',
            //'value' => 'CHtml::dropDownList("otype[]", $data->otype, '.$otypestr.', array("onchange"=>"updateType(this);"))',
            'value' => 'CHtml::dropDownList("otype", $data->otype, '.$otypestr.')',
            'filter' => $otypes,
        ),
        */

        array(
            'name' => 'category',
            'type' => 'raw',
            'value' => 'CHtml::dropDownList("category", fmtCategory($data->category), '.$categorystr.')',
            'filter' => $categories,
        ),

        'host_country',

		/*
        array(
            'name' => 'host_country',
            'type' => 'raw',
            'filter' => $countries,
        ),
		'tld',
		'onlinesince',
		'linkingdomains',
		'inboundlinks',
		'indexedurls',
		'alexarank',
		'ip',
		'subnet',
		'title',
		'owner',
		'email',
		'telephone',
		'country',
		'state',
		'city',
		'zip',
		'street',
		'touched',
		'touched_by',
		'created',
		'created_by',
		'modified_by',
		*/
		//'touched_by',
        array(
            'name' => 'touched_by',
            'type' => 'raw',
            //'value' => 'CHtml::link(CHtml::encode($data->touchedby->username), array("user/view", "id" =>$data->touched_by))',
            'value' => 'CHtml::encode($data->touchedby->username)',
            'filter' => CHtml::listData(User::model()->actived()->findAll(),'id','username'),
        ),
        array(
            'name' => 'touched_status',
            'type' => 'raw',
            //'value' => 'CHtml::encode(Utils::getValue(' . $statusstr . ', $data->touched_status))',
            'value' => 'CHtml::dropDownList("touched_status", $data->touched_status, '.$statusstr.')',
            'filter' => $touchedstatus,
        ),
		//'touched_status',
		'modified',
		array(
			'class'=>'CButtonColumn',
            'template'=>'{email} {note} {view} {update}',
            'buttons' => array(
                'email' => array(
                    'label' => 'Mail To',
                    'imageUrl' => Yii::app()->theme->baseUrl.'/css/gridview/email.png',
                    'visible' => "$mailvisible",
                    'url' => 'Yii::app()->createUrl("domain/view", array("id"=>$data->id))',
                    'click' => "function(){
                        addMail(this);
                        return false;
                    }",
                ),
                'note' => array(
                    'label' => 'Add Notes',
                    'imageUrl' => Yii::app()->theme->baseUrl.'/css/gridview/note.png',
                    'url' => 'Yii::app()->createUrl("domain/view", array("id"=>$data->id))',
                    'options' => array('id'=>$this->evaluateExpression('$data->id', array('data'=>$data))),
                    'click' => "function(){
                        addNote(this);
                        return false;
                    }",
                ),
                'update' => array(
                    'visible' => "$isadmin",
                ),
            ),
            'htmlOptions'=>array('nowrap'=>'nowrap'),
		),
	),
)); ?>

<script type="text/javascript">

<?php
$tplmodel = new Template;
$tplm = $tplmodel->findByAttributes(array("created_by"=>Yii::app()->user->id));
if ($tplm) {
    echo "var defaulttpl = ".$tplm->id.";";
} else {
    echo "var defaulttpl = 0;";
}
?>

</script>

<div id="hiddenContainer">

    <?php $this->renderPartial('_mail',array(
        'model'=>$model,
        'touchedstatus'=>$touchedstatus,
        'stypes'=>$stypes,
        'otypes'=>$otypes,
        'tplm'=>$tplm,
    )); ?>

    <div id="noteboxdiv" style="display:none;">
    </div>

</div>

<script type="text/javascript">
$(document).ready(function() {

    $('#processing').bind("ajaxSend", function() {
        $(this).html("&nbsp;");
        $(this).css('background-image', 'url(' + "<?php echo Yii::app()->theme->baseUrl; ?>" + '/images/loading.gif)');
        //$(this).show();
    }).bind("ajaxComplete", function() {
        $(this).css('background-image', '');
        $(this).css('color', 'red');
        //$(this).hide();
    });

    $.fn.yiiGridView.defaults.afterAjaxUpdate = function(){
        //jquery onchange will firing event twice in ie7, So we need hack it as following.
        $("select[name='stype'],select[name='otype'],select[name='touched_status'],select[name='category']").each(function() {
            //way 1
            //$(this).change(updateType);
            //$(this).unbind('click').change(updateType);

            //way 2
            $(this).unbind('click').change(function(){
                var gvid = $(this).parent().parent().closest('.grid-view').attr('id');
                var gvoffset = $(this).parent().parent().prevAll().length;
                var currenttrid = $.fn.yiiGridView.getKey(gvid, gvoffset);
                var thistd = $(this);

                $.ajax({
                    'type': 'GET',
                    'dataType': 'json',
                    'url': "<?php echo CHtml::normalizeUrl(array('/domain/setattr'));?>",
                    'data': 'id='+currenttrid+"&attrname="+$(this).attr('name')+"&attrvalue="+this.value,
                    'success':function(data){
                        //donothing for now;
                        if (data.success){
                            $(thistd).css("background-color","yellow");
                            if (data.operation && data.operation.obj == 'touched_status') {
                                $(thistd).parent().prev().html(data.operation.operator);
                                $(thistd).parent().next().html(data.operation.modified);
                            }
                        } else {
                            $(thistd).css("background-color","red");
                            alert(data.msg);
                        }
                    },
                    'complete':function(XHR,TS){XHR = null;}
                });
            });


            /*
            //bind one times handler in the object.
            $(this).one(
                'change',
                function() {}
            )
            */

        });

        $("input[name^='googlepr'],input[name^='mozrank'],input[name^='alexarank']").each(function() {
            if ($(this).attr('name') == "googlepr[]"){
                $(this).css({width:"30px"});
            } else {
                $(this).css({width:"60px"});
            }
            $(this).unbind('blur').blur(function(){
                var gvid = $(this).parent().parent().closest('.grid-view').attr('id');
                var gvoffset = $(this).parent().parent().prevAll().length;
                var currenttrid = $.fn.yiiGridView.getKey(gvid, gvoffset);
                var thistd = $(this);

                if (currenttrid)
                {
                    $.ajax({
                        'type': 'GET',
                        'dataType': 'json',
                        'url': "<?php echo CHtml::normalizeUrl(array('/domain/setattr'));?>",
                        'data': 'id='+currenttrid+"&attrname="+$(this).attr('name')+"&attrvalue="+this.value,
                        'success':function(data){
                            //donothing for now;
                            if (data.success){
                                $(thistd).css("background-color","yellow");
                            } else {
                                $(thistd).css("background-color","red");
                                alert(data.msg);
                            }
                        },
                        'complete':function(XHR,TS){XHR = null;}
                    });
                }

            });
        });

        //$("input[name^='email'],input[name^='primary_email']").each(function() {
        $("#email,#primary_email").each(function() {
            $(this).unbind('blur').blur(function(){
                var currenttrid = $("#mail_domain_id").val();
                //alert(currenttrid);
                //alert($(this).attr('name'));
                var thistd = $(this);

                if (currenttrid)
                {
                    $.ajax({
                        'type': 'GET',
                        'dataType': 'json',
                        'url': "<?php echo CHtml::normalizeUrl(array('/domain/setattr'));?>",
                        'data': 'id='+currenttrid+"&attrname="+$(this).attr('name')+"&attrvalue="+this.value,
                        'success':function(data){
                            //donothing for now;
                            if (data.success){
                                $(thistd).css("background-color","yellow");
                                $(thistd).animate({backgroundColor: 'white'}, 8000);
                            } else {
                                $(thistd).css("background-color","red");
                                $(thistd).animate({backgroundColor: 'white'}, 8000);
                                alert(data.msg);
                            }
                        },
                        'complete':function(XHR,TS){XHR = null;}
                    });
                }
            });
        });


        //issue: when the user click the pager(i mean change pager number), then the mailbox & notebox may not showing again.
        //cause we append the mailbox & notebox into the grid already when we click the addmail or addnote button,
        //so when we jump to another outreach page number, the mailbox & notebox may be removed due to the grid overwrited.
        $("div.pager > ul > li a").each(function(){
            $(this).click(function() {
                $("#mailboxdiv").hide();
                $("#noteboxdiv").hide();
                $("#mailboxdiv").appendTo($("#hiddenContainer"));
                $("#noteboxdiv").appendTo($("#hiddenContainer"));

            });
            return true;
        });

        $("table.items #pageSize").change(function(){
            $("#mailboxdiv").hide();
            $("#noteboxdiv").hide();
            $("#mailboxdiv").appendTo($("#hiddenContainer"));
            $("#noteboxdiv").appendTo($("#hiddenContainer"));
        });

        $("table.items thead tr.filters input, table.items thead tr.filters select").each(function(){
            $(this).change(function() {
                $("#mailboxdiv").hide();
                $("#noteboxdiv").hide();
                $("#mailboxdiv").appendTo($("#hiddenContainer"));
                $("#noteboxdiv").appendTo($("#hiddenContainer"));

            });
            return true;
        });

        var _ids = [];
        $('#domain-grid > div.keys > span').each(function(i){
            _ids[i] = $(this).html();
        });
        $("#domain-grid > table.items > tbody > tr").each(function(i){
            $(this).attr("id", "etr"+_ids[i]);//reset table.tr.id
        });

        $.ajax({
            'type': 'POST',
            'dataType': 'json',
            'url': "<?php echo Yii::app()->createUrl('/note/icon');?>",
            'data': {'ids[]': _ids},
            'success':function(data){
                //alert(data.msg);
                if (data.success){
                    if (data.ids){
                        $.each(data.ids, function (v){
                            //alert(v);
                            $("#etr" +v+" > td:last > a.note > img").attr("src", "<?php echo Yii::app()->theme->baseUrl?>/css/gridview/notes.png");
                        });
                    }
                }
            },
            'complete':function(XHR,TS){XHR = null;}
        });
    }

    $.fn.yiiGridView.defaults.afterAjaxUpdate();

});


//jquery onchange will firing event twice in ie7, So we couldn't use this way.
function updateType(){
    //alert(this.value);
    var gvid = $(this).parent().parent().closest('.grid-view').attr('id');
    var gvoffset = $(this).parent().parent().prevAll().length;
    var currenttrid = $.fn.yiiGridView.getKey(gvid, gvoffset);


    $.ajax({
        'type': 'GET',
        'dataType': 'json',
        //'url': "<?php echo CHtml::normalizeUrl(array('/domain/setattr'));?>",
        'url': "<?php echo Yii::app()->createUrl('/domain/setattr');?>",
        'data': 'id='+currenttrid+"&attrname="+$(this).attr('name')+"&attrvalue="+this.value,
        'success':function(data){
            //donothing for now;
            alert(data.msg);
        },
        'complete':function(XHR,TS){XHR = null;}
    });

    return false;
}

var lastclickid = 0;


function addMail(t) {
    var gvid = $(t).parent().parent().closest('.grid-view').attr('id');
    var gvoffset = $(t).parent().parent().prevAll().length;
    var currenttrid = $.fn.yiiGridView.getKey(gvid, gvoffset);
    var currentdomain = $(t).parent().parent().children("td:eq(1)").text();
    //$("#currentdomain").text(currentdomain);
    //alert(currentdomain);
    var lc = top.location;

    //alert(currentdomain);

    $("#noteboxdiv").hide();
    if (lastclickid == currenttrid || lastclickid == 0) {
        $("#mailboxdiv").toggle();
    } else {
        $("#mailboxdiv").show();
    }

    //$("#mailboxdiv:visible");
    if ($("#mailboxdiv").is(":visible")) {
        $("#ifr_webpreview").attr({'src': 'http://www.'+currentdomain});
        $("#mail_domain_id").val(currenttrid);

        $("#lnabout").attr({'href': 'http://www.'+currentdomain});
        $("#lnwhois").attr({'href': 'http://who.is/whois/'+currentdomain});
        //alert($("#mailto").val());
        $("#mailto").val("");

        $.ajax({
            'type': 'GET',
            'dataType': 'json',
            'url': "<?php echo Yii::app()->createUrl('/domain/view');?>",
            'data': 'id='+currenttrid+"&ajax=true",
            'success':function(data){
                var rtn = "";
                $.each(data, function(lb, v){
                    if ($.inArray(lb, ["domain","googlepr","creation","linkingdomains",
                                       "inboundlinks","indexedurls","alexarank","title","owner",
                                       "email","primary_email","telephone","country","state","city","zip","street"]) >= 0){
                        //rtn += lb + ": " + v + "<br />";
                        if (lb == "primary_email") {
                            lb = "Primary Email";
                            $("#primary_email").val(v);
                        } else if (lb == "email") {
                            $("#email").val(v);
                        }
                        rtn += lb + ": " + v + "<br />";
                    }
                });
                //alert(rtn);
                $("#domaininfo").html(rtn);

                //alert(data.id);
                //$("#mailto").val(data.email);
            },
            'complete':function(XHR,TS){XHR = null;}
        });

        if ($("#"+currenttrid+"_dtr").length>0) {
            /*
            here you couldn't use the find("td"), coz it will search all of the posterity td elements,
            The .find() and .children() methods are similar,
            but .children() only travels a single level down the DOM tree.
            */
            $("#mailboxdiv").appendTo($("#"+currenttrid+"_dtr").children("td"));
        } else {
            var vartr = $('<tr><td colspan="11"></td></tr>').attr({ 'id': currenttrid+"_dtr", 'class':"bltr"});
            //$("#mailboxdiv").appendTo(vartr.find("td"));
            $("#mailboxdiv").appendTo(vartr.children("td"));
            $(t).parent().parent().after(vartr);
            $('#'+gvid+' > div.keys > span:eq('+gvoffset+')').after("<span>"+currenttrid+"_dtr</span>");
        }

        //Uninstall the XHeditor first, Then reload(re-install) the WYSIWYG editor
        //these steps will help us keep the focus on the editor always, and can make the WYSIWYG editor always avaliable
        $('#message').xheditor(false);
        $('#message').xheditor({tools:'mfull',width:460,height:380}).focus();

        /*
        * Set default template
        */
        if (defaulttpl > 0) {
            /*
            if ($("#template_id").val() != defaulttpl){
                $("#template_id").val(defaulttpl);
            }
            */
            $("#template_id").val(defaulttpl);
            $.ajax({
                'type': 'GET',
                'dataType': 'json',
                'url': "<?php echo Yii::app()->createUrl('template/replacement');?>",
                'data': 'id='+defaulttpl,
                'success':function(data){
                    $("#subject").val(data.subject);$("#message").val(data.content);
                },
                'complete':function(XHR,TS){XHR = null;}
            });
        }
    } else {}


    //top.location = lc;

    lastclickid = currenttrid;
}

function addNote(t) {
    var gvid = $(t).parent().parent().closest('.grid-view').attr('id');
    var gvoffset = $(t).parent().parent().prevAll().length;
    var currenttrid = $.fn.yiiGridView.getKey(gvid, gvoffset);
    var currentdomain = $(t).parent().parent().children("td:eq(1)").text();

    $("#mailboxdiv").hide();
    if (lastclickid == currenttrid || lastclickid == 0) {
        $("#noteboxdiv").toggle();
    } else {
        $("#noteboxdiv").show();
    }

    if ($("#noteboxdiv").is(":visible")) {

        $.ajax({
            'type': 'GET',
            //'dataType': 'json',
            'dataType': 'html',
            'url': "<?php echo Yii::app()->createUrl('/domain/note');?>",
            'data': 'domain_id='+currenttrid+"&ajax=true",
            'success':function(data){
                $("#noteboxdiv").html(data);
            },
            'complete':function(XHR,TS){XHR = null;}
        });


        if ($("#"+currenttrid+"_dtr").length>0) {
            /*
            here you couldn't use the find("td"), coz it will search all of the posterity td elements,
            The .find() and .children() methods are similar,
            but .children() only travels a single level down the DOM tree.
            */
            $("#noteboxdiv").appendTo($("#"+currenttrid+"_dtr").children("td"));
        } else {
            var vartr = $('<tr><td colspan="11"></td></tr>').attr({ 'id': currenttrid+"_dtr", 'class':"bltr"});
            //$("#noteboxdiv").appendTo(vartr.find("td"));
            $("#noteboxdiv").appendTo(vartr.children("td"));
            $(t).parent().parent().after(vartr);
            $('#'+gvid+' > div.keys > span:eq('+gvoffset+')').after("<span>"+currenttrid+"_dtr</span>");
        }

    } else {}

    lastclickid = currenttrid;
}

//$(window).bind('hashchange', function() {
//   alert("hello");
//});

//window.frames[0].open = function (e){return null;}
//window.frames[0].location.href = "http://www.angelfire.lycos.com/";
</script>

<style type="text/css">
.grid-view table.items tr.bltr td {
    height:100%;
}
</style>