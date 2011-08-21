<h1>Opciones de administrador: <?php echo $this->session->userdata('Nombre'); ?></h1>
<div id="page-wrap">
	<ul class="dropdown">
		<li><a href='#' title="Clientes">Salas</a>
			<ul class="sub_menu">				
				<li><a href='<?php echo base_url() ?>index.php/sala/NuevaSala' title="Registro de nueva sala">Nueva sala</a></li>
				<li><a href='<?php echo base_url() ?>index.php/sala/BuscaParaModificar/1' title="Modificacion de datos de sala">Modificaci&oacute;n</a></li>
			</ul>
		</li>
		<li><a href='#' title="Usuarios">Grupos</a>
			<ul class="sub_menu">				
				<li><a href='<?php echo base_url() ?>index.php/grupo/NuevoGrupo' title="Registro de nuevo grupo">Nuevo grupo</a></li>
				<li><a href='<?php echo base_url() ?>index.php/grupo/BuscaParaModificar/1' title="Modificacion de datos de grupo">Modificaci&oacute;n</a></li>
			</ul>
		</li>
		<li><a href='#' title="Usuarios">Reservas</a>
			<ul class="sub_menu">				
				<li><a href='<?php echo base_url() ?>index.php/reserva/NuevaReserva' title="Registro de nueva reserva">Nueva reserva</a></li>
				<li><a href='<?php echo base_url() ?>index.php/reserva/BuscaParaModificar/1' title="Modificacion de datos de reserva">Modificaci&oacute;n</a></li>
			</ul>
		</li>
		<li><a href='#' title="Configuracion">Configuraci&oacute;n</a>
			<ul class="sub_menu">				
				<li><a href='<?php echo base_url() ?>index.php/configuracion/Identificacion' title="Identificacion de la institucion">Identificaci&oacute;n</a></li>
			</ul>
		</li>
		
		<li><a href='<?php echo base_url() ?>index.php/cambia_clave' title="Cambia la clave de acceso">Cambio de clave</a></li>
		<li><a href='<?php echo base_url() ?>index.php/login/Salir' title="Cerrar sesi&oacute;n">Salir</a></li>
	</ul>
</div>
<br /><br /><hr />