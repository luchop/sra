<h1>Opciones de operador 1: <?php echo $this->session->userdata('Nombre'); ?></h1>
<div id="page-wrap">
	<ul class="dropdown">
		<li><a href='#' title="Contratos">O.T.'s</a>
			<ul class="sub_menu">				
				<li><a href='<?php echo base_url() ?>index.php/ot/NuevaOT' title="Registro de nueva O.T.">Nueva O.T.</a></li>
				<li><a href='<?php echo base_url() ?>index.php/ot/BuscaParaModificar/1' title="Modificacion de O.T.">Modificaci&oacute;n O.T.</a></li>
			</ul>
		</li>
		<li><a href='#' title="Clientes">Clientes</a>
			<ul class="sub_menu">				
				<li><a href='<?php echo base_url() ?>index.php/cliente/NuevoCliente' title="Registro de nuevo cliente">Nuevo cliente</a></li>
				<li><a href='<?php echo base_url() ?>index.php/cliente/BuscaParaModificar/1' title="Modificacion de cliente">Modificaci&oacute;n cliente</a></li>
			</ul>
		</li>
		<li><a href='#'>Reportes</a>
			<ul class="sub_menu">				
				<li><a href='<?php echo base_url() ?>index.php/reporte/Comprobante' title="Impresion de OT">Orden de trabajo</a></li>
				<li><a href='<?php echo base_url() ?>index.php/reporte/ReportePorFechas' title="Registro de tareas">Listado</a></li>
			</ul>
		</li>
		<li><a href='#' title="Configuracion">Configuraci&oacute;n</a>
			<ul class="sub_menu">				
				<li><a href='<?php echo base_url() ?>index.php/articulo/ListaArticulos' title="Registro de articulos">Art&iacute;culos</a></li>
				<li><a href='<?php echo base_url() ?>index.php/marca/ListaMarcas' title="Registro de marcas">Marcas</a></li>
				<li><a href='<?php echo base_url() ?>index.php/modelo/ListaModelos' title="Registro de modelos">Modelos</a></li>
			</ul>
		</li>
		<li><a href='<?php echo base_url() ?>index.php/cambia_clave' title="Cambia la clave de acceso">Cambio de clave</a></li>
		<li><a href='<?php echo base_url() ?>index.php/login/Salir' title="Cerrar sesi&oacute;n">Salir</a></li>
	</ul>
</div>
<br /><br /><hr />