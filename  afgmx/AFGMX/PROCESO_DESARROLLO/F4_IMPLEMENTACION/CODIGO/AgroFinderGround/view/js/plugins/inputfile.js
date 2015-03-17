
			function actuar(peso, anchura, altura)	{
				this.peso.value = peso;
				this.ancho.value = anchura;
				this.alto.value = altura;
			}

			function ini()	{
				document.forms.frmregister.actualizar = actuar;
				window.frames.ver.location.href = "view/ajax/visor.php";
				document.forms.frmregister.actualizar(0, 0, 0);

			}

			function validar(f)	{
				enviar = /\.(gif|jpg|png|ico|bmp)$/i.test(f.imagen.value);				
				if(enviar){
					return enviar;
				}else{
					return "";
				}
			}

			function limpiar()	{
				document.forms.frmregister.actualizar(0, 0, 0);
				f = document.getElementById("imagen");
				nuevoFile = document.createElement("input");
				nuevoFile.id = f.id;
				nuevoFile.type = "file";
				nuevoFile.name = "imagen";
				nuevoFile.value = "";
				nuevoFile.onchange = f.onchange;
				nodoPadre = f.parentNode;
				nodoSiguiente = f.nextSibling;
				nodoPadre.removeChild(f);
				(nodoSiguiente == null) ? nodoPadre.appendChild(nuevoFile):
					nodoPadre.insertBefore(nuevoFile, nodoSiguiente);
			}

			function checkear(f)	{
				function no_prever() {
					alert("El fichero seleccionado no es válido...");
					limpiar();
				}
				function prever() {
					actionActual = f.form.action;
					targetActual = f.form.target;
					f.form.action = "view/ajax/visor.php";
					f.form.target = "ver";
					f.form.submit();
					f.form.action = actionActual;
					f.form.target = targetActual;
				}

				(/\.(gif|jpg|png|ico|bmp)$/i.test(f.value)) ? prever() : no_prever();
			}

			function datosImagen(peso, ancho, alto, error)	{
				function mostrar_error()	{
					enviar = false;					
					mensaje = "Ha habido un error (error nº " + error + "):";
					if (error % 2 == 1) // tipo incorrecto
						mensaje += "\nel fichero no es válido";
					error = parseInt(error / 2);
					if (error % 2 == 1) // excede en peso
						mensaje += "\nLa imagen que selecciono excede el peso permitido (" + peso + ").";
					error = parseInt(error / 2);
					if (error % 2 == 1) // excede en anchura
						mensaje += "\nla imagen excede en anchura (" + ancho + ").";
					error = parseInt(error / 2);
					if (error % 2 == 1) // excede en altura
						mensaje += "\nla imagen excede en altura (" + alto + ").";
					error = parseInt(error / 2);
					alert (mensaje);
					limpiar();
				}
				if (error == 0)
					document.forms.frmregister.actualizar(peso, ancho, alto);
				else
					mostrar_error();
			}