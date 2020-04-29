<div>
	<form name="frm" id="frm">
				<?php
					$conn = oci_pconnect('fac', 'r2017', 
					'(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = dbcldev-scan.orange.com.do)(PORT = 1521)))(CONNECT_DATA=(SERVICE_NAME=TAFMGDEV.orange.com.do)))');
					if (!$conn) {
						$e = oci_error();
						trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
					}
				$stid= oci_parse($conn, "SELECT ID_PLATFORM, PLATFORM, DESCRIPCION,STATUS   FROM TWC_PLATFORM_T where  STATUS = 'A' ORDER BY DESCRIPCION ASC");
					oci_execute($stid); 
				?>	
				<div id="formulario">
					<div id="div_plataformas">
						<div class="divLeft">
						<label class="labelLeft" for="plataformas">Plataforma:</label>
						</div>
						<div class="divRight"> 
							<select name="select1" onChange="showState(this.value);" id='plataformas'>
									<option value="">--- Seleccione Plataforma---</option>
								<?php
								while (($row = oci_fetch_array($stid, OCI_ASSOC)) != false ) {
									if(!(isset($_REQUEST["select1"]))){
										$_REQUEST["select1"]=$row['ID_PLATFORM'];
									}
								?>
								
									<option value="<?php echo $row['ID_PLATFORM'];?>" <?php if($row['ID_PLATFORM']==$_REQUEST["select1"]){ echo "Selected"; } ?> > <?php echo $row['DESCRIPCION'];?></option>
								<?php
								 }
								?>
							</select>
						</div>
					</div>
					<div id="div_conciliaciones">
						<div class="divLeft">
							<label class="labelLeft" for="conciliaciones">Conciliaciones:</label>
						</div>
						<div class="divRight">
							<select name="select2" onChange="showState(this.value);">
									<option value="">--- Select Conciliaci&oacute;n---</option>
							   <?php
								$conn = oci_pconnect('fac', 'r2017', 
								'(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = dbcldev-scan.orange.com.do)(PORT = 1521)))(CONNECT_DATA=(SERVICE_NAME=TAFMGDEV.orange.com.do)))');
								if (!$conn) {
									$e = oci_error();
									trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
								}
								$stid = oci_parse($conn,"select ID_SOLICITUD, DESCRIPCION, ID_PLATFORM  from TWC_TYPE_SOLICITUDE_T where ID_PLATFORM='$_REQUEST[select1]'");
								   oci_execute($stid);
								while (($row = oci_fetch_array($stid, OCI_ASSOC)) != false) {
									if(!(isset($_REQUEST["select2"]))){
										$_REQUEST["select2"]=$row['ID_SOLICITUD'];
									}
								?>
								
									<option value="<?php echo $row['ID_SOLICITUD'];?>"  <?php if($row['ID_SOLICITUD']==$_REQUEST["select2"]){ echo "Selected"; } ?> > <?php echo $row['DESCRIPCION'];?></option>  
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
								<th>Secuencia</th>
								<th>Plataforma</th>
								<th>Solicitud</th>
								<th>Fecha</th>
								<th>Estatus</th>
							</thead>
						<tbody>
							<?php
							
							$conn = oci_pconnect('fac', 'r2017', 
							'(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = dbcldev-scan.orange.com.do)(PORT = 1521)))(CONNECT_DATA=(SERVICE_NAME=TAFMGDEV.orange.com.do)))');
							if (!$conn) {
								$e = oci_error();
								trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
							}
							if(!(empty($_REQUEST['select1'])) && !(empty($_REQUEST['select2'])))
							{
								$stid = oci_parse($conn,"select ID_SECUENCE, ID_PLATFORM, ID_SOLICITUDE, DATE_CREATED, STATUS  from TWC_HIST_SOLICITUDE_T where status='A' and ID_PLATFORM='$_REQUEST[select1]' and ID_SOLICITUDE='$_REQUEST[select2]'");
								   oci_execute($stid);
								
								while (($row = oci_fetch_array($stid, OCI_ASSOC)) != false) {
									?>
									<tr name="secuencia" value="<?php echo $row['ID_SECUENCE']; ?>" onclick="showState(this.value);">
									<?php
										if
										(	
											!(empty($row['ID_SECUENCE']))  		&&
												!(empty($row['ID_PLATFORM']))
											&&	!(empty($row['ID_SOLICITUDE']))
											&&	!(empty($row['DATE_CREATED']))
											&&	!(empty($row['STATUS']))
										)
										{
											echo "<td> <a href=\"?select1=".$_REQUEST['select1']."&select2=".$_REQUEST['select2']."&secuencia=".$row['ID_SECUENCE']."\"> ". $row['ID_SECUENCE'] ."</td>";
											echo "<td>".$row['ID_PLATFORM']."</td>";
											echo "<td>".$row['ID_SOLICITUDE']."</td>";
											echo "<td>".$row['DATE_CREATED']."</td>";
											echo "<td>".$row['STATUS']."</td>";
										}
									?>
									</tr>
								<?php 
								}
							}
								# oci_free_statement($stid);
								# oci_close($conn);
							?>
							<tbody>
						</table>
					</div>
				</div>
				<div style="clear:both;widht:50%;height:5%;"></div>
				<div id="unmatch">
					<table>
						<thead>
							<th>Plataforma</th>
							<th>Solicitud</th>
							<th>Secuencia</th>
							<th>Estatus</th>
							<th>Fecha Creacion</th>
							<th>Usuario</th>
							<th>Fecha Proceso</th>
						</thead>
						<tbody>
						<?php
						if(isset($_REQUEST['secuencia'])){
						$stid = oci_parse($conn,"select ID_PLATFORM,ID_SOLICITUDE,ID_secuence,STATUS, DATE_CREATED, USER_CREATED, FECHA_PROCESO from TWC_UNMATCH_T where ID_secuence = '".$_REQUEST['secuencia']."'" );
										oci_execute($stid);
						echo "select ID_PLATFORM,ID_SOLICITUDE,ID_secuence,STATUS, DATE_CREATED, USER_CREATED, FECHA_PROCESO from TWC_UNMATCH_T where ID_secuence = '".$_REQUEST['secuencia']."'" ;
					//	if(!(empty($stid))){
								while (($row = oci_fetch_array($stid, OCI_ASSOC)) /*!= false*/) {
									echo "dentro de while";
									?>
									
									
										<tr>
										<?php
										if
										(		
												!(empty($row['ID_PLATFORM']))
											&&	!(empty($row['ID_SOLICITUDE']))
											&&	!(empty($row['STATUS']))
											&&	!(empty($row['DATE_CREATED']))
											&&	!(empty($row['USER_CREATED']))
											&&	!(empty($row['FECHA_PROCESO']))
										)
										{
											?>
											<td><?php echo $row['ID_PLATFORM']		;?> </td>
											<td><?php echo $row['ID_SOLICITUDE']	;?> </td>
											<td><?php echo $row['STATUS']			;?> </td>
											<td><?php echo $row['DATE_CREATED']		;?> </td>
											<td><?php echo $row['USER_CREATED']		;?> </td>
											<td><?php echo $row['FECHA_PROCESO']	;?> </td>
											<?php
										}
									?>
											</tr>
									<?php 
								}
						//}
						}
						# oci_free_statement($stid);
						# oci_close($conn);
					?>
				</tbody>
			</table>
		</div>
	</form>          
</div>
