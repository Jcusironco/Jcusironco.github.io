</main>
      	<script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" src="../js/sweetalert2.js"></script>
      	<script type="text/javascript" src="../js/materialize.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.3.2/sweetalert2.js"></script>
      	<script>
  			$('.button-collpase').sideNav();
		</script>
            <!-- acativar el select -->
            <script>
                  $('select').material_select();
            </script>
		<!-- conversion a mayusculas -->
      	<script>
      		function vay(obj,id)
      		{
      			obj=obj.toUpperCase();
      			document.getElementById(id).value=obj;
      		}
      	</script>
            <!-- funcion validar -->
            <script>
                  $('#buscar').keyup(function(event)
                        {
                              var contenido = new RegExp($(this).val(),'i');
                              $('tr').hide();
                              $('tr').filter(function()
                                    {
                                          return contenido.test($(this).text());
                                    }).show();
                        });
            </script>
