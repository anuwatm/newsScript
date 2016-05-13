var mnuFull = [{
        name: 'Edit',
        img: 'images/edit_context.png',
        title: 'Edit',
        fun: function () {
            window.location.href='writeScript.php?eid=' + $("#txtID").val();
        }
    }, {
        name: 'Print',
        img: 'images/preview_context.png',
        title: 'Preview',
        fun: function () {
            showPrint();
        }
    }, {
        name: 'Tranfer',
        img: 'images/tranfer_context.png',
        title: 'Tranfer',
        fun: function () {
            showTranfer($("#txtID").val());
        }
    }
];
var mnuView = [{
        name: 'Print',
        img: 'images/preview_context.png',
        title: 'Print',
        fun: function () {
            showPrint();
        }
    }, {
        name: 'Tranfer',
        img: 'images/tranfer_context.png',
        title: 'Tranfer',
        fun: function () {
            alert('i am Tranfer button')
        }
    }
];	
 var mnuPrint = [{
        name: 'Print',
        img: 'images/preview_context.png',
        title: 'Print',
        fun: function () {
            showPrint();
            //window.open("previewScript.php?id=" +  + $("#txtID").val(), "Preview", "width=600,height=600,scrollbars=yes,resizable=no");
        }
	}
];
tinymce.create('tinymce.plugins.ExamplePlugin', {
    createControl: function(n, cm) {
        switch (n) {
            case 'commandScript':
                var mlb = cm.createListBox('commandScript', {
                     title : 'Command',
                     onselect : function(v) {
						 tinyMCE.activeEditor.execCommand('mceInsertContent', false, v);
                     }
                });

                // Add some values to the list box
                mlb.add('สด', '<p><img src="images/[.png">สด<img src="images/].png"></p>');
                mlb.add('เทป', '<p><img src="images/[.png">เทป<img src="images/].png"></p>');
                mlb.add('อ่าน','<p><img src="images/[.png">อ่าน<img src="images/].png"></p>');
				mlb.add('ลงเสียง' ,'<p><img src="images/[.png">ลงเสียง<img src="images/].png"></p>' );
				mlb.add('Anchor' ,'<p><img src="images/[.png">Anchor<img src="images/].png"></p>' );
				mlb.add('Anchor - ผู้ประกาศ' ,'<p><img src="images/[.png">Anchor - ผู้ประกาศ<img src="images/].png"></p>' );
				mlb.add('เห็นภาพ...อ่านต่อ' ,'<p><img src="images/[.png">เห็นภาพ...อ่านต่อ<img src="images/].png"></p>' );
				mlb.add('CG 1 บรรทัด ชื่อ' ,'<p><img src="images/[.png">CG 1 บรรทัด ชื่อ : <img src="images/].png"></p>' );
				mlb.add('CG 1 บรรทัด สถานที่' ,'<p><img src="images/[.png">CG 1 บรรทัด สถานที่ : <img src="images/].png"></p>' );
				mlb.add('CG 1 บรรทัด ผู้ประกาศคู่' ,'<p><img src="images/[.png">CG 1 บรรทัด ผู้ประกาศคู่ : <img src="images/].png"></p>' );
				mlb.add('CG 1 บรรทัด ประเด็น' ,'<p><img src="images/[.png">CG 1 บรรทัด ประเด็น : <img src="images/].png"></p>' );
				mlb.add('CG 1 บรรทัด ตำแหน่ง' ,'<p><img src="images/[.png">CG 1 บรรทัด ตำแหน่ง : <img src="images/].png"></p>' );
				mlb.add('CG 1 บรรทัด รายงานสด' ,'<p><img src="images/[.png">CG 1 บรรทัด รายงานสด : <img src="images/].png"></p>' );
				mlb.add('CG 1 บรรทัด รายงานโทรศัพท์' ,'<p><img src="images/[.png">CG 1 บรรทัด รายงานโทรศัพท์  : <img src="images/].png"></p>' );
				mlb.add('CG 2 บรรทัด ชื่อ ตำแหน่ง' , '<p><img src="images/[.png">CG 2 บรรทัด ชื่อ :  <br>ตำแหน่ง : <img src="images/].png"></p>');
				mlb.add('รายงานโทรทัศน์' ,'<p><img src="images/[.png">รายงานโทรทัศน์<img src="images/].png"></p>' );
                mlb.add('ปล่อยเสียง' ,'<p><img src="images/[.png">ปล่อยเสียง : <img src="images/].png"></p>' );
                mlb.add( 'NOTE','<p><img src="images/[.png">NOTE : <img src="images/].png"></p>' );		
				mlb.add('Title' ,'<p><img src="images/[.png">Title : <img src="images/].png"></p>' );
				mlb.add('Description' ,'<p><img src="images/[.png">Tag : <img src="images/].png"></p>' );
				mlb.add('Tag' ,'<p><img src="images/[.png"> : <img src="images/].png"></p>' );
				mlb.add( 'Add By','<p><img src="images/[.png">Add By : <img src="images/].png"></p>' );
				mlb.add( 'Story','<p><img src="images/[.png">Story<img src="images/].png"></p>' );		
                return mlb;
        }

        return null;
    }
});

// Register plugin with a short name
tinymce.PluginManager.add('example', tinymce.plugins.ExamplePlugin);

	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		skin : "o2k7",
		paste_auto_cleanup_on_paste : true,
		paste_remove_styles: true,
        paste_as_text : true,
        paste_remove_spans : true,
        
		paste_remove_styles_if_webkit: true,
		paste_strip_class_attributes: true,
		plugins : "-example,lists,pagebreak,style,save,advhr,advimage,advlink,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,autosave,visualblocks",
		content_css : "css/example.css",
		// Theme options
		theme_advanced_buttons1 : "newScript,save,|,undo,redo,|,completeScript,approveScript,|,cut,copy,pastetext,|,search,replace,|,undo,redo,|,cleanup,|,printScript,|removeformat,|,fullscreen,|,durationScript,|,commandScript,",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		
		//Start Add Other Button
		setup : function(ed) {
        // Add a custom button
        ed.addButton('newScript', {
            title : 'เริ่มใหม่',
            image : 'images/new.png',
            onclick : function() {
                clearContent();
            }
        });
		ed.addButton('printScript', {
            title : 'พิมพ์',
            image : 'images/printer.png',
            onclick : function() {
                showPrintReview();
            }
        });
		ed.addButton('saveScript', {
            title : 'บันทึก',
            image : 'images/save.png',
            onclick : function() {
                saveScript();
            }
        });
		ed.addButton('completeScript', {
            title : 'เรียบร้อย',
            image : 'images/complete.png',
            onclick : function() {
                completeScript();
            }
        });
		ed.addButton('durationScript', {
            title : 'เวลา',
            image : 'images/duration.png',
            onclick : function() {
                $.post("duration.php",{sc:$("#txtScript").val()},function(data,status){showMessager("Duration :" + data);});
            }
        });
		ed.addButton('approveScript', {
            title : 'Approve',
            image : 'images/approve.png',
            onclick : function() {
                approveScript();
            }
        });
	}
});

 function newsFormater(date){
	var y = date.getFullYear();
	var m = date.getMonth()+1;
	var d = date.getDate();
	return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
}
function newsParser(s){
	if (!s) return new Date();
		var ss = (s.split('-'));
		var y = parseInt(ss[0],10);
		var m = parseInt(ss[1],10);
		var d = parseInt(ss[2],10);
		if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
			return new Date(y,m-1,d);
		} else {
			return new Date();
		}
}

function saveScript(){
    $("#frmScript").submit();
}

function completeScript(){
	$.post("flow.php",{cpID:$("#txtNewsID").val(),title:$("#txtTitle").val(),Script:$("#txtScript").val(),TypeScript:$("#cboTypeScript").val(),TableNews:$("#cboTableNews").val(),ProgramNews:$("#cboProgramNews").val(),DateOnAir:$("#txtDateOnAir").val(),TimeOnAir:$("#txtTimeOnAir").val(),status:$("#txtStatusID").val()},function(data,status){clearContent();showMessager("Update Status Complete OK!!");getAllList();});
}

function clearContent(){
	$("#frmScript").form('clear');
	tinymce.activeEditor.setContent('');
}
function approveScript(){
    $.post("flow.php",{apID:$("#txtNewsID").val(),title:$("#txtTitle").val(),Script:$("#txtScript").val(),TypeScript:$("#cboTypeScript").val(),TableNews:$("#cboTableNews").val(),ProgramNews:$("#cboProgramNews").val(),DateOnAir:$("#txtDateOnAir").val(),TimeOnAir:$("#txtTimeOnAir").val(),status:$("#txtStatusID").val()},function(data,status){clearContent();showMessager(data + "Approve Complete OK!!");getAllList();});
}
function showMessager(message){
    var win=$.messager.show({
        title:'NewsScript : Message',
        msg:message,
        showType:'fade',
        style:{
            right:'',
            bottom:''
        }
    });
	setTimeout(function(){$.messager.progress('close');},500)
}
function showBottomMessager(message){
    var win=$.messager.show({
        title:'NewsScript : Message',
        msg:message,
        showType:'fade'
    });
	setTimeout(function(){$.messager.progress('close');},500)
}
function showPrint(){
	window.open("previewScript.php?id=" + $("#txtID").val(), "Preview", "width=860,height=600,scrollbars=yes,resizable=no");
}
function showPrintReview(){
    window.open("previewScript.php?id=" + $("#txtNewsID").val(), "Preview", "width=860,height=600,scrollbars=yes,resizable=no");
}
function disableSave(){
	tinyMCE.activeEditor.controlManager.get('txtScript_save').setDisabled(true) ;
    tinyMCE.activeEditor.controlManager.get('txtScript_completeScript').setDisabled(true) ;
}
function disableApprove(){
	tinyMCE.activeEditor.controlManager.get('txtScript_approveScript').setDisabled(true) ;
}
function enableApprove(){
	tinyMCE.activeEditor.controlManager.get('txtScript_approveScript').setDisabled(false) ;
}
function getAllList(){
    $("#dListNewsMe").load("part_listNewsMe.php");
    //$("#dListNewsTable").load("part_listNewsTable.php?t=" + $("#cboGroupSearch").val() + "&s=" + $('#txtSearchTable').val());
    $("#dListNewsTable").load("part_listNewsTable.php?t=" + $('#cboGroupSearch').combobox('getValue') + "&s=" + $("#txtSearchTable").val() + "&d=" + $('#txtDateTable').datebox('getValue'));
    //$("#dListNewsProgram").load("part_listNewsProgram.php?t=" + $("#cboProgramSearch").val() + "&s=" + $('#txtSearchProgram').val());
    $("#dListNewsProgram").load("part_listNewsProgram.php?pid=" + $('#cboProgramSearch').combobox('getValue') + "&s=" + $("#txtSearchProgram").val() + "&d=" + $('#txtDateProg').datebox('getValue'));
    $("#dListWire").load("part_listNewsWire.php");
}
function savetext(){
   intTimer=intTimer+1;
    
    if(intTimer>60){
        intTimer=0;
        autoSaveText();
    }
    
}
function autoSaveText(){
    var scriptBody=$("#txtScript").val();
    if (scriptBody.length>10){
         $.post("autosave.php",{textScript:$("#txtScript").val()},function(data,status){showBottomMessager("Auto Save Complete !!");});
    }
}
function showTranfer(sID){
    $.get("searchScript.php",{sc:sID},function(data,status){$("#dTitleTran").text(data);});
    $('#dlg').dialog('open');
    $('#txtTranID').val(sID);
}
//http://fiddle.tinymce.com/O6caab/1
//http://wordpress.stackexchange.com/questions/103347/removing-buttons-from-the-editor