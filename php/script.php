<div>
	<form name="frm" id="frm">
				<?php
					$conn = oci_pconnect('fac', 'r2017', 
					'(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = dbcldev-scan.orange.com.do)(PORT = 1521)))(CONNECT_DATA=(SERVICE_NAME=TAFMGDEV.orange.com.do)))');
					if (!$conn) {
						$e = oci_error();
						trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
					}
				$stid= oci_parse($conn, "SELECT  HEMISFERIO_ID, DESCRIPCION FROM  os.HEMISFERIO");
					oci_execute($stid); 
				?>	
				<div id="formulario">
					<div id="div_hemisferio">
						<div class="divLeft">
						<label class="labelLeft" for="hemisferios">HEMISFERIO:</label>
						</div>
						<div class="divRight"> 
							<select name="select1" onChange="showState(this.value);" id='hemisferios'>
									<option value="">--- Seleccione hemisferio---</option>
								<?php
								while (($row = oci_fetch_array($stid, OCI_ASSOC)) != false ) {
									if(!(isset($_REQUEST["select1"]))){
										$_REQUEST["select1"]=$row['HEMISFERIO_ID'];
									}
								?>
									<option value="<?php echo $row['HEMISFERIO_ID'];?>" <?php if($row['HEMISFERIO_ID']==$_REQUEST["select1"]){ echo "Selected"; } ?> > <?php echo $row['DESCRIPCION'];?></option>
								<?php
								 }
								?>
							</select>
						</div>
					</div>
					<div id="div_continentes">
						<div class="divLeft">
							<label class="labelLeft" for="Continentes">Continentes:</label>
						</div>
						<div class="divRight">
							<select name="select2" onChange="showState(this.value);" id = "Continentes">
									<option value="">--- Select Continente---</option>
							   <?php
								if (!$conn) {
									$e = oci_error();
									trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
								}
								$stid = oci_parse($conn,"select CONTINENTE_ID ,DESCRIPCION ,HEMISFERIO_ID  from  os.CONTINENTE  where HEMISFERIO_ID='$_REQUEST[select1]'");
								   oci_execute($stid);
								while (($row = oci_fetch_array($stid, OCI_ASSOC)) != false) {
									if(!(isset($_REQUEST["select2"]))){
										$_REQUEST["select2"]=$row['CONTINENTE_ID'];
									}
								?>
									<option value="<?php echo $row['CONTINENTE_ID'];?>"  <?php if($row['CONTINENTE_ID']==$_REQUEST["select2"]){ echo "Selected"; } ?> > <?php echo $row['DESCRIPCION'];?></option>  
								<?php 
								}
								?> 
							</select>
						</div>
					</div>
				</div>
				<div style="clear:both;height:5%;widht:100%;"></div>	
				<div id="historico">
					
					<div>
						<table>
							<thead>
								<th>PAIS</th>
							</thead>
						<tbody>
							<?php
							if( !(empty($_REQUEST['select2'])))
							{ 
								$stid = oci_parse($conn,"select  PAIS_ID, DESCRIPCION, CONTINENTE_ID  from os.PAIS where CONTINENTE_ID='$_REQUEST[select2]'");
								   oci_execute($stid);
								while (($row = oci_fetch_array($stid, OCI_ASSOC)) != false) {
									?>
									<tr name="pais" value="<?php echo $row['PAIS_ID']; ?>" onclick="showState(this.value);">
									<?php
										if
										(	
											!(empty($row['PAIS_ID']))  		&&
												!(empty($row['DESCRIPCION']))
										)
										{
											echo "<td> <a href=\"?select1=".$_REQUEST['select1']."&select2=".$_REQUEST['select2']."&pais=".$row['PAIS_ID']."\"> ". $row['DESCRIPCION'] ."</td>";
										}
									?>
									</tr>
								<?php 
								}
							}
							?>
							<tbody>
						</table>
					</div>
				</div>
				<div style="clear:both;widht:50%;height:5%;"></div>
				<div id="unmatch">
					<table>
						<thead>
							<th>CIUDAD</th>
						</thead>
						<tbody>
						<?php
						if(isset($_REQUEST['pais'])){
						$stid = oci_parse($conn,"SELECT CIUDAD_ID, DESCRIPCION, PAIS_ID  from  os.CIUDAD where PAIS_ID = '".$_REQUEST['pais']."'" );
										oci_execute($stid);
								while (($row = oci_fetch_array($stid, OCI_ASSOC)) != false) {
									?>
										<tr>
										<?php
										if
										(		
												!(empty($row['CIUDAD_ID']))
											&&	!(empty($row['DESCRIPCION']))
										)
										{
											?>
											<td><?php echo $row['DESCRIPCION']	;?> </td>
											<?php
										}
									?>
										</tr>
									<?php 
								}
						}
					?>
				</tbody>
			</table>
		</div>
	</form>          
</div>
