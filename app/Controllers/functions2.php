<?php
define('BASEPATH', str_replace("\\", "/", 'http://localhost/koperasi/'));


function publish_action($xcrud)
{
    if ($xcrud->get('primary'))
    {
        $db = Xcrud_db::get_instance();
        $query = 'UPDATE base_fields SET `bool` = b\'1\' WHERE id = ' . (int)$xcrud->get('primary');
        $db->query($query);
    }
}
function unpublish_action($xcrud)
{
    if ($xcrud->get('primary'))
    {
        $db = Xcrud_db::get_instance();
        $query = 'UPDATE base_fields SET `bool` = b\'0\' WHERE id = ' . (int)$xcrud->get('primary');
        $db->query($query);
    }
}

function nice_input_divisi($value, $field, $primary_key, $list, $xcrud)
{

    $html = '<script>'
        .'jQuery("input[name=id_divisi-id]").autocomplete({ 
        source: "'.dirname($_SERVER["SCRIPT_NAME"]).'/../master/auto_id_divisi",
        select: function( event, ui ) {
          if(ui.item.id == "00"){
            jQuery("#tambah").show();
            this.value = "";
          }else{
            jQuery("input[name='.$xcrud->fieldname_encode($field).']").val(ui.item.id);
            jQuery("#tambah").hide();
          }
        }
        });
        
        jQuery("#tambah").hide();

        jQuery(".modal").on("click", function () {
            window.location.reload();
        });
        '
    .'</script>';
    
    $html .= '
    <div class="input-prepend input-append">'
    . '<input type="hidden" name="'.$xcrud->fieldname_encode($field).'" value="'.$value.'" class="xcrud-input" />'
    . '<input type="text" name="id_divisi-id" value="" class="xcrud-input" />'
    . '<button type="button" id="tambah" class="btn btn-primary" data-toggle="modal" data-target=".modal_divisi">Buat Baru</button>'
 . '</div>'
 . '
    <div class="modal fade modal_divisi" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
           <iframe width="860px" height="660px" name="master" frameborder=0 src="'.dirname($_SERVER["SCRIPT_NAME"]).'/../master/divisi_modal"></iframe>
        </div>
      </div>
    </div>';
    
    return $html;
        
}

function nice_input_subdivisi($value, $field, $primary_key, $list, $xcrud)
{

    $html = '<script>'
        .'jQuery("input[name=id_subdivisi-id]").autocomplete({ 
        source: "'.dirname($_SERVER["SCRIPT_NAME"]).'/../master/auto_id_subdivisi",
        select: function( event, ui ) {
          if(ui.item.id == "00"){
            jQuery("#tambah").show();
            this.value = "";
          }else{
            jQuery("input[name='.$xcrud->fieldname_encode($field).']").val(ui.item.id);
            jQuery("#tambah").hide();
          }
        }
        });
        
        jQuery("#tambah").hide();

        jQuery(".modal").on("click", function () {
            window.location.reload();
        });
        '
    .'</script>';
    
    $html .= '
    <div class="input-prepend input-append">'
    . '<input type="hidden" name="'.$xcrud->fieldname_encode($field).'" value="'.$value.'" class="xcrud-input" /> '
    . '<input type="text" name="id_subdivisi-id" value="" class="xcrud-input" />'
    . '<button type="button" id="tambah" class="btn btn-primary" data-toggle="modal" data-target=".modal_subdivisi">Buat Baru</button>'
 . '</div>'
 . '
    <div class="modal fade modal_subdivisi" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
           <iframe width="860px" height="660px" name="master" frameborder=0 src="'.dirname($_SERVER["SCRIPT_NAME"]).'/../master/subdivisi_modal"></iframe>
        </div>
      </div>
    </div>';
    
    return $html;
        
}

function nice_input_kelas($value, $field, $primary_key, $list, $xcrud)
{

    $html = '<script>'
        .'jQuery("input[name=id_kelas-id]").autocomplete({ 
        source: "'.dirname($_SERVER["SCRIPT_NAME"]).'/../master/auto_id_kelas",
        select: function( event, ui ) {
          if(ui.item.id == "00"){
            jQuery("#tambah").show();
            this.value = "";
          }else{
            jQuery("input[name='.$xcrud->fieldname_encode($field).']").val(ui.item.id);
            jQuery("#tambah").hide();
          }
        }
        });
        
        jQuery("#tambah").hide();

        jQuery(".modal").on("click", function () {
            window.location.reload();
        });
        '
    .'</script>';
    
    $html .= '
    <div class="input-prepend input-append">'
    . '<input type="text" name="id_kelas-id" value="" class="xcrud-input" />'
    . '<input type="hidden" name="'.$xcrud->fieldname_encode($field).'" value="'.$value.'" class="xcrud-input" /> '
    . '<button type="button" id="tambah" class="btn btn-primary" data-toggle="modal" data-target=".modal_kelas">Buat Baru</button>'
 . '</div>'
 . '
    <div class="modal fade modal_kelas" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
           <iframe width="860px" height="660px" name="master" frameborder=0 src="'.dirname($_SERVER["SCRIPT_NAME"]).'/../master/kelas_modal"></iframe>
        </div>
      </div>
    </div>';
    
    return $html;
        
}

function nice_input_bangsa($value, $field, $primary_key, $list, $xcrud)
{

    $html = '<script>'
        .'jQuery("input[name=id_bangsa-id]").autocomplete({ 
        source: "'.dirname($_SERVER["SCRIPT_NAME"]).'/../master/auto_id_bangsa",
        select: function( event, ui ) {
          if(ui.item.id == "00"){
            jQuery("#tambah").show();
            this.value = "";
          }else{
            jQuery("input[name='.$xcrud->fieldname_encode($field).']").val(ui.item.id);
            jQuery("#tambah").hide();
          }
        }
        });
        
        jQuery("#tambah").hide();

        jQuery(".modal").on("click", function () {
            window.location.reload();
        });
        '
    .'</script>';
    
    $html .= '
    <div class="input-prepend input-append">'
    . '<input type="hidden" name="'.$xcrud->fieldname_encode($field).'" value="'.$value.'" class="xcrud-input" /> '
    . '<input type="text" name="id_bangsa-id" value="" class="xcrud-input" />'
    . '<button type="button" id="tambah" class="btn btn-primary" data-toggle="modal" data-target=".modal_bangsa">Buat Baru</button>'
 . '</div>'
 . '
    <div class="modal fade modal_bangsa" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
           <iframe width="860px" height="660px" name="master" frameborder=0 src="'.dirname($_SERVER["SCRIPT_NAME"]).'/../master/bangsa_modal"></iframe>
        </div>
      </div>
    </div>';
    
    return $html;
        
}


function nice_input_suku($value, $field, $primary_key, $list, $xcrud)
{

	$html = '<script>'
		.'jQuery("input[name=id_suku-id]").autocomplete({ 
		source: "'.dirname($_SERVER["SCRIPT_NAME"]).'/../master/auto_id_suku",
        select: function( event, ui ) {
		  if(ui.item.id == "00"){
			jQuery("#tambah").show();
			this.value = "";
		  }else{
            jQuery("input[name='.$xcrud->fieldname_encode($field).']").val(ui.item.id);
			jQuery("#tambah").hide();
		  }
        }
		});
		
		jQuery("#tambah").hide();

        jQuery(".modal").on("click", function () {
            window.location.reload();
        });
		'
	.'</script>';
	
	$html .= '
    <div class="input-prepend input-append">'
    . '<input type="hidden" name="'.$xcrud->fieldname_encode($field).'" value="'.$value.'" class="xcrud-input" /> '
    . '<input type="text" name="id_suku-id" value="" class="xcrud-input" />'
    . '<button type="button" id="tambah" class="btn btn-primary" data-toggle="modal" data-target=".modal_suku">Buat Baru</button>'
 . '</div>'
 . '
    <div class="modal fade modal_suku" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
           <iframe width="860px" height="660px" name="master" frameborder=0 src="'.dirname($_SERVER["SCRIPT_NAME"]).'/../master/suku_modal"></iframe>
        </div>
      </div>
    </div>';
	
	return $html;
		
}

function nice_input_marga($value, $field, $primary_key, $list, $xcrud)
{

	$html = '<script>'
		.'jQuery("input[name=id_marga-id]").autocomplete({ 
		source: "'.dirname($_SERVER["SCRIPT_NAME"]).'/../master/auto_id_marga",
        select: function( event, ui ) {
		  if(ui.item.id == "00"){
			jQuery("#tambah").show();
			this.value = "";
		  }else{
            jQuery("input[name='.$xcrud->fieldname_encode($field).']").val(ui.item.id);
			jQuery("#tambah").hide();
		  }
        }
		});
		
		jQuery("#tambah").hide();

        jQuery(".modal").on("click", function () {
            window.location.reload();
        });
		'
	.'</script>';
	
	$html .= '
	<div class="input-prepend input-append">'
	. '<input type="hidden" name="'.$xcrud->fieldname_encode($field).'" value="'.$value.'" class="xcrud-input" /> '
    . '<input type="text" name="id_marga-id" value="" class="xcrud-input" />'
	. '<button type="button" id="tambah" class="btn btn-primary" data-toggle="modal" data-target=".modal_marga">Buat Baru</button>'
 . '</div>'
 . '
	<div class="modal fade modal_marga" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-sm">
		<div class="modal-content">
		   <iframe width="900px" height="800px" name="master" frameborder=0 src="'.dirname($_SERVER["SCRIPT_NAME"]).'/../master/marga_modal"></iframe>
		</div>
	  </div>
	</div>
 
 ';
	
	return $html;
		
}

function nice_input_jenis_tumbuhan($value, $field, $primary_key, $list, $xcrud)
{

    $html = '<script>'
        .'jQuery("input[name=id_jenis_tumbuhan-id]").autocomplete({ 
        source: "'.dirname($_SERVER["SCRIPT_NAME"]).'/../master/auto_id_jenis_tumbuhan",
        select: function( event, ui ) {
          if(ui.item.id == "00"){
            jQuery("#tambah").show();
            this.value = "";
          }else{
            jQuery("input[name='.$xcrud->fieldname_encode($field).']").val(ui.item.id);
            jQuery("#tambah").hide();
          }
        }
        });
        
        jQuery("#tambah").hide();

        jQuery(".modal").on("click", function () {
            window.location.reload();
        });
        '
    .'</script>';
    
    $html .= '
    <div class="input-prepend input-append">'
    . '<input type="hidden" name="'.$xcrud->fieldname_encode($field).'" value="'.$value.'" class="xcrud-input" /> '
    . '<input type="text" name="id_jenis_tumbuhan-id" value="" class="xcrud-input" />'
    . '<button type="button" id="tambah" class="btn btn-primary" data-toggle="modal" data-target=".modal_jenis_tumbuhan">Buat Baru</button>'
 . '</div>'
 . '
    <div class="modal fade modal_jenis_tumbuhan" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
           <iframe width="900px" height="800px" name="master" frameborder=0 src="'.dirname($_SERVER["SCRIPT_NAME"]).'/../master/jenis_tumbuhan_modal"></iframe>
        </div>
      </div>
    </div>
 
 ';
    
    return $html;
        
}

function nice_input_bagian_tumbuhan($value, $field, $primary_key, $list, $xcrud)
{

    $html = '<script>'
        .'jQuery("input[name=id_bagian_tumbuhan-id]").autocomplete({ 
        source: "'.dirname($_SERVER["SCRIPT_NAME"]).'/../master/auto_id_bagian_tumbuhan",
        select: function( event, ui ) {
          if(ui.item.id == "00"){
            jQuery("#tambah").show();
            this.value = "";
          }else{
            jQuery("input[name='.$xcrud->fieldname_encode($field).']").val(ui.item.id);
            jQuery("#tambah").hide();
          }
        }
        });
        
        jQuery("#tambah").hide();

        jQuery(".modal").on("click", function () {
            window.location.reload();
        });
        '
    .'</script>';
    
    $html .= '
    <div class="input-prepend input-append">'
    . '<input type="hidden" name="'.$xcrud->fieldname_encode($field).'" value="'.$value.'" class="xcrud-input" /> '
    . '<input type="text" name="id_bagian_tumbuhan-id" value="" class="xcrud-input" />'
    . '<button type="button" id="tambah" class="btn btn-primary" data-toggle="modal" data-target=".modal_bagian_tumbuhan">Buat Baru</button>'
 . '</div>'
 . '
    <div class="modal fade modal_bagian_tumbuhan" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
           <iframe width="900px" height="800px" name="master" frameborder=0 src="'.dirname($_SERVER["SCRIPT_NAME"]).'/../master/bagian_tumbuhan_modal"></iframe>
        </div>
      </div>
    </div>
 
 ';
    
    return $html;
        
}

function nice_input_kandungan_kimia($value, $field, $primary_key, $list, $xcrud)
{

    $html = '<script>'
        .'jQuery("input[name=id_kandungan_kimia-id]").autocomplete({ 
        source: "'.dirname($_SERVER["SCRIPT_NAME"]).'/../master/auto_id_kandungan_kimia",
        select: function( event, ui ) {
          if(ui.item.id == "00"){
            jQuery("#tambah").show();
            this.value = "";
          }else{
            jQuery("input[name='.$xcrud->fieldname_encode($field).']").val(ui.item.id);
            jQuery("#tambah").hide();
          }
        }
        });
        
        jQuery("#tambah").hide();

        jQuery(".modal").on("click", function () {
            window.location.reload();
        });
        '
    .'</script>';
    
    $html .= '
    <div class="input-prepend input-append">'
    . '<input type="hidden" name="'.$xcrud->fieldname_encode($field).'" value="'.$value.'" class="xcrud-input" /> '
    . '<input type="text" name="id_kandungan_kimia-id" value="" class="xcrud-input" />'
    . '<button type="button" id="tambah" class="btn btn-primary" data-toggle="modal" data-target=".modal_kandungan_kimia">Buat Baru</button>'
 . '</div>'
 . '
    <div class="modal fade modal_kandungan_kimia" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
           <iframe width="900px" height="800px" name="master" frameborder=0 src="'.dirname($_SERVER["SCRIPT_NAME"]).'/../master/kandungan_kimia_modal"></iframe>
        </div>
      </div>
    </div>
 
 ';
    
    return $html;
        
}

function nice_input_jenis_penyakit($value, $field, $primary_key, $list, $xcrud)
{

    $html = '<script>'
        .'jQuery("input[name=id_jenis_penyakit-id]").autocomplete({ 
        source: "'.dirname($_SERVER["SCRIPT_NAME"]).'/../master/auto_id_jenis_penyakit",
        select: function( event, ui ) {
          if(ui.item.id == "00"){
            jQuery("#tambah").show();
            this.value = "";
          }else{
            jQuery("input[name='.$xcrud->fieldname_encode($field).']").val(ui.item.id);
            jQuery("#tambah").hide();
          }
        }
        });
        
        jQuery("#tambah").hide();

        jQuery(".modal").on("click", function () {
            window.location.reload();
        });
        '
    .'</script>';
    
    $html .= '
    <div class="input-prepend input-append">'
    . '<input type="hidden" name="'.$xcrud->fieldname_encode($field).'" value="'.$value.'" class="xcrud-input" /> '
    . '<input type="text" name="id_jenis_penyakit-id" value="" class="xcrud-input" />'
    . '<button type="button" id="tambah" class="btn btn-primary" data-toggle="modal" data-target=".modal_jenis_penyakit">Buat Baru</button>'
 . '</div>'
 . '
    <div class="modal fade modal_jenis_penyakit" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
           <iframe width="900px" height="800px" name="master" frameborder=0 src="'.dirname($_SERVER["SCRIPT_NAME"]).'/../master/jenis_penyakit_modal"></iframe>
        </div>
      </div>
    </div>
 
 ';
    
    return $html;
        
}

function nice_input_penyakit($value, $field, $primary_key, $list, $xcrud)
{

    $html = '<script>'
        .'jQuery("input[name=id_penyakit-id]").autocomplete({ 
        source: "'.dirname($_SERVER["SCRIPT_NAME"]).'/../master/auto_id_penyakit",
        select: function( event, ui ) {
          if(ui.item.id == "00"){
            jQuery("#tambah").show();
            this.value = "";
          }else{
            jQuery("input[name='.$xcrud->fieldname_encode($field).']").val(ui.item.id);
            jQuery("#tambah").hide();
          }
        }
        });
        
        jQuery("#tambah").hide();

        jQuery(".modal").on("click", function () {
            window.location.reload();
        });
        '
    .'</script>';
    
    $html .= '
    <div class="input-prepend input-append">'
    . '<input type="hidden" name="'.$xcrud->fieldname_encode($field).'" value="'.$value.'" class="xcrud-input" /> '
    . '<input type="text" name="id_penyakit-id" value="" class="xcrud-input" />'
    . '<button type="button" id="tambah" class="btn btn-primary" data-toggle="modal" data-target=".modal_penyakit">Buat Baru</button>'
 . '</div>'
 . '
    <div class="modal fade modal_penyakit" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
           <iframe width="900px" height="800px" name="master" frameborder=0 src="'.dirname($_SERVER["SCRIPT_NAME"]).'/../master/penyakit_modal"></iframe>
        </div>
      </div>
    </div>
 
 ';
    
    return $html;
        
}


function nice_input_khasiat($value, $field, $primary_key, $list, $xcrud)
{

    $html = '<script>'
        .'jQuery("input[name=id_khasiat-id]").autocomplete({ 
        source: "'.dirname($_SERVER["SCRIPT_NAME"]).'/../master/auto_id_khasiat",
        select: function( event, ui ) {
          if(ui.item.id == "00"){
            jQuery("#tambah").show();
            this.value = "";
          }else{
            jQuery("input[name='.$xcrud->fieldname_encode($field).']").val(ui.item.id);
            jQuery("#tambah").hide();
          }
        }
        });
        
        jQuery("#tambah").hide();

        jQuery(".modal").on("click", function () {
            window.location.reload();
        });
        '
    .'</script>';
    
    $html .= '
    <div class="input-prepend input-append">'
    . '<input type="hidden" name="'.$xcrud->fieldname_encode($field).'" value="'.$value.'" class="xcrud-input" /> '
    . '<input type="text" name="id_khasiat-id" value="" class="xcrud-input" />'
    . '<button type="button" id="tambah" class="btn btn-primary" data-toggle="modal" data-target=".modal_khasiat">Buat Baru</button>'
 . '</div>'
 . '
    <div class="modal fade modal_khasiat" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
           <iframe width="900px" height="800px" name="master" frameborder=0 src="'.dirname($_SERVER["SCRIPT_NAME"]).'/../master/khasiat_modal"></iframe>
        </div>
      </div>
    </div>
 
 ';
    
    return $html;
        
}

function after_upload_example($field, $file_name, $file_path, $params, $xcrud)
{
    $ext = trim(strtolower(strrchr($file_name, '.')), '.');
    if ($ext != 'pdf' && $field == 'uploads.simple_upload')
    {
        unlink($file_path);
        $xcrud->set_exception('simple_upload', 'This is not PDF', 'error');
    }
}

function date_example($postdata, $primary, $xcrud)
{
    $created = $postdata->get('datetime')->as_datetime();
    $postdata->set('datetime', $created);
}

function movetop($xcrud)
{
    if ($xcrud->get('primary') !== false)
    {
        $primary = (int)$xcrud->get('primary');
        $db = Xcrud_db::get_instance();
        $query = 'SELECT `officeCode` FROM `offices` ORDER BY `ordering`,`officeCode`';
        $db->query($query);
        $result = $db->result();
        $count = count($result);

        $sort = array();
        foreach ($result as $key => $item)
        {
            if ($item['officeCode'] == $primary && $key != 0)
            {
                array_splice($result, $key - 1, 0, array($item));
                unset($result[$key + 1]);
                break;
            }
        }

        foreach ($result as $key => $item)
        {
            $query = 'UPDATE `offices` SET `ordering` = ' . $key . ' WHERE officeCode = ' . $item['officeCode'];
            $db->query($query);
        }
    }
}
function movebottom($xcrud)
{
    if ($xcrud->get('primary') !== false)
    {
        $primary = (int)$xcrud->get('primary');
        $db = Xcrud_db::get_instance();
        $query = 'SELECT `officeCode` FROM `offices` ORDER BY `ordering`,`officeCode`';
        $db->query($query);
        $result = $db->result();
        $count = count($result);

        $sort = array();
        foreach ($result as $key => $item)
        {
            if ($item['officeCode'] == $primary && $key != $count - 1)
            {
                unset($result[$key]);
                array_splice($result, $key + 1, 0, array($item));
                break;
            }
        }

        foreach ($result as $key => $item)
        {
            $query = 'UPDATE `offices` SET `ordering` = ' . $key . ' WHERE officeCode = ' . $item['officeCode'];
            $db->query($query);
        }
    }
}


