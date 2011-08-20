<h1>Opciones de administrador: <?php echo $this->session->userdata('Nombre'); ?></h1>
<div id="page-wrap">
	<ul class="dropdown">
		<li><a href='#'>Reportes</a>
			<ul class="sub_menu">				
				<li><a href='<?php echo base_url() ?>index.php/reporte/ReportePorFechas' title="Reporte por fechas">Listado por fecha</a></li>
				<li><a href='<?php echo base_url() ?>index.php/reporte/ReportePorCliente' title="Reporte por cliente">Listado por cliente</a></li>
				<li><a href='<?php echo base_url() ?>index.php/reporte/ReportePorUsuario' title="Reporte por usuario">Listado por usuario</a></li>
				<li><a href='<?php echo base_url() ?>index.php/reporte/Comprobante' title="Registro de tareas">Orden de trabajo</a></li>
			</ul>
		</li>
		<li><a href='#' title="Clientes">Clientes</a>
			<ul class="sub_menu">				
				<li><a href='<?php echo base_url() ?>index.php/cliente/NuevoCliente' title="Registro de nuevo cliente">Nuevo cliente</a></li>
				<li><a href='<?php echo base_url() ?>index.php/cliente/BuscaParaModificar/1' title="Modificacion de datos de cliente">Modificaci&oacute;n</a></li>
			</ul>
		</li>
		<li><a href='#' title="Usuarios">Usuarios</a>
			<ul class="sub_menu">				
				<li><a href='<?php echo base_url() ?>index.php/usuario/NuevoUsuario' title="Registro de nuevo usuario">Nuevo usuario</a></li>
				<li><a href='<?php echo base_url() ?>index.php/usuario/BuscaParaModificar/1' title="Modificacion de datos de usuario">Modificaci&oacute;n</a></li>
			</ul>
		</li>
		<li><a href='#' title="Configuracion">Configuraci&oacute;n</a>
			<ul class="sub_menu">				
				<li><a href='<?php echo base_url() ?>index.php/configuracion/Identificacion' title="Identificacion de la institucion">Identificaci&oacute;n</a></li>
				<li><a href='<?php echo base_url() ?>index.php/configuracion/Rotulos' title="Configuracion de rotulos">R&oacute;tulos</a></li>
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